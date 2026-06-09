<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'apellido_paterno',
        'apellido_materno',
        'rol_id',
        'email',
        'password',
        'estado',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
    ];

    public function pacientesAsignados(): HasMany
    {
        return $this->hasMany(Paciente::class, 'medico_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim(
            $this->primer_nombre . ' ' .
            ($this->segundo_nombre ?? '') . ' ' .
            $this->apellido_paterno . ' ' .
            $this->apellido_materno
        );
    }
}