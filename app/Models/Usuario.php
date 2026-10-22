<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    protected function casts(): array
    {
        return [
            'ultimo_acceso' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con el rol del usuario.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Si el usuario es un médico, obtiene su perfil médico.
     */
    public function medico(): HasOne
    {
        return $this->hasOne(Medico::class, 'usuario_id');
    }

    /**
     * Si el usuario es un paciente, obtiene su perfil de paciente.
     */
    public function paciente(): HasOne
    {
        return $this->hasOne(Paciente::class, 'usuario_id');
    }

    /**
     * Pacientes asignados si este usuario fuese médico (vía tabla pacientes).
     */
    public function pacientesAsignados(): HasMany
    {
        return $this->hasMany(Paciente::class, 'medico_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim(
            $this->primer_nombre . ' ' .
            ($this->segundo_nombre ? $this->segundo_nombre . ' ' : '') .
            $this->apellido_paterno . ' ' .
            $this->apellido_materno
        );
    }

    public function esAdmin(): bool
    {
        return (int) $this->rol_id === 1;
    }

    public function esMedico(): bool
    {
        return (int) $this->rol_id === 2;
    }

    public function esPaciente(): bool
    {
        return (int) $this->rol_id === 3;
    }
}