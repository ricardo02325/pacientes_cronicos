<div class="modal-overlay" id="doctorModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nuevo Médico</h2>
            <button class="btn-close" id="btnCloseModal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nombre Completo *</label>
                <input type="text" class="form-control" autofocus>
            </div>

            <div class="form-group">
                <label>Especialidad *</label>
                <select class="form-control">
                    <option value="">Seleccionar</option>
                    <option value="endocrinologia">Endocrinología</option>
                    <option value="cardiologia">Cardiología</option>
                    <option value="general">Medicina General</option>
                </select>
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select class="form-control">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input type="email" class="form-control">
            </div>

            <div class="form-group full-width">
                <label>Cédula Profesional</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group full-width">
                <label>Notas</label>
                <textarea class="form-control"></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-secondary" id="btnCancelModal">Cancelar</button>
            <button class="btn-primary">Crear Médico</button>
        </div>
    </div>
</div>