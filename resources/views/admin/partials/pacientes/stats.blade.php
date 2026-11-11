<div class="patient-stats-strip">
    <a href="{{ route('admin.pacientes', request()->except(['page', 'riesgo', 'estado'])) }}" class="patient-stat-card {{ !request('riesgo') ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-blue">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Total Pacientes</span>
            <span class="stat-number">{{ $totalPacientes ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Bajo'])) }}" class="patient-stat-card {{ request('riesgo') == 'Bajo' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-green">
            <i class="fa-solid fa-heart-circle-check"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Estables (Riesgo Bajo)</span>
            <span class="stat-number text-green">{{ $totalEstables ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Medio'])) }}" class="patient-stat-card {{ request('riesgo') == 'Medio' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-amber">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Riesgo Medio</span>
            <span class="stat-number text-amber">{{ $totalMedioRiesgo ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Alto'])) }}" class="patient-stat-card {{ request('riesgo') == 'Alto' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-red">
            <i class="fa-solid fa-circle-exclamation pulse-icon"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Críticos (Riesgo Alto)</span>
            <span class="stat-number text-red">{{ $totalAltoRiesgo ?? 0 }}</span>
        </div>
    </a>
</div>
