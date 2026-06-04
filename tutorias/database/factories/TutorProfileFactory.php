<?php

namespace Database\Factories;

use App\Models\TutorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorProfileFactory extends Factory
{
    protected $model = TutorProfile::class;

    public function definition(): array
    {
        return [
            'biografia' => fake()->paragraph(),
            'formacion_academica' => fake()->sentence(),
            'calificacion_promedio' => fake()->randomFloat(2, 3, 5),
            'total_sesiones' => fake()->numberBetween(0, 500),
            'tarifa_por_hora' => fake()->randomFloat(2, 50, 500),
        ];
    }
}
