<!-- MODAL VER EXPEDIENTE CLÍNICO -->
<div id="viewModalOverlay" class="modal-overlay hidden">
    <div class="modal-card" style="max-width: 580px;">
        <div class="modal-header">
            <div>
                <h3 class="modal-title"><i class="fa-regular fa-id-card" style="color: var(--primary); margin-right: 8px;"></i> Expediente del Paciente</h3>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">Resumen clínico institucional y datos de contacto.</p>
            </div>
            <button type="button" id="closeViewModalIcon" class="close-modal-btn" aria-label="Cerrar modal">&times;</button>
        </div>

        <div class="modal-form-body">
            <!-- Header del perfil del paciente -->
            <div class="view-profile-hero">
                <div class="view-avatar" id="view_avatar">P</div>
                <div class="view-meta-main">
                    <h2 class="view-patient-name" id="view_nombre_completo">Cargando...</h2>
                    <div class="view-pill-strip">
                        <span class="badge-risk" id="view_badge_riesgo">Riesgo</span>
                        <span class="badge-status-active" id="view_badge_estado">Activo</span>
                    </div>
                </div>
            </div>

            <!-- Grilla de Información -->
            <div class="view-info-grid">
                <div class="info-card-item">
                    <span class="info-item-label"><i class="fa-solid fa-cake-candles"></i> Edad & Sexo</span>
                    <span class="info-item-val" id="view_edad_sexo">-</span>
                </div>

                <div class="info-card-item">
                    <span class="info-item-label"><i class="fa-solid fa-ruler-vertical"></i> Estatura</span>
                    <span class="info-item-val" id="view_estatura">-</span>
                </div>

                <div class="info-card-item">
                    <span class="info-item-label"><i class="fa-regular fa-envelope"></i> Correo Electrónico</span>
                    <span class="info-item-val" id="view_email">-</span>
                </div>

                <div class="info-card-item">
                    <span class="info-item-label"><i class="fa-solid fa-phone-volume"></i> Teléfono Emergencia</span>
                    <span class="info-item-val" id="view_telefono">-</span>
                </div>

                <div class="info-card-item" style="grid-column: span 2;">
                    <span class="info-item-label"><i class="fa-solid fa-user-doctor"></i> Médico Principal</span>
                    <span class="info-item-val" id="view_medico">-</span>
                </div>

                <div class="info-card-item" style="grid-column: span 2;">
                    <span class="info-item-label"><i class="fa-solid fa-user-group"></i> Equipo Médico</span>
                    <span class="info-item-val" id="view_medicos">-</span>
                </div>

                <div class="info-card-item" style="grid-column: span 2; background: #eff6ff; border-color: #bfdbfe;">
                    <span class="info-item-label" style="color: #1e40af;"><i class="fa-solid fa-notes-medical"></i> Diagnóstico Principal</span>
                    <span class="info-item-val" id="view_diagnostico" style="color: #1e3a8a; font-weight: 600;">-</span>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" id="closeViewBtn" class="btn-secondary">Cerrar</button>
            <button type="button" id="btnEditFromView" class="btn-primary">
                <i class="fa-solid fa-pen"></i> Editar Paciente
            </button>
        </div>
    </div>
</div>
