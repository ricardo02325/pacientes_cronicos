<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetricaPaciente extends Model
{
    protected $table = 'metricas_pacientes'; //
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // No tienes updated_at en esta tabla
}
