<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    //     public function run(): void
    // {
    //     $this->call([
    //         RoleSeeder::class,      // 1. Crear roles primero
    //         DocenteSeeder::class,   // 2. Crear docentes (con usuarios)
    //         CursoSeeder::class,     // 3. Crear cursos asignados a docentes
    //     ]);
    // }
}
