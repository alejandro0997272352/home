<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Subject;
use App\Models\TutorProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_user_with_valid_data()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'estudiante',
        ]);

        $this->assertModelExists($user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    public function test_admin_role_check()
    {
        $admin = User::factory()->admin()->create();
        $tutor = User::factory()->tutor()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($tutor->isAdmin());
    }

    public function test_tutor_role_check()
    {
        $tutor = User::factory()->tutor()->create();
        $student = User::factory()->estudiante()->create();

        $this->assertTrue($tutor->isTutor());
        $this->assertFalse($student->isTutor());
    }

    public function test_estudiante_role_check()
    {
        $student = User::factory()->estudiante()->create();
        $admin = User::factory()->admin()->create();

        $this->assertTrue($student->isEstudiante());
        $this->assertFalse($admin->isEstudiante());
    }

    public function test_tutor_scope_returns_only_active_tutors()
    {
        User::factory()->tutor()->create(['activo' => true]);
        User::factory()->tutor()->create(['activo' => false]);
        User::factory()->admin()->create(['activo' => true]);

        $tutores = User::tutores()->get();

        $this->assertCount(1, $tutores);
        $this->assertTrue($tutores->first()->isTutor());
    }

    public function test_estudiante_scope_returns_only_students()
    {
        User::factory()->estudiante()->create();
        User::factory()->tutor()->create();
        User::factory()->admin()->create();

        $estudiantes = User::estudiantes()->get();

        $this->assertCount(1, $estudiantes);
        $this->assertTrue($estudiantes->first()->isEstudiante());
    }

    public function test_tutor_has_tutor_profile()
    {
        $tutor = User::factory()->tutor()->create();

        $this->assertNotNull($tutor->tutorProfile);
        $this->assertInstanceOf(TutorProfile::class, $tutor->tutorProfile);
        $this->assertEquals($tutor->id, $tutor->tutorProfile->user_id);
    }

    public function test_non_tutor_has_no_tutor_profile()
    {
        $student = User::factory()->estudiante()->create();

        $this->assertNull($student->tutorProfile);
    }

    public function test_tutor_can_have_subjects()
    {
        $tutor = User::factory()->tutor()->create();
        $subject = Subject::factory()->create();

        $tutor->subjects()->attach($subject, ['experiencia' => '5 años']);

        $this->assertCount(1, $tutor->subjects);
        $this->assertTrue($tutor->subjects->contains($subject));
        $this->assertEquals('5 años', $tutor->subjects->first()->pivot->experiencia);
    }

    public function test_tutor_has_availability_slots()
    {
        $tutor = User::factory()->tutor()->create();
        $availability = Availability::factory()->create(['user_id' => $tutor->id]);

        $this->assertCount(1, $tutor->availability);
        $this->assertEquals($availability->id, $tutor->availability->first()->id);
    }

    public function test_tutor_has_tutor_appointments()
    {
        $tutor = User::factory()->tutor()->create();
        $student = User::factory()->estudiante()->create();
        $subject = Subject::factory()->create();

        $appointment = Appointment::factory()->create([
            'tutor_id' => $tutor->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
        ]);

        $this->assertCount(1, $tutor->tutorAppointments);
        $this->assertEquals($appointment->id, $tutor->tutorAppointments->first()->id);
    }

    public function test_student_has_student_appointments()
    {
        $tutor = User::factory()->tutor()->create();
        $student = User::factory()->estudiante()->create();
        $subject = Subject::factory()->create();

        $appointment = Appointment::factory()->create([
            'tutor_id' => $tutor->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
        ]);

        $this->assertCount(1, $student->studentAppointments);
        $this->assertEquals($appointment->id, $student->studentAppointments->first()->id);
    }

    public function test_password_is_hashed()
    {
        $user = User::factory()->create(['password' => bcrypt('plain-text')]);

        $this->assertNotEquals('plain-text', $user->password);
    }
}
