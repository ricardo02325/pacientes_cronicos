<?php

namespace App\Http\Controllers;

use App\Models\TotalPacientes;
use App\Models\PacienteEstado;

class PacientesController extends Controller
{
    public function index()
    {
        // Total de pacientes
        $totalPacientes = TotalPacientes::all();

        // Lista de pacientes
        $pacientes = PacienteEstado::all();

        return view('admin.pacientes', compact(
            'totalPacientes',
            'pacientes'
        ));
    }
}