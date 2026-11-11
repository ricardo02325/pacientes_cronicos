<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Metrica;
use App\Models\MetricaPaciente;
use Carbon\Carbon;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener el perfil médico del usuario autenticado
        $medico = auth()->check() ? auth()->user()->medico : null;
        $medicoId = $medico?->id;

        // 2. Query base para los pacientes de este médico (o todos si no tiene filtro específico)
        $queryBase = $medicoId ? Paciente::whereHas('medicos', fn($q) => $q->where('medicos.id', $medicoId)) : Paciente::query();

        // 3. Calcular Estadísticas (Clonamos la query para no afectarla)
        $stats = [
            'total' => (clone $queryBase)->count(),
            'bajo'  => (clone $queryBase)->where('nivel_riesgo', 'Bajo')->count(),
            'medio' => (clone $queryBase)->where('nivel_riesgo', 'Medio')->count(),
            'alto'  => (clone $queryBase)->where('nivel_riesgo', 'Alto')->count(),
        ];

        // 4. Aplicar Filtros para la Tabla
        // Filtro por nivel de riesgo (Pills)
        if ($request->filled('riesgo') && $request->riesgo !== 'todos') {
            $queryBase->where('nivel_riesgo', ucfirst($request->riesgo));
        }

        // Filtro por búsqueda de texto (Nombre, Email o Diagnóstico)
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $queryBase->where(function($q) use ($busqueda) {
                $q->where('diagnostico_principal', 'LIKE', "%{$busqueda}%")
                  ->orWhereHas('usuario', function($userQuery) use ($busqueda) {
                      // Usamos CONCAT_WS para unir los nombres con un espacio, ignorando los nulos
                      $userQuery->where(DB::raw("CONCAT_WS(' ', primer_nombre, segundo_nombre, apellido_paterno, apellido_materno)"), 'LIKE', "%{$busqueda}%")
                                ->orWhere('email', 'LIKE', "%{$busqueda}%");
                  });
            });
        }

        // 5. Obtener los resultados con sus relaciones
        $pacientes = $queryBase->with(['usuario', 'ultimaMetrica'])->paginate(10)->onEachSide(1)->withQueryString();

        // 6. Retornar a la vista con las variables
        return view('medico.pacientes', compact('stats', 'pacientes'));
    }

    public function show($id, Request $request)
    {
        // 1. Obtener el paciente con la información de su usuario
        $paciente = Paciente::with('usuario')->findOrFail($id);

        // 2. Obtener el catálogo de métricas para el <select>
        $metricasDisponibles = Metrica::all();

        // 3. Obtener los filtros actuales de la URL (o valores por defecto)
        // Si no selecciona nada, por defecto mostramos la métrica 1 (Presión Sistólica)
        $metricaId = $request->input('metrica_id', 1); 
        
        // Por defecto mostramos los últimos 7 días
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(7)->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', Carbon::now()->format('Y-m-d'));

        $metricaSeleccionada = $metricasDisponibles->where('id', $metricaId)->first();

        // 4. Consultar el historial en la base de datos
        // Ordenamos ascendente para que la gráfica fluya de izquierda (viejo) a derecha (nuevo)
        $historial = MetricaPaciente::where('paciente_id', $id)
            ->where('tipo_metrica_id', $metricaId)
            ->whereBetween('fecha_registro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('fecha_registro', 'asc') 
            ->get();

        // 5. Preparar datos para Chart.js (Extraemos las fechas y los valores en arreglos separados)
        $chartLabels = $historial->map(function($item) {
            return Carbon::parse($item->fecha_registro)->format('d M'); // Ej: "20 Oct"
        })->values()->toArray();

        $chartData = $historial->pluck('valor')->toArray(); // Ej: [145, 140, 138]

        // 6. Para la tabla HTML, suele ser mejor mostrar lo más reciente arriba (descendente)
        $historialTabla = $historial->sortByDesc('fecha_registro');

        return view('medico.monitoreo', compact(
            'paciente', 
            'metricasDisponibles', 
            'metricaSeleccionada', 
            'fechaInicio', 
            'fechaFin', 
            'chartLabels', 
            'chartData', 
            'historialTabla'
        ));
    }

    /**
     * Registrar una métrica para un paciente desde el panel médico.
     */
    public function storeMetrica(Request $request, $id)
    {
        $paciente = Paciente::with('usuario')->findOrFail($id);

        $request->validate([
            'tipo_metrica_id' => 'required|exists:metricas,id',
            'valor' => 'required|numeric|between:0,9999.99',
            'notas' => 'nullable|string|max:255',
        ]);

        MetricaPaciente::create([
            'paciente_id' => $paciente->id,
            'tipo_metrica_id' => $request->tipo_metrica_id,
            'valor' => $request->valor,
            'fecha_registro' => now(),
            'notas' => $request->notas,
        ]);

        $metrica = Metrica::find($request->tipo_metrica_id);

        return redirect()
            ->route('medico.pacientes.show', [
                'id' => $id,
                'metrica_id' => $request->tipo_metrica_id,
            ])
            ->with('success', "Métrica '{$metrica->nombre}' registrada exitosamente para {$paciente->usuario->primer_nombre}.");
    }

    public function exportPDF($id, Request $request)
    {
        // 1. Obtener los datos del paciente y catálogos
        $paciente = Paciente::with('usuario')->findOrFail($id);
        
        $metricaId = $request->input('metrica_id', 1);
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(7)->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', Carbon::now()->format('Y-m-d'));
        
        $metricaSeleccionada = Metrica::findOrFail($metricaId);

        // 2. Consultar el historial filtrado (Idéntico a la lógica del show)
        $historial = MetricaPaciente::where('paciente_id', $id)
            ->where('tipo_metrica_id', $metricaId)
            ->whereBetween('fecha_registro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('fecha_registro', 'desc') // Más reciente primero para el reporte impreso
            ->get();

        // 3. Cargar la vista Blade especial para el PDF y pasarle las variables
        $pdf = Pdf::loadView('medico.partials.pacientes.pdf', compact(
            'paciente',
            'metricaSeleccionada',
            'fechaInicio',
            'fechaFin',
            'historial'
        ));

        // 4. Descargar el archivo con un nombre dinámico y limpio
        $nombreArchivo = 'Reporte_' . str_replace(' ', '_', $paciente->usuario->primer_nombre) . '_' . $fechaFin . '.pdf';
        return $pdf->download($nombreArchivo);
    }

    /**
     * Centro de Reportes Clínicos y Telemetría Médica
     */
    public function reportes(Request $request)
    {
        $medico = auth()->check() ? auth()->user()->medico : null;
        $medicoId = $medico?->id;

        $queryPacientes = $medicoId ? Paciente::whereHas('medicos', fn($q) => $q->where('medicos.id', $medicoId)) : Paciente::query();

        $totalPacientes = (clone $queryPacientes)->count();
        $riesgoAlto = (clone $queryPacientes)->where('nivel_riesgo', 'Alto')->count();
        $riesgoMedio = (clone $queryPacientes)->where('nivel_riesgo', 'Medio')->count();
        $riesgoBajo = (clone $queryPacientes)->where('nivel_riesgo', 'Bajo')->count();

        // Pacientes con sus últimas métricas para el radar clínico
        $pacientesConMetricas = (clone $queryPacientes)
            ->with(['usuario', 'ultimaMetrica.tipoMetrica'])
            ->get();

        // Últimas alertas clínicas registradas (últimos 15 días)
        $alertasRecientes = MetricaPaciente::whereHas('paciente.medicos', function($q) use ($medicoId) {
                if ($medicoId) {
                    $q->where('medicos.id', $medicoId);
                }
            })
            ->with(['paciente.usuario', 'tipoMetrica'])
            ->where(function($q) {
                // Presión sistólica alta (>=140), Diastólica alta (>=90) o Glucosa alterada (>=140 o <=70)
                $q->where(function($sub) {
                    $sub->where('tipo_metrica_id', 1)->where('valor', '>=', 140);
                })->orWhere(function($sub) {
                    $sub->where('tipo_metrica_id', 2)->where('valor', '>=', 90);
                })->orWhere(function($sub) {
                    $sub->where('tipo_metrica_id', 3)->where('valor', '>=', 140);
                })->orWhere(function($sub) {
                    $sub->where('tipo_metrica_id', 3)->where('valor', '<=', 70);
                });
            })
            ->orderBy('fecha_registro', 'desc')
            ->limit(8)
            ->get();

        return view('medico.reportes', compact(
            'totalPacientes',
            'riesgoAlto',
            'riesgoMedio',
            'riesgoBajo',
            'pacientesConMetricas',
            'alertasRecientes'
        ));
    }
}

