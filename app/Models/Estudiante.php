<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'usuario_id',
        'seccion_id',
        'padres_divorciados',
        'promedio_anterior',
        'faltas',
        'horas_estudio_semanal',
        'participacion_clases',
        'nivel_socioeconomico',
        'vive_con',
        'internet_en_casa',
        'dispositivo_propio',
        'motivacion',
    ];

    protected $casts = [
        'padres_divorciados' => 'boolean',
        'promedio_anterior' => 'decimal:2',
        'faltas' => 'integer',
        'horas_estudio_semanal' => 'integer',
        'participacion_clases' => 'integer',
        'internet_en_casa' => 'boolean',
        'dispositivo_propio' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    // Relación con calificaciones
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'estudiante_id');
    }

    // Relación con notas (AGREGADA)
    public function notas()
    {
        return $this->hasMany(Nota::class, 'estudiante_id');
    }

    // Relación con asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'estudiante_id');
    }

    // Relación con predicciones (AGREGADA)
    public function predicciones()
    {
        return $this->hasMany(PrediccionRendimiento::class, 'estudiante_id');
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->usuario->nombres . ' ' . $this->usuario->apellidos;
    }

    public function getEmailAttribute()
    {
        return $this->usuario->email;
    }

    public function getDniAttribute()
    {
        return $this->usuario->dni;
    }

    public function getGradoSeccionAttribute()
    {
        return $this->seccion ? $this->seccion->grado . ' ' . $this->seccion->nombre : 'Sin sección';
    }

    public function getParticipacionTextoAttribute()
    {
        if ($this->participacion_clases === null) return 'No evaluado';
        if ($this->participacion_clases >= 8) return 'Excelente';
        if ($this->participacion_clases >= 6) return 'Bueno';
        if ($this->participacion_clases >= 4) return 'Regular';
        return 'Deficiente';
    }

    public function getSituacionFamiliarAttribute()
    {
        $situacion = ucfirst($this->vive_con);
        if ($this->padres_divorciados) {
            $situacion .= ' (Padres divorciados)';
        }
        return $situacion;
    }

    public function getRecursosEducativosAttribute()
    {
        $recursos = [];
        if ($this->internet_en_casa) $recursos[] = 'Internet en casa';
        if ($this->dispositivo_propio) $recursos[] = 'Dispositivo propio';
        
        return empty($recursos) ? 'Sin recursos' : implode(', ', $recursos);
    }

    // Scopes
    public function scopeConRecursosCompletos($query)
    {
        return $query->where('internet_en_casa', true)
                    ->where('dispositivo_propio', true);
    }

    public function scopeConDificultadesSocioeconomicas($query)
    {
        return $query->where('nivel_socioeconomico', 'bajo')
                    ->orWhere('internet_en_casa', false)
                    ->orWhere('dispositivo_propio', false);
    }

    public function scopeAltaMotivacion($query)
    {
        return $query->where('motivacion', 'Alta');
    }

    public function scopeBajaMotivacion($query)
    {
        return $query->where('motivacion', 'Baja');
    }

    public function scopeConProblemasFamiliares($query)
    {
        return $query->where('padres_divorciados', true)
                    ->orWhere('vive_con', '!=', 'padres');
    }
}