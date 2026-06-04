<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tutorias.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'telefono' => '555-0000-000',
            'activo' => true,
        ]);

        $tutor = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'juan@tutorias.com',
            'password' => Hash::make('tutor123'),
            'role' => 'tutor',
            'telefono' => '555-0000-001',
            'activo' => true,
        ]);

        $tutor->tutorProfile()->create([
            'biografia' => 'Doctor en Matemáticas con 10 años de experiencia docente.',
            'formacion_academica' => 'Doctorado en Matemáticas - UNAM',
            'tarifa_por_hora' => 200,
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria@tutorias.com',
            'password' => Hash::make('estudiante123'),
            'role' => 'estudiante',
            'telefono' => '555-0000-002',
            'activo' => true,
        ]);
    }
}
