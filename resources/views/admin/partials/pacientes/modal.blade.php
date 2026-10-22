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
                    <span>Expediente Clínico y Médico Responsable</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="medico_id">Médico Asignado <span class="required-star">*</span></label>
                        <select id="medico_id" name="medico_id" class="modal-select" required>
                            <option value="">Selecciona el médico a cargo...</option>
                            @foreach($medicos ?? [] as $doc)
                                <option value="{{ $doc->id }}">
                                    Dr(a). {{ $doc->nombre_completo }} — Especialidad: {{ $doc->especialidad }} (Turno: {{ $doc->turno }})
                                </option>
                            @endforeach
                        </select>
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

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="diagnostico_principal">Diagnóstico Principal / Condición Crónica <span class="required-star">*</span></label>
                        <input type="text" id="diagnostico_principal" name="diagnostico_principal" class="modal-input" placeholder="Ej. Diabetes Mellitus Tipo 2, Hipertensión Arterial..." required>
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
