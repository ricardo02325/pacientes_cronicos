<div class="header-detalle">
    <a href="{{ route('medico.pacientes.index') }}" class="btn-back" title="Regresar al listado">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="patient-title">
        <h1>
            {{ $paciente->usuario->nombre_completo ?? 'Expediente del Paciente' }}
            @if(($paciente->nivel_riesgo ?? '') == 'Alto')
                <span class="badge-risk badge-risk-high" style="font-size: 12px; vertical-align: middle; margin-left: 8px;">
                    <span class="dot-pulse"></span> Riesgo Alto
                </span>
            @elseif(($paciente->nivel_riesgo ?? '') == 'Medio')
                <span class="badge-risk badge-risk-medium" style="font-size: 12px; vertical-align: middle; margin-left: 8px;">
                    <span class="dot-amber"></span> Riesgo Medio
                </span>
            @else
                <span class="badge-risk badge-risk-low" style="font-size: 12px; vertical-align: middle; margin-left: 8px;">
                    <span class="dot-green"></span> Estable
                </span>
            @endif
        </h1>
        <p>
            {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años • {{ ucfirst($paciente->sexo) }} • Diagnóstico: <strong>{{ $paciente->diagnostico_principal }}</strong>
        </p>
    </div>
</div>