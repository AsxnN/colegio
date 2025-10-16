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
            $table->foreignId('prediccion_id')->constrained('predicciones_rendimiento')->onDelete('cascade');
            $table->string('tipo', 80)->nullable();
            $table->text('texto');
            $table->string('creado_por', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendaciones_ia');
    }
};