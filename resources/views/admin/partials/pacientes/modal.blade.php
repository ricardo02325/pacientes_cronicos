<!-- MODAL CREAR NUEVO PACIENTE -->
<div id="modalOverlay" class="modal-overlay hidden">
    <div class="modal-card">
        <!-- HEADER -->
        <div class="modal-header">
            <div>
                <h3 class="modal-title"><i class="fa-solid fa-user-plus" style="color: var(--primary); margin-right: 8px;"></i> Registrar Nuevo Paciente</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">Ingresa la información personal y médica para dar de alta en el sistema.</p>
            </div>
            <button type="button" id="closeModalIcon" class="close-modal-btn" aria-label="Cerrar modal">&times;</button>
        </div>

        <!-- FORMULARIO -->
        <form id="patientForm" method="POST" action="{{ route('pacientes.store') }}">
            @csrf

            <div class="modal-form-body">
                <!-- Sección 1: Datos Personales -->
                <div class="form-section-header">
                    <span class="section-tag">1</span>
                    <span>Información Personal del Paciente</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="primer_nombre">Primer Nombre <span class="required-star">*</span></label>
                        <input type="text" id="primer_nombre" name="primer_nombre" class="modal-input" placeholder="Ej. Juan" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="segundo_nombre">Segundo Nombre</label>
                        <input type="text" id="segundo_nombre" name="segundo_nombre" class="modal-input" placeholder="Ej. Carlos (opcional)" maxlength="50">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="apellido_paterno">Apellido Paterno <span class="required-star">*</span></label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" class="modal-input" placeholder="Ej. Gómez" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="apellido_materno">Apellido Materno <span class="required-star">*</span></label>
                        <input type="text" id="apellido_materno" name="apellido_materno" class="modal-input" placeholder="Ej. López" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="fecha_nacimiento">Fecha de Nacimiento <span class="required-star">*</span></label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="sexo">Sexo <span class="required-star">*</span></label>
                        <select id="sexo" name="sexo" class="modal-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <!-- Sección 2: Cuenta y Contacto -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">2</span>
                    <span>Contacto y Acceso</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="email">Correo Electrónico <span class="required-star">*</span></label>
                        <input type="email" id="email" name="email" class="modal-input" placeholder="paciente@correo.com" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="telefono_emergencia">Teléfono de Emergencia <span class="required-star">*</span></label>
                        <input type="tel" id="telefono_emergencia" name="telefono_emergencia" class="modal-input" placeholder="10 dígitos" maxlength="20" required>
                    </div>

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="password">Contraseña de Acceso (Opcional)</label>
                        <input type="text" id="password" name="password" class="modal-input" placeholder="Dejar vacío para generar clave automática segura">
                        <span class="field-hint">Si no especificas una contraseña, el sistema generará una y te la mostrará.</span>
                    </div>
                </div>

                <!-- Sección 3: Datos Clínicos y Asignación Médica -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">3</span>
                    <span>Expediente Clínico y Equipo Médico</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="diagnostico_principal">Diagnóstico Principal / Condición Crónica <span class="required-star">*</span></label>
                        <select id="diagnostico_principal" name="diagnostico_principal" class="modal-select" required>
                            <option value="" disabled selected hidden>Selecciona una condición...</option>
                            <option value="Hipertensión" data-diagnostico>Hipertensión</option>
                            <option value="Diabetes tipo 2" data-diagnostico>Diabetes tipo 2</option>
                            <option value="Obesidad" data-diagnostico>Obesidad</option>
                        </select>
                        <span class="field-hint" id="createDiagnosisHint">Elige el diagnóstico para filtrar los médicos compatibles.</span>
                    </div>

                    <div class="form-group-custom doctor-assignment" style="grid-column: span 2;">
                        <div class="doctor-assignment-heading">
                            <span class="modal-label">Médicos asignados <span class="required-star">*</span></span>
                            <span class="doctor-selection-count" id="createDoctorSelectionCount">0 seleccionados</span>
                        </div>
                        <span class="field-hint">Elige un diagnóstico para ver los médicos compatibles; se sugieren primero los de menor carga.</span>
                        <div class="doctor-assignment-tools">
                            <input type="search" id="createDoctorSearch" class="modal-input doctor-search" placeholder="Buscar por nombre o especialidad" autocomplete="off">
                            <div class="doctor-assignment-actions">
                                <button type="button" class="doctor-assignment-action" id="createSelectVisibleDoctors">Seleccionar visibles</button>
                                <button type="button" class="doctor-assignment-action" id="createClearDoctors">Limpiar</button>
                            </div>
                        </div>
                        <div class="doctor-assignment-list" id="createDoctorAssignmentList">
                            <p class="doctor-assignment-empty" id="createDoctorFilterEmpty">Selecciona un diagnóstico para ver médicos compatibles.</p>
                            @forelse($medicos ?? [] as $doc)
                                <div class="doctor-option" data-diagnosticos="{{ json_encode($doc->diagnosticos_disponibles) }}" data-pacientes="{{ $doc->pacientes_count }}" hidden>
                                    <label class="doctor-option-select" for="create_doctor_{{ $doc->id }}">
                                        <input type="checkbox" class="doctor-assignment-checkbox" id="create_doctor_{{ $doc->id }}" name="medico_ids[]" value="{{ $doc->id }}">
                                        <span class="doctor-option-details">
                                            <span class="doctor-option-name">
                                                <strong>Dr(a). {{ $doc->nombre_completo }}</strong>
                                                <span class="doctor-load-badge" hidden>Menor carga</span>
                                            </span>
                                            <small>{{ $doc->especialidad }} · {{ $doc->turno }} · {{ $doc->estado }}</small>
                                            <span class="doctor-load-indicator">
                                                <span>{{ $doc->pacientes_count }} {{ $doc->pacientes_count === 1 ? 'paciente' : 'pacientes' }} asignados</span>
                                                <span class="doctor-load-track" aria-hidden="true">
                                                    <span style="width: {{ $maxPacientesAsignados > 0 ? round(($doc->pacientes_count / $maxPacientesAsignados) * 100) : 0 }}%"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <label class="doctor-principal-choice">
                                        <input type="radio" name="medico_principal_id" value="{{ $doc->id }}" required>
                                        <span>Principal</span>
                                    </label>
                                </div>
                            @empty
                                <p class="doctor-assignment-empty">No hay médicos registrados para asignar.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="estatura">Estatura (metros)</label>
                        <input type="number" step="0.01" min="0.5" max="2.5" id="estatura" name="estatura" class="modal-input" placeholder="Ej. 1.72" value="1.70">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="nivel_riesgo">Nivel de Riesgo Inicial <span class="required-star">*</span></label>
                        <select id="nivel_riesgo" name="nivel_riesgo" class="modal-select" required>
                            <option value="Bajo">Bajo (Estable)</option>
                            <option value="Medio">Medio (Vigilancia periódica)</option>
                            <option value="Alto">Alto (Atención prioritaria)</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" id="cancelModalBtn" class="btn-secondary">Cancelar</button>
                <button type="submit" id="createPatientBtn" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Registrar Paciente
                </button>
            </div>
        </form>
    </div>
</div>
