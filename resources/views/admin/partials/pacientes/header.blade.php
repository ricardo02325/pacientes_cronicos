<div class="patients-header-container">
    <div class="patients-title-group">
        <h1 class="page-main-heading">Gestión de Pacientes</h1>
        <p class="page-sub-heading">
            <span class="badge-counter">{{ $totalPacientes ?? 0 }} registrados</span>
            Monitoreo clínico, asignación de médicos y control de riesgo de la institución
        </p>
    </div>

    <div class="patients-header-actions">
        <!-- Formulario de Búsqueda -->
        <form method="GET" action="{{ route('admin.pacientes') }}" class="search-form-modern" id="searchPatientForm">
            @if(request('riesgo'))
                <input type="hidden" name="riesgo" value="{{ request('riesgo') }}">
            @endif
            @if(request('estado'))
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif
            <div class="search-input-box">
                <i class="fa-solid fa-magnifying-glass search-icon-lead"></i>
                <input 
                    type="text" 
                    name="buscar" 
                    id="searchPatientInput"
                    class="search-input-field" 
                    placeholder="Buscar por nombre, diagnóstico, email..."
                    value="{{ request('buscar') }}"
                    autocomplete="off"
                >
                @if(request('buscar'))
                    <a href="{{ route('admin.pacientes', array_merge(request()->except('buscar'), [])) }}" class="search-clear-btn" title="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <button type="button" id="addPatientBtn" class="btn-primary btn-add-patient">
            <i class="fa-solid fa-user-plus"></i>
            <span>Nuevo Paciente</span>
        </button>
    </div>
</div>