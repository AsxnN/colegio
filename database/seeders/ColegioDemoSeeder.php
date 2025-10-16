<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ColegioDemoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Limpieza básica por si ya corriste algo antes
        DB::table('recomendaciones_ia')->truncate();
        DB::table('predicciones_rendimiento')->truncate();
        DB::table('asistencias')->truncate();
        DB::table('notas')->truncate();
        DB::table('estudiantes')->truncate();
        DB::table('secciones')->truncate();
        DB::table('cursos')->truncate();
        DB::table('docentes')->truncate();
        DB::table('administradores')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // =============================
        // 1) ROLES
        // =============================
        $roles = [
            ['id' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Acceso total'],
            ['id' => 2, 'nombre' => 'Docente', 'descripcion' => 'Gestiona cursos y evaluaciones'],
            ['id' => 3, 'nombre' => 'Estudiante', 'descripcion' => 'Acceso a su progreso'],
        ];
        DB::table('roles')->insert($roles);

        // =============================
        // 2) ADMIN BASE (opcional)
        // =============================
        $adminId = DB::table('users')->insertGetId([
            'dni' => '70000000',
            'nombres' => 'Juan Carlos',
            'apellidos' => 'Administrador',
            'name' => 'Juan Carlos Admin',
            'email' => 'admin@colegio.com',
            'password' => Hash::make('123456789'),
            'rol_id' => 1,
            'telefono' => '999999999',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('administradores')->insert([
            'usuario_id' => $adminId,
            'cargo' => 'Administrador General',
            'telefono' => '999999999',
            'direccion' => 'Av. Principal 123',
            'fecha_creacion' => now(),
        ]);

        // =============================
        // 3) 13 DOCENTES (user + docente)
        // =============================
        $docentesUsuarios = [];
        $docentes = [];
        $nombresDocentes = [
            'Matemática I',
            'Comunicación I',
            'Inglés',
            'Ciencia y Tecnología',
            'Física',
            'Historia',
            'Geografía',
            'Educación Física',
            'Arte y Cultura',
            'Computación',
            'Educación Cívica',
            'Tutoría',
            'Religión',
        ];
        for ($i = 1; $i <= 13; $i++) {
            $first = $faker->firstName;
            $last  = $faker->lastName;
            $userId = DB::table('users')->insertGetId([
                'dni' => (string)$faker->unique()->numberBetween(40000000, 79999999),
                'nombres' => $first,
                'apellidos' => $last,
                'name' => "$first $last",
                'email' => Str::slug("$first.$last")."@colegio.com",
                'password' => Hash::make('123456789'),
                'rol_id' => 2,
                'telefono' => $faker->numberBetween(900000000, 999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $docentesUsuarios[] = $userId;

            $docentes[] = [
                'usuario_id' => $userId,
                'especialidad' => $nombresDocentes[$i - 1],
                'bio' => $faker->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('docentes')->insert($docentes);

        // IDs autoincrement de docentes (1..13)
        $docentesIds = DB::table('docentes')->orderBy('id')->pluck('id')->values()->all();

        // =============================
        // 4) CURSOS (asignados al docente correcto)
        // =============================
        $cursosNombreDocente = [
            ['Matemática I',          $docentesIds[0]],
            ['Comunicación I',        $docentesIds[1]],
            ['Inglés',                $docentesIds[2]],
            ['Ciencia y Tecnología',  $docentesIds[3]],
            ['Física',                $docentesIds[4]],
            ['Historia',              $docentesIds[5]],
            ['Geografía',             $docentesIds[6]],
            ['Educación Física',      $docentesIds[7]],
            ['Arte y Cultura',        $docentesIds[8]],
            ['Computación',           $docentesIds[9]],
            ['Educación Cívica',      $docentesIds[10]],
            ['Tutoría',               $docentesIds[11]],
            ['Religión',              $docentesIds[12]],
        ];
        $cursos = [];
        foreach ($cursosNombreDocente as $idx => [$nombre, $idDocente]) {
            $cursos[] = [
                'nombre' => $nombre,
                'codigo' => 'CUR-' . str_pad((string)($idx + 1), 3, '0', STR_PAD_LEFT),
                'docente_id' => $idDocente,
                'descripcion' => "Curso de $nombre",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('cursos')->insert($cursos);
        $cursoIds = DB::table('cursos')->orderBy('id')->pluck('id')->values()->all();

        // =============================
        // 5) SECCIONES (ejemplo simple)
        // =============================
        $secciones = [];
        foreach (['1°', '2°', '3°', '4°', '5°'] as $grado) {
            foreach (['A', 'B', 'C'] as $sec) {
                $secciones[] = [
                    'nombre' => $sec,
                    'grado'  => $grado,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('secciones')->insert($secciones);
        $seccionIds = DB::table('secciones')->orderBy('id')->pluck('id')->values()->all();

        // =============================
        // 6) 200 ESTUDIANTES (user + estudiante)
        // =============================
        $estudianteIds = [];
        for ($i = 1; $i <= 200; $i++) {
            // user
            $first = $faker->firstName;
            $last  = $faker->lastName;
            $userId = DB::table('users')->insertGetId([
                'dni' => (string)$faker->unique()->numberBetween(80000000, 99999999),
                'nombres' => $first,
                'apellidos' => $last,
                'name' => "$first $last",
                'email' => Str::slug("$first.$last").$i.'@alumno.edu',
                'password' => Hash::make('123456789'),
                'rol_id' => 3,
                'telefono' => $faker->numberBetween(900000000, 999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // features para IA
            $padresDiv = $faker->boolean(18); // ~18% padres divorciados
            $nivelSoc  = $faker->randomElement(['bajo','medio','alto']);
            $viveCon   = $faker->randomElement(['padres','madre','padre','otros']);
            $horas     = $faker->numberBetween(0, 20);
            $part      = $faker->numberBetween(1, 5);
            $promAnt   = $faker->randomFloat(2, 8, 18);
            $faltas    = $faker->numberBetween(0, 20);
            $motiv     = $faker->randomElement(['Alta','Media','Baja']);

            $estudianteId = DB::table('estudiantes')->insertGetId([
                'usuario_id' => $userId,
                'seccion_id' => $faker->randomElement($seccionIds),
                'padres_divorciados' => $padresDiv ? 1 : 0,
                'promedio_anterior' => $promAnt,
                'faltas' => $faltas,
                'horas_estudio_semanal' => $horas,
                'participacion_clases' => $part,
                'nivel_socioeconomico' => $nivelSoc,
                'vive_con' => $viveCon,
                'internet_en_casa' => $faker->boolean(90) ? 1 : 0,
                'dispositivo_propio' => $faker->boolean(85) ? 1 : 0,
                'motivacion' => $motiv,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $estudianteIds[] = $estudianteId;

            // =============================
            // 7) NOTAS por los 13 cursos (4 bimestres + promedio)
            //    Generación semi-realista:
            //    - +horas_estudio / +motivación / +participación => sube nota
            //    - +faltas / padres_divorciados / nivel socioeconómico bajo => baja nota
            // =============================
            foreach ($cursoIds as $cursoId) {
                $base = $promAnt; // parte del promedio anterior

                // Penalizaciones y bonificadores
                $delta  = 0;
                $delta += ($horas - 8) * 0.2;                 // + si estudia > 8h/sem
                $delta += ($part - 3) * 0.8;                  // + si participa más
                $delta -= max(0, $faltas - 5) * 0.2;          // faltas castigan
                $delta -= $padresDiv ? 0.5 : 0;               // leve impacto
                $delta += ($motiv === 'Alta' ? 0.8 : ($motiv === 'Baja' ? -0.8 : 0));
                $delta += ($nivelSoc === 'alto' ? 0.4 : ($nivelSoc === 'bajo' ? -0.4 : 0));

                // cuatro bimestres con ligera variación
                $b1 = $this->clip($base + $delta + $faker->randomFloat(2, -1.2, 1.2));
                $b2 = $this->clip($base + $delta + $faker->randomFloat(2, -1.5, 1.5));
                $b3 = $this->clip($base + $delta + $faker->randomFloat(2, -1.5, 1.5));
                $b4 = $this->clip($base + $delta + $faker->randomFloat(2, -1.5, 1.5));
                $prom = $this->clip(($b1 + $b2 + $b3 + $b4) / 4);

                DB::table('notas')->insert([
                    'estudiante_id' => $estudianteId,
                    'curso_id' => $cursoId,
                    'bimestre1' => $b1,
                    'bimestre2' => $b2,
                    'bimestre3' => $b3,
                    'bimestre4' => $b4,
                    'promedio_final' => $prom,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // =============================
            // 8) ASISTENCIAS (últimos 30 días hábiles)
            // =============================
            for ($d = 0; $d < 30; $d++) {
                $fecha = now()->subDays($d);
                if (in_array($fecha->dayOfWeekIso, [6,7])) continue; // evita sábado/domingo

                foreach ($cursoIds as $cursoId) {
                    // probabilidad de asistencia disminuye con faltas altas
                    $p = max(0.6, 0.95 - ($faltas * 0.01));
                    $presente = $faker->boolean($p * 100);
                    DB::table('asistencias')->insert([
                        'estudiante_id' => $estudianteId,
                        'curso_id' => $cursoId,
                        'fecha' => $fecha->toDateString(),
                        'presente' => $presente ? 1 : 0,
                        'observacion' => $presente ? null : $faker->randomElement([null,'Resfrío','Cita médica','Tardanza']),
                        'created_at' => now(),
                    ]);
                }
            }

            // =============================
            // 9) PREDICCIÓN IA simple (probabilidad + binaria)
            //    Modelo heurístico -> logistic
            // =============================
            $x = 0;
            $x += ($promAnt - 11) * 0.6;             // centro en 11
            $x += ($horas - 8) * 0.15;
            $x += ($part - 3) * 0.25;
            $x -= ($faltas - 5) * 0.07;
            $x -= $padresDiv ? 0.3 : 0;
            $x += ($motiv === 'Alta' ? 0.35 : ($motiv === 'Baja' ? -0.35 : 0));
            $x += ($nivelSoc === 'alto' ? 0.2 : ($nivelSoc === 'bajo' ? -0.2 : 0));

            $probAprobar = 1 / (1 + exp(-$x)); // 0..1
            DB::table('predicciones_rendimiento')->insert([
                'estudiante_id' => $estudianteId,
                'fecha_prediccion' => now(),
                'probabilidad_aprobar' => $probAprobar,
                'prediccion_binaria' => $probAprobar >= 0.5 ? 1 : 0,
                'modelo' => 'heuristico_demo_v1',
                'metadatos' => json_encode([
                    'padres_divorciados' => $padresDiv,
                    'promedio_anterior' => $promAnt,
                    'faltas' => $faltas,
                    'horas_estudio' => $horas,
                    'participacion' => $part,
                    'motivacion' => $motiv,
                    'nivel_socioeconomico' => $nivelSoc,
                ]),
                'created_at' => now(),
            ]);
        }

        $this->command->info('✅ Datos demo creados: 13 docentes, 13 cursos, 15 secciones, 200 estudiantes con notas, asistencias y predicciones.');
    }

    private function clip(float $x, float $min = 0, float $max = 20): float
    {
        return round(max($min, min($max, $x)), 2);
    }
}
