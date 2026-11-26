<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Paciente;
use App\Models\TotalPacientes;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PacientesController extends Controller
{
    /**
     * Listado y gestión principal de pacientes (Admin).
     */
    public function index(Request $request)
    {
        $query = Paciente::with(['usuario', 'medico.usuario', 'medicos.usuario', 'ultimaMetrica'])
            ->whereHas('usuario');

        // Búsqueda por texto (nombre, apellido, email o diagnóstico)
        if ($request->filled('buscar')) {
            $term = trim($request->buscar);
            $query->where(function ($q) use ($term) {
                $q->where('diagnostico_principal', 'LIKE', "%{$term}%")
                    ->orWhere('telefono_emergencia', 'LIKE', "%{$term}%")
                    ->orWhereHas('usuario', function ($uq) use ($term) {
                        $uq->where(DB::raw("CONCAT_WS(' ', primer_nombre, segundo_nombre, apellido_paterno, apellido_materno)"), 'LIKE', "%{$term}%")
                            ->orWhere('email', 'LIKE', "%{$term}%");
                    });
            });
        }

        // Filtro por nivel de riesgo
        if ($request->filled('riesgo') && in_array($request->riesgo, ['Bajo', 'Medio', 'Alto'])) {
            $query->where('nivel_riesgo', $request->riesgo);
        }

        // Filtro por estado del usuario
        if ($request->filled('estado') && in_array($request->estado, ['Activo', 'Inactivo'])) {
            $query->whereHas('usuario', function ($uq) use ($request) {
                $uq->where('estado', $request->estado);
            });
        }

        // Ordenamiento
        $query->orderBy('created_at', 'desc');

        $pacientes = $query->paginate(12)->onEachSide(1)->withQueryString();

        // Totales y estadísticas
        $totalPacientes = Paciente::count();
        $totalAltoRiesgo = Paciente::where('nivel_riesgo', 'Alto')->count();
        $totalMedioRiesgo = Paciente::where('nivel_riesgo', 'Medio')->count();
        $totalEstables = Paciente::where('nivel_riesgo', 'Bajo')->count();

        // Médicos disponibles para asignación
        $medicos = Medico::with('usuario')
            ->withCount('pacientes')
            ->whereHas('usuario')
            ->orderBy('pacientes_count')
            ->orderBy('id')
            ->get();
        $medicos->each(function (Medico $medico) {
            $medico->setAttribute(
                'diagnosticos_disponibles',
                Medico::diagnosticosParaEspecialidad($medico->especialidad)
            );
        });
        $menorCargaMedica = $medicos->min('pacientes_count');
        $maxPacientesAsignados = $medicos->max('pacientes_count') ?? 0;

        return view('admin.pacientes', compact(
            'pacientes',
            'totalPacientes',
            'totalAltoRiesgo',
            'totalMedioRiesgo',
            'totalEstables',
            'medicos',
            'menorCargaMedica',
            'maxPacientesAsignados'
        ));
    }

    /**
     * Registrar un nuevo paciente.
     */
    public function store(Request $request)
    {
        $especialidadesPermitidas = Medico::especialidadesParaDiagnostico(
            $request->input('diagnostico_principal')
        );

        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:usuarios,email',
            'password' => 'nullable|string|min:6|max:255',

            'medico_ids' => 'required|array|min:1',
            'medico_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('medicos', 'id')->whereIn('especialidad', $especialidadesPermitidas),
            ],
            'medico_principal_id' => [
                'required',
                'integer',
                Rule::exists('medicos', 'id')->whereIn('especialidad', $especialidadesPermitidas),
                Rule::in($request->input('medico_ids', [])),
            ],
            'fecha_nacimiento' => 'required|date',
            'telefono_emergencia' => 'required|string|max:20',
            'sexo' => 'required|string|in:Masculino,Femenino,Otro',
            'estatura' => 'nullable|numeric|between:0.5,2.5',
            'diagnostico_principal' => ['required', Rule::in(Medico::DIAGNOSTICOS)],
            'nivel_riesgo' => 'required|in:Bajo,Medio,Alto',
        ]);

        $passwordPlano = $request->filled('password')
            ? $request->password
            : 'PAC' . rand(100000, 999999);

        DB::beginTransaction();
        try {
            // 1. Crear el usuario
            $usuario = Usuario::create([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'rol_id' => 3, // Rol Paciente
                'email' => $request->email,
                'password' => Hash::make($passwordPlano),
                'estado' => 'Activo',
            ]);

            // 2. Crear el expediente de paciente
            $paciente = Paciente::create([
                'usuario_id' => $usuario->id,
                'medico_id' => $request->medico_principal_id,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono_emergencia' => $request->telefono_emergencia,
                'sexo' => $request->sexo,
                'estatura' => $request->estatura ?? 1.70,
                'diagnostico_principal' => $request->diagnostico_principal,
                'nivel_riesgo' => $request->nivel_riesgo,
            ]);

            $asignaciones = collect($request->input('medico_ids'))
                ->mapWithKeys(fn ($medicoId) => [
                    $medicoId => ['es_principal' => (int) $medicoId === (int) $request->medico_principal_id],
                ])
                ->all();
            $paciente->medicos()->sync($asignaciones);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Paciente {$usuario->nombre_completo} registrado exitosamente.",
                    'paciente' => $paciente->load('usuario', 'medico.usuario', 'medicos.usuario'),
                ]);
            }

            return redirect()
                ->route('admin.pacientes')
                ->with('success', "Paciente {$usuario->nombre_completo} registrado correctamente. (Contraseña de acceso: {$passwordPlano})");

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al registrar paciente: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al registrar el paciente: ' . $e->getMessage());
        }
    }

    /**
     * Obtener datos de un paciente (para edición o vista detallada).
     */
    public function show($id)
    {
        $paciente = Paciente::with(['usuario', 'medico.usuario', 'medicos.usuario', 'ultimaMetrica'])->findOrFail($id);
        $medicoPrincipal = $paciente->medicos->first(fn ($medico) => (bool) $medico->pivot->es_principal)
            ?? $paciente->medico;

        return response()->json([
            'success' => true,
            'paciente' => [
                'id' => $paciente->id,
                'usuario_id' => $paciente->usuario_id,
                'primer_nombre' => $paciente->usuario->primer_nombre,
                'segundo_nombre' => $paciente->usuario->segundo_nombre,
                'apellido_paterno' => $paciente->usuario->apellido_paterno,
                'apellido_materno' => $paciente->usuario->apellido_materno,
                'nombre_completo' => $paciente->usuario->nombre_completo,
                'email' => $paciente->usuario->email,
                'estado' => $paciente->usuario->estado,
                'medico_id' => $medicoPrincipal?->id,
                'medico_nombre' => $medicoPrincipal?->nombre_completo ?? 'Sin Asignar',
                'medicos' => $paciente->medicos->map(function ($medico) {
                    return [
                        'id' => $medico->id,
                        'nombre_completo' => $medico->nombre_completo,
                        'especialidad' => $medico->especialidad,
                        'es_principal' => (bool) ($medico->pivot->es_principal ?? false),
                    ];
                })->values(),
                'fecha_nacimiento' => $paciente->fecha_nacimiento,
                'telefono_emergencia' => $paciente->telefono_emergencia,
                'sexo' => $paciente->sexo,
                'estatura' => $paciente->estatura,
                'diagnostico_principal' => $paciente->diagnostico_principal,
                'nivel_riesgo' => $paciente->nivel_riesgo,
                'edad' => \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age,
                'created_at' => $paciente->created_at ? $paciente->created_at->format('d/m/Y') : '',
            ]
        ]);
    }

    /**
     * Actualizar los datos del paciente.
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::with('usuario')->findOrFail($id);
        $usuario = $paciente->usuario;
        $especialidadesPermitidas = Medico::especialidadesParaDiagnostico(
            $request->input('diagnostico_principal')
        );

        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('usuarios', 'email')->ignore($usuario->id),
            ],
            'password' => 'nullable|string|min:6|max:255',
            'estado' => 'required|in:Activo,Inactivo',

            'medico_ids' => 'required|array|min:1',
            'medico_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('medicos', 'id')->whereIn('especialidad', $especialidadesPermitidas),
            ],
            'medico_principal_id' => [
                'required',
                'integer',
                Rule::exists('medicos', 'id')->whereIn('especialidad', $especialidadesPermitidas),
                Rule::in($request->input('medico_ids', [])),
            ],
            'fecha_nacimiento' => 'required|date',
            'telefono_emergencia' => 'required|string|max:20',
            'sexo' => 'required|string|in:Masculino,Femenino,Otro',
            'estatura' => 'nullable|numeric|between:0.5,2.5',
            'diagnostico_principal' => ['required', Rule::in(Medico::DIAGNOSTICOS)],
            'nivel_riesgo' => 'required|in:Bajo,Medio,Alto',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar Usuario
            $usuarioData = [
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'estado' => $request->estado,
            ];

            if ($request->filled('password')) {
                $usuarioData['password'] = Hash::make($request->password);
            }

            $usuario->update($usuarioData);

            // Actualizar Paciente
            $paciente->update([
                'medico_id' => $request->medico_principal_id,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono_emergencia' => $request->telefono_emergencia,
                'sexo' => $request->sexo,
                'estatura' => $request->estatura ?? $paciente->estatura,
                'diagnostico_principal' => $request->diagnostico_principal,
                'nivel_riesgo' => $request->nivel_riesgo,
            ]);

            $asignaciones = collect($request->input('medico_ids'))
                ->mapWithKeys(fn ($medicoId) => [
                    $medicoId => ['es_principal' => (int) $medicoId === (int) $request->medico_principal_id],
                ])
                ->all();
            $paciente->medicos()->sync($asignaciones);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Expediente del paciente {$usuario->nombre_completo} actualizado correctamente.",
                ]);
            }

            return redirect()
                ->route('admin.pacientes')
                ->with('success', "Expediente de {$usuario->nombre_completo} actualizado con éxito.");

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al actualizar paciente: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el paciente: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar o inactivar un paciente.
     */
    public function destroy(Request $request, $id)
    {
        $paciente = Paciente::with('usuario')->findOrFail($id);
        $nombre = $paciente->usuario->nombre_completo;

        DB::beginTransaction();
        try {
            // Si el usuario solicitó borrado físico o inactivación
            if ($request->input('accion') === 'eliminar_definitivo') {
                $paciente->metricas()->delete();
                $usuario = $paciente->usuario;
                $paciente->delete();
                $usuario->delete();
                $mensaje = "Paciente {$nombre} eliminado permanentemente.";
            } else {
                // Inactivar por defecto para preservar historial clínico
                $paciente->usuario->update(['estado' => 'Inactivo']);
                $mensaje = "Paciente {$nombre} ha sido marcado como Inactivo.";
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $mensaje]);
            }

            return redirect()
                ->route('admin.pacientes')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }
}