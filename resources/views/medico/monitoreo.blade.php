@extends('medico.layouts.app')

@section('title', 'Monitoreo Clínico')

@push('styles')
    @vite('resources/css/medico/monitoreo.css')
@endpush

@section('content')
    
    @include('medico.partials.monitoreo.header')

    <div class="detalle-grid">
        <div class="panel-graficas">
            @include('medico.partials.monitoreo.filters')
            @include('medico.partials.monitoreo.chart')
        </div>

        <div class="panel-lateral">
            @include('medico.partials.monitoreo.export')
            @include('medico.partials.monitoreo.history')
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('metricChart').getContext('2d');
        
        // Convertimos los arreglos de PHP a variables de Javascript nativas
        const labels = @json($chartLabels);
        const dataValues = @json($chartData);
        const metricaNombre = "{{ $metricaSeleccionada->nombre }}";

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: metricaNombre,
                    data: dataValues,
                    borderColor: '#3b82f6',
                    backgroundColor: '#ffffff',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointRadius: 4,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        // Sugerimos límites dinámicos basados en la métrica (Opcional pero recomendado)
                        suggestedMin: {{ $metricaSeleccionada->rango_min_normal ?? 0 }}, 
                        grid: { borderDash: [5, 5] }, 
                        border: { display: false } 
                    },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    });
</script>
@endpush