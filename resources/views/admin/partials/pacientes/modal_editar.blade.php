<!-- MODAL EDITAR PACIENTE -->
<div id="editModalOverlay" class="modal-overlay hidden">

    <div class="modal-card">

        <!-- HEADER -->
        <div class="modal-header">

            <h3 class="modal-title">
                Editar Paciente
            </h3>

            <button id="closeEditModalIcon" class="close-modal-btn">
                &times;
            </button>

        </div>

        <!-- FORM -->
        <div class="modal-form">

            <!-- NOMBRE -->
            <div class="form-group-full">

                <label class="modal-label" for="edit_full_name">
                    Nombre Completo
                    <span class="required-star">*</span>
                </label>

                <input
                    type="text"
                    id="edit_full_name"
                    class="modal-input"
                    placeholder="Nombre del paciente">

            </div>

            <!-- FILA -->
            <div class="form-row">

                <!-- EDAD -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_age">
                        Edad
                    </label>

                    <input
                        type="text"
                        id="edit_age"
                        class="modal-input">

                </div>

                <!-- GENERO -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_gender">
                        Género
                    </label>

                    <select id="edit_gender" class="modal-select">

                        <option value="">
                            Seleccionar
                        </option>

                        <option value="masculino">
                            Masculino
                        </option>

                        <option value="femenino">
                            Femenino
                        </option>

                    </select>

                </div>

            </div>

            <!-- FILA -->
            <div class="form-row">

                <!-- CONDICION -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_condition">
                        Condición Crónica
                    </label>

                    <select id="edit_condition" class="modal-select">

                        <option value="">
                            Seleccionar
                        </option>

                        <option value="diabetes">
                            Diabetes
                        </option>

                        <option value="hipertension">
                            Hipertensión
                        </option>

                        <option value="renal">
                            Enfermedad Renal
                        </option>

                    </select>

                </div>

                <!-- ESTADO -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_status">
                        Estado
                    </label>

                    <select id="edit_status" class="modal-select">

                        <option value="estable">
                            Estable
                        </option>

                        <option value="tratamiento">
                            En Tratamiento
                        </option>

                        <option value="critico">
                            Crítico
                        </option>

                        <option value="observacion">
                            En Observación
                        </option>

                    </select>

                </div>

            </div>

            <!-- FILA -->
            <div class="form-row">

                <!-- TELEFONO -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_phone">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        id="edit_phone"
                        class="modal-input">

                </div>

                <!-- EMAIL -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_email">
                        Correo
                    </label>

                    <input
                        type="email"
                        id="edit_email"
                        class="modal-input">

                </div>

            </div>

            <!-- FILA -->
            <div class="form-row">

                <!-- ULTIMA VISITA -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_last_visit">
                        ÚLTIMA VISITA
                    </label>

                    <input
                        type="date"
                        id="edit_last_visit"
                        class="modal-input">

                </div>

                <!-- PROXIMA CITA -->
                <div class="form-group-half">

                    <label class="modal-label" for="edit_next_appointment">
                        PRÓXIMA CITA
                    </label>

                    <input
                        type="date"
                        id="edit_next_appointment"
                        class="modal-input">

                </div>

            </div>

            <!-- NOTAS -->
            <div class="form-group-full">

                <label class="modal-label" for="edit_notes">
                    Notas
                </label>

                <textarea
                    id="edit_notes"
                    class="modal-textarea"></textarea>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">

            <button
                id="cancelEditModalBtn"
                class="cancel-modal-btn">

                Cancelar

            </button>

            <button
                id="savePatientBtn"
                class="create-patient-modal-btn">

                Guardar Cambios

            </button>

        </div>

    </div>

</div>