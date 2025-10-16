<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Role;
use App\Models\Seccion;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        $estudianteRole = Role::where('nombre', 'Estudiante')->first();
        
        if (!$estudianteRole) {
            $this->command->error('El rol "Estudiante" no existe. Ejecuta primero RoleSeeder.');
            return;
        }

        // Obtener algunas secciones para asignar
        $secciones = Seccion::all();

        if ($secciones->isEmpty()) {
            $this->command->error('No hay secciones disponibles. Ejecuta primero SeccionSeeder.');
            return;
        }

        // Obtener secciones específicas o usar las primeras disponibles
        $seccionA = $secciones->where('nombre', 'A')->first() ?? $secciones->first();
        $seccionB = $secciones->where('nombre', 'B')->first() ?? $secciones->skip(1)->first() ?? $secciones->first();
        $seccionC = $secciones->where('nombre', 'C')->first() ?? $secciones->skip(2)->first() ?? $secciones->first();

        // Crear estudiantes de ejemplo
        $estudiantes = [
            [
                'user' => [
                    'dni' => '44444444',
                    'nombres' => 'Juan',
                    'apellidos' => 'Pérez García',
                    'email' => 'juan.perez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionA->id,
                    'promedio_anterior' => 15.5,
                    'motivacion' => 'Alta',
                ]
            ],
            [
                'user' => [
                    'dni' => '55555555',
                    'nombres' => 'Ana',
                    'apellidos' => 'López Silva',
                    'email' => 'ana.lopez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionA->id,
                    'promedio_anterior' => 12.8,
                    'motivacion' => 'Media',
                ]
            ],
            [
                'user' => [
                    'dni' => '66666666',
                    'nombres' => 'Carlos',
                    'apellidos' => 'Rodríguez Morales',
                    'email' => 'carlos.rodriguez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionB->id,
                    'promedio_anterior' => 18.2,
                    'motivacion' => 'Alta',
                ]
            ],
            [
                'user' => [
                    'dni' => '77777777',
                    'nombres' => 'Sofía',
                    'apellidos' => 'Martínez Vega',
                    'email' => 'sofia.martinez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionB->id,
                    'promedio_anterior' => 14.0,
                    'motivacion' => 'Media',
                ]
            ],
            [
                'user' => [
                    'dni' => '88888888',
                    'nombres' => 'Diego',
                    'apellidos' => 'Fernández Ruiz',
                    'email' => 'diego.fernandez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionC->id,
                    'promedio_anterior' => 11.5,
                    'motivacion' => 'Baja',
                ]
            ],
            [
                'user' => [
                    'dni' => '99999999',
                    'nombres' => 'María',
                    'apellidos' => 'González Herrera',
                    'email' => 'maria.gonzalez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionC->id,
                    'promedio_anterior' => 16.3,
                    'motivacion' => 'Alta',
                ]
            ],
            [
                'user' => [
                    'dni' => '11223344',
                    'nombres' => 'Pedro',
                    'apellidos' => 'Ramírez Castro',
                    'email' => 'pedro.ramirez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionA->id,
                    'promedio_anterior' => 13.7,
                    'motivacion' => 'Media',
                ]
            ],
            [
                'user' => [
                    'dni' => '55667788',
                    'nombres' => 'Laura',
                    'apellidos' => 'Torres Mendoza',
                    'email' => 'laura.torres@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionB->id,
                    'promedio_anterior' => 17.8,
                    'motivacion' => 'Alta',
                ]
            ],
            [
                'user' => [
                    'dni' => '99887766',
                    'nombres' => 'Roberto',
                    'apellidos' => 'Jiménez Vargas',
                    'email' => 'roberto.jimenez@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionC->id,
                    'promedio_anterior' => 10.2,
                    'motivacion' => 'Baja',
                ]
            ],
            [
                'user' => [
                    'dni' => '12345678',
                    'nombres' => 'Valeria',
                    'apellidos' => 'Moreno Delgado',
                    'email' => 'valeria.moreno@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => $seccionA->id,
                    'promedio_anterior' => 19.1,
                    'motivacion' => 'Alta',
                ]
            ],
            // Algunos estudiantes sin sección para probar la asignación
            [
                'user' => [
                    'dni' => '87654321',
                    'nombres' => 'Miguel',
                    'apellidos' => 'Santana Ríos',
                    'email' => 'miguel.santana@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => null, // Sin sección asignada
                    'promedio_anterior' => 14.5,
                    'motivacion' => 'Media',
                ]
            ],
            [
                'user' => [
                    'dni' => '13579246',
                    'nombres' => 'Carmen',
                    'apellidos' => 'Flores Aguilar',
                    'email' => 'carmen.flores@estudiante.com',
                ],
                'estudiante' => [
                    'seccion_id' => null, // Sin sección asignada
                    'promedio_anterior' => 16.7,
                    'motivacion' => 'Alta',
                ]
            ],
        ];

        foreach ($estudiantes as $estudianteData) {
            try {
                $user = User::create([
                    'dni' => $estudianteData['user']['dni'],
                    'nombres' => $estudianteData['user']['nombres'],
                    'apellidos' => $estudianteData['user']['apellidos'],
                    'email' => $estudianteData['user']['email'],
                    'password' => Hash::make('password123'),
                    'rol_id' => $estudianteRole->id,
                    'telefono' => '999' . substr($estudianteData['user']['dni'], -6),
                ]);

                Estudiante::create(array_merge(
                    ['usuario_id' => $user->id],
                    $estudianteData['estudiante']
                ));

                $this->command->info("Estudiante creado: {$estudianteData['user']['nombres']} {$estudianteData['user']['apellidos']}");

            } catch (\Exception $e) {
                $this->command->error("Error creando estudiante {$estudianteData['user']['nombres']}: " . $e->getMessage());
            }
        }

        $this->command->info('✅ Estudiantes creados exitosamente.');
        $this->command->info('📧 Contraseña para todos: password123');
        $this->command->info('👥 Total estudiantes: ' . count($estudiantes));
        $this->command->info('📊 Distribución:');
        $this->command->info("   - Sección {$seccionA->nombre_completo}: " . collect($estudiantes)->where('estudiante.seccion_id', $seccionA->id)->count());
        if ($seccionB->id !== $seccionA->id) {
            $this->command->info("   - Sección {$seccionB->nombre_completo}: " . collect($estudiantes)->where('estudiante.seccion_id', $seccionB->id)->count());
        }
        if ($seccionC->id !== $seccionA->id && $seccionC->id !== $seccionB->id) {
            $this->command->info("   - Sección {$seccionC->nombre_completo}: " . collect($estudiantes)->where('estudiante.seccion_id', $seccionC->id)->count());
        }
        $this->command->info("   - Sin sección: " . collect($estudiantes)->whereNull('estudiante.seccion_id')->count());
    }
}