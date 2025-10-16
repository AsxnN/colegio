<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursoEducativo extends Model
{
    use HasFactory;

    protected $table = 'recursos_educativos';

    protected $fillable = [
        'curso_id',
        'titulo',
        'tipo',
        'url',
        'descripcion',
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Accessors
    public function getTipoNombreAttribute()
    {
        $tipos = [
            'video' => 'Video',
            'pdf' => 'PDF',
            'link' => 'Enlace',
            'otro' => 'Otro',
        ];
        return $tipos[$this->tipo] ?? $this->tipo;
    }

    public function getTipoColorAttribute()
    {
        $colores = [
            'video' => 'bg-red-100 text-red-800',
            'pdf' => 'bg-blue-100 text-blue-800',
            'link' => 'bg-green-100 text-green-800',
            'otro' => 'bg-gray-100 text-gray-800',
        ];
        return $colores[$this->tipo] ?? 'bg-gray-100 text-gray-800';
    }

    public function getTipoIconoAttribute()
    {
        $iconos = [
            'video' => '🎥',
            'pdf' => '📄',
            'link' => '🔗',
            'otro' => '📎',
        ];
        return $iconos[$this->tipo] ?? '📎';
    }

    // Scopes
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }
}