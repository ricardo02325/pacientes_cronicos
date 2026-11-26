<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use Illuminate\Http\JsonResponse;

class MedicoApiController extends Controller
{
    /**
     * Lista de médicos activos disponibles para vinculación del paciente.
     */
    public function index(): JsonResponse
    {
        $medicos = Medico::with(['usuario' => function ($query) {
            $query->where('estado', 'Activo');
        }])
        ->whereHas('usuario', function ($query) {
            $query->where('estado', 'Activo');
        })
        ->get()
        ->map(function ($medico) {
            return [
                'id'                 => $medico->id,
                'nombre_completo'    => 'Dr(a). ' . ($medico->usuario ? $medico->usuario->nombre_completo : 'Médico'),
                'especialidad'       => $medico->especialidad,
                'cedula_profesional' => $medico->cedula_profesional,
                'consultorio'        => $medico->consultorio,
                'turno'              => $medico->turno,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $medicos,
        ]);
    }
}
