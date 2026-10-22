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
                    <span>Expediente Médico</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="edit_medico_id">Médico Asignado <span class="required-star">*</span></label>
                        <select id="edit_medico_id" name="medico_id" class="modal-select" required>
                            @foreach($medicos ?? [] as $doc)
                                <option value="{{ $doc->id }}">
                                    Dr(a). {{ $doc->nombre_completo }} — Especialidad: {{ $doc->especialidad }} (Turno: {{ $doc->turno }})
                                </option>
                            @endforeach
                        </select>
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
                        <input type="text" id="edit_diagnostico_principal" name="diagnostico_principal" class="modal-input" required>
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