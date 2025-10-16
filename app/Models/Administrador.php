<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administradores';

    protected $fillable = [
        'usuario_id',
        'cargo',
        'telefono',
        'direccion',
        'fecha_creacion',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    public $timestamps = false; // Ya que usamos fecha_creacion personalizado

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Accessor para obtener el nombre completo a través del usuario
    public function getNombreCompletoAttribute()
    {
        return $this->usuario->nombres . ' ' . $this->usuario->apellidos;
    }

    // Accessor para obtener el email a través del usuario
    public function getEmailAttribute()
    {
        return $this->usuario->email;
    }

    // Accessor para obtener el DNI a través del usuario
    public function getDniAttribute()
    {
        return $this->usuario->dni;
    }
}