<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_appointment_with_valid_data()
    {
        $appointment = Appointment::factory()->create([
            'estado' => 'pendiente',
        ]);

        $this->assertModelExists($appointment);
        $this->assertEquals('pendiente', $appointment->estado);
    }

    public function test_belongs_to_tutor()
    {
        $tutor = User::factory()->tutor()->create();
        $appointment = Appointment::factory()->create(['tutor_id' => $tutor->id]);

        $this->assertInstanceOf(User::class, $appointment->tutor);
        $this->assertEquals($tutor->id, $appointment->tutor->id);
    }

    public function test_belongs_to_student()
    {
        $student = User::factory()->estudiante()->create();
        $appointment = Appointment::factory()->create(['student_id' => $student->id]);

        $this->assertInstanceOf(User::class, $appointment->student);
        $this->assertEquals($student->id, $appointment->student->id);
    }

    public function test_belongs_to_subject()
    {
        $subject = Subject::factory()->create();
        $appointment = Appointment::factory()->create(['subject_id' => $subject->id]);

        $this->assertInstanceOf(Subject::class, $appointment->subject);
        $this->assertEquals($subject->id, $appointment->subject->id);
    }

    public function test_has_one_review()
    {
        $appointment = Appointment::factory()->completada()->create();
        $review = Review::factory()->create(['appointment_id' => $appointment->id]);

        $this->assertInstanceOf(Review::class, $appointment->review);
        $this->assertEquals($review->id, $appointment->review->id);
    }

    public function test_scope_pendientes()
    {
        Appointment::factory()->pendiente()->create();
        Appointment::factory()->confirmada()->create();
        Appointment::factory()->completada()->create();

        $this->assertCount(1, Appointment::pendientes()->get());
    }

    public function test_scope_confirmadas()
    {
        Appointment::factory()->confirmada()->create();
        Appointment::factory()->pendiente()->create();

        $this->assertCount(1, Appointment::confirmadas()->get());
    }

    public function test_scope_completadas()
    {
        Appointment::factory()->completada()->create();
        Appointment::factory()->pendiente()->create();
        Appointment::factory()->confirmada()->create();

        $this->assertCount(1, Appointment::completadas()->get());
    }

    public function test_scope_canceladas()
    {
        Appointment::factory()->cancelada()->create();
        Appointment::factory()->pendiente()->create();

        $this->assertCount(1, Appointment::canceladas()->get());
    }

    public function test_scope_by_tutor()
    {
        $tutor1 = User::factory()->tutor()->create();
        $tutor2 = User::factory()->tutor()->create();

        Appointment::factory()->create(['tutor_id' => $tutor1->id]);
        Appointment::factory()->create(['tutor_id' => $tutor1->id]);
        Appointment::factory()->create(['tutor_id' => $tutor2->id]);

        $this->assertCount(2, Appointment::byTutor($tutor1->id)->get());
    }

    public function test_scope_by_student()
    {
        $student1 = User::factory()->estudiante()->create();
        $student2 = User::factory()->estudiante()->create();

        Appointment::factory()->create(['student_id' => $student1->id]);
        Appointment::factory()->create(['student_id' => $student2->id]);

        $this->assertCount(1, Appointment::byStudent($student1->id)->get());
    }

    public function test_scope_fecha_between()
    {
        Appointment::factory()->create(['fecha' => '2024-06-01']);
        Appointment::factory()->create(['fecha' => '2024-06-15']);
        Appointment::factory()->create(['fecha' => '2024-07-01']);

        $result = Appointment::fechaBetween('2024-06-01', '2024-06-30')->get();

        $this->assertCount(2, $result);
    }
}
