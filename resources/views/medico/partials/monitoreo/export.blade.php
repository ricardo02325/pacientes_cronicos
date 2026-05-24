<div class="export-card">
    <h3>Exportar Reporte</h3>
    <p>Descarga el historial de métricas en formato PDF según el rango de fechas.</p>
    
    <a href="{{ route('medico.pacientes.exportPdf', [
        'id' => $paciente->id,
        'metrica_id' => $metricaSeleccionada->id,
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin
       ]) }}" 
       class="btn-export" 
       style="text-decoration: none;">
        <i class="fa-solid fa-download"></i> Descargar PDF
    </a>
</div>