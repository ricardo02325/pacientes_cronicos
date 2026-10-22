<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Metrica;
use App\Models\MetricaPaciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard principal del paciente: resumen + últimas métricas.
     */
    public function index()
    {
        $user = auth()->user();
        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->route('login')->with('error', 'No se encontró un expediente de paciente asociado.');
        }

        // Últimas métricas registradas (una por tipo)
        $metricasDisponibles = Metrica::all();

        $ultimasMetricas = [];
        foreach ($metricasDisponibles as $metrica) {
            $ultima = MetricaPaciente::where('paciente_id', $paciente->id)
                ->where('tipo_metrica_id', $metrica->id)
                ->orderBy('fecha_registro', 'desc')
                ->first();

            $ultimasMetricas[] = [
                'metrica' => $metrica,
                'registro' => $ultima,
            ];
        }

        // Gráfica: últimos 7 días de la primera métrica disponible
        $metricaDefault = $metricasDisponibles->first();
        $chartData = [];
        $chartLabels = [];

        if ($metricaDefault) {
            $historial = MetricaPaciente::where('paciente_id', $paciente->id)
                ->where('tipo_metrica_id', $metricaDefault->id)
                ->where('fecha_registro', '>=', Carbon::now()->subDays(7))
                ->orderBy('fecha_registro', 'asc')
                ->get();

            $chartLabels = $historial->map(fn($item) => Carbon::parse($item->fecha_registro)->format('d M'))->values()->toArray();
            $chartData = $historial->pluck('valor')->toArray();
        }

        return view('paciente.dashboard', compact(
            'paciente',
            'metricasDisponibles',
            'ultimasMetricas',
            'metricaDefault',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * Registrar una nueva métrica del paciente.
     */
    public function storeMetrica(Request $request)
    {
        $user = auth()->user();
        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->route('login')->with('error', 'Expediente de paciente no encontrado.');
        }

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
            ->route('paciente.dashboard')
            ->with('success', "Registro de {$metrica->nombre} ({$request->valor} {$metrica->unidad_medida}) guardado exitosamente.");
    }

    /**
     * Historial completo con filtros y gráfica.
     */
    public function historial(Request $request)
    {
        $user = auth()->user();
        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->route('login');
        }

        $metricasDisponibles = Metrica::all();

        $metricaId = $request->input('metrica_id', 1);
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', Carbon::now()->format('Y-m-d'));

        $metricaSeleccionada = $metricasDisponibles->where('id', $metricaId)->first();

        $historial = MetricaPaciente::where('paciente_id', $paciente->id)
            ->where('tipo_metrica_id', $metricaId)
            ->whereBetween('fecha_registro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('fecha_registro', 'asc')
            ->get();

        $chartLabels = $historial->map(fn($item) => Carbon::parse($item->fecha_registro)->format('d M'))->values()->toArray();
        $chartData = $historial->pluck('valor')->toArray();
        $historialTabla = $historial->sortByDesc('fecha_registro');

        return view('paciente.historial', compact(
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
}
