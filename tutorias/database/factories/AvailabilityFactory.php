<?php

namespace Database\Factories;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    protected $model = Availability::class;

    public function definition(): array
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $horaInicio = fake()->numberBetween(7, 17);
        $horaFin = min($horaInicio + fake()->numberBetween(1, 4), 21);

        return [
            'user_id' => User::factory()->tutor(),
            'dia_semana' => fake()->randomElement($dias),
            'hora_inicio' => sprintf('%02d:00', $horaInicio),
            'hora_fin' => sprintf('%02d:00', $horaFin),
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
