<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/perfil');

        $response->assertStatus(200);
        $response->assertViewIs('perfil.index');
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/perfil', [
            'name' => 'Updated Name',
            'email' => $user->email,
            'telefono' => '555-1234',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'telefono' => '555-1234',
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create(['password' => bcrypt('OldPass1@')]);

        $response = $this->actingAs($user)->post('/perfil/password', [
            'current_password' => 'OldPass1@',
            'password' => 'NewPass1@',
            'password_confirmation' => 'NewPass1@',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_user_cannot_update_password_with_wrong_current()
    {
        $user = User::factory()->create(['password' => bcrypt('OldPass1@')]);

        $response = $this->actingAs($user)->post('/perfil/password', [
            'current_password' => 'wrong-password',
            'password' => 'NewPass1@',
            'password_confirmation' => 'NewPass1@',
        ]);

        $response->assertSessionHasErrors('current_password');
    }
}
