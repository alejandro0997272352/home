<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentAppointmentTest extends TestCase
{
    use RefreshDatabase;

    private User $student;
    private User $tutor;
    private Subject $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = User::factory()->estudiante()->create();
        $this->tutor = User::factory()->tutor()->create();
        $this->subject = Subject::factory()->create();
    }

    public function test_student_can_view_dashboard()
    {
        $response = $this->actingAs($this->student)->get('/estudiante/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('estudiante.dashboard');
    }

    public function test_student_can_search_tutors()
    {
        $response = $this->actingAs($this->student)->get('/estudiante/buscar');

        $response->assertStatus(200);
        $response->assertViewIs('estudiante.buscar');
    }

    public function test_student_can_view_tutor_availability()
    {
        Availability::factory()->create(['user_id' => $this->tutor->id]);

        $response = $this->actingAs($this->student)->get(
            "/estudiante/tutores/{$this->tutor->id}/disponibilidad"
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([]);
    }

    public function test_student_can_create_appointment()
    {
        $response = $this->actingAs($this->student)->post('/estudiante/citas', [
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
            'fecha' => now()->addDays(3)->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin' => '11:00',
            'modalidad' => 'presencial',
            'ubicacion' => 'Biblioteca Central',
            'notas' => 'Ayuda con límites',
        ]);

        $response->assertRedirect('/estudiante/citas');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('appointments', [
            'student_id' => $this->student->id,
            'tutor_id' => $this->tutor->id,
            'estado' => 'pendiente',
        ]);
    }

    public function test_student_cannot_create_appointment_with_past_date()
    {
        $response = $this->actingAs($this->student)->post('/estudiante/citas', [
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
            'fecha' => now()->subDays(1)->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin' => '11:00',
            'modalidad' => 'presencial',
        ]);

        $response->assertSessionHasErrors('fecha');
    }

    public function test_student_cannot_create_appointment_with_conflicting_time()
    {
        Appointment::factory()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => User::factory()->estudiante()->create()->id,
            'subject_id' => $this->subject->id,
            'fecha' => now()->addDays(3)->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'hora_fin' => '11:00',
            'estado' => 'pendiente',
        ]);

        $response = $this->actingAs($this->student)->post('/estudiante/citas', [
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
            'fecha' => now()->addDays(3)->format('Y-m-d'),
            'hora_inicio' => '10:30',
            'hora_fin' => '11:30',
            'modalidad' => 'presencial',
        ]);

        $response->assertSessionHasErrors('error');
    }

    public function test_student_can_view_own_appointments()
    {
        Appointment::factory()->create([
            'student_id' => $this->student->id,
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->student)->get('/estudiante/citas');

        $response->assertStatus(200);
        $response->assertViewIs('estudiante.citas');
    }

    public function test_student_can_cancel_own_pending_appointment()
    {
        $appointment = Appointment::factory()->pendiente()->create([
            'student_id' => $this->student->id,
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->student)->patch(
            "/estudiante/citas/{$appointment->id}/cancelar",
            ['motivo_cancelacion' => 'Ya no lo necesito']
        );

        $response->assertRedirect();
        $this->assertEquals('cancelada', $appointment->fresh()->estado);
    }

    public function test_student_cannot_cancel_completed_appointment()
    {
        $appointment = Appointment::factory()->completada()->create([
            'student_id' => $this->student->id,
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->student)->patch(
            "/estudiante/citas/{$appointment->id}/cancelar"
        );

        $response->assertSessionHasErrors('error');
    }

    public function test_student_cannot_cancel_other_student_appointment()
    {
        $otherStudent = User::factory()->estudiante()->create();
        $appointment = Appointment::factory()->pendiente()->create([
            'student_id' => $otherStudent->id,
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->student)->patch(
            "/estudiante/citas/{$appointment->id}/cancelar"
        );

        $response->assertStatus(403);
    }

    public function test_student_can_review_completed_appointment()
    {
        $appointment = Appointment::factory()->completada()->create([
            'student_id' => $this->student->id,
            'tutor_id' => $this->tutor->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->student)->post(
            "/estudiante/citas/{$appointment->id}/review",
            [
                'calificacion' => 5,
                'comentario' => 'Excelente tutor',
            ]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'appointment_id' => $appointment->id,
            'user_id' => $this->student->id,
            'calificacion' => 5,
        ]);
    }
}
