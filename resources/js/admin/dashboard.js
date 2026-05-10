document.addEventListener("DOMContentLoaded", () => {

    // ======================
    // MODAL EDITAR
    // ======================

    const editModalOverlay = document.getElementById("editModalOverlay");
    const closeEditModalIcon = document.getElementById("closeEditModalIcon");
    const cancelEditModalBtn = document.getElementById("cancelEditModalBtn");
    const savePatientBtn = document.getElementById("savePatientBtn");

    // ======================
    // ABRIR MODAL
    // ======================

    const editButtons = document.querySelectorAll(".edit-btn");

    editButtons.forEach((button) => {

        button.addEventListener("click", (e) => {

            e.stopPropagation();

            editModalOverlay.classList.remove("hidden");

            document.querySelectorAll(".actions-menu").forEach(menu => {
                menu.classList.add("hidden");
            });

        });

    });

    // ======================
    // CERRAR CON X
    // ======================

    closeEditModalIcon.addEventListener("click", () => {

        editModalOverlay.classList.add("hidden");

    });

    // ======================
    // CERRAR CON CANCELAR
    // ======================

    cancelEditModalBtn.addEventListener("click", () => {

        editModalOverlay.classList.add("hidden");

    });

    // ======================
    // CERRAR CON GUARDAR
    // ======================

    savePatientBtn.addEventListener("click", () => {

        editModalOverlay.classList.add("hidden");

    });

    // ======================
    // CERRAR AFUERA
    // ======================

    editModalOverlay.addEventListener("click", (e) => {

        if (e.target === editModalOverlay) {

            editModalOverlay.classList.add("hidden");

        }

    });

});