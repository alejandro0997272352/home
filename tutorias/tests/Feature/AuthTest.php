<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirects_to_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Test1234@'),
            'role' => 'estudiante',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'Test1234@',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Test1234@'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Test1234@'),
            'activo' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'Test1234@',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_register_as_estudiante()
    {
        $response = $this->post('/register', [
            'name' => 'Nuevo Estudiante',
            'email' => 'nuevo@example.com',
            'password' => 'Test1234@',
            'password_confirmation' => 'Test1234@',
            'role' => 'estudiante',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@example.com',
            'role' => 'estudiante',
        ]);
    }

    public function test_user_can_register_as_tutor()
    {
        $response = $this->post('/register', [
            'name' => 'Nuevo Tutor',
            'email' => 'tutor@example.com',
            'password' => 'Test1234@',
            'password_confirmation' => 'Test1234@',
            'role' => 'tutor',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'tutor@example.com',
            'role' => 'tutor',
        ]);
        $this->assertDatabaseHas('tutor_profiles', [
            'user_id' => User::where('email', 'tutor@example.com')->first()->id,
        ]);
    }

    public function test_register_requires_strong_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'weak',
            'password_confirmation' => 'weak',
            'role' => 'estudiante',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_dashboard_redirects_by_role()
    {
        $routes = [
            'admin' => '/admin/dashboard',
            'tutor' => '/tutor/dashboard',
            'estudiante' => '/estudiante/dashboard',
        ];

        foreach ($routes as $role => $expectedPath) {
            $user = User::factory()->{$role}()->create();

            $response = $this->actingAs($user)->get('/dashboard');

            $response->assertRedirect($expectedPath);
        }
    }

    public function test_role_middleware_blocks_wrong_role()
    {
        $student = User::factory()->estudiante()->create();

        $response = $this->actingAs($student)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_role_middleware_allows_correct_role()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}
