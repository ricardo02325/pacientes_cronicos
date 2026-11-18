<!-- MODAL REGISTRAR NUEVO MÉDICO -->
<div class="modal-overlay hidden" id="doctorModal">
    <div class="modal-card">
        <!-- HEADER -->
        <div class="modal-header">
            <div>
                <h3 class="modal-title"><i class="fa-solid fa-user-doctor" style="color: var(--primary); margin-right: 8px;"></i> Registrar Nuevo Médico</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">Crea la cuenta de acceso y perfil profesional para el médico.</p>
            </div>
            <button type="button" class="btn-close" id="btnCloseModal" aria-label="Cerrar modal">&times;</button>
        </div>

        <!-- FORMULARIO -->
        <form id="doctorForm" action="{{ route('medicos.store') }}" method="POST">
            @csrf

            <div class="modal-form-body">
                <!-- Sección 1: Datos Personales -->
                <div class="form-section-header">
                    <span class="section-tag">1</span>
                    <span>Datos Personales del Médico</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_primer_nombre">Primer Nombre <span class="required-star">*</span></label>
                        <input type="text" id="doc_primer_nombre" name="primer_nombre" class="modal-input" placeholder="Ej. Carlos" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_segundo_nombre">Segundo Nombre</label>
                        <input type="text" id="doc_segundo_nombre" name="segundo_nombre" class="modal-input" placeholder="Ej. Eduardo (opcional)" maxlength="50">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_apellido_paterno">Apellido Paterno <span class="required-star">*</span></label>
                        <input type="text" id="doc_apellido_paterno" name="apellido_paterno" class="modal-input" placeholder="Ej. Gómez" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_apellido_materno">Apellido Materno <span class="required-star">*</span></label>
                        <input type="text" id="doc_apellido_materno" name="apellido_materno" class="modal-input" placeholder="Ej. Salas" maxlength="50" required>
                    </div>
                </div>

                <!-- Sección 2: Cuenta y Contacto -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">2</span>
                    <span>Credenciales de Acceso y Contacto</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_email">Correo Electrónico <span class="required-star">*</span></label>
                        <input type="email" id="doc_email" name="email" class="modal-input" placeholder="doctor@CroniCare.com" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_password">Contraseña de Acceso <span class="required-star">*</span></label>
                        <input type="password" id="doc_password" name="password" class="modal-input" placeholder="Mínimo 6 caracteres" minlength="6" required>
                    </div>

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="doc_telefono">Teléfono de Contacto <span class="required-star">*</span></label>
                        <input type="tel" id="doc_telefono" name="telefono" class="modal-input" placeholder="Ej. 3121234567 (10 dígitos)" maxlength="15" required>
                    </div>
                </div>

                <!-- Sección 3: Datos Laborales y Profesionales -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">3</span>
                    <span>Información Profesional y Asignación</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_cedula">Cédula Profesional <span class="required-star">*</span></label>
                        <input type="text" id="doc_cedula" name="cedula_profesional" class="modal-input" placeholder="Ej. MED-1234567" maxlength="30" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_especialidad">Especialidad Médica <span class="required-star">*</span></label>
                        <select id="doc_especialidad" name="especialidad" class="modal-select" required>
                            <option value="" disabled selected>Selecciona una especialidad...</option>
                            @foreach(\App\Models\Medico::ESPECIALIDADES as $especialidad)
                                <option value="{{ $especialidad }}">{{ $especialidad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_turno">Turno Laboral <span class="required-star">*</span></label>
                        <select id="doc_turno" name="turno" class="modal-select" required>
                            <option value="Matutino">Matutino (07:00 - 15:00)</option>
                            <option value="Vespertino">Vespertino (14:00 - 21:00)</option>
                            <option value="Nocturno">Nocturno (20:00 - 08:00)</option>
                            <option value="Mixto">Mixto</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="doc_consultorio">Consultorio Asignado</label>
                        <input type="text" id="doc_consultorio" name="consultorio" class="modal-input" placeholder="Ej. Consultorio 204-B" maxlength="50">
                    </div>

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="doc_observaciones">Observaciones / Perfil</label>
                        <textarea id="doc_observaciones" name="observaciones" class="modal-input" rows="2" placeholder="Notas sobre trayectoria, enfoque médico o notas administrativas..."></textarea>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelModal">Cancelar</button>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Registrar Médico
                </button>
            </div>
        </form>
    </div>
</div>
