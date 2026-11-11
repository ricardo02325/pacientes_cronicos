<!-- MODAL EDITAR PACIENTE -->
<div id="editModalOverlay" class="modal-overlay hidden">
    <div class="modal-card">
        <!-- HEADER -->
        <div class="modal-header">
            <div>
                <h3 class="modal-title"><i class="fa-solid fa-user-pen" style="color: var(--primary); margin-right: 8px;"></i> Editar Expediente de Paciente</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">Actualiza los datos personales, clínicos o el médico asignado.</p>
            </div>
            <button type="button" id="closeEditModalIcon" class="close-modal-btn" aria-label="Cerrar modal">&times;</button>
        </div>

        <!-- FORMULARIO EDITAR -->
        <form id="editPatientForm" method="POST" action="">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_paciente_id" name="paciente_id">

            <div class="modal-form-body">
                <!-- Sección 1: Datos Personales -->
                <div class="form-section-header">
                    <span class="section-tag">1</span>
                    <span>Datos Personales</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_primer_nombre">Primer Nombre <span class="required-star">*</span></label>
                        <input type="text" id="edit_primer_nombre" name="primer_nombre" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_segundo_nombre">Segundo Nombre</label>
                        <input type="text" id="edit_segundo_nombre" name="segundo_nombre" class="modal-input">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_apellido_paterno">Apellido Paterno <span class="required-star">*</span></label>
                        <input type="text" id="edit_apellido_paterno" name="apellido_paterno" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_apellido_materno">Apellido Materno <span class="required-star">*</span></label>
                        <input type="text" id="edit_apellido_materno" name="apellido_materno" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_fecha_nacimiento">Fecha de Nacimiento <span class="required-star">*</span></label>
                        <input type="date" id="edit_fecha_nacimiento" name="fecha_nacimiento" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_sexo">Sexo <span class="required-star">*</span></label>
                        <select id="edit_sexo" name="sexo" class="modal-select" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <!-- Sección 2: Cuenta y Estado -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">2</span>
                    <span>Contacto y Estado de Cuenta</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_email">Correo Electrónico <span class="required-star">*</span></label>
                        <input type="email" id="edit_email" name="email" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_telefono_emergencia">Teléfono de Emergencia <span class="required-star">*</span></label>
                        <input type="tel" id="edit_telefono_emergencia" name="telefono_emergencia" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_estado">Estado en el Sistema <span class="required-star">*</span></label>
                        <select id="edit_estado" name="estado" class="modal-select" required>
                            <option value="Activo">Activo (Acceso habilitado)</option>
                            <option value="Inactivo">Inactivo (Acceso suspendido)</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_password">Nueva Contraseña (Opcional)</label>
                        <input type="password" id="edit_password" name="password" class="modal-input" placeholder="Solo si deseas cambiarla">
                    </div>
                </div>

                <!-- Sección 3: Datos Clínicos -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">3</span>
                    <span>Expediente Clínico y Equipo Médico</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom doctor-assignment" style="grid-column: span 2;">
                        <div class="doctor-assignment-heading">
                            <span class="modal-label">Médicos asignados <span class="required-star">*</span></span>
                            <span class="doctor-selection-count" id="editDoctorSelectionCount">0 seleccionados</span>
                        </div>
                        <span class="field-hint">Selecciona uno o varios médicos y marca cuál será el principal.</span>
                        <div class="doctor-assignment-tools">
                            <input type="search" id="editDoctorSearch" class="modal-input doctor-search" placeholder="Buscar por nombre o especialidad" autocomplete="off">
                            <div class="doctor-assignment-actions">
                                <button type="button" class="doctor-assignment-action" id="editSelectVisibleDoctors">Seleccionar visibles</button>
                                <button type="button" class="doctor-assignment-action" id="editClearDoctors">Limpiar</button>
                            </div>
                        </div>
                        <div class="doctor-assignment-list" id="editDoctorAssignmentList">
                            @forelse($medicos ?? [] as $doc)
                                <div class="doctor-option">
                                    <label class="doctor-option-select" for="edit_doctor_{{ $doc->id }}">
                                        <input type="checkbox" class="doctor-assignment-checkbox" id="edit_doctor_{{ $doc->id }}" name="medico_ids[]" value="{{ $doc->id }}">
                                        <span class="doctor-option-details">
                                            <strong>Dr(a). {{ $doc->nombre_completo }}</strong>
                                            <small>{{ $doc->especialidad }} · {{ $doc->turno }} · {{ $doc->estado }}</small>
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
                        <label class="modal-label" for="edit_estatura">Estatura (metros)</label>
                        <input type="number" step="0.01" min="0.5" max="2.5" id="edit_estatura" name="estatura" class="modal-input">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_nivel_riesgo">Nivel de Riesgo <span class="required-star">*</span></label>
                        <select id="edit_nivel_riesgo" name="nivel_riesgo" class="modal-select" required>
                            <option value="Bajo">Bajo (Estable)</option>
                            <option value="Medio">Medio (Vigilancia periódica)</option>
                            <option value="Alto">Alto (Atención prioritaria)</option>
                        </select>
                    </div>

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="edit_diagnostico_principal">Diagnóstico Principal <span class="required-star">*</span></label>
                        <select id="edit_diagnostico_principal" name="diagnostico_principal" class="modal-select" required>
                            <option value="" disabled selected hidden>Selecciona una condición...</option>
                            <option value="Hipertensión">Hipertensión</option>
                            <option value="Diabetes tipo 2">Diabetes tipo 2</option>
                            <option value="Obesidad">Obesidad</option>
                        </select>
                        <span class="field-hint">Elige la condición crónica principal del paciente.</span>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" id="cancelEditModalBtn" class="btn-secondary">Cancelar</button>
                <button type="submit" id="savePatientBtn" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>