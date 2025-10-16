<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('seccion_id')->nullable()->constrained('secciones')->onDelete('set null');
            $table->boolean('padres_divorciados')->default(0);
            $table->decimal('promedio_anterior', 5, 2)->nullable();
            $table->integer('faltas')->default(0);
            $table->integer('horas_estudio_semanal')->default(0);
            $table->tinyInteger('participacion_clases')->nullable();
            $table->enum('nivel_socioeconomico', ['bajo', 'medio', 'alto'])->default('medio');
            $table->enum('vive_con', ['padres', 'madre', 'padre', 'otros'])->default('padres');
            $table->boolean('internet_en_casa')->default(1);
            $table->boolean('dispositivo_propio')->default(1);
            $table->enum('motivacion', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};