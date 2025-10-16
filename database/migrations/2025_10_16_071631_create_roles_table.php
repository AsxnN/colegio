<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });

        // Insertar roles por defecto
        DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'descripcion' => 'Rol administrador del sistema', 'created_at' => now()],
            ['nombre' => 'Docente', 'descripcion' => 'Rol docente', 'created_at' => now()],
            ['nombre' => 'Estudiante', 'descripcion' => 'Rol estudiante', 'created_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};