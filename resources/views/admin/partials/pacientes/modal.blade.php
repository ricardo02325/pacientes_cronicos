<!-- Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Nuevo Paciente</h3>
            <button id="closeModalIcon" class="close-modal-btn">&times;</button>
        </div>
        <div class="modal-form">
            <div class="form-group-full">
                <label class="modal-label" for="full_name">Nombre Completo <span class="required-star">*</span></label>
                <input type="text" id="full_name" class="modal-input" placeholder="Miguel Ángel Ortiz">
            </div>
            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="age">Edad</label>
                    <input type="text" id="age" class="modal-input" placeholder="">
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
                    <label class="modal-label" for="chronic_condition">Condición Crónica <span
                            class="required-star">*</span></label>
                    <select id="chronic_condition" class="modal-select">
                        <option value="">Seleccionar</option>
                        <option value="diabetes">Diabetes</option>
                        <option value="hipertension">Hipertensión</option>
                        <option value="renal">Enfermedad Renal</option>
                    </select>
                </div>
                <div class="form-group-half">
                    <label class="modal-label" for="status">Estado</label>
                    <select id="status" class="modal-select">
                        <option value="estable">Estable</option>
                        <option value="tratamiento">En Tratamiento</option>
                        <option value="critico">Crítico</option>
                        <option value="observacion">En Observación</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="phone">Teléfono</label>
                    <input type="text" id="phone" class="modal-input" placeholder="">
                </div>
                <div class="form-group-half">
                    <label class="modal-label" for="email">Correo</label>
                    <input type="email" id="email" class="modal-input" placeholder="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-half">
                    <label class="modal-label" for="last_visit">ÚLTIMA VISITA</label>
                    <input type="date" id="last_visit" class="modal-input modal-input-date" placeholder="dd/mm/aaaa">
                </div>
                <div class="form-group-half">
                    <label class="modal-label" for="next_appointment">PRÓXIMA CITA</label>
                    <input type="date" id="next_appointment" class="modal-input modal-input-date"
                        placeholder="dd/mm/aaaa">
                </div>
            </div>
            <div class="form-group-full">
                <label class="modal-label" for="notes">Notas</label>
                <textarea id="notes" class="modal-textarea" placeholder=""></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button id="cancelModalBtn" class="cancel-modal-btn">Cancelar</button>
            <button id="createPatientBtn" class="create-patient-modal-btn">Crear Paciente</button>
        </div>
    </div>
</div>