<!-- Modal -->
<div id="modalOverlay" class="modal-overlay hidden">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Nuevo Paciente</h3>
            <button id="closeModalIcon" class="close-modal-btn">&times;</button>
        </div>

        <div class="modal-form">
            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="age">Nombre *</label>
                    <input type="text" id="age" class="modal-input" placeholder="Primero Nombre (obligatorio)">
                </div>

                <div class="form-group-half">
                    <label class="modal-label" for="age">Segundo Nombre</label>
                    <input type="text" id="age" class="modal-input" placeholder="Segundo Nombre (opcional)">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="age">Apellido Paterno *</label>
                    <input type="text" id="age" class="modal-input" placeholder="Apellido Paterno(obligatorio)">
                </div>

                <div class="form-group-half">
                    <label class="modal-label" for="age">Apellido Materno *</label>
                    <input type="text" id="age" class="modal-input" placeholder="Apellido Materno (obligatorio)">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="age">Fecha de Nacimiento</label>
                    <input type="date" id="age" class="modal-input">
                </div>

                <div class="form-group-half">
                    <label class="modal-label" for="gender">Género</label>
                    <select id="gender" class="modal-select">
                        <option value="">Seleccionar</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="phone">Teléfono</label>
                    <input type="text" id="phone" class="modal-input" placeholder="Teléfono (opcional)">
                </div>

                <div class="form-group-half">
                    <label class="modal-label" for="email">Correo *</label>
                    <input type="email" id="email" class="modal-input" placeholder="Correo Electrónico (opcional)">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button id="cancelModalBtn" class="cancel-modal-btn">
                Cancelar
            </button>

            <button id="createPatientBtn" class="create-patient-modal-btn">
                Crear Paciente
            </button>
        </div>
    </div>
</div>
