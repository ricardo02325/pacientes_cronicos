<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'usuario_id',
        'medico_id',
        'fecha_nacimiento',
        'telefono_emergencia',
        'sexo',
        'estatura',
        'diagnostico_principal',
        'nivel_riesgo',
    ];

    /**
     * Relación con el usuario (cuenta, datos personales, correo, estado).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación con el médico a cargo.
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    /**
     * Historial de métricas del paciente.
     */
    public function metricas(): HasMany
    {
        return $this->hasMany(MetricaPaciente::class, 'paciente_id');
    }

    /**
     * Último registro de métricas.
     */
    public function ultimaMetrica(): HasOne
    {
        return $this->hasOne(MetricaPaciente::class, 'paciente_id')->latest('fecha_registro');
    }
}
