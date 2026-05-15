<!-- Modal -->
<div id="modalOverlay" class="modal-overlay hidden">
    <div class="modal-card">

        <!-- HEADER -->
        <div class="modal-header">

            <h3 class="modal-title">
                Nuevo Paciente
            </h3>

            <button id="closeModalIcon" class="close-modal-btn">
                &times;
            </button>

        </div>

        <!-- FORM -->
        <form id="patientForm">

            <div class="modal-form">

                <!-- NOMBRES -->
                <div class="form-row">

                    <!-- PRIMER NOMBRE -->
                    <div class="form-group-half">

                        <label class="modal-label" for="primer_nombre">
                            Primer Nombre *
                        </label>

                        <input type="text" id="primer_nombre" name="primer_nombre" class="modal-input"
                            placeholder="Primer Nombre (obligatorio)" maxlength="50" minlength="2"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}" autocomplete="given-name" required>

                    </div>

                    <!-- SEGUNDO NOMBRE -->
                    <div class="form-group-half">

                        <label class="modal-label" for="segundo_nombre">
                            Segundo Nombre
                        </label>

                        <input type="text" id="segundo_nombre" name="segundo_nombre" class="modal-input"
                            placeholder="Segundo Nombre (opcional)" maxlength="50" minlength="2"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}" autocomplete="additional-name">

                    </div>

                </div>

                <!-- APELLIDOS -->
                <div class="form-row">

                    <!-- APELLIDO PATERNO -->
                    <div class="form-group-half">

                        <label class="modal-label" for="apellido_paterno">
                            Apellido Paterno *
                        </label>

                        <input type="text" id="apellido_paterno" name="apellido_paterno" class="modal-input"
                            placeholder="Apellido Paterno (obligatorio)" maxlength="50" minlength="2"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}" autocomplete="family-name" required>

                    </div>

                    <!-- APELLIDO MATERNO -->
                    <div class="form-group-half">

                        <label class="modal-label" for="apellido_materno">
                            Apellido Materno *
                        </label>

                        <input type="text" id="apellido_materno" name="apellido_materno" class="modal-input"
                            placeholder="Apellido Materno (obligatorio)" maxlength="50" minlength="2"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}" autocomplete="family-name" required>

                    </div>

                </div>

                <!-- FECHA Y GÉNERO -->
                <div class="form-row">

                    <!-- FECHA -->
                    <div class="form-group-half">

                        <label class="modal-label" for="fecha_nacimiento">
                            Fecha de Nacimiento *
                        </label>

                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="modal-input"
                            max="2026-05-15" required>

                    </div>

                    <!-- SEXO -->
                    <div class="form-group-half">

                        <label class="modal-label" for="sexo">
                            Género *
                        </label>

                        <select id="sexo" name="sexo" class="modal-select" required>

                            <option value="" selected disabled hidden>
                                Seleccionar
                            </option>

                            <option value="Masculino">
                                Masculino
                            </option>

                            <option value="Femenino">
                                Femenino
                            </option>

                        </select>

                    </div>

                </div>

                <!-- CONTACTO -->
                <div class="form-row">

                    <!-- TELÉFONO -->
                    <div class="form-group-half">

                        <label class="modal-label" for="telefono_emergencia">
                            Teléfono de Emergencia *
                        </label>

                        <input type="tel" id="telefono_emergencia" name="telefono_emergencia" class="modal-input"
                            placeholder="10 dígitos" maxlength="10" minlength="10" pattern="[0-9]{10}"
                            inputmode="numeric" autocomplete="tel" required>

                    </div>

                    <!-- EMAIL -->
                    <div class="form-group-half">

                        <label class="modal-label" for="email">
                            Correo Electrónico *
                        </label>

                        <input type="email" id="email" name="email" class="modal-input"
                            placeholder="Correo Electrónico" maxlength="50" autocomplete="email" required>

                    </div>

                </div>

                <!-- PASSWORD Y MÉDICO -->
                <div class="form-row">

                    <!-- PASSWORD -->
                    <div class="form-group-half">

                        <label class="modal-label" for="password">
                            Contraseña *
                        </label>

                        <input type="password" id="password" name="password" class="modal-input"
                            placeholder="Mínimo 8 caracteres" minlength="8" maxlength="255"
                            autocomplete="new-password" required>

                    </div>

                    <!-- MÉDICO -->
                    <div class="form-group-half">

                        <label class="modal-label" for="medico_id">
                            Médico Responsable *
                        </label>

                        <select id="medico_id" name="medico_id" class="modal-select" required>

                            <option value="" selected disabled hidden>
                                Seleccionar Médico
                            </option>

                            <option value="1">
                                Dr. Juan Pérez
                            </option>

                            <option value="2">
                                Dra. María López
                            </option>

                        </select>

                    </div>

                </div>

                <!-- NIVEL DE RIESGO -->
                <div class="form-row">

                    <div class="form-group-half">

                        <label class="modal-label" for="nivel_riesgo">
                            Nivel de Riesgo *
                        </label>

                        <select id="nivel_riesgo" name="nivel_riesgo" class="modal-select" required>

                            <option value="" selected disabled hidden>
                                Seleccionar
                            </option>

                            <option value="Bajo">
                                Bajo
                            </option>

                            <option value="Medio">
                                Medio
                            </option>

                            <option value="Alto">
                                Alto
                            </option>

                        </select>

                    </div>

                </div>

                <!-- DIAGNÓSTICO -->
                <div class="form-row">

                    <div class="form-group-full">

                        <label class="modal-label" for="diagnostico_principal">
                            Diagnóstico Principal *
                        </label>

                        <textarea id="diagnostico_principal" name="diagnostico_principal" class="modal-textarea"
                            placeholder="Diagnóstico Principal" rows="4" maxlength="255" minlength="5" required></textarea>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">

                <button type="button" id="cancelModalBtn" class="cancel-modal-btn">
                    Cancelar
                </button>

                <button type="submit" id="createPatientBtn" class="create-patient-modal-btn">
                    Crear Paciente
                </button>

            </div>

        </form>

    </div>
</div>
