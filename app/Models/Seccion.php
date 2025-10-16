<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';

    protected $fillable = [
        'nombre',
        'grado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'seccion_id');
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        if ($this->grado) {
            return $this->grado . ' ' . $this->nombre;
        }
        return $this->nombre;
    }

    public function getEstudiantesActualesAttribute()
    {
        return $this->estudiantes()->count();
    }

    // Scopes
    public function scopePorGrado($query, $grado)
    {
        return $query->where('grado', $grado);
    }

    public function scopeConEstudiantes($query)
    {
        return $query->has('estudiantes');
    }

    public function scopeSinEstudiantes($query)
    {
        return $query->doesntHave('estudiantes');
    }

    // Métodos útiles
    public function puedeEliminar()
    {
        return $this->estudiantes()->count() === 0;
    }
}