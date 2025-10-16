<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    public function run(): void
    {
        $secciones = [
            // Primaria
            ['nombre' => 'A', 'grado' => '1° Primaria'],
            ['nombre' => 'B', 'grado' => '1° Primaria'],
            ['nombre' => 'A', 'grado' => '2° Primaria'],
            ['nombre' => 'B', 'grado' => '2° Primaria'],
            ['nombre' => 'A', 'grado' => '3° Primaria'],
            ['nombre' => 'B', 'grado' => '3° Primaria'],
            ['nombre' => 'A', 'grado' => '4° Primaria'],
            ['nombre' => 'B', 'grado' => '4° Primaria'],
            ['nombre' => 'A', 'grado' => '5° Primaria'],
            ['nombre' => 'B', 'grado' => '5° Primaria'],
            ['nombre' => 'A', 'grado' => '6° Primaria'],
            ['nombre' => 'B', 'grado' => '6° Primaria'],

            // Secundaria
            ['nombre' => 'A', 'grado' => '1° Secundaria'],
            ['nombre' => 'B', 'grado' => '1° Secundaria'],
            ['nombre' => 'C', 'grado' => '1° Secundaria'],
            ['nombre' => 'A', 'grado' => '2° Secundaria'],
            ['nombre' => 'B', 'grado' => '2° Secundaria'],
            ['nombre' => 'C', 'grado' => '2° Secundaria'],
            ['nombre' => 'A', 'grado' => '3° Secundaria'],
            ['nombre' => 'B', 'grado' => '3° Secundaria'],
            ['nombre' => 'C', 'grado' => '3° Secundaria'],
            ['nombre' => 'A', 'grado' => '4° Secundaria'],
            ['nombre' => 'B', 'grado' => '4° Secundaria'],
            ['nombre' => 'C', 'grado' => '4° Secundaria'],
            ['nombre' => 'A', 'grado' => '5° Secundaria'],
            ['nombre' => 'B', 'grado' => '5° Secundaria'],
            ['nombre' => 'C', 'grado' => '5° Secundaria'],

            // Secciones generales (sin grado específico)
            ['nombre' => 'General A', 'grado' => null],
            ['nombre' => 'General B', 'grado' => null],
        ];

        foreach ($secciones as $seccion) {
            Seccion::create($seccion);
        }

        $this->command->info('Secciones creadas exitosamente.');
    }
}