<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetricaPaciente extends Model
{
    protected $table = 'metricas_pacientes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'paciente_id',
        'tipo_metrica_id',
        'valor',
        'fecha_registro',
        'notas',
    ];

    /**
     * Paciente al que pertenece este registro.
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Tipo de métrica (catálogo).
     */
    public function tipoMetrica(): BelongsTo
    {
        return $this->belongsTo(Metrica::class, 'tipo_metrica_id');
    }
}
