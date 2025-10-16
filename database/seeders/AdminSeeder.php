<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('nombre', 'Administrador')->first()->id;

        // Crear usuario administrador
        $adminUserId = DB::table('users')->insertGetId([
            'dni' => '12345678',
            'nombres' => 'Super',
            'apellidos' => 'Administrador',
            'name' => 'Super Administrador',
            'email' => 'admin@colegio.com',
            'password' => Hash::make('password123'),
            'rol_id' => $adminRoleId,
            'telefono' => '999999999',
            'creado_en' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear registro en tabla administradores
        DB::table('administradores')->insert([
            'usuario_id' => $adminUserId,
            'cargo' => 'Super Administrador',
            'telefono' => '999999999',
            'direccion' => 'Dirección del Colegio',
            'fecha_creacion' => now(),
        ]);

        $this->command->info('Administrador creado exitosamente:');
        $this->command->info('Email: admin@colegio.com');
        $this->command->info('Password: password123');
    }
}