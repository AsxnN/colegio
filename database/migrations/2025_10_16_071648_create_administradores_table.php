<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('cargo', 100)->default('Administrador General');
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};