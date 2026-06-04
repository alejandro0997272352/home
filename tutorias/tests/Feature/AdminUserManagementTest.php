<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_users_list()
    {
        User::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get('/admin/usuarios');

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.index');
    }

    public function test_admin_can_view_create_user_form()
    {
        $response = $this->actingAs($this->admin)->get('/admin/usuarios/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.create');
    }

    public function test_admin_can_create_estudiante_user()
    {
        $response = $this->actingAs($this->admin)->post('/admin/usuarios', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'Test1234@',
            'password_confirmation' => 'Test1234@',
            'role' => 'estudiante',
        ]);

        $response->assertRedirect('/admin/usuarios');
        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'role' => 'estudiante',
        ]);
    }

    public function test_admin_can_create_tutor_user_with_profile()
    {
        $response = $this->actingAs($this->admin)->post('/admin/usuarios', [
            'name' => 'New Tutor',
            'email' => 'tutor@example.com',
            'password' => 'Test1234@',
            'password_confirmation' => 'Test1234@',
            'role' => 'tutor',
        ]);

        $response->assertRedirect('/admin/usuarios');
        $user = User::where('email', 'tutor@example.com')->first();
        $this->assertNotNull($user->tutorProfile);
    }

    public function test_admin_can_view_user_details()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/usuarios/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.show');
    }

    public function test_admin_can_edit_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/usuarios/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.usuarios.edit');
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin)->put("/admin/usuarios/{$user->id}", [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => $user->role,
        ]);

        $response->assertRedirect('/admin/usuarios');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/usuarios/{$user->id}");

        $response->assertRedirect('/admin/usuarios');
        $this->assertModelMissing($user);
    }

    public function test_admin_cannot_delete_self()
    {
        $response = $this->actingAs($this->admin)->delete("/admin/usuarios/{$this->admin->id}");

        $response->assertRedirect();
        $this->assertModelExists($this->admin);
    }

    public function test_admin_can_filter_users_by_role()
    {
        User::factory()->tutor()->create();
        User::factory()->estudiante()->create();

        $response = $this->actingAs($this->admin)->get('/admin/usuarios?role=tutor');

        $response->assertStatus(200);
    }

    public function test_admin_can_search_users()
    {
        User::factory()->create(['name' => 'Juan Pérez']);
        User::factory()->create(['name' => 'María García']);

        $response = $this->actingAs($this->admin)->get('/admin/usuarios?search=Juan');

        $response->assertStatus(200);
    }
}
