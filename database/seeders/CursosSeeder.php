<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Docente;

class CursosSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => 'Matemática I',
                'codigo' => 'MAT-101',
                'descripcion' => 'Curso de matemática básica: álgebra, geometría y trigonometría',
                'docente_id' => 1,
            ],
            [
                'nombre' => 'Comunicación I',
                'codigo' => 'COM-101',
                'descripcion' => 'Lenguaje, literatura y comprensión lectora',
                'docente_id' => 2,
            ],
            [
                'nombre' => 'Inglés',
                'codigo' => 'ING-101',
                'descripcion' => 'Idioma inglés nivel básico e intermedio',
                'docente_id' => 3,
            ],
            [
                'nombre' => 'Ciencia y Tecnología',
                'codigo' => 'CYT-101',
                'descripcion' => 'Biología, química y ciencias naturales',
                'docente_id' => 4,
            ],
            [
                'nombre' => 'Física',
                'codigo' => 'FIS-101',
                'descripcion' => 'Física básica y experimental',
                'docente_id' => 5,
            ],
            [
                'nombre' => 'Historia',
                'codigo' => 'HIS-101',
                'descripcion' => 'Historia del Perú y universal',
                'docente_id' => 6,
            ],
            [
                'nombre' => 'Geografía',
                'codigo' => 'GEO-101',
                'descripcion' => 'Geografía física, humana y económica',
                'docente_id' => 7,
            ],
            [
                'nombre' => 'Educación Física',
                'codigo' => 'EDF-101',
                'descripcion' => 'Deportes, atletismo y actividad física',
                'docente_id' => 8,
            ],
            [
                'nombre' => 'Arte y Cultura',
                'codigo' => 'ART-101',
                'descripcion' => 'Artes plásticas, música y danza',
                'docente_id' => 9,
            ],
            [
                'nombre' => 'Computación',
                'codigo' => 'COM-102',
                'descripcion' => 'Informática, programación y ofimática',
                'docente_id' => 10,
            ],
            [
                'nombre' => 'Educación Cívica',
                'codigo' => 'CIV-101',
                'descripcion' => 'Formación ciudadana y cívica',
                'docente_id' => 11,
            ],
            [
                'nombre' => 'Tutoría',
                'codigo' => 'TUT-101',
                'descripcion' => 'Orientación y tutoría escolar',
                'docente_id' => 12,
            ],
            [
                'nombre' => 'Religión',
                'codigo' => 'REL-101',
                'descripcion' => 'Educación religiosa y formación en valores',
                'docente_id' => 13,
            ],
        ];

        foreach ($cursos as $cursoData) {
            Curso::create($cursoData);
        }
    }
}