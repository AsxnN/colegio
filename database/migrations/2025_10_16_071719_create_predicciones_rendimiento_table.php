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
            $table->float('probabilidad_aprobar')->default(0);
            $table->boolean('prediccion_binaria')->default(0);
            $table->text('modelo')->nullable();
            $table->json('metadatos')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('estudiante_id', 'idx_pred_estudiante');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predicciones_rendimiento');
    }
};