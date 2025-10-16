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
        'modelo',
        'metadatos',
    ];

    protected $casts = [
        'fecha_prediccion' => 'datetime',
        'probabilidad_aprobar' => 'float',
        'prediccion_binaria' => 'boolean',
        'metadatos' => 'array',
    ];

    public $timestamps = false;

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

    // Accessors
    public function getEstadoPrediccionAttribute()
    {
        return $this->prediccion_binaria ? 'Aprobará' : 'En Riesgo';
    }

    public function getEstadoColorAttribute()
    {
        if ($this->probabilidad_aprobar >= 75) {
            return 'success';
        } elseif ($this->probabilidad_aprobar >= 50) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    public function getNivelRiesgoAttribute()
    {
        if ($this->probabilidad_aprobar >= 75) {
            return 'Bajo';
        } elseif ($this->probabilidad_aprobar >= 50) {
            return 'Medio';
        } else {
            return 'Alto';
        }
    }

    // Scopes
    public function scopeEnRiesgo($query)
    {
        return $query->where('probabilidad_aprobar', '<', 50);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_prediccion', 'desc');
    }
}