<!-- MODAL NUEVO MÉDICO -->
<div class="modal-overlay hidden" id="doctorModal">

    <div class="modal-content">

        <!-- HEADER -->
        <div class="modal-header">

            <h2>Nuevo Médico</h2>

            <button type="button" class="btn-close" id="btnCloseModal" aria-label="Cerrar modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <!-- FORMULARIO -->
        <form id="doctorForm" action="{{ route('medicos.store') }}" method="POST">

            @csrf

            <div class="form-grid">

                <!-- PRIMER NOMBRE -->
                <div class="form-group">

                    <label for="primer_nombre">
                        Primer Nombre *
                    </label>

                    <input type="text" id="primer_nombre" name="primer_nombre" class="form-control"
                        placeholder="Primer Nombre (obligatorio)" maxlength="50" required autofocus>
                </div>

                <!-- SEGUNDO NOMBRE -->
                <div class="form-group">

                    <label for="segundo_nombre">
                        Segundo Nombre
                    </label>

                    <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control"
                        placeholder="Segundo Nombre (opcional)" maxlength="50">
                </div>

                <!-- APELLIDO PATERNO -->
                <div class="form-group">

                    <label for="apellido_paterno">
                        Apellido Paterno *
                    </label>

                    <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control"
                        placeholder="Apellido Paterno (obligatorio)" maxlength="50" required>
                </div>

                <!-- APELLIDO MATERNO -->
                <div class="form-group">

                    <label for="apellido_materno">
                        Apellido Materno
                    </label>

                    <input type="text" id="apellido_materno" name="apellido_materno" class="form-control"
                        placeholder="Apellido Materno (Opcional)" maxlength="50">
                </div>

                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">
                        Correo Electrónico *
                    </label>

                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="Correo Electrónico (obligatorio)" maxlength="50" required>
                </div>

                <!-- TELÉFONO -->
                <div class="form-group">

                    <label for="telefono">
                        Teléfono *
                    </label>

                    <input type="tel" id="telefono" name="telefono" class="form-control"
                        placeholder="Teléfono (obligatorio)" maxlength="10" pattern="[0-9]{10}" required>
                </div>

                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">
                        Contraseña *
                    </label>

                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Contraseña (obligatorio)" minlength="8" maxlength="255" required
                        autocomplete="off">
                </div>

                <!-- CÉDULA -->
                <div class="form-group">

                    <label for="cedula_profesional">
                        Cédula Profesional *
                    </label>

                    <input type="text" id="cedula_profesional" name="cedula_profesional" class="form-control"
                        placeholder="Cédula Profesional (obligatorio)" maxlength="30" required>
                </div>

                <!-- TURNO -->
                <div class="form-group">

                    <label for="turno">
                        Turno *
                    </label>

                    <select id="turno" name="turno" class="form-control" required>
                        <option value="" selected disabled hidden>
                            Seleccionar
                        </option>

                        <option value="Matutino">
                            Mañana
                        </option>

                        <option value="Vespertino">
                            Tarde
                        </option>

                        <option value="Nocturno">
                            Noche
                        </option>

                        <option value="Mixto">
                            Mixto
                        </option>
                    </select>
                </div>

                <!-- ESPECIALIDAD -->
                <div class="form-group">

                    <label for="especialidad">
                        Especialidad *
                    </label>

                    <select id="especialidad" name="especialidad" class="form-control" required>
                        <option value="" selected disabled hidden>
                            Seleccionar
                        </option>

                        <option value="Endocrinología">
                            Endocrinología
                        </option>

                        <option value="Cardiología">
                            Cardiología
                        </option>

                        <option value="Medicina General">
                            Medicina General
                        </option>

                        <option value="Nefrología">
                            Nefrología
                        </option>
                    </select>
                </div>

                <!-- CONSULTORIO -->
                <div class="form-group full-width">

                    <label for="consultorio">
                        Consultorio
                    </label>

                    <input type="text" id="consultorio" name="consultorio" class="form-control"
                        placeholder="Consultorio (opcional)" maxlength="50">
                </div>

                <!-- OBSERVACIONES -->
                <div class="form-group full-width">

                    <label for="observaciones">
                        Observaciones
                    </label>

                    <textarea id="observaciones" name="observaciones" class="form-control"
                        placeholder="Notas u observaciones... (obligatorio)" rows="4"></textarea>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">

                <button type="button" class="btn-secondary" id="btnCancelModal">
                    Cancelar
                </button>

                <button type="submit" class="btn-primary" id="btnCreateDoctor">
                    Crear Médico
                </button>

            </div>

        </form>

    </div>

</div>
