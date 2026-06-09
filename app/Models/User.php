<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'apellido_paterno',
        'apellido_materno',
        'rol_id',
        'email',
        'password_hash',
        'estado',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'ultimo_acceso' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Indica a Laravel qué campo contiene la contraseña.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Nombre completo del usuario.
     */
    public function getNombreCompletoAttribute()
    {
        return trim(
            $this->primer_nombre . ' ' .
            ($this->segundo_nombre ?? '') . ' ' .
            $this->apellido_paterno . ' ' .
            $this->apellido_materno
        );
    }
}