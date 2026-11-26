<div class="patients-header-container">
    <div class="patients-title-group">
        <h1 class="page-main-heading">Cuerpo Médico</h1>
        <p class="page-sub-heading">
            <span class="badge-counter">{{ $totalMedicos ?? 0 }} profesionales</span>
            Gestión del personal médico, especialidades, turnos y asignación de pacientes
        </p>
    </div>

    <div class="patients-header-actions">
        <!-- Formulario de Búsqueda -->
        <form method="GET" action="{{ route('admin.medicos') }}" class="search-form-modern" id="searchDoctorForm">
            @if(request('turno'))
                <input type="hidden" name="turno" value="{{ request('turno') }}">
            @endif
            @if(request('estado'))
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif
            <div class="search-input-box">
                <i class="fa-solid fa-magnifying-glass search-icon-lead"></i>
                <input 
                    type="text" 
                    name="buscar" 
                    id="searchDoctorInput"
                    class="search-input-field" 
                    placeholder="Buscar por médico, especialidad, cédula..."
                    value="{{ request('buscar') }}"
                    autocomplete="off"
                >
                @if(request('buscar'))
                    <a href="{{ route('admin.medicos', array_merge(request()->except('buscar'), [])) }}" class="search-clear-btn" title="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <button type="button" class="btn-primary" id="btnOpenModal">
            <i class="fa-solid fa-user-doctor"></i>
            <span>Nuevo Médico</span>
        </button>
    </div>
</div>
