<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('curso_id')->nullable()->constrained('cursos')->onDelete('set null');
            $table->date('fecha');
            $table->boolean('presente')->default(1);
            $table->string('observacion', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['estudiante_id', 'fecha'], 'idx_asistencia_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};