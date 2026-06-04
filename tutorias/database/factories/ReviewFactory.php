<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory()->completada(),
            'user_id' => User::factory()->estudiante(),
            'calificacion' => fake()->numberBetween(1, 5),
            'comentario' => fake()->optional(0.8)->sentence(),
        ];
    }
}
