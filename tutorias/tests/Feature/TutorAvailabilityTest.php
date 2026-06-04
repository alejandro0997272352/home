<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TutorAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private User $tutor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tutor = User::factory()->tutor()->create();
    }

    public function test_tutor_can_view_availability_page()
    {
        $response = $this->actingAs($this->tutor)->get('/tutor/disponibilidad');

        $response->assertStatus(200);
        $response->assertViewIs('tutor.disponibilidad');
    }

    public function test_tutor_can_create_availability()
    {
        $response = $this->actingAs($this->tutor)->post('/tutor/disponibilidad', [
            'dia_semana' => 'Lunes',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('availability', [
            'user_id' => $this->tutor->id,
            'dia_semana' => 'Lunes',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);
    }

    public function test_tutor_cannot_create_overlapping_availability()
    {
        Availability::factory()->create([
            'user_id' => $this->tutor->id,
            'dia_semana' => 'Lunes',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);

        $response = $this->actingAs($this->tutor)->post('/tutor/disponibilidad', [
            'dia_semana' => 'Lunes',
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_tutor_can_delete_own_availability()
    {
        $availability = Availability::factory()->create([
            'user_id' => $this->tutor->id,
        ]);

        $response = $this->actingAs($this->tutor)->delete(
            "/tutor/disponibilidad/{$availability->id}"
        );

        $response->assertRedirect();
        $this->assertModelMissing($availability);
    }

    public function test_tutor_cannot_delete_other_tutor_availability()
    {
        $otherTutor = User::factory()->tutor()->create();
        $availability = Availability::factory()->create([
            'user_id' => $otherTutor->id,
        ]);

        $response = $this->actingAs($this->tutor)->delete(
            "/tutor/disponibilidad/{$availability->id}"
        );

        $response->assertStatus(403);
    }

    public function test_tutor_availability_requires_valid_hours()
    {
        $response = $this->actingAs($this->tutor)->post('/tutor/disponibilidad', [
            'dia_semana' => 'Lunes',
            'hora_inicio' => '11:00',
            'hora_fin' => '09:00',
        ]);

        $response->assertSessionHasErrors('hora_fin');
    }

    public function test_tutor_availability_requires_valid_day()
    {
        $response = $this->actingAs($this->tutor)->post('/tutor/disponibilidad', [
            'dia_semana' => 'Domingo',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);

        $response->assertSessionHasErrors('dia_semana');
    }
}
