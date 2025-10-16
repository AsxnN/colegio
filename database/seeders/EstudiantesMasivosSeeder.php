<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Role;
use App\Models\Seccion;
use App\Models\Curso;
use App\Models\Nota;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class EstudiantesMasivosSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        
        $estudianteRole = Role::where('nombre', 'Estudiante')->first();
        
        if (!$estudianteRole) {
            $this->command->error('El rol "Estudiante" no existe. Ejecuta primero RoleSeeder.');
            return;
        }

        $secciones = Seccion::all();
        if ($secciones->isEmpty()) {
            $this->command->error('No hay secciones disponibles. Ejecuta primero SeccionSeeder.');
            return;
        }

        $cursos = Curso::all();
        if ($cursos->isEmpty()) {
            $this->command->error('No hay cursos disponibles. Ejecuta primero CursoSeeder.');
            return;
        }

        if ($cursos->count() < 13) {
            $this->command->error('Se requieren 13 cursos. Solo hay ' . $cursos->count() . ' cursos disponibles.');
            return;
        }

        $this->command->info('🚀 Iniciando creación de 200 estudiantes...');
        $this->command->info('📚 Todos los estudiantes tendrán los 13 cursos');
        $this->command->info('🏫 Todos los estudiantes estarán en una sección');
        $this->command->info('');
        
        // Nombres comunes peruanos
        $nombresHombres = [
            'Juan', 'Carlos', 'José', 'Luis', 'Miguel', 'Jorge', 'Pedro', 'Manuel',
            'Francisco', 'Antonio', 'Diego', 'Fernando', 'Ricardo', 'Alberto', 'Roberto',
            'Alejandro', 'Daniel', 'Javier', 'Andrés', 'Pablo', 'Rafael', 'Sergio',
            'Raúl', 'Víctor', 'Eduardo', 'Gustavo', 'Óscar', 'César', 'Gabriel', 'Martín'
        ];

        $nombresMujeres = [
            'María', 'Carmen', 'Ana', 'Rosa', 'Isabel', 'Teresa', 'Patricia', 'Laura',
            'Sofía', 'Claudia', 'Gabriela', 'Andrea', 'Mónica', 'Sandra', 'Verónica',
            'Diana', 'Paola', 'Natalia', 'Valeria', 'Lucía', 'Daniela', 'Carolina',
            'Fernanda', 'Paula', 'Adriana', 'Elena', 'Julia', 'Beatriz', 'Alejandra', 'Victoria'
        ];

        $apellidos = [
            'García', 'Rodríguez', 'Martínez', 'López', 'González', 'Pérez', 'Sánchez',
            'Ramírez', 'Torres', 'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales',
            'Reyes', 'Jiménez', 'Hernández', 'Ruiz', 'Vargas', 'Castro', 'Romero',
            'Vega', 'Mendoza', 'Silva', 'Rojas', 'Medina', 'Ortiz', 'Delgado', 'Herrera',
            'Gutiérrez', 'Chávez', 'Quispe', 'Huamán', 'Ccama', 'Mamani', 'Condori',
            'Paredes', 'Aguilar', 'Salazar', 'Campos', 'Navarro', 'León', 'Moreno'
        ];

        $motivaciones = ['Alta', 'Media', 'Baja'];

        $estudiantesCreados = 0;
        $intentos = 0;
        $maxIntentos = 300;

        while ($estudiantesCreados < 200 && $intentos < $maxIntentos) {
            $intentos++;
            
            // Generar DNI único
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Verificar si el DNI ya existe
            if (User::where('dni', $dni)->exists()) {
                continue;
            }

            // Generar datos aleatorios
            $esHombre = rand(0, 1);
            $nombre = $esHombre 
                ? $nombresHombres[array_rand($nombresHombres)]
                : $nombresMujeres[array_rand($nombresMujeres)];
            
            $apellido1 = $apellidos[array_rand($apellidos)];
            $apellido2 = $apellidos[array_rand($apellidos)];
            $apellidosCompletos = "$apellido1 $apellido2";
            $nombreCompleto = "$nombre $apellidosCompletos";

            // Generar email único
            $emailBase = strtolower(
                $this->removeAccents($nombre) . '.' . 
                $this->removeAccents($apellido1) . 
                rand(1, 999)
            );
            $email = $emailBase . '@estudiante.com';

            try {
                // Crear usuario
                $user = User::create([
                    'dni' => $dni,
                    'nombres' => $nombre,
                    'apellidos' => $apellidosCompletos,
                    'name' => $nombreCompleto,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'rol_id' => $estudianteRole->id,
                    'telefono' => '9' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                ]);

                // Asignar sección aleatoria (TODOS los estudiantes tendrán sección)
                $seccionId = $secciones->random()->id;

                // Crear estudiante
                $estudiante = Estudiante::create([
                    'usuario_id' => $user->id,
                    'seccion_id' => $seccionId,
                    'promedio_anterior' => round(rand(800, 2000) / 100, 2), // 8.00 a 20.00
                    'motivacion' => $motivaciones[array_rand($motivaciones)],
                ]);

                // Asignar TODOS los 13 cursos a cada estudiante
                foreach ($cursos as $curso) {
                    // Generar notas aleatorias para cada bimestre
                    $bim1 = $this->generarNota();
                    $bim2 = $this->generarNota();
                    $bim3 = $this->generarNota();
                    $bim4 = $this->generarNota();

                    // Crear nota
                    $nota = Nota::create([
                        'estudiante_id' => $estudiante->id,
                        'curso_id' => $curso->id,
                        'bimestre1' => $bim1,
                        'bimestre2' => $bim2,
                        'bimestre3' => $bim3,
                        'bimestre4' => $bim4,
                    ]);

                    // Calcular promedio
                    $nota->calcularPromedio();
                }

                $estudiantesCreados++;

                if ($estudiantesCreados % 20 == 0) {
                    $this->command->info("✅ Creados {$estudiantesCreados}/200 estudiantes...");
                }

            } catch (\Exception $e) {
                $this->command->warn("⚠️  Error creando estudiante (intento {$intentos}): " . $e->getMessage());
                continue;
            }
        }

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('✅ PROCESO COMPLETADO');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info("👥 Total estudiantes creados: {$estudiantesCreados}");
        $this->command->info('📧 Contraseña para todos: password123');
        $this->command->info('📚 Cursos por estudiante: 13 (todos los cursos)');
        $this->command->info('');
        
        // Estadísticas por sección
        $this->command->info('📊 DISTRIBUCIÓN POR SECCIÓN:');
        foreach ($secciones as $seccion) {
            $count = Estudiante::where('seccion_id', $seccion->id)->count();
            $porcentaje = $estudiantesCreados > 0 ? round(($count / $estudiantesCreados) * 100, 1) : 0;
            $this->command->info("   - {$seccion->nombre_completo}: {$count} estudiantes ({$porcentaje}%)");
        }
        
        // Estadísticas de notas
        $this->command->info('');
        $this->command->info('📝 ESTADÍSTICAS DE NOTAS:');
        $totalNotas = Nota::count();
        $aprobados = Nota::where('promedio_final', '>=', 14)->count();
        $desaprobados = Nota::where('promedio_final', '<', 14)->whereNotNull('promedio_final')->count();
        
        $this->command->info("   - Total de notas registradas: {$totalNotas}");
        $this->command->info("   - Aprobados: {$aprobados}");
        $this->command->info("   - Desaprobados: {$desaprobados}");
        
        if ($totalNotas > 0) {
            $promedioGeneral = Nota::whereNotNull('promedio_final')->avg('promedio_final');
            $this->command->info("   - Promedio general: " . round($promedioGeneral, 2));
        }
        
        // Estadísticas por curso
        $this->command->info('');
        $this->command->info('📊 ESTADÍSTICAS POR CURSO:');
        foreach ($cursos as $curso) {
            $promedioCurso = Nota::where('curso_id', $curso->id)
                ->whereNotNull('promedio_final')
                ->avg('promedio_final');
            $this->command->info("   - {$curso->nombre}: " . round($promedioCurso, 2));
        }
        
        $this->command->info('═══════════════════════════════════════════════');
    }

    /**
     * Generar nota aleatoria con distribución realista
     */
    private function generarNota(): ?float
    {
        // 3% de probabilidad de no tener nota (reducido de 5%)
        if (rand(1, 100) <= 3) {
            return null;
        }

        // Distribución de notas más realista
        $random = rand(1, 100);
        
        if ($random <= 10) {
            // 10% notas bajas (8-11)
            return round(rand(800, 1100) / 100, 2);
        } elseif ($random <= 30) {
            // 20% notas medias-bajas (11-13)
            return round(rand(1100, 1300) / 100, 2);
        } elseif ($random <= 70) {
            // 40% notas medias (13-16)
            return round(rand(1300, 1600) / 100, 2);
        } elseif ($random <= 90) {
            // 20% notas buenas (16-18)
            return round(rand(1600, 1800) / 100, 2);
        } else {
            // 10% notas excelentes (18-20)
            return round(rand(1800, 2000) / 100, 2);
        }
    }

    /**
     * Remover acentos de texto
     */
    private function removeAccents(string $text): string
    {
        $unwanted_array = [
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
            'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
            'ñ'=>'n', 'Ñ'=>'N'
        ];
        return strtr($text, $unwanted_array);
    }
}