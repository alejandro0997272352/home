<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_subject_with_valid_data()
    {
        $subject = Subject::factory()->create([
            'nombre' => 'Cálculo Diferencial',
            'codigo' => 'MAT-101',
            'area' => 'Matemáticas',
        ]);

        $this->assertModelExists($subject);
        $this->assertEquals('Cálculo Diferencial', $subject->nombre);
    }

    public function test_activas_scope_returns_only_active_subjects()
    {
        Subject::factory()->create(['activo' => true]);
        Subject::factory()->create(['activo' => false]);

        $activas = Subject::activas()->get();

        $this->assertCount(1, $activas);
    }

    public function test_subject_can_have_tutors()
    {
        $subject = Subject::factory()->create();
        $tutor = User::factory()->tutor()->create();

        $subject->tutors()->attach($tutor, ['experiencia' => '3 años']);

        $this->assertCount(1, $subject->tutors);
        $this->assertTrue($subject->tutors->contains($tutor));
    }

    public function test_subject_can_have_appointments()
    {
        $subject = Subject::factory()->create();
        $appointment = Appointment::factory()->create(['subject_id' => $subject->id]);

        $this->assertCount(1, $subject->appointments);
        $this->assertEquals($appointment->id, $subject->appointments->first()->id);
    }

    public function test_subject_is_active_by_default()
    {
        $subject = Subject::factory()->create();

        $this->assertTrue($subject->activo);
    }

    public function test_subject_soft_deletes()
    {
        $subject = Subject::factory()->create();
        $subject->delete();

        $this->assertModelMissing($subject);
    }
}
