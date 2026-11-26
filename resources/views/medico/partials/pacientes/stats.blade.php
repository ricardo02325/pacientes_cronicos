<div class="patient-stats-strip">
    <a href="{{ route('medico.pacientes.index', request()->only('buscar')) }}" class="patient-stat-card {{ !request('riesgo') || request('riesgo') === 'todos' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-blue">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Total Asignados</span>
            <span class="stat-number">{{ $stats['total'] ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'bajo'])) }}" class="patient-stat-card {{ request('riesgo') === 'bajo' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-green">
            <i class="fa-solid fa-heart-circle-check"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Riesgo Bajo (Estables)</span>
            <span class="stat-number text-green">{{ $stats['bajo'] ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'medio'])) }}" class="patient-stat-card {{ request('riesgo') === 'medio' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-amber">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Riesgo Medio</span>
            <span class="stat-number text-amber">{{ $stats['medio'] ?? 0 }}</span>
        </div>
    </a>

    <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'alto'])) }}" class="patient-stat-card {{ request('riesgo') === 'alto' ? 'active-filter' : '' }}">
        <div class="stat-icon-wrapper bg-red">
            <i class="fa-solid fa-circle-exclamation pulse-icon"></i>
        </div>
        <div class="stat-content">
            <span class="stat-label">Críticos (Riesgo Alto)</span>
            <span class="stat-number text-red">{{ $stats['alto'] ?? 0 }}</span>
        </div>
    </a>
</div>