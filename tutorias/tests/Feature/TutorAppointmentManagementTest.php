<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TutorAppointmentManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $tutor;
    private User $student;
    private Subject $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tutor = User::factory()->tutor()->create();
        $this->student = User::factory()->estudiante()->create();
        $this->subject = Subject::factory()->create();
    }

    public function test_tutor_can_view_dashboard()
    {
        $response = $this->actingAs($this->tutor)->get('/tutor/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('tutor.dashboard');
    }

    public function test_tutor_can_view_appointments()
    {
        Appointment::factory()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->get('/tutor/citas');

        $response->assertStatus(200);
        $response->assertViewIs('tutor.citas');
    }

    public function test_tutor_can_confirm_pending_appointment()
    {
        $appointment = Appointment::factory()->pendiente()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/confirmar"
        );

        $response->assertRedirect();
        $this->assertEquals('confirmada', $appointment->fresh()->estado);
    }

    public function test_tutor_cannot_confirm_other_tutor_appointment()
    {
        $otherTutor = User::factory()->tutor()->create();
        $appointment = Appointment::factory()->pendiente()->create([
            'tutor_id' => $otherTutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/confirmar"
        );

        $response->assertStatus(403);
    }

    public function test_tutor_can_complete_confirmed_appointment()
    {
        $appointment = Appointment::factory()->confirmada()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/completar"
        );

        $response->assertRedirect();
        $this->assertEquals('completada', $appointment->fresh()->estado);
    }

    public function test_completing_appointment_increments_session_count()
    {
        $appointment = Appointment::factory()->confirmada()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/completar"
        );

        $this->assertEquals(
            1,
            $this->tutor->tutorProfile->fresh()->total_sesiones
        );
    }

    public function test_tutor_cannot_complete_pending_appointment()
    {
        $appointment = Appointment::factory()->pendiente()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/completar"
        );

        $response->assertStatus(403);
    }

    public function test_tutor_can_cancel_appointment()
    {
        $appointment = Appointment::factory()->pendiente()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/cancelar",
            ['motivo_cancelacion' => 'Problemas de horario']
        );

        $response->assertRedirect();
        $this->assertEquals('cancelada', $appointment->fresh()->estado);
    }

    public function test_tutor_cancellation_requires_reason()
    {
        $appointment = Appointment::factory()->pendiente()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->patch(
            "/tutor/citas/{$appointment->id}/cancelar",
            ['motivo_cancelacion' => '']
        );

        $response->assertSessionHasErrors('motivo_cancelacion');
    }

    public function test_tutor_can_filter_appointments_by_status()
    {
        Appointment::factory()->pendiente()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);
        Appointment::factory()->completada()->create([
            'tutor_id' => $this->tutor->id,
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
        ]);

        $response = $this->actingAs($this->tutor)->get('/tutor/citas?estado=pendiente');

        $response->assertStatus(200);
    }
}
