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
            @include('medico.partials.monitoreo.alert-ranges')
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

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: metricaNombre,
                    data: dataValues,
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13, weight: '700' },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' ' + "{{ $metricaSeleccionada->unidad_medida }}";
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        suggestedMin: {{ $metricaSeleccionada->rango_min_normal ?? 0 }}, 
                        grid: { color: '#f1f5f9', borderDash: [4, 4] }, 
                        border: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }, color: '#64748b' }
                    },
                    x: { 
                        grid: { display: false }, 
                        border: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }, color: '#64748b' }
                    }
                }
            }
        });
    });
</script>
@endpush