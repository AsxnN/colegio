<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendacionIA extends Model
{
    use HasFactory;

    protected $table = 'recomendaciones_ia';

    protected $fillable = [
        'prediccion_id',
        'tipo',
        'prioridad',
        'titulo',
        'descripcion',
        'curso_id',
        'recurso_educativo_id',
        'acciones_sugeridas',
        'completada',
        'fecha_completada',
        'observaciones',
        'dirigida_a',
        'creado_por',
        'calificacion_efectividad',
        'metadatos',
    ];

    protected $casts = [
        'acciones_sugeridas' => 'array',
        'metadatos' => 'array',
        'completada' => 'boolean',
        'fecha_completada' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constantes para tipos
    const TIPO_ACADEMICA = 'academica';
    const TIPO_METODOLOGICA = 'metodologica';
    const TIPO_RECURSO = 'recurso_educativo';
    const TIPO_ASISTENCIA = 'asistencia';
    const TIPO_TUTORIA = 'tutoria';
    const TIPO_PSICOPEDAGOGICA = 'psicopedagogica';
    const TIPO_REFUERZO = 'refuerzo';
    const TIPO_GENERAL = 'general';

    // Constantes para prioridades
    const PRIORIDAD_BAJA = 'baja';
    const PRIORIDAD_MEDIA = 'media';
    const PRIORIDAD_ALTA = 'alta';
    const PRIORIDAD_URGENTE = 'urgente';

    // Relaciones
    public function prediccion()
    {
        return $this->belongsTo(PrediccionRendimiento::class, 'prediccion_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function recursoEducativo()
    {
        return $this->belongsTo(RecursoEducativo::class, 'recurso_educativo_id');
    }

    // Scopes
    public function scopeCompletadas($query)
    {
        return $query->where('completada', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('completada', false);
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeUrgentes($query)
    {
        return $query->where('prioridad', self::PRIORIDAD_URGENTE);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos auxiliares
    public function marcarComoCompletada($observaciones = null)
    {
        $this->update([
            'completada' => true,
            'fecha_completada' => now(),
            'observaciones' => $observaciones,
        ]);
    }

    public function calificar($calificacion)
    {
        if ($calificacion >= 1 && $calificacion <= 5) {
            $this->update(['calificacion_efectividad' => $calificacion]);
        }
    }

    public function getColorPrioridadAttribute()
    {
        return match($this->prioridad) {
            self::PRIORIDAD_BAJA => 'green',
            self::PRIORIDAD_MEDIA => 'yellow',
            self::PRIORIDAD_ALTA => 'orange',
            self::PRIORIDAD_URGENTE => 'red',
            default => 'gray',
        };
    }

    public function getIconoTipoAttribute()
    {
        return match($this->tipo) {
            self::TIPO_ACADEMICA => '📚',
            self::TIPO_METODOLOGICA => '🎯',
            self::TIPO_RECURSO => '📖',
            self::TIPO_ASISTENCIA => '📅',
            self::TIPO_TUTORIA => '👨‍🏫',
            self::TIPO_PSICOPEDAGOGICA => '💡',
            self::TIPO_REFUERZO => '💪',
            default => '📋',
        };
    }
}