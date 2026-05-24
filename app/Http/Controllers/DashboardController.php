<?php

namespace App\Http\Controllers;

use App\Models\PacienteEstado;
use App\Models\TotalPacientes;
use App\Models\TotalPacientesRiesgoAlto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPacientes = TotalPacientes::value('total');

        $riesgoAlto = TotalPacientesRiesgoAlto::value('total');

        $pacientesEstables = DB::table('pacientes')
            ->where('nivel_riesgo', 'Bajo')
            ->count();

        $pacientesEstado = PacienteEstado::orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // DISTRIBUCIÓN POR CONDICIÓN
        $condiciones = DB::table('pacientes')
            ->select(
                'diagnostico_principal',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnostico_principal')
            ->get();

        return view('admin.dashboard', compact(
            'totalPacientes',
            'riesgoAlto',
            'pacientesEstables',
            'pacientesEstado',
            'condiciones'
        ));
    }
}