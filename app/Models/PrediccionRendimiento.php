<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrediccionRendimiento extends Model
{
    use HasFactory;

    protected $table = 'predicciones_rendimiento';

    protected $fillable = [
        'estudiante_id',
        'fecha_prediccion',
        'probabilidad_aprobar',
        'prediccion_binaria',
        'nivel_riesgo',
        'analisis',
        'fortalezas',
        'debilidades',
        'recomendaciones_generales',
        'recursos_recomendados',
        'cursos_criticos',
        'plan_mejora',
        'metadatos',
    ];

    protected $casts = [
        'fecha_prediccion' => 'datetime',
        'probabilidad_aprobar' => 'decimal:2',
        'prediccion_binaria' => 'boolean',
        'fortalezas' => 'array',
        'debilidades' => 'array',
        'recomendaciones_generales' => 'array',
        'recursos_recomendados' => 'array',
        'cursos_criticos' => 'array',
        'metadatos' => 'array',
        'created_at' => 'datetime',
    ];

    const UPDATED_AT = null; // No usar updated_at

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->created_at = now();
            $model->fecha_prediccion = now();
        });
    }

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function recomendaciones()
    {
        return $this->hasMany(RecomendacionIA::class, 'prediccion_id');
    }

    // Scopes
    public function scopeRiesgoAlto($query)
    {
        return $query->where('nivel_riesgo', 'Alto');
    }

    public function scopeRiesgoMedio($query)
    {
        return $query->where('nivel_riesgo', 'Medio');
    }

    public function scopeRiesgoBajo($query)
    {
        return $query->where('nivel_riesgo', 'Bajo');
    }

    // Métodos auxiliares
    public function getColorRiesgoAttribute()
    {
        return match($this->nivel_riesgo) {
            'Bajo' => 'green',
            'Medio' => 'yellow',
            'Alto' => 'red',
            default => 'gray',
        };
    }

    public function getIconoRiesgoAttribute()
    {
        return match($this->nivel_riesgo) {
            'Bajo' => '🟢',
            'Medio' => '🟡',
            'Alto' => '🔴',
            default => '⚪',
        };
    }
}