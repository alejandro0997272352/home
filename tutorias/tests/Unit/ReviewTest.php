<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_review_with_valid_data()
    {
        $review = Review::factory()->create([
            'calificacion' => 5,
        ]);

        $this->assertModelExists($review);
        $this->assertEquals(5, $review->calificacion);
    }

    public function test_belongs_to_appointment()
    {
        $appointment = Appointment::factory()->completada()->create();
        $review = Review::factory()->create(['appointment_id' => $appointment->id]);

        $this->assertInstanceOf(Appointment::class, $review->appointment);
        $this->assertEquals($appointment->id, $review->appointment->id);
    }

    public function test_belongs_to_user()
    {
        $user = User::factory()->estudiante()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $review->user);
        $this->assertEquals($user->id, $review->user->id);
    }

    public function test_calificacion_is_between_one_and_five()
    {
        $review = Review::factory()->create();

        $this->assertGreaterThanOrEqual(1, $review->calificacion);
        $this->assertLessThanOrEqual(5, $review->calificacion);
    }

    public function test_comentario_is_optional()
    {
        $review = Review::factory()->create(['comentario' => null]);

        $this->assertNull($review->comentario);
    }
}
