<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Listado y gestión principal de médicos (Admin).
     */
    public function index(Request $request)
    {
        $query = Medico::with(['usuario', 'pacientes'])
            ->withCount('pacientes')
            ->whereHas('usuario');

        // Búsqueda por texto (nombre, cédula, especialidad, email, consultorio)
        if ($request->filled('buscar')) {
            $term = trim($request->buscar);
            $query->where(function ($q) use ($term) {
                $q->where('cedula_profesional', 'LIKE', "%{$term}%")
                    ->orWhere('especialidad', 'LIKE', "%{$term}%")
                    ->orWhere('telefono', 'LIKE', "%{$term}%")
                    ->orWhere('consultorio', 'LIKE', "%{$term}%")
                    ->orWhereHas('usuario', function ($uq) use ($term) {
                        $uq->where(DB::raw("CONCAT_WS(' ', primer_nombre, segundo_nombre, apellido_paterno, apellido_materno)"), 'LIKE', "%{$term}%")
                            ->orWhere('email', 'LIKE', "%{$term}%");
                    });
            });
        }

        // Filtro por turno
        if ($request->filled('turno') && in_array($request->turno, ['Matutino', 'Vespertino', 'Nocturno', 'Mixto'])) {
            $query->where('turno', $request->turno);
        }

        // Filtro por estado
        if ($request->filled('estado') && in_array($request->estado, ['Activo', 'Inactivo'])) {
            $query->whereHas('usuario', function ($uq) use ($request) {
                $uq->where('estado', $request->estado);
            });
        }

        $medicos = $query->orderBy('created_at', 'desc')->paginate(12)->onEachSide(1)->withQueryString();

        // Estadísticas y métricas
        $totalMedicos = Medico::count();
        $totalActivos = Medico::whereHas('usuario', fn($q) => $q->where('estado', 'Activo'))->count();
        $totalMatutino = Medico::where('turno', 'Matutino')->count();
        $totalVespertino = Medico::where('turno', 'Vespertino')->count();

        return view('admin.medicos', compact(
            'medicos',
            'totalMedicos',
            'totalActivos',
            'totalMatutino',
            'totalVespertino'
        ));
    }

    /**
     * Registrar un nuevo médico.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Datos Usuario
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:usuarios,email',
            'password' => 'required|string|min:6|max:255',

            // Datos Médico
            'telefono' => 'required|string|max:15',
            'cedula_profesional' => 'required|string|max:30|unique:medicos,cedula_profesional',
            'especialidad' => ['required', Rule::in(Medico::ESPECIALIDADES)],
            'turno' => 'required|in:Matutino,Vespertino,Nocturno,Mixto',
            'consultorio' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Crear el usuario
            $usuario = Usuario::create([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'rol_id' => 2, // Rol Médico
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'estado' => 'Activo',
            ]);

            // 2. Crear el registro en tabla médicos
            $medico = Medico::create([
                'usuario_id' => $usuario->id,
                'cedula_profesional' => $request->cedula_profesional,
                'especialidad' => $request->especialidad,
                'telefono' => $request->telefono,
                'consultorio' => $request->consultorio,
                'turno' => $request->turno,
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Dr(a). {$usuario->nombre_completo} registrado exitosamente.",
                    'medico' => $medico->load('usuario'),
                ]);
            }

            return redirect()
                ->route('admin.medicos')
                ->with('success', "Dr(a). {$usuario->nombre_completo} registrado correctamente en el sistema.");

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al registrar el médico: ' . $e->getMessage());
        }
    }

    /**
     * Obtener datos de un médico (para modal de edición o vista rápida).
     */
    public function show($id)
    {
        $medico = Medico::with(['usuario', 'pacientes.usuario'])->withCount('pacientes')->findOrFail($id);

        return response()->json([
            'success' => true,
            'medico' => [
                'id' => $medico->id,
                'usuario_id' => $medico->usuario_id,
                'primer_nombre' => $medico->usuario->primer_nombre,
                'segundo_nombre' => $medico->usuario->segundo_nombre,
                'apellido_paterno' => $medico->usuario->apellido_paterno,
                'apellido_materno' => $medico->usuario->apellido_materno,
                'nombre_completo' => $medico->nombre_completo,
                'email' => $medico->usuario->email,
                'estado' => $medico->usuario->estado,
                'cedula_profesional' => $medico->cedula_profesional,
                'especialidad' => $medico->especialidad,
                'telefono' => $medico->telefono,
                'consultorio' => $medico->consultorio,
                'turno' => $medico->turno,
                'observaciones' => $medico->observaciones,
                'pacientes_count' => $medico->pacientes_count,
            ]
        ]);
    }

    /**
     * Actualizar los datos de un médico.
     */
    public function update(Request $request, $id)
    {
        $medico = Medico::with('usuario')->findOrFail($id);
        $usuario = $medico->usuario;

        $request->validate([
            // Usuario
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

            // Médico
            'telefono' => 'required|string|max:15',
            'cedula_profesional' => [
                'required',
                'string',
                'max:30',
                Rule::unique('medicos', 'cedula_profesional')->ignore($medico->id),
            ],
            'especialidad' => ['required', Rule::in(Medico::ESPECIALIDADES)],
            'turno' => 'required|in:Matutino,Vespertino,Nocturno,Mixto',
            'consultorio' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string',
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

            // Actualizar Médico
            $medico->update([
                'cedula_profesional' => $request->cedula_profesional,
                'especialidad' => $request->especialidad,
                'telefono' => $request->telefono,
                'consultorio' => $request->consultorio,
                'turno' => $request->turno,
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Dr(a). {$usuario->nombre_completo} actualizado correctamente.",
                ]);
            }

            return redirect()
                ->route('admin.medicos')
                ->with('success', "Datos del Dr(a). {$usuario->nombre_completo} actualizados correctamente.");

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar médico: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar o inactivar un médico.
     */
    public function destroy(Request $request, $id)
    {
        $medico = Medico::with(['usuario', 'pacientes'])->findOrFail($id);
        $nombre = $medico->nombre_completo;

        DB::beginTransaction();
        try {
            if ($request->input('accion') === 'eliminar_definitivo') {
                if ($medico->pacientes()->count() > 0) {
                    return redirect()
                        ->back()
                        ->with('error', "No se puede eliminar al Dr(a). {$nombre} porque tiene pacientes asignados. Reasigna los pacientes o inactívalo.");
                }

                $usuario = $medico->usuario;
                $medico->delete();
                $usuario->delete();
                $mensaje = "Dr(a). {$nombre} eliminado permanentemente.";
            } else {
                $medico->usuario->update(['estado' => 'Inactivo']);
                $mensaje = "Dr(a). {$nombre} marcado como Inactivo.";
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $mensaje]);
            }

            return redirect()
                ->route('admin.medicos')
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