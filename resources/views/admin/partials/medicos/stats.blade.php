<div class="patient-stats-strip">
    <a href="{{ route('admin.medicos') }}" class="patient-stat-card {{ !request('turno') && !request('estado') ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-blue">
            <i class="fa-solid fa-user-doctor"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Total Médicos</span>
            <span class="stat-number">{{ $totalMedicos ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.medicos', array_merge(request()->except('estado'), ['estado' => 'Activo'])) }}" class="patient-stat-card {{ request('estado') == 'Activo' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-green">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Médicos Activos</span>
            <span class="stat-number text-green">{{ $totalActivos ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.medicos', array_merge(request()->except('turno'), ['turno' => 'Matutino'])) }}" class="patient-stat-card {{ request('turno') == 'Matutino' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-amber">
            <i class="fa-solid fa-sun"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Turno Matutino</span>
            <span class="stat-number text-amber">{{ $totalMatutino ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('admin.medicos', array_merge(request()->except('turno'), ['turno' => 'Vespertino'])) }}" class="patient-stat-card {{ request('turno') == 'Vespertino' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper" style="background: #f3e8ff; color: #7e22ce;">
            <i class="fa-solid fa-cloud-sun"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Turno Vespertino</span>
            <span class="stat-number" style="color: #7e22ce;">{{ $totalVespertino ?? 0 }}</span>
        </div>
    </a>
</div>
