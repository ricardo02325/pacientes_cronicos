<div class="dash-card">
    <div class="dash-card-header">
        <div>
            <h3 class="dash-card-title"><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary); margin-right: 8px;"></i> Pacientes Recientes</h3>
            <p class="dash-card-subtitle">Últimos pacientes incorporados al programa de monitoreo continuo</p>
        </div>
        <a href="{{ route('admin.pacientes') }}" class="dash-card-link">
            Ver Todos <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>CONDICIÓN</th>
                    <th>MÉDICO A CARGO</th>
                    <th>RIESGO</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pacientesEstado as $paciente)
                    <tr class="table-row-hover">
                        <td>
                            <div class="patient-cell-flex">
                                <div class="avatar-patient {{ $paciente->nivel_riesgo == 'Alto' ? 'border-danger' : ($paciente->nivel_riesgo == 'Medio' ? 'border-warning' : 'border-success') }}">
                                    {{ strtoupper(substr($paciente->usuario->primer_nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($paciente->usuario->apellido_paterno ?? '', 0, 1)) }}
                                </div>
                                <div class="patient-meta">
                                    <span class="patient-name-title">{{ $paciente->usuario->nombre_completo ?? 'Sin Nombre' }}</span>
                                    <span class="patient-details-sub">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años • {{ ucfirst($paciente->sexo) }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="diagnosis-badge">
                                <i class="fa-solid fa-notes-medical"></i> {{ $paciente->diagnostico_principal }}
                            </span>
                        </td>

                        <td>
                            <div class="assigned-doctor">
                                <i class="fa-solid fa-user-doctor"></i>
                                <span>Dr(a). {{ $paciente->medico->nombre_completo ?? 'Sin asignar' }}</span>
                            </div>
                        </td>

                        <td>
                            @if ($paciente->nivel_riesgo == 'Alto')
                                <span class="badge-risk badge-risk-high">
                                    <span class="dot-pulse"></span> Alto
                                </span>
                            @elseif($paciente->nivel_riesgo == 'Medio')
                                <span class="badge-risk badge-risk-medium">
                                    <span class="dot-amber"></span> Medio
                                </span>
                            @else
                                <span class="badge-risk badge-risk-low">
                                    <span class="dot-green"></span> Bajo
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state-card" style="padding: 32px 16px;">
                                <p style="color: var(--text-muted); font-size: 13.5px;">No hay pacientes registrados aún.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
