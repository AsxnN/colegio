<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'bimestre1',
        'bimestre2',
        'bimestre3',
        'bimestre4',
        'promedio_final',
    ];

    protected $casts = [
        'bimestre1' => 'decimal:2',
        'bimestre2' => 'decimal:2',
        'bimestre3' => 'decimal:2',
        'bimestre4' => 'decimal:2',
        'promedio_final' => 'decimal:2',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Calcular promedio automáticamente
    public function calcularPromedio()
    {
        $notas = array_filter([
            $this->bimestre1,
            $this->bimestre2,
            $this->bimestre3,
            $this->bimestre4,
        ]);

        if (count($notas) > 0) {
            $this->promedio_final = round(array_sum($notas) / count($notas), 2);
            $this->save();
        }

        return $this->promedio_final;
    }

    // Accessor para estado
    public function getEstadoAttribute()
    {
        if (is_null($this->promedio_final)) {
            return 'Sin calificar';
        }
        return $this->promedio_final >= 14 ? 'Aprobado' : 'Desaprobado';
    }
}