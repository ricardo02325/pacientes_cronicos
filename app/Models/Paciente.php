<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    
    // Relación con el usuario para obtener su nombre y correo
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación para obtener el último registro de métricas (Último Registro)
    public function ultimaMetrica()
    {
        return $this->hasOne(MetricaPaciente::class, 'paciente_id')->latest('fecha_registro');
    }
}
