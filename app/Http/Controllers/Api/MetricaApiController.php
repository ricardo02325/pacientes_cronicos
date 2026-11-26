<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Metrica;
use App\Models\MetricaPaciente;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetricaApiController extends Controller
{
    /**
     * Catálogo completo de métricas disponibles (unidades y rangos normales).
     */
    public function catalogo(): JsonResponse
    {
        $metricas = Metrica::select([
            'id',
            'nombre',
            'unidad_medida',
            'rango_min_normal',
            'rango_max_normal',
        ])->get();

        return response()->json([
            'success' => true,
            'data'    => $metricas,
        ]);
    }

    /**
     * Historial de métricas del paciente autenticado (o consultado por su médico).
     */
    public function index(Request $request): JsonResponse
    {
        $usuario = $request->user();
        $pacienteId = null;

        if ($usuario->esPaciente()) {
            $paciente = $usuario->paciente;
            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró un perfil de paciente asociado a esta cuenta.',
                ], 404);
            }
            $pacienteId = $paciente->id;
        } elseif ($usuario->esMedico() || $usuario->esAdmin()) {
            $pacienteId = $request->query('paciente_id');
            if (!$pacienteId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe especificar el parámetro paciente_id.',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para consultar estas métricas.',
            ], 403);
        }

        $query = MetricaPaciente::with('tipoMetrica')
            ->where('paciente_id', $pacienteId);

        // Filtro por tipo de métrica
        if ($request->filled('tipo_metrica_id')) {
            $query->where('tipo_metrica_id', $request->tipo_metrica_id);
        }

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_registro', '>=', Carbon::parse($request->fecha_inicio)->startOfDay());
        }
        if ($request->filled('fecha_fin')) {
            $query->where('fecha_registro', '<=', Carbon::parse($request->fecha_fin)->endOfDay());
        }

        $metricas = $query->orderBy('fecha_registro', 'desc')
            ->paginate($request->query('per_page', 20));

        // Formatear items con semáforo / rango normal
        $items = collect($metricas->items())->map(function ($m) {
            $estado = 'Normal';
            if ($m->tipoMetrica) {
                if ($m->tipoMetrica->rango_min_normal !== null && $m->valor < $m->tipoMetrica->rango_min_normal) {
                    $estado = 'Bajo';
                } elseif ($m->tipoMetrica->rango_max_normal !== null && $m->valor > $m->tipoMetrica->rango_max_normal) {
                    $estado = 'Alto';
                }
            }

            return [
                'id'              => $m->id,
                'tipo_metrica_id' => $m->tipo_metrica_id,
                'tipo_nombre'     => $m->tipoMetrica->nombre ?? 'Desconocido',
                'unidad_medida'   => $m->tipoMetrica->unidad_medida ?? '',
                'valor'           => (float) $m->valor,
                'estado'          => $estado,
                'rango_normal'    => [
                    'min' => $m->tipoMetrica->rango_min_normal ? (float) $m->tipoMetrica->rango_min_normal : null,
                    'max' => $m->tipoMetrica->rango_max_normal ? (float) $m->tipoMetrica->rango_max_normal : null,
                ],
                'fecha_registro'  => $m->fecha_registro,
                'notas'           => $m->notas,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $items,
            'pagination' => [
                'total'        => $metricas->total(),
                'per_page'     => $metricas->perPage(),
                'current_page' => $metricas->currentPage(),
                'last_page'    => $metricas->lastPage(),
            ],
        ]);
    }

    /**
     * Registrar una nueva métrica desde la app móvil o web.
     */
    public function store(Request $request): JsonResponse
    {
        $usuario = $request->user();
        $pacienteId = null;

        if ($usuario->esPaciente()) {
            $paciente = $usuario->paciente;
            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró un perfil de paciente activo.',
                ], 404);
            }
            $pacienteId = $paciente->id;
        } elseif ($usuario->esMedico()) {
            $pacienteId = $request->input('paciente_id');
            if (!$pacienteId || !Paciente::where('id', $pacienteId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El paciente_id especificado no es válido.',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para registrar métricas.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'tipo_metrica_id' => 'required|exists:metricas,id',
            'valor'           => 'required|numeric|min:0',
            'fecha_registro'  => 'nullable|date',
            'notas'           => 'nullable|string|max:255',
        ], [
            'tipo_metrica_id.required' => 'Debe seleccionar un tipo de métrica.',
            'tipo_metrica_id.exists'   => 'El tipo de métrica seleccionado no existe.',
            'valor.required'           => 'Debe ingresar un valor numérico para la métrica.',
            'valor.numeric'            => 'El valor de la métrica debe ser un número.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos para el registro de la métrica.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $metrica = MetricaPaciente::create([
            'paciente_id'     => $pacienteId,
            'tipo_metrica_id' => $request->tipo_metrica_id,
            'valor'           => $request->valor,
            'fecha_registro'  => $request->fecha_registro ? Carbon::parse($request->fecha_registro) : now(),
            'notas'           => $request->notas,
        ]);

        $metrica->load('tipoMetrica');

        // Evaluar semáforo de normalidad
        $estado = 'Normal';
        if ($metrica->tipoMetrica) {
            if ($metrica->tipoMetrica->rango_min_normal !== null && $metrica->valor < $metrica->tipoMetrica->rango_min_normal) {
                $estado = 'Bajo';
            } elseif ($metrica->tipoMetrica->rango_max_normal !== null && $metrica->valor > $metrica->tipoMetrica->rango_max_normal) {
                $estado = 'Alto';
            }
        }

        return response()->json([
            'success' => true,
            'message' => '¡Métrica registrada exitosamente!',
            'data'    => [
                'id'              => $metrica->id,
                'tipo_nombre'     => $metrica->tipoMetrica->nombre ?? '',
                'unidad_medida'   => $metrica->tipoMetrica->unidad_medida ?? '',
                'valor'           => (float) $metrica->valor,
                'estado'          => $estado,
                'fecha_registro'  => $metrica->fecha_registro,
                'notas'           => $metrica->notas,
            ],
        ], 201);
    }

    /**
     * Resumen para el dashboard móvil del paciente (última medición por cada métrica).
     */
    public function resumenDashboard(Request $request): JsonResponse
    {
        $usuario = $request->user();

        if (!$usuario->esPaciente()) {
            return response()->json([
                'success' => false,
                'message' => 'Solo los pacientes tienen resumen de métricas personal.',
            ], 403);
        }

        $paciente = $usuario->paciente;
        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil de paciente no encontrado.',
            ], 404);
        }

        // Obtener todos los tipos de métrica
        $tipos = Metrica::all();

        $resumen = $tipos->map(function ($tipo) use ($paciente) {
            $ultima = MetricaPaciente::where('paciente_id', $paciente->id)
                ->where('tipo_metrica_id', $tipo->id)
                ->orderBy('fecha_registro', 'desc')
                ->first();

            $estado = 'Sin datos';
            if ($ultima) {
                $estado = 'Normal';
                if ($tipo->rango_min_normal !== null && $ultima->valor < $tipo->rango_min_normal) {
                    $estado = 'Bajo';
                } elseif ($tipo->rango_max_normal !== null && $ultima->valor > $tipo->rango_max_normal) {
                    $estado = 'Alto';
                }
            }

            return [
                'tipo_metrica_id' => $tipo->id,
                'nombre'          => $tipo->nombre,
                'unidad_medida'   => $tipo->unidad_medida,
                'rango_min'       => $tipo->rango_min_normal ? (float) $tipo->rango_min_normal : null,
                'rango_max'       => $tipo->rango_max_normal ? (float) $tipo->rango_max_normal : null,
                'ultima_medicion' => $ultima ? [
                    'id'             => $ultima->id,
                    'valor'          => (float) $ultima->valor,
                    'fecha_registro' => $ultima->fecha_registro,
                    'estado'         => $estado,
                    'notas'          => $ultima->notas,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'paciente'        => [
                    'nombre'        => $usuario->nombre_completo,
                    'nivel_riesgo'  => $paciente->nivel_riesgo,
                    'diagnostico'   => $paciente->diagnostico_principal,
                    'medico'        => $paciente->medico && $paciente->medico->usuario 
                        ? 'Dr. ' . $paciente->medico->usuario->nombre_completo 
                        : 'Sin médico asignado',
                ],
                'metricas_resumen'=> $resumen,
            ],
        ]);
    }
}
