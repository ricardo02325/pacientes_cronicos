<?php

namespace App\Http\Controllers;

use App\Models\PacienteEstado;
use App\Models\TotalPacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacientesController extends Controller
{
    public function index()
    {
        $totalPacientes = TotalPacientes::value('total');
        $pacientes = PacienteEstado::all();

        $medicos = DB::table('vista_medicos')
            ->select('medico_id', 'nombre_completo')
            ->get();

        return view('admin.pacientes', compact(
            'totalPacientes',
            'pacientes',
            'medicos'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'email' => 'required|email|max:50',

            'medico_id' => 'required|numeric',

            'fecha_nacimiento' => 'required|date',
            'telefono_emergencia' => 'required|digits:10',
            'sexo' => 'required|string',
            'diagnostico_principal' => 'required|string|max:255',
            'nivel_riesgo' => 'required|in:Bajo,Medio,Alto',
        ]);

        $passwordPlano = 'PAC' . rand(100000, 999999);

        $medicoId = (int) $request->medico_id;

        DB::statement(
            'CALL insertar_paciente(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->primer_nombre,
                $request->segundo_nombre,
                $request->apellido_paterno,
                $request->apellido_materno,
                $request->email,

                $passwordPlano,

                $medicoId,
                $request->fecha_nacimiento,
                $request->telefono_emergencia,
                $request->sexo,
                $request->diagnostico_principal,
                $request->nivel_riesgo,
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Paciente registrado. Contraseña: ' . $passwordPlano);
    }
}