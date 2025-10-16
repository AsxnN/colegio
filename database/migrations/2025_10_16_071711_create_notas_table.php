<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->decimal('bimestre1', 5, 2)->nullable();
            $table->decimal('bimestre2', 5, 2)->nullable();
            $table->decimal('bimestre3', 5, 2)->nullable();
            $table->decimal('bimestre4', 5, 2)->nullable();
            $table->decimal('promedio_final', 5, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            $table->index(['estudiante_id', 'curso_id'], 'idx_estudiante_curso');
            $table->index('promedio_final', 'idx_notas_promedio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};