<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        //Los Roles ya se están creando en las migraciones
        $this->call([
            RoleSeeder::class,      // 1. Crear roles primero
            DocenteSeeder::class,   // 2. Crear docentes (con usuarios)
            CursosSeeder::class,     // 3. Crear cursos asignados a docentes
            EstudiantesMasivosSeeder::class,    // 4. 200 Estudiantes con notas
            RecursosEducativosSeeder::class,    // 5. Recursos educativos (52)
        ]);
    }
}
