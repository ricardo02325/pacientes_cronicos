<div class="header-detalle">
    <a href="{{ route('medico.pacientes.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="patient-title">
        <h1>{{ $paciente->usuario->primer_nombre }} {{ $paciente->usuario->segundo_nombre }} {{ $paciente->usuario->apellido_paterno }} {{ $paciente->usuario->apellido_materno }}</h1>
        <p>Expediente Clínico Electrónico</p>
    </div>
</div>