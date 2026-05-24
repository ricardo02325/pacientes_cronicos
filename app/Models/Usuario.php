<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // Apunta a tu tabla personalizada
    
    // Un usuario (médico) tiene muchos pacientes asignados
    public function pacientesAsignados()
    {
        return $this->hasMany(Paciente::class, 'medico_id');
    }
}
