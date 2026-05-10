document.addEventListener("DOMContentLoaded", () => {

    // ======================
    // TOKEN CSRF
    // ======================

    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    // ======================
    // MODAL CREAR
    // ======================

    const addPatientBtn = document.getElementById("addPatientBtn");

    const modalOverlay = document.getElementById("modalOverlay");
    const closeModalIcon = document.getElementById("closeModalIcon");
    const cancelModalBtn = document.getElementById("cancelModalBtn");
    const createPatientBtn = document.getElementById("createPatientBtn");

    // ======================
    // MODAL EDITAR
    // ======================

    const editModalOverlay = document.getElementById("editModalOverlay");

    const closeEditModalIcon = document.getElementById("closeEditModalIcon");

    const cancelEditModalBtn = document.getElementById("cancelEditModalBtn");

    const savePatientBtn = document.getElementById("savePatientBtn");

    // ======================
    // MODAL ELIMINAR / INACTIVAR
    // ======================

    const deleteModal = document.getElementById("deleteModal");

    const confirmDelete = document.getElementById("confirmDelete");

    const cancelDelete = document.getElementById("cancelDelete");

    const closeModalDelete = document.getElementById("closeModal");

    let usuarioId = null;

    // ======================
    // ABRIR MODAL CREAR
    // ======================

    if (addPatientBtn && modalOverlay) {

        addPatientBtn.addEventListener("click", () => {

            modalOverlay.classList.remove("hidden");

        });

    }

    // ======================
    // CERRAR MODAL CREAR
    // ======================

    if (closeModalIcon && modalOverlay) {

        closeModalIcon.addEventListener("click", () => {

            modalOverlay.classList.add("hidden");

        });

    }

    if (cancelModalBtn && modalOverlay) {

        cancelModalBtn.addEventListener("click", () => {

            modalOverlay.classList.add("hidden");

        });

    }

    if (createPatientBtn && modalOverlay) {

        createPatientBtn.addEventListener("click", () => {

            modalOverlay.classList.add("hidden");

        });

    }

    if (modalOverlay) {

        modalOverlay.addEventListener("click", (e) => {

            if (e.target === modalOverlay) {

                modalOverlay.classList.add("hidden");

            }

        });

    }

    // ======================
    // MENU ACCIONES
    // ======================

    document.addEventListener("click", (e) => {

        const actionBtn = e.target.closest(".actions-btn");

        if (actionBtn) {

            e.stopPropagation();

            const currentMenu = actionBtn.nextElementSibling;

            document.querySelectorAll(".actions-menu").forEach((menu) => {

                if (menu !== currentMenu) {

                    menu.classList.add("hidden");

                }

            });

            if (currentMenu) {

                currentMenu.classList.toggle("hidden");

            }

        }

    });

    // ======================
    // BOTON EDITAR
    // ======================

    document.addEventListener("click", (e) => {

        if (e.target.closest(".edit-btn")) {

            e.stopPropagation();

            if (editModalOverlay) {

                editModalOverlay.classList.remove("hidden");

            }

            document.querySelectorAll(".actions-menu").forEach((menu) => {

                menu.classList.add("hidden");

            });

        }

    });

    // ======================
    // CERRAR MODAL EDITAR
    // ======================

    if (closeEditModalIcon && editModalOverlay) {

        closeEditModalIcon.addEventListener("click", () => {

            editModalOverlay.classList.add("hidden");

        });

    }

    if (cancelEditModalBtn && editModalOverlay) {

        cancelEditModalBtn.addEventListener("click", () => {

            editModalOverlay.classList.add("hidden");

        });

    }

    if (savePatientBtn && editModalOverlay) {

        savePatientBtn.addEventListener("click", () => {

            editModalOverlay.classList.add("hidden");

        });

    }

    if (editModalOverlay) {

        editModalOverlay.addEventListener("click", (e) => {

            if (e.target === editModalOverlay) {

                editModalOverlay.classList.add("hidden");

            }

        });

    }

    // ======================
    // ABRIR MODAL ELIMINAR
    // ======================

    document.addEventListener("click", (e) => {

        const deleteBtn = e.target.closest(".delete-item");

        if (deleteBtn) {

            e.stopPropagation();

            usuarioId = deleteBtn.dataset.id;

            if (deleteModal) {

                deleteModal.classList.remove("hidden");

            }

            document.querySelectorAll(".actions-menu").forEach((menu) => {

                menu.classList.add("hidden");

            });

        }

    });

    // ======================
    // CERRAR MODAL ELIMINAR
    // ======================

    if (cancelDelete && deleteModal) {

        cancelDelete.addEventListener("click", () => {

            deleteModal.classList.add("hidden");

        });

    }

    if (closeModalDelete && deleteModal) {

        closeModalDelete.addEventListener("click", () => {

            deleteModal.classList.add("hidden");

        });

    }

    if (deleteModal) {

        deleteModal.addEventListener("click", (e) => {

            if (e.target === deleteModal) {

                deleteModal.classList.add("hidden");

            }

        });

    }

    // ======================
    // CONFIRMAR INACTIVAR
    // ======================

    if (confirmDelete) {

        confirmDelete.addEventListener("click", async () => {

            if (!usuarioId) return;

            try {

                const response = await fetch(`/usuarios/${usuarioId}/estado`, {

                    method: "PUT",

                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },

                    body: JSON.stringify({
                        estado: "Inactivo"
                    })

                });

                const data = await response.json();

                if (response.ok) {

                    location.reload();

                } else {

                    console.error(data);

                    alert("Error al cambiar estado");

                }

            } catch (error) {

                console.error(error);

                alert("Ocurrió un error");

            }

            deleteModal.classList.add("hidden");

        });

    }

    // ======================
    // CERRAR MENUS (CLICK FUERA)
    // ======================

    document.addEventListener("click", (e) => {

        const isActionBtn = e.target.closest(".actions-btn");

        const isMenu = e.target.closest(".actions-menu");

        if (!isActionBtn && !isMenu) {

            document.querySelectorAll(".actions-menu").forEach((menu) => {

                menu.classList.add("hidden");

            });

        }

    });

});