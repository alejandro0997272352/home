<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $estados = ['pendiente', 'confirmada', 'completada', 'cancelada'];
        $estado = fake()->randomElement($estados);
        $horaInicio = fake()->numberBetween(7, 18);
        $horaFin = $horaInicio + 1;

        $data = [
            'tutor_id' => User::factory()->tutor(),
            'student_id' => User::factory()->estudiante(),
            'subject_id' => Subject::factory(),
            'fecha' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora_inicio' => sprintf('%02d:00', $horaInicio),
            'hora_fin' => sprintf('%02d:00', $horaFin),
            'notas' => fake()->optional()->sentence(),
            'estado' => $estado,
            'modalidad' => fake()->randomElement(['presencial', 'en linea']),
            'ubicacion' => fake()->optional()->address(),
        ];

        if ($estado === 'cancelada') {
            $data['motivo_cancelacion'] = fake()->sentence();
            $data['cancelado_en'] = now();
        }

        if ($estado === 'completada') {
            $data['notas_tutor'] = fake()->optional()->sentence();
        }

        return $data;
    }

    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'pendiente',
            'motivo_cancelacion' => null,
            'cancelado_en' => null,
            'notas_tutor' => null,
        ]);
    }

    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'confirmada',
            'motivo_cancelacion' => null,
            'cancelado_en' => null,
        ]);
    }

    public function completada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'completada',
            'notas_tutor' => fake()->sentence(),
        ]);
    }

    public function cancelada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'cancelada',
            'motivo_cancelacion' => fake()->sentence(),
            'cancelado_en' => now(),
        ]);
    }
}
