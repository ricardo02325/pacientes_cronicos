<div class="patient-card-wrapper">
    <!-- Toolbar de filtros -->
    <div class="table-toolbar">
        <div class="filter-pills-group">
            <a href="{{ route('medico.pacientes.index', request()->only('buscar')) }}" 
               class="filter-pill {{ !request('riesgo') || request('riesgo') === 'todos' ? 'active' : '' }}">
                Todos los Pacientes
            </a>
            <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'alto'])) }}" 
               class="filter-pill pill-danger {{ request('riesgo') === 'alto' ? 'active' : '' }}">
                <span class="dot-indicator dot-danger"></span> Críticos (Alto)
            </a>
            <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'medio'])) }}" 
               class="filter-pill pill-warning {{ request('riesgo') === 'medio' ? 'active' : '' }}">
                <span class="dot-indicator dot-warning"></span> Riesgo Medio
            </a>
            <a href="{{ route('medico.pacientes.index', array_merge(request()->only('buscar'), ['riesgo' => 'bajo'])) }}" 
               class="filter-pill pill-success {{ request('riesgo') === 'bajo' ? 'active' : '' }}">
                <span class="dot-indicator dot-success"></span> Estables (Bajo)
            </a>
        </div>

        <div class="table-count-label">
            Mostrando <strong>{{ isset($pacientes) ? $pacientes->count() : 0 }}</strong> pacientes
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>DIAGNÓSTICO PRINCIPAL</th>
                    <th>ÚLTIMO REGISTRO</th>
                    <th>NIVEL DE RIESGO</th>
                    <th style="text-align: right;">ACCIÓN CLÍNICA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pacientes ?? [] as $paciente)
                    <tr class="table-row-hover">
                        <!-- PACIENTE -->
                        <td>
                            <div class="patient-cell-flex">
                                <div class="avatar-patient {{ $paciente->nivel_riesgo == 'Alto' ? 'border-danger' : ($paciente->nivel_riesgo == 'Medio' ? 'border-warning' : 'border-success') }}">
                                    {{ strtoupper(substr($paciente->usuario->primer_nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($paciente->usuario->apellido_paterno ?? '', 0, 1)) }}
                                </div>
                                <div class="patient-meta">
                                    <span class="patient-name-title">
                                        {{ $paciente->usuario->primer_nombre ?? '' }} {{ $paciente->usuario->segundo_nombre ?? '' }} {{ $paciente->usuario->apellido_paterno ?? '' }} {{ $paciente->usuario->apellido_materno ?? '' }}
                                    </span>
                                    <span class="patient-details-sub">
                                        <i class="fa-regular fa-calendar" style="font-size: 11px;"></i>
                                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años • {{ ucfirst($paciente->sexo) }}
                                        <span class="bullet-sep">•</span>
                                        <span class="email-muted">{{ $paciente->usuario->email ?? '' }}</span>
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- DIAGNÓSTICO -->
                        <td>
                            <span class="diagnosis-badge">
                                <i class="fa-solid fa-notes-medical"></i> {{ $paciente->diagnostico_principal ?? 'N/D' }}
                            </span>
                        </td>

                        <!-- ÚLTIMO REGISTRO -->
                        <td>
                            <div class="last-visit-cell">
                                @if($paciente->ultimaMetrica)
                                    <span class="date-main">{{ \Carbon\Carbon::parse($paciente->ultimaMetrica->fecha_registro)->format('d M, Y') }}</span>
                                    <span class="date-sub">{{ \Carbon\Carbon::parse($paciente->ultimaMetrica->fecha_registro)->diffForHumans() }}</span>
                                @else
                                    <span class="text-muted-italics">Sin mediciones</span>
                                @endif
                            </div>
                        </td>

                        <!-- NIVEL DE RIESGO -->
                        <td>
                            @if(($paciente->nivel_riesgo ?? '') == 'Alto')
                                <span class="badge-risk badge-risk-high">
                                    <span class="dot-pulse"></span> Riesgo Alto
                                </span>
                            @elseif(($paciente->nivel_riesgo ?? '') == 'Medio')
                                <span class="badge-risk badge-risk-medium">
                                    <span class="dot-amber"></span> Riesgo Medio
                                </span>
                            @else
                                <span class="badge-risk badge-risk-low">
                                    <span class="dot-green"></span> Riesgo Bajo
                                </span>
                            @endif
                        </td>

                        <!-- ACCIÓN -->
                        <td style="text-align: right;">
                            <a href="{{ route('medico.pacientes.show', $paciente->id) }}" class="btn-monitor-patient">
                                <i class="fa-solid fa-chart-line"></i> Monitorear
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state-card">
                                <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                                <h3>No tienes pacientes asignados en esta categoría</h3>
                                <p>Prueba ajustando los filtros de búsqueda o riesgo.</p>
                                @if(request()->anyFilled(['buscar', 'riesgo']))
                                    <a href="{{ route('medico.pacientes.index') }}" class="btn-secondary" style="margin-top: 12px;">
                                        <i class="fa-solid fa-rotate-left"></i> Restablecer Filtros
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    @if(isset($pacientes) && method_exists($pacientes, 'links'))
        <div class="pagination-container">
            {{ $pacientes->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>