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
        // 1. Obtener el ID del médico autenticado (simulado como 1 si no tienes Auth aún)
        $medicoId = auth()->check() ? auth()->user()->id : 10;

        // 2. Query base para los pacientes de este médico
        $queryBase = Paciente::where('medico_id', $medicoId);

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
        $pacientes = $queryBase->with(['usuario', 'ultimaMetrica'])->paginate(10);

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
}
