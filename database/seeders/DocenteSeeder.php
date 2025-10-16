<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Docente;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $docentes = [
            [
                'dni' => '12335678',
                'nombres' => 'Carlos',
                'apellidos' => 'Mendoza Ríos',
                'name' => 'Carlos Mendoza Ríos',
                'email' => 'carlos.mendoza@colegio.edu',
                'especialidad' => 'Matemáticas',
                'bio' => 'Licenciado en Matemáticas con 10 años de experiencia en educación secundaria. Especialista en álgebra y geometría.',
            ],
            [
                'dni' => '23456789',
                'nombres' => 'María',
                'apellidos' => 'González Pérez',
                'name' => 'María González Pérez',
                'email' => 'maria.gonzalez@colegio.edu',
                'especialidad' => 'Comunicación',
                'bio' => 'Licenciada en Literatura y Lengua Española. Especialista en comprensión lectora y redacción.',
            ],
            [
                'dni' => '34567890',
                'nombres' => 'Roberto',
                'apellidos' => 'Silva Chang',
                'name' => 'Roberto Silva Chang',
                'email' => 'roberto.silva@colegio.edu',
                'especialidad' => 'Idiomas',
                'bio' => 'Profesor de inglés certificado con nivel C2. Experiencia en preparación para exámenes internacionales.',
            ],
            [
                'dni' => '45678901',
                'nombres' => 'José',
                'apellidos' => 'Ramírez Torres',
                'name' => 'José Ramírez Torres',
                'email' => 'jose.ramirez@colegio.edu',
                'especialidad' => 'Ciencias Naturales',
                'bio' => 'Biólogo con maestría en educación. Especialista en ciencias naturales y experimentación científica.',
            ],
            [
                'dni' => '56789012',
                'nombres' => 'Daniel',
                'apellidos' => 'Herrera Campos',
                'name' => 'Daniel Herrera Campos',
                'email' => 'daniel.herrera@colegio.edu',
                'especialidad' => 'Física',
                'bio' => 'Físico con doctorado en educación. Especialista en física experimental y mecánica.',
            ],
            [
                'dni' => '67890123',
                'nombres' => 'Ana',
                'apellidos' => 'Torres Vega',
                'name' => 'Ana Torres Vega',
                'email' => 'ana.torres@colegio.edu',
                'especialidad' => 'Historia',
                'bio' => 'Historiadora especializada en historia del Perú y América Latina. Experiencia en investigación histórica.',
            ],
            [
                'dni' => '78901234',
                'nombres' => 'Carmen',
                'apellidos' => 'Vega Morales',
                'name' => 'Carmen Vega Morales',
                'email' => 'carmen.vega@colegio.edu',
                'especialidad' => 'Geografía',
                'bio' => 'Geógrafa con especialización en geografía humana y económica. Experta en cartografía.',
            ],
            [
                'dni' => '89012345',
                'nombres' => 'Luis',
                'apellidos' => 'Paredes Díaz',
                'name' => 'Luis Paredes Díaz',
                'email' => 'luis.paredes@colegio.edu',
                'especialidad' => 'Educación Física',
                'bio' => 'Licenciado en Educación Física. Entrenador deportivo certificado con experiencia en atletismo y fútbol.',
            ],
            [
                'dni' => '90123456',
                'nombres' => 'Patricia',
                'apellidos' => 'Flores Quispe',
                'name' => 'Patricia Flores Quispe',
                'email' => 'patricia.flores@colegio.edu',
                'especialidad' => 'Arte y Música',
                'bio' => 'Artista plástica y musicóloga. Especialista en artes visuales, danza y música folklórica.',
            ],
            [
                'dni' => '01234567',
                'nombres' => 'Fernando',
                'apellidos' => 'Rojas Castro',
                'name' => 'Fernando Rojas Castro',
                'email' => 'fernando.rojas@colegio.edu',
                'especialidad' => 'Computación e Informática',
                'bio' => 'Ingeniero de sistemas con certificaciones en programación. Especialista en desarrollo web y bases de datos.',
            ],
            [
                'dni' => '11234567',
                'nombres' => 'Laura',
                'apellidos' => 'Sánchez Vargas',
                'name' => 'Laura Sánchez Vargas',
                'email' => 'laura.sanchez@colegio.edu',
                'especialidad' => 'Educación Cívica',
                'bio' => 'Abogada especializada en derecho constitucional y educación ciudadana. Promotora de valores democráticos.',
            ],
            [
                'dni' => '22345678',
                'nombres' => 'Miguel Ángel',
                'apellidos' => 'Castro León',
                'name' => 'Miguel Ángel Castro León',
                'email' => 'miguel.castro@colegio.edu',
                'especialidad' => 'Psicología y Tutoría',
                'bio' => 'Psicólogo educativo con maestría en orientación vocacional. Especialista en desarrollo adolescente.',
            ],
            [
                'dni' => '33456789',
                'nombres' => 'Gabriela',
                'apellidos' => 'Morales Huamán',
                'name' => 'Gabriela Morales Huamán',
                'email' => 'gabriela.morales@colegio.edu',
                'especialidad' => 'Religión',
                'bio' => 'Licenciada en Ciencias Religiosas y Teología. Especialista en formación en valores y ética cristiana.',
            ],
        ];

        // Obtener el rol de docente
        $roleDocente = Role::where('nombre', 'Docente')->first();

        foreach ($docentes as $docenteData) {
            // Crear usuario
            $user = User::create([
                'dni' => $docenteData['dni'],
                'nombres' => $docenteData['nombres'],
                'apellidos' => $docenteData['apellidos'],
                'name' => $docenteData['name'],
                'email' => $docenteData['email'],
                'password' => Hash::make('password123'),
                'rol_id' => $roleDocente->id,  // Usar rol_id en lugar de role_id
            ]);

            // Crear docente
            Docente::create([
                'usuario_id' => $user->id,
                'especialidad' => $docenteData['especialidad'],
                'bio' => $docenteData['bio'],
            ]);
        }
    }
}