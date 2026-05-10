<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PacienteEstado extends Model
{
    protected $table = 'pacientes_estado';

    public $timestamps = false;
    protected $fillable = [
        'nombre_completo',
        'diagnostico_principal',
        'nivel_riesgo',
        'created_at'
    ];
}