<div class="grafica-card">
    <h3>
        <i class="fa-solid fa-chart-line" style="color: var(--primary);"></i>
        Evolución: {{ $metricaSeleccionada->nombre }} ({{ $metricaSeleccionada->unidad_medida }})
    </h3>
    <div class="canvas-container">
        <canvas id="metricChart"></canvas>
    </div>
</div>