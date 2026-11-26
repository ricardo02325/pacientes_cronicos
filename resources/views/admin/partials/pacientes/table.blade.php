<div class="patient-card-wrapper">
    <!-- Barra superior de filtros rápidos dentro de la tarjeta -->
    <div class="table-toolbar">
        <div class="filter-pills-group">
            <a href="{{ route('admin.pacientes', request()->except(['page', 'riesgo', 'estado'])) }}" 
               class="filter-pill {{ !request('riesgo') && !request('estado') ? 'active' : '' }}">
                Todos los Pacientes
            </a>
            <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Alto'])) }}" 
               class="filter-pill pill-danger {{ request('riesgo') == 'Alto' ? 'active' : '' }}">
                <span class="dot-indicator dot-danger"></span> Críticos (Alto)
            </a>
            <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Medio'])) }}" 
               class="filter-pill pill-warning {{ request('riesgo') == 'Medio' ? 'active' : '' }}">
                <span class="dot-indicator dot-warning"></span> Riesgo Medio
            </a>
            <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['riesgo' => 'Bajo'])) }}" 
               class="filter-pill pill-success {{ request('riesgo') == 'Bajo' ? 'active' : '' }}">
                <span class="dot-indicator dot-success"></span> Estables (Bajo)
            </a>
            <a href="{{ route('admin.pacientes', array_merge(request()->except(['page', 'riesgo', 'estado']), ['estado' => 'Inactivo'])) }}" 
               class="filter-pill pill-muted {{ request('estado') == 'Inactivo' ? 'active' : '' }}">
                Inactivos
            </a>
        </div>

        <div class="table-count-label">
            Mostrando <strong>{{ $pacientes->count() }}</strong> pacientes
        </div>
    </div>

    <!-- Tabla Principal -->
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>DIAGNÓSTICO & MÉDICO A CARGO</th>
                    <th>NIVEL DE RIESGO</th>
                    <th>ESTADO</th>
                    <th>ÚLTIMA VISITA</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pacientes as $paciente)
                    <tr class="table-row-hover" data-patient-id="{{ $paciente->id }}">
                        <!-- PACIENTE -->
                        <td>
                            <div class="patient-cell-flex">
                                <div class="avatar-patient {{ $paciente->nivel_riesgo == 'Alto' ? 'border-danger' : ($paciente->nivel_riesgo == 'Medio' ? 'border-warning' : 'border-success') }}">
                                    {{ strtoupper(substr($paciente->usuario->primer_nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($paciente->usuario->apellido_paterno ?? '', 0, 1)) }}
                                </div>
                                <div class="patient-meta">
                                    <span class="patient-name-title">
                                        {{ $paciente->usuario->nombre_completo ?? 'Sin Nombre' }}
                                    </span>
                                    <span class="patient-details-sub">
                                        <i class="fa-regular fa-calendar" style="font-size: 11px;"></i>
                                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años • {{ ucfirst($paciente->sexo) }}
                                        <span class="bullet-sep">•</span>
                                        <span class="email-muted">{{ $paciente->usuario->email }}</span>
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- DIAGNÓSTICO Y MÉDICO -->
                        <td>
                            <div class="condition-cell">
                                <span class="diagnosis-badge">
                                    <i class="fa-solid fa-stethoscope"></i> {{ $paciente->diagnostico_principal }}
                                </span>
                                <div class="assigned-doctor">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    @php
                                        $medicoPrincipal = $paciente->medicos->first(fn ($medico) => (bool) $medico->pivot->es_principal)
                                            ?? $paciente->medico;
                                        $otrosMedicos = $paciente->medicos->reject(fn ($medico) => $medico->id === $medicoPrincipal?->id);
                                    @endphp
                                    <span>Principal: Dr(a). {{ $medicoPrincipal->nombre_completo ?? 'Sin médico asignado' }}</span>
                                </div>
                                @if($otrosMedicos->isNotEmpty())
                                    <div class="assigned-doctor-more" title="{{ $otrosMedicos->pluck('nombre_completo')->implode(', ') }}">
                                        + {{ $otrosMedicos->count() }} médico{{ $otrosMedicos->count() === 1 ? '' : 's' }} en el equipo
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- NIVEL DE RIESGO -->
                        <td>
                            @if ($paciente->nivel_riesgo == 'Alto')
                                <span class="badge-risk badge-risk-high">
                                    <span class="dot-pulse"></span> Riesgo Alto
                                </span>
                            @elseif($paciente->nivel_riesgo == 'Medio')
                                <span class="badge-risk badge-risk-medium">
                                    <span class="dot-amber"></span> Riesgo Medio
                                </span>
                            @else
                                <span class="badge-risk badge-risk-low">
                                    <span class="dot-green"></span> Riesgo Bajo
                                </span>
                            @endif
                        </td>

                        <!-- ESTADO DE LA CUENTA -->
                        <td>
                            @if(($paciente->usuario->estado ?? 'Activo') == 'Activo')
                                <span class="badge-status-active">
                                    <i class="fa-solid fa-circle-check"></i> Activo
                                </span>
                            @else
                                <span class="badge-status-inactive">
                                    <i class="fa-solid fa-circle-pause"></i> Inactivo
                                </span>
                            @endif
                        </td>

                        <!-- ÚLTIMA VISITA / REGISTRO -->
                        <td>
                            <div class="last-visit-cell">
                                @if($paciente->ultimaMetrica)
                                    <span class="date-main">{{ \Carbon\Carbon::parse($paciente->ultimaMetrica->fecha_registro)->format('d M, Y') }}</span>
                                    <span class="date-sub">{{ \Carbon\Carbon::parse($paciente->ultimaMetrica->fecha_registro)->diffForHumans() }}</span>
                                @else
                                    <span class="text-muted-italics">Sin registros</span>
                                @endif
                            </div>
                        </td>

                        <!-- ACCIONES -->
                        <td style="text-align: right;">
                            <div class="row-actions-group">
                                <button type="button" class="btn-action-view" data-id="{{ $paciente->id }}" title="Ver Expediente Completo">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                                <button type="button" class="btn-action-edit edit-patient-btn" data-id="{{ $paciente->id }}" title="Editar Paciente">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <!-- Menú desplegable adicional -->
                                <div class="action-dropdown-wrapper">
                                    <button type="button" class="btn-action-dots actions-btn-trigger" title="Más opciones">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div class="action-dropdown-menu hidden">
                                        <button type="button" class="dropdown-link view-patient-dropdown" data-id="{{ $paciente->id }}">
                                            <i class="fa-regular fa-id-card"></i> Ver Expediente
                                        </button>
                                        <button type="button" class="dropdown-link edit-patient-dropdown" data-id="{{ $paciente->id }}">
                                            <i class="fa-solid fa-user-pen"></i> Editar Datos
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" class="dropdown-link toggle-status-btn" data-id="{{ $paciente->usuario_id }}" data-current="{{ $paciente->usuario->estado ?? 'Activo' }}">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                            {{ ($paciente->usuario->estado ?? 'Activo') == 'Activo' ? 'Inactivar Paciente' : 'Reactivar Paciente' }}
                                        </button>
                                        <button type="button" class="dropdown-link text-danger delete-patient-btn" data-id="{{ $paciente->id }}" data-name="{{ $paciente->usuario->nombre_completo ?? 'Paciente' }}">
                                            <i class="fa-regular fa-trash-can"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state-card">
                                <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                                <h3>No se encontraron pacientes</h3>
                                <p>No hay pacientes registrados que coincidan con los filtros o el término de búsqueda.</p>
                                @if(request()->anyFilled(['buscar', 'riesgo', 'estado']))
                                    <a href="{{ route('admin.pacientes') }}" class="btn-secondary" style="margin-top: 12px;">
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
