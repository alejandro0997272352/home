<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        $areas = ['Matemáticas', 'Computación', 'Física', 'Química', 'Idiomas'];

        return [
            'nombre' => fake()->unique()->words(3, true),
            'codigo' => strtoupper(fake()->lexify('???-###')),
            'descripcion' => fake()->sentence(),
            'area' => fake()->randomElement($areas),
            'creditos' => fake()->numberBetween(4, 10),
            'activo' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }
}
