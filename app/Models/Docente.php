<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'usuario_id',
        'especialidad',
        'grado_academico',
        'telefono',
        'direccion',
        'fecha_ingreso',
        'estado',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public $timestamps = false; // Usamos fecha_ingreso personalizado

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con materias que enseña
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'docente_materia', 'docente_id', 'materia_id');
    }

    // Relación con cursos que tiene a cargo
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'docente_id');
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

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'Inactivo');
    }
}