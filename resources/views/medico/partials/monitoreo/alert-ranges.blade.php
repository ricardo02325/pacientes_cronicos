<div class="export-card">
    <h3>Alertas de este paciente</h3>
    <p>Define los límites individuales para generar alertas en sus mediciones.</p>

    @if($errors->has('rangos'))
        <p role="alert" style="color: #be123c; font-size: 12px; margin-bottom: 12px;">
            {{ $errors->first('rangos') }}
        </p>
    @endif

    <form method="POST" action="{{ route('medico.pacientes.alertas.rangos.update', $paciente->id) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 12px;">
            @foreach($metricasDisponibles as $indice => $metrica)
                @php
                    $rango = $rangosAlertas[$metrica->id];
                    $rangoMin = old("rangos.$indice.min", $rango['min']);
                    $rangoMax = old("rangos.$indice.max", $rango['max']);
                @endphp
                <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    <input type="hidden" name="rangos[{{ $indice }}][metrica_id]" value="{{ $metrica->id }}">
                    <div style="font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        {{ $metrica->nombre }} ({{ $metrica->unidad_medida }})
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <label style="font-size: 10px; color: #64748b;">
                            Mínimo
                            <input type="number" step="0.01" min="0" name="rangos[{{ $indice }}][min]"
                                value="{{ $rangoMin }}" aria-label="Mínimo de {{ $metrica->nombre }}"
                                style="display: block; width: 100%; padding: 6px; border: 1px solid #cbd5e1; border-radius: 6px;">
                        </label>
                        <label style="font-size: 10px; color: #64748b;">
                            Máximo
                            <input type="number" step="0.01" min="0" name="rangos[{{ $indice }}][max]"
                                value="{{ $rangoMax }}" aria-label="Máximo de {{ $metrica->nombre }}"
                                style="display: block; width: 100%; padding: 6px; border: 1px solid #cbd5e1; border-radius: 6px;">
                        </label>
                    </div>
                    @if($errors->has("rangos.$indice.min") || $errors->has("rangos.$indice.max"))
                        <p role="alert" style="color: #be123c; font-size: 11px; margin-top: 4px;">
                            {{ $errors->first("rangos.$indice.min") ?: $errors->first("rangos.$indice.max") }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <p style="font-size: 10.5px; color: #64748b; margin: 10px 0;">
            Deja un límite vacío para no generar alertas en esa dirección. Los rangos iniciales corresponden al catálogo.
        </p>
        <button type="submit" class="btn-export" style="border: 0; cursor: pointer;">
            Guardar rangos
        </button>
    </form>
</div>
