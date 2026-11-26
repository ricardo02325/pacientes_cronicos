<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Paciente;
use App\Models\PacienteEstado;
use App\Models\TotalPacientes;
use App\Models\TotalPacientesRiesgoAlto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPacientes = Paciente::count();
        $riesgoAlto = Paciente::where('nivel_riesgo', 'Alto')->count();
        $pacientesEstables = Paciente::where('nivel_riesgo', 'Bajo')->count();
        $riesgoMedio = Paciente::where('nivel_riesgo', 'Medio')->count();
        $totalMedicos = Medico::count();

        // Pacientes recientes con datos completos
        $pacientesEstado = Paciente::with(['usuario', 'medico.usuario'])
            ->whereHas('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // DISTRIBUCIÓN POR CONDICIÓN
        $condiciones = DB::table('pacientes')
            ->select(
                'diagnostico_principal',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnostico_principal')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        // Médicos activos para selects
        $medicos = Medico::with('usuario')
            ->whereHas('usuario', fn($q) => $q->where('estado', 'Activo'))
            ->get();

        return view('admin.dashboard', compact(
            'totalPacientes',
            'riesgoAlto',
            'riesgoMedio',
            'pacientesEstables',
            'totalMedicos',
            'pacientesEstado',
            'condiciones',
            'medicos'
        ));
    }
}