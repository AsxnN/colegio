<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agregar los campos que NO existen en la migración original
            $table->string('dni', 12)->unique()->nullable()->after('id');
            $table->string('nombres', 100)->after('dni');
            $table->string('apellidos', 100)->after('nombres');
            $table->foreignId('rol_id')->after('password')->constrained('roles')->onDelete('restrict');
            $table->string('telefono', 30)->nullable()->after('rol_id');
            $table->timestamp('creado_en')->useCurrent()->after('telefono');
            $table->timestamp('actualizado_en')->nullable()->after('creado_en');
            
            // Agregar índice
            $table->index('rol_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rol_id']);
            $table->dropIndex(['rol_id']);
            $table->dropColumn([
                'dni', 'nombres', 'apellidos', 'rol_id', 
                'telefono', 'creado_en', 'actualizado_en'
            ]);
        });
    }
};