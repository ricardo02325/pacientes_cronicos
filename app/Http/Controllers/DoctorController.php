<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $medicos = DB::table('vista_medicos')->get();

        return view('admin.medicos', compact('medicos'));
    }

    // Método para mostrar el formulario de registro de médico
    public function store(Request $request)
    {
        $request->validate([

            // =========================
            // DATOS USUARIO
            // =========================
            'primer_nombre' => 'required|string|max:50',

            'segundo_nombre' => 'nullable|string|max:50',

            'apellido_paterno' => 'required|string|max:50',

            'apellido_materno' => 'required|string|max:50',

            'email' => 'required|email|max:50|unique:usuarios,email',

            'password' => 'required|string|min:8|max:255',

            // =========================
            // DATOS MÉDICO
            // =========================
            'telefono' => 'required|digits:10',

            'cedula_profesional' => 'required|string|max:30|unique:medicos,cedula_profesional',

            'especialidad' => 'required|string|max:100',

            'turno' => 'required|in:Matutino,Vespertino,Nocturno,Mixto',

            'consultorio' => 'nullable|string|max:50',

            'observaciones' => 'nullable|string',
        ]);

        DB::statement(
            'CALL sp_registrar_medico(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [

                // =========================
                // USUARIO
                // =========================
                $request->primer_nombre,

                $request->segundo_nombre,

                $request->apellido_paterno,

                $request->apellido_materno,

                2, // ROL MÉDICO

                $request->email,

                Hash::make($request->password),

                // =========================
                // MÉDICO
                // =========================
                $request->cedula_profesional,

                $request->especialidad,

                $request->telefono,

                $request->consultorio,

                $request->turno,

                $request->observaciones,
            ]
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Médico registrado correctamente'
            );
    }
}
