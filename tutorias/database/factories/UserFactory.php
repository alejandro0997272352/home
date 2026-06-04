<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'estudiante',
            'telefono' => fake()->phoneNumber(),
            'activo' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function tutor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'tutor',
        ]);
    }

    public function estudiante(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'estudiante',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if ($user->role === 'tutor') {
                $user->tutorProfile()->create(
                    TutorProfileFactory::new()->definition()
                );
            }
        });
    }
}
