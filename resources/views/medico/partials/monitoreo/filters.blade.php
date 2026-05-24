<form method="GET" action="{{ route('medico.pacientes.show', $paciente->id) }}" class="filtros-card" id="formFiltros">
    <div class="filtro-grupo">
        <label>Métrica a evaluar</label>
        <select name="metrica_id" class="input-control" onchange="document.getElementById('formFiltros').submit();">
            @foreach($metricasDisponibles as $metrica)
                <option value="{{ $metrica->id }}" {{ $metricaSeleccionada->id == $metrica->id ? 'selected' : '' }}>
                    {{ $metrica->nombre }} ({{ $metrica->unidad_medida }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="filtro-grupo">
        <label>Rango de Fechas</label>
        <div class="fechas-grupo">
            <input type="date" name="fecha_inicio" class="input-control" value="{{ $fechaInicio }}" onchange="document.getElementById('formFiltros').submit();">
            <input type="date" name="fecha_fin" class="input-control" value="{{ $fechaFin }}" onchange="document.getElementById('formFiltros').submit();">
        </div>
    </div>
</form>