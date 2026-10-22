<!-- MODAL EDITAR MÉDICO -->
<div class="modal-overlay hidden" id="editDoctorModal">
    <div class="modal-card">
        <!-- HEADER -->
        <div class="modal-header">
            <div>
                <h3 class="modal-title"><i class="fa-solid fa-user-pen" style="color: var(--primary); margin-right: 8px;"></i> Editar Perfil Médico</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">Modifica los datos profesionales, consultorio, turno o estado de cuenta.</p>
            </div>
            <button type="button" class="btn-close" id="btnCloseEditDoctorModal" aria-label="Cerrar modal">&times;</button>
        </div>

        <!-- FORMULARIO EDITAR -->
        <form id="editDoctorForm" action="" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_medico_id" name="medico_id">

            <div class="modal-form-body">
                <!-- Sección 1: Datos Personales -->
                <div class="form-section-header">
                    <span class="section-tag">1</span>
                    <span>Datos Personales</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_primer_nombre">Primer Nombre <span class="required-star">*</span></label>
                        <input type="text" id="edit_doc_primer_nombre" name="primer_nombre" class="modal-input" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_segundo_nombre">Segundo Nombre</label>
                        <input type="text" id="edit_doc_segundo_nombre" name="segundo_nombre" class="modal-input" maxlength="50">
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_apellido_paterno">Apellido Paterno <span class="required-star">*</span></label>
                        <input type="text" id="edit_doc_apellido_paterno" name="apellido_paterno" class="modal-input" maxlength="50" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_apellido_materno">Apellido Materno <span class="required-star">*</span></label>
                        <input type="text" id="edit_doc_apellido_materno" name="apellido_materno" class="modal-input" maxlength="50" required>
                    </div>
                </div>

                <!-- Sección 2: Cuenta y Contacto -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">2</span>
                    <span>Cuenta y Estado</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_email">Correo Electrónico <span class="required-star">*</span></label>
                        <input type="email" id="edit_doc_email" name="email" class="modal-input" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_telefono">Teléfono <span class="required-star">*</span></label>
                        <input type="tel" id="edit_doc_telefono" name="telefono" class="modal-input" maxlength="15" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_estado">Estado en el Sistema <span class="required-star">*</span></label>
                        <select id="edit_doc_estado" name="estado" class="modal-select" required>
                            <option value="Activo">Activo (En servicio)</option>
                            <option value="Inactivo">Inactivo (Suspendido / Baja temporal)</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_password">Nueva Contraseña (Opcional)</label>
                        <input type="password" id="edit_doc_password" name="password" class="modal-input" placeholder="Solo si deseas cambiarla">
                    </div>
                </div>

                <!-- Sección 3: Datos Laborales -->
                <div class="form-section-header" style="margin-top: 20px;">
                    <span class="section-tag">3</span>
                    <span>Información Profesional</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_cedula">Cédula Profesional <span class="required-star">*</span></label>
                        <input type="text" id="edit_doc_cedula" name="cedula_profesional" class="modal-input" maxlength="30" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_especialidad">Especialidad Médica <span class="required-star">*</span></label>
                        <input type="text" id="edit_doc_especialidad" name="especialidad" class="modal-input" maxlength="100" required>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_turno">Turno Laboral <span class="required-star">*</span></label>
                        <select id="edit_doc_turno" name="turno" class="modal-select" required>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                            <option value="Nocturno">Nocturno</option>
                            <option value="Mixto">Mixto</option>
                        </select>
                    </div>

                    <div class="form-group-custom">
                        <label class="modal-label" for="edit_doc_consultorio">Consultorio Asignado</label>
                        <input type="text" id="edit_doc_consultorio" name="consultorio" class="modal-input" maxlength="50">
                    </div>

                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label class="modal-label" for="edit_doc_observaciones">Observaciones / Perfil</label>
                        <textarea id="edit_doc_observaciones" name="observaciones" class="modal-input" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelEditDoctor">Cancelar</button>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
