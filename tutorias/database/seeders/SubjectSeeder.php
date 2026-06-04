<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['nombre' => 'Cálculo Diferencial', 'codigo' => 'MAT-101', 'area' => 'Matemáticas', 'creditos' => 8],
            ['nombre' => 'Cálculo Integral', 'codigo' => 'MAT-102', 'area' => 'Matemáticas', 'creditos' => 8],
            ['nombre' => 'Álgebra Lineal', 'codigo' => 'MAT-103', 'area' => 'Matemáticas', 'creditos' => 7],
            ['nombre' => 'Ecuaciones Diferenciales', 'codigo' => 'MAT-201', 'area' => 'Matemáticas', 'creditos' => 8],
            ['nombre' => 'Programación I', 'codigo' => 'COM-101', 'area' => 'Computación', 'creditos' => 6],
            ['nombre' => 'Programación II', 'codigo' => 'COM-102', 'area' => 'Computación', 'creditos' => 6],
            ['nombre' => 'Estructuras de Datos', 'codigo' => 'COM-201', 'area' => 'Computación', 'creditos' => 7],
            ['nombre' => 'Bases de Datos', 'codigo' => 'COM-202', 'area' => 'Computación', 'creditos' => 7],
            ['nombre' => 'Física I', 'codigo' => 'FIS-101', 'area' => 'Física', 'creditos' => 8],
            ['nombre' => 'Física II', 'codigo' => 'FIS-102', 'area' => 'Física', 'creditos' => 8],
            ['nombre' => 'Química General', 'codigo' => 'QUI-101', 'area' => 'Química', 'creditos' => 7],
            ['nombre' => 'Probabilidad y Estadística', 'codigo' => 'MAT-301', 'area' => 'Matemáticas', 'creditos' => 7],
            ['nombre' => 'Redes de Computadoras', 'codigo' => 'COM-301', 'area' => 'Computación', 'creditos' => 6],
            ['nombre' => 'Inglés Técnico', 'codigo' => 'ING-101', 'area' => 'Idiomas', 'creditos' => 4],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
