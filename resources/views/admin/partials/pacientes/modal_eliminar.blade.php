<!-- MODAL ELIMINAR / INACTIVAR PACIENTE -->
<div id="deleteModal" class="modal-overlay hidden">
    <div class="modal-card" style="max-width: 440px;">
        <div class="modal-header" style="border-bottom: none; padding-bottom: 0;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <button type="button" id="closeModalDelete" class="close-modal-btn">&times;</button>
        </div>

        <form id="deletePatientForm" method="POST" action="">
            @csrf
            @method('DELETE')

            <input type="hidden" name="accion" id="delete_accion" value="inactivar">

            <div class="modal-form-body" style="padding-top: 14px;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">¿Qué acción deseas realizar?</h3>
                <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.5;" id="deleteModalMessage">
                    Estás a punto de modificar el estado del paciente.
                </p>

                <div class="delete-options-box" style="margin-top: 16px; display: flex; flex-direction: column; gap: 10px;">
                    <label class="action-choice-card">
                        <input type="radio" name="delete_choice" value="inactivar" checked onchange="document.getElementById('delete_accion').value='inactivar'">
                        <div>
                            <strong>Inactivar Paciente (Recomendado)</strong>
                            <p>Mantiene el historial clínico y las métricas, pero bloquea el acceso.</p>
                        </div>
                    </label>

                    <label class="action-choice-card border-danger-subtle">
                        <input type="radio" name="delete_choice" value="eliminar_definitivo" onchange="document.getElementById('delete_accion').value='eliminar_definitivo'">
                        <div>
                            <strong style="color: #b91c1c;">Eliminar Definitivamente</strong>
                            <p>Borra el paciente y su historial de métricas permanentemente.</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid var(--border-color);">
                <button type="button" id="cancelDelete" class="btn-secondary">Cancelar</button>
                <button type="submit" id="confirmDelete" class="btn-primary" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    Confirmar Acción
                </button>
            </div>
        </form>
    </div>
</div>