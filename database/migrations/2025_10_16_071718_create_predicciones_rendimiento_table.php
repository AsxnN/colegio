<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predicciones_rendimiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->timestamp('fecha_prediccion')->useCurrent();
            
            // Datos principales de la predicción
            $table->decimal('probabilidad_aprobar', 5, 2)->default(0)->comment('Probabilidad de aprobar (0-100)');
            $table->boolean('prediccion_binaria')->default(0)->comment('true: aprobará, false: en riesgo');
            $table->enum('nivel_riesgo', ['Bajo', 'Medio', 'Alto'])->default('Medio')->comment('Nivel de riesgo académico');
            
            // Análisis detallado generado por IA
            $table->text('analisis')->nullable()->comment('Análisis detallado del rendimiento del estudiante');
            
            // Arrays JSON con información específica
            $table->json('fortalezas')->nullable()->comment('Lista de fortalezas identificadas');
            $table->json('debilidades')->nullable()->comment('Lista de debilidades o áreas de mejora');
            $table->json('recomendaciones_generales')->nullable()->comment('Recomendaciones generales para el estudiante');
            $table->json('recursos_recomendados')->nullable()->comment('Recursos educativos específicos recomendados');
            $table->json('cursos_criticos')->nullable()->comment('Cursos que requieren atención urgente');
            
            // Plan de mejora personalizado
            $table->text('plan_mejora')->nullable()->comment('Plan de mejora detallado y personalizado');
            
            // Metadatos técnicos
            $table->json('metadatos')->nullable()->comment('Información adicional y técnica');
            
            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            
            // Índices para optimizar consultas
            $table->index('estudiante_id', 'idx_pred_estudiante');
            $table->index('fecha_prediccion', 'idx_pred_fecha');
            $table->index('nivel_riesgo', 'idx_pred_riesgo');
            $table->index(['estudiante_id', 'fecha_prediccion'], 'idx_pred_estudiante_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predicciones_rendimiento');
    }
};