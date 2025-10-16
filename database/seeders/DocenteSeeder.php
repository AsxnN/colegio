<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Docente;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $docenteRole = Role::where('nombre', 'Docente')->first();
        
        if (!$docenteRole) {
            $this->command->error('El rol "Docente" no existe. Ejecuta primero RoleSeeder.');
            return;
        }

        // Crear docentes de ejemplo
        $docentes = [
            [
                'user' => [
                    'dni' => '11111111',
                    'nombres' => 'Ana',
                    'apellidos' => 'Matemática',
                    'email' => 'ana.matematica@colegio.com',
                ],
                'docente' => [
                    'especialidad' => 'Matemáticas',
                    'grado_academico' => 'Licenciado',
                    'fecha_ingreso' => '2023-01-15',
                ]
            ],
            [
                'user' => [
                    'dni' => '22222222',
                    'nombres' => 'Carlos',
                    'apellidos' => 'Historia',
                    'email' => 'carlos.historia@colegio.com',
                ],
                'docente' => [
                    'especialidad' => 'Historia',
                    'grado_academico' => 'Magíster',
                    'fecha_ingreso' => '2022-08-20',
                ]
            ],
            [
                'user' => [
                    'dni' => '33333333',
                    'nombres' => 'María',
                    'apellidos' => 'Ciencias',
                    'email' => 'maria.ciencias@colegio.com',
                ],
                'docente' => [
                    'especialidad' => 'Ciencias Naturales',
                    'grado_academico' => 'Doctor',
                    'fecha_ingreso' => '2021-03-10',
                ]
            ],
        ];

        foreach ($docentes as $docenteData) {
            $user = User::create([
                'dni' => $docenteData['user']['dni'],
                'nombres' => $docenteData['user']['nombres'],
                'apellidos' => $docenteData['user']['apellidos'],
                'email' => $docenteData['user']['email'],
                'password' => Hash::make('password123'),
                'rol_id' => $docenteRole->id,
                'telefono' => '999' . substr($docenteData['user']['dni'], -6),
                'creado_en' => now(),
            ]);

            Docente::create([
                'usuario_id' => $user->id,
                'especialidad' => $docenteData['docente']['especialidad'],
                'grado_academico' => $docenteData['docente']['grado_academico'],
                'telefono' => '555' . substr($docenteData['user']['dni'], -6),
                'direccion' => 'Dirección del docente ' . $docenteData['user']['nombres'],
                'fecha_ingreso' => $docenteData['docente']['fecha_ingreso'],
                'estado' => 'Activo',
            ]);
        }

        $this->command->info('Docentes creados exitosamente.');
        $this->command->info('Contraseña para todos: password123');
    }
}