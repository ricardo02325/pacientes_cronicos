<div id="editModalOverlay" class="modal-overlay hidden">

    <div class="modal-card">

        <div class="modal-header">

            <h3 class="modal-title">
                Editar Paciente
            </h3>

            <button type="button" id="closeEditModalIcon" class="close-modal-btn">
                &times;
            </button>

        </div>

        <div class="modal-form">

            <div class="form-group-full">

                <label class="modal-label" for="editFullName">
                    Nombre Completo
                </label>

                <input
                    type="text"
                    id="editFullName"
                    class="modal-input"
                    placeholder="Nombre del paciente"
                >

            </div>

            <div class="form-row">

                <div class="form-group-half">

                    <label class="modal-label" for="editAge">
                        Edad
                    </label>

                    <input
                        type="text"
                        id="editAge"
                        class="modal-input"
                        placeholder="Edad"
                    >

                </div>

                <div class="form-group-half">

                    <label class="modal-label" for="editGender">
                        Género
                    </label>

                    <select id="editGender" class="modal-select">

                        <option value="">
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

            <div class="form-row">

                <div class="form-group-half">

                    <label class="modal-label" for="editCondition">
                        Condición
                    </label>

                    <input
                        type="text"
                        id="editCondition"
                        class="modal-input"
                        placeholder="Condición"
                    >

                </div>

                <div class="form-group-half">

                    <label class="modal-label" for="editStatus">
                        Estado
                    </label>

                    <select id="editStatus" class="modal-select">

                        <option value="Estable">
                            Estable
                        </option>

                        <option value="Tratamiento">
                            En Tratamiento
                        </option>

                        <option value="Critico">
                            Crítico
                        </option>

                    </select>

                </div>

            </div>

            <div class="form-group-full">

                <label class="modal-label" for="editNotes">
                    Notas
                </label>

                <textarea
                    id="editNotes"
                    class="modal-textarea"
                    placeholder="Notas del paciente"
                ></textarea>

            </div>

        </div>

        <div class="modal-footer">

            <button
                type="button"
                id="cancelEditModalBtn"
                class="cancel-modal-btn"
            >
                Cancelar
            </button>

            <button
                type="button"
                id="savePatientBtn"
                class="create-patient-modal-btn"
            >
                Guardar Cambios
            </button>

        </div>

    </div>

</div>