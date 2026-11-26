document.addEventListener("DOMContentLoaded", () => {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    // ==========================================
    // MODAL CREAR MÉDICO
    // ==========================================
    const btnOpenModal = document.getElementById("btnOpenModal");
    const doctorModal = document.getElementById("doctorModal");
    const btnCloseModal = document.getElementById("btnCloseModal");
    const btnCancelModal = document.getElementById("btnCancelModal");

    const closeCreateModal = () => {
        if (doctorModal) doctorModal.classList.add("hidden");
    };

    if (btnOpenModal && doctorModal) {
        btnOpenModal.addEventListener("click", () => {
            doctorModal.classList.remove("hidden");
        });
    }

    if (btnCloseModal) btnCloseModal.addEventListener("click", closeCreateModal);
    if (btnCancelModal) btnCancelModal.addEventListener("click", closeCreateModal);
    if (doctorModal) {
        doctorModal.addEventListener("click", (e) => {
            if (e.target === doctorModal) closeCreateModal();
        });
    }

    // ==========================================
    // MODAL EDITAR MÉDICO
    // ==========================================
    const editDoctorModal = document.getElementById("editDoctorModal");
    const btnCloseEditDoctorModal = document.getElementById("btnCloseEditDoctorModal");
    const btnCancelEditDoctor = document.getElementById("btnCancelEditDoctor");
    const editDoctorForm = document.getElementById("editDoctorForm");

    const closeEditDoctorModal = () => {
        if (editDoctorModal) editDoctorModal.classList.add("hidden");
    };

    if (btnCloseEditDoctorModal) btnCloseEditDoctorModal.addEventListener("click", closeEditDoctorModal);
    if (btnCancelEditDoctor) btnCancelEditDoctor.addEventListener("click", closeEditDoctorModal);
    if (editDoctorModal) {
        editDoctorModal.addEventListener("click", (e) => {
            if (e.target === editDoctorModal) closeEditDoctorModal();
        });
    }

    const openEditDoctor = async (doctorId) => {
        try {
            const response = await fetch(`/medicos/${doctorId}`);
            const data = await response.json();

            if (!data.success || !data.medico) {
                alert("No se pudo cargar la información del médico.");
                return;
            }

            const doc = data.medico;

            if (editDoctorForm) {
                editDoctorForm.action = `/medicos/${doc.id}`;
            }

            document.getElementById("edit_medico_id").value = doc.id;
            document.getElementById("edit_doc_primer_nombre").value = doc.primer_nombre || "";
            document.getElementById("edit_doc_segundo_nombre").value = doc.segundo_nombre || "";
            document.getElementById("edit_doc_apellido_paterno").value = doc.apellido_paterno || "";
            document.getElementById("edit_doc_apellido_materno").value = doc.apellido_materno || "";
            document.getElementById("edit_doc_email").value = doc.email || "";
            document.getElementById("edit_doc_telefono").value = doc.telefono || "";
            document.getElementById("edit_doc_estado").value = doc.estado || "Activo";
            document.getElementById("edit_doc_cedula").value = doc.cedula_profesional || "";
            document.getElementById("edit_doc_especialidad").value = doc.especialidad || "";
            document.getElementById("edit_doc_turno").value = doc.turno || "Matutino";
            document.getElementById("edit_doc_consultorio").value = doc.consultorio || "";
            document.getElementById("edit_doc_observaciones").value = doc.observaciones || "";
            document.getElementById("edit_doc_password").value = "";

            if (editDoctorModal) {
                editDoctorModal.classList.remove("hidden");
            }
        } catch (error) {
            console.error(error);
            alert("Error al cargar los datos del médico.");
        }
    };

    // ==========================================
    // MODAL ELIMINAR / INACTIVAR MÉDICO
    // ==========================================
    const deleteDoctorModal = document.getElementById("deleteDoctorModal");
    const closeDeleteDoctorModal = document.getElementById("closeDeleteDoctorModal");
    const btnCancelDeleteDoctor = document.getElementById("btnCancelDeleteDoctor");
    const deleteDoctorForm = document.getElementById("deleteDoctorForm");
    const deleteDoctorModalMessage = document.getElementById("deleteDoctorModalMessage");

    const closeDeleteModal = () => {
        if (deleteDoctorModal) deleteDoctorModal.classList.add("hidden");
    };

    if (closeDeleteDoctorModal) closeDeleteDoctorModal.addEventListener("click", closeDeleteModal);
    if (btnCancelDeleteDoctor) btnCancelDeleteDoctor.addEventListener("click", closeDeleteModal);
    if (deleteDoctorModal) {
        deleteDoctorModal.addEventListener("click", (e) => {
            if (e.target === deleteDoctorModal) closeDeleteModal();
        });
    }

    const openDeleteDoctorModal = (doctorId, doctorName) => {
        if (deleteDoctorForm) {
            deleteDoctorForm.action = `/medicos/${doctorId}`;
        }
        if (deleteDoctorModalMessage) {
            deleteDoctorModalMessage.innerHTML = `Estás a punto de modificar el estado del <strong>Dr(a). ${doctorName}</strong>.`;
        }
        if (deleteDoctorModal) {
            deleteDoctorModal.classList.remove("hidden");
        }
    };

    // ==========================================
    // DELEGACIÓN DE EVENTOS EN LAS TARJETAS
    // ==========================================
    document.addEventListener("click", (e) => {
        // 1. Botón Editar
        const editBtn = e.target.closest(".edit-doctor-btn");
        if (editBtn) {
            e.stopPropagation();
            const id = editBtn.dataset.id;
            if (id) openEditDoctor(id);
            closeAllActionMenus();
            return;
        }

        // 2. Botón Eliminar
        const deleteBtn = e.target.closest(".delete-doctor-btn");
        if (deleteBtn) {
            e.stopPropagation();
            const id = deleteBtn.dataset.id;
            const name = deleteBtn.dataset.name || "este médico";
            if (id) openDeleteDoctorModal(id, name);
            closeAllActionMenus();
            return;
        }

        // 3. Alternar Estado Rápido
        const toggleBtn = e.target.closest(".toggle-doctor-status-btn");
        if (toggleBtn) {
            e.stopPropagation();
            const userId = toggleBtn.dataset.id;
            const currentStatus = toggleBtn.dataset.current;
            const newStatus = currentStatus === "Activo" ? "Inactivo" : "Activo";

            if (confirm(`¿Deseas cambiar el estado de este médico a "${newStatus}"?`)) {
                fetch(`/usuarios/${userId}/estado`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ estado: newStatus }),
                })
                    .then((r) => r.json())
                    .then((data) => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Error al cambiar estado");
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                        alert("Ocurrió un error");
                    });
            }
            closeAllActionMenus();
            return;
        }

        // 4. Trigger Menú de Opciones
        const triggerDots = e.target.closest(".actions-btn-trigger");
        if (triggerDots) {
            e.stopPropagation();
            const menu = triggerDots.nextElementSibling;
            const isClosed = menu.classList.contains("hidden");
            closeAllActionMenus();
            if (isClosed) {
                menu.classList.remove("hidden");
            }
            return;
        }

        // 5. Clic fuera: cerrar cualquier menú
        if (!e.target.closest(".action-dropdown-menu")) {
            closeAllActionMenus();
        }
    });

    const closeAllActionMenus = () => {
        document.querySelectorAll(".action-dropdown-menu").forEach((m) => {
            m.classList.add("hidden");
        });
    };
});