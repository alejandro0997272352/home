<?php

namespace Tests\Unit;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_availability_with_valid_data()
    {
        $availability = Availability::factory()->create();

        $this->assertModelExists($availability);
        $this->assertContains($availability->dia_semana, Availability::dias());
    }

    public function test_belongs_to_user()
    {
        $tutor = User::factory()->tutor()->create();
        $availability = Availability::factory()->create(['user_id' => $tutor->id]);

        $this->assertInstanceOf(User::class, $availability->user);
        $this->assertEquals($tutor->id, $availability->user->id);
    }

    public function test_dias_returns_weekdays()
    {
        $dias = Availability::dias();

        $this->assertCount(6, $dias);
        $this->assertEquals(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'], $dias);
    }

    public function test_is_active_by_default()
    {
        $availability = Availability::factory()->create();

        $this->assertTrue($availability->activo);
    }

    public function test_can_be_inactive()
    {
        $availability = Availability::factory()->inactive()->create();

        $this->assertFalse($availability->activo);
    }

    public function test_hora_inicio_is_before_hora_fin()
    {
        $availability = Availability::factory()->create();

        $this->assertLessThan($availability->hora_fin, $availability->hora_inicio);
    }
}
