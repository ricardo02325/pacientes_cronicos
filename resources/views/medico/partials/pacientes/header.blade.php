<div class="patients-header-container">
    <div class="patients-title-group">
        <h1 class="page-main-heading">Monitoreo de Pacientes Asignados</h1>
        <p class="page-sub-heading">
            <span class="badge-counter">{{ $stats['total'] ?? 0 }} a tu cargo</span>
            Dr(a). {{ auth()->user()->nombre_completo ?? 'Médico' }} • {{ now()->translatedFormat('d \d\e F, Y') }}
        </p>
    </div>

    <div class="patients-header-actions">
        <!-- Buscador de Pacientes del Médico -->
        <form method="GET" action="{{ route('medico.pacientes.index') }}" class="search-form-modern">
            @if(request('riesgo') && request('riesgo') !== 'todos')
                <input type="hidden" name="riesgo" value="{{ request('riesgo') }}">
            @endif
            <div class="search-input-box">
                <i class="fa-solid fa-magnifying-glass search-icon-lead"></i>
                <input 
                    type="text" 
                    name="buscar" 
                    class="search-input-field" 
                    placeholder="Buscar por nombre, email o diagnóstico..."
                    value="{{ request('buscar') }}"
                    autocomplete="off"
                >
                @if(request('buscar'))
                    <a href="{{ route('medico.pacientes.index', request()->except('buscar')) }}" class="search-clear-btn" title="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <a href="{{ route('medico.reportes') }}" class="btn-secondary">
            <i class="fa-solid fa-file-waveform"></i>
            <span>Reportes Clínicos</span>
        </a>
    </div>
</div>