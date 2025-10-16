<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'name',          // Campo original de Laravel
        'email',         // Campo original de Laravel
        'password',
        'rol_id',
        'telefono',
        'creado_en',
        'actualizado_en',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Role::class,  'rol_id');
    }

    /** Helper: compara por slug o id */
    public function hasRole($role): bool
    {
        // acepta 'administrador' | 'docente' | 'estudiante' o 1/2/3
        $map = ['administrador' => 1, 'docente' => 2, 'estudiante' => 3];

        if (is_numeric($role)) {
            return (int)$this->id_rol === (int)$role;
        }

        $role = strtolower($role);
        if (isset($map[$role])) {
            return (int)$this->id_rol === $map[$role];
        }

        // también soporta comparar por nombre_rol desde la relación
        return strtolower(optional($this->rol)->nombre_rol) === $role;
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'usuario_id');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'usuario_id');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'usuario_id');
    }

    // Mutators para sincronizar name con nombres y apellidos
    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = $value;
        $this->updateNameFromParts();
    }

    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = $value;
        $this->updateNameFromParts();
    }

    // Método privado para actualizar name
    private function updateNameFromParts()
    {
        if (!empty($this->attributes['nombres']) && !empty($this->attributes['apellidos'])) {
            $this->attributes['name'] = $this->attributes['nombres'] . ' ' . $this->attributes['apellidos'];
        }
    }

    // Método para verificar si el usuario es administrador
    public function esAdministrador()
    {
        return $this->rol && $this->rol->nombre === 'Administrador';
    }

    // Método para verificar si el usuario es docente
    public function esDocente()
    {
        return $this->rol && $this->rol->nombre === 'Docente';
    }

    // Método para verificar si el usuario es estudiante
    public function esEstudiante()
    {
        return $this->rol && $this->rol->nombre === 'Estudiante';
    }
}
