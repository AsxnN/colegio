<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'docente_id',
    ];

    // Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    
    public function recursos()
    {
        return $this->hasMany(RecursoEducativo::class);
    }

    // Accessor
    public function getNombreCompletoAttribute()
    {
        return $this->codigo ? "{$this->codigo} - {$this->nombre}" : $this->nombre;
    }
}