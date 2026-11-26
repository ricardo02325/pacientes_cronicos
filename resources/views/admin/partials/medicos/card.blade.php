@forelse($medicos as $medico)
<div class="doctor-card-modern" data-doctor-id="{{ $medico->id }}">
    <!-- Acciones en esquina superior -->
    <div class="doctor-card-top-bar">
        <span class="badge-shift-pill {{ $medico->turno == 'Matutino' ? 'shift-morning' : ($medico->turno == 'Vespertino' ? 'shift-evening' : 'shift-night') }}">
            <i class="fa-regular fa-clock"></i> {{ $medico->turno ?? 'Matutino' }}
        </span>

        <div class="action-dropdown-wrapper">
            <button type="button" class="doctor-card-menu-btn actions-btn-trigger" title="Opciones">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <div class="action-dropdown-menu hidden">
                <button type="button" class="dropdown-link edit-doctor-btn" data-id="{{ $medico->id }}">
                    <i class="fa-solid fa-user-pen"></i> Editar Médico
                </button>
                <div class="dropdown-divider"></div>
                <button type="button" class="dropdown-link toggle-doctor-status-btn" data-id="{{ $medico->usuario_id }}" data-current="{{ $medico->estado }}">
                    <i class="fa-solid fa-arrows-rotate"></i>
                    {{ $medico->estado == 'Activo' ? 'Inactivar Médico' : 'Reactivar Médico' }}
                </button>
                <button type="button" class="dropdown-link text-danger delete-doctor-btn" data-id="{{ $medico->id }}" data-name="{{ $medico->nombre_completo }}">
                    <i class="fa-regular fa-trash-can"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Perfil del Doctor -->
    <div class="doctor-header-profile">
        <div class="avatar-doctor">
            {{ strtoupper(substr($medico->usuario->primer_nombre ?? 'M', 0, 1)) }}{{ strtoupper(substr($medico->usuario->apellido_paterno ?? '', 0, 1)) }}
        </div>

        <div class="doctor-meta-block">
            <h3 class="doctor-name-title">
                Dr(a). {{ $medico->nombre_completo }}
            </h3>
            <span class="doctor-specialty-badge">
                <i class="fa-solid fa-user-doctor"></i> {{ $medico->especialidad }}
            </span>
        </div>
    </div>

    <!-- Detalles Clínicos / Laborales -->
    <div class="doctor-details-list">
        <div class="doctor-detail-line">
            <i class="fa-solid fa-id-card-clip"></i>
            <span>Cédula: <strong>{{ $medico->cedula_profesional }}</strong></span>
        </div>

        <div class="doctor-detail-line">
            <i class="fa-solid fa-door-open"></i>
            <span>Consultorio: <strong>{{ $medico->consultorio ?? 'Por asignar' }}</strong></span>
        </div>

        <div class="doctor-detail-line">
            <i class="fa-solid fa-phone"></i>
            <span>{{ $medico->telefono }}</span>
        </div>

        <div class="doctor-detail-line">
            <i class="fa-regular fa-envelope"></i>
            <span class="text-truncate">{{ $medico->email }}</span>
        </div>
    </div>

    <!-- Divider -->
    <div class="card-divider-light"></div>

    <!-- Footer de la tarjeta -->
    <div class="doctor-card-footer">
        <div class="assigned-patients-count">
            <i class="fa-solid fa-users"></i>
            <strong>{{ $medico->pacientes_count ?? $medico->pacientes->count() }}</strong> pacientes
        </div>

        @if($medico->estado == 'Activo')
            <span class="badge-status-active">
                <i class="fa-solid fa-circle-check"></i> Activo
            </span>
        @else
            <span class="badge-status-inactive">
                <i class="fa-solid fa-circle-pause"></i> Inactivo
            </span>
        @endif
    </div>
</div>
@empty
<div class="empty-state-card" style="grid-column: 1 / -1; background: #ffffff; border-radius: 16px; border: 1px solid var(--border-color);">
    <div class="empty-icon"><i class="fa-solid fa-user-doctor"></i></div>
    <h3>No se encontraron médicos</h3>
    <p>No hay médicos registrados con los criterios de búsqueda actuales.</p>
    @if(request()->anyFilled(['buscar', 'turno', 'estado']))
        <a href="{{ route('admin.medicos') }}" class="btn-secondary" style="margin-top: 12px;">
            <i class="fa-solid fa-rotate-left"></i> Restablecer Filtros
        </a>
    @endif
</div>
@endforelse