<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recomendaciones_ia', function (Blueprint $table) {
            $table->id();
            
            // Relación con la predicción
            $table->foreignId('prediccion_id')
                ->constrained('predicciones_rendimiento')
                ->onDelete('cascade')
                ->comment('Predicción a la que pertenece esta recomendación');
            
            // Tipo de recomendación
            $table->enum('tipo', [
                'academica',           // Relacionada con el rendimiento académico
                'metodologica',        // Sobre métodos de estudio
                'recurso_educativo',   // Recomendación de un recurso específico
                'asistencia',          // Relacionada con asistencia
                'tutoria',             // Necesita tutoría o apoyo
                'psicopedagogica',     // Apoyo emocional/motivacional
                'refuerzo',            // Refuerzo en curso específico
                'general'              // Recomendación general
            ])->default('general')->comment('Categoría de la recomendación');
            
            // Prioridad de la recomendación
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])
                ->default('media')
                ->comment('Nivel de prioridad de la recomendación');
            
            // Contenido de la recomendación
            $table->string('titulo', 255)->comment('Título breve de la recomendación');
            $table->text('descripcion')->comment('Descripción detallada de la recomendación');
            
            // Curso relacionado (opcional)
            $table->foreignId('curso_id')
                ->nullable()
                ->constrained('cursos')
                ->onDelete('set null')
                ->comment('Curso al que aplica esta recomendación (si es específica)');
            
            // Recurso educativo relacionado (opcional)
            $table->foreignId('recurso_educativo_id')
                ->nullable()
                ->constrained('recursos_educativos')
                ->onDelete('set null')
                ->comment('Recurso educativo recomendado (si aplica)');
            
            // Acciones sugeridas
            $table->json('acciones_sugeridas')
                ->nullable()
                ->comment('Lista de acciones concretas a realizar');
            
            // Seguimiento
            $table->boolean('completada')
                ->default(false)
                ->comment('Si la recomendación fue implementada');
            
            $table->timestamp('fecha_completada')
                ->nullable()
                ->comment('Cuándo se implementó la recomendación');
            
            $table->text('observaciones')
                ->nullable()
                ->comment('Observaciones sobre la implementación');
            
            // Responsables
            $table->string('dirigida_a', 100)
                ->default('estudiante')
                ->comment('A quién va dirigida: estudiante, docente, tutor, padre');
            
            $table->string('creado_por', 100)
                ->default('Gemini IA')
                ->comment('Sistema o persona que creó la recomendación');
            
            // Efectividad (después de implementarla)
            $table->tinyInteger('calificacion_efectividad')
                ->nullable()
                ->comment('Calificación de 1-5 sobre qué tan efectiva fue');
            
            // Metadatos adicionales
            $table->json('metadatos')
                ->nullable()
                ->comment('Información adicional en formato JSON');
            
            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            
            // Índices para optimizar consultas
            $table->index('prediccion_id', 'idx_rec_prediccion');
            $table->index('tipo', 'idx_rec_tipo');
            $table->index('prioridad', 'idx_rec_prioridad');
            $table->index('completada', 'idx_rec_completada');
            $table->index('curso_id', 'idx_rec_curso');
            $table->index(['prediccion_id', 'tipo'], 'idx_rec_pred_tipo');
            $table->index(['prediccion_id', 'completada'], 'idx_rec_pred_completada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendaciones_ia');
    }
};