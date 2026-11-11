<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'usuario_id',
        'cedula_profesional',
        'especialidad',
        'telefono',
        'consultorio',
        'turno',
        'observaciones',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function pacientes(): BelongsToMany
    {
        return $this->belongsToMany(Paciente::class, 'medico_paciente')
            ->withPivot('es_principal')
            ->withTimestamps();
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->usuario ? $this->usuario->nombre_completo : 'Dr(a). Sin Asignar';
    }

    public function getEmailAttribute(): string
    {
        return $this->usuario ? $this->usuario->email : '';
    }

    public function getEstadoAttribute(): string
    {
        return $this->usuario ? $this->usuario->estado : 'Activo';
    }
}
