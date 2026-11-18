document.addEventListener("DOMContentLoaded", () => {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    // ==========================================
    // MODAL CREAR PACIENTE
    // ==========================================
    const addPatientBtn = document.getElementById("addPatientBtn");
    const modalOverlay = document.getElementById("modalOverlay");
    const closeModalIcon = document.getElementById("closeModalIcon");
    const cancelModalBtn = document.getElementById("cancelModalBtn");

    const setupDoctorAssignment = (listId, countId, searchId, selectVisibleId, clearId, formId) => {
        const list = document.getElementById(listId);
        const count = document.getElementById(countId);
        if (!list) return null;

        const search = document.getElementById(searchId);
        const selectVisibleButton = document.getElementById(selectVisibleId);
        const clearButton = document.getElementById(clearId);
        const form = document.getElementById(formId);
        const checkboxes = () => [...list.querySelectorAll(".doctor-assignment-checkbox")];
        const radios = () => [...list.querySelectorAll('input[name="medico_principal_id"]')];

        const update = () => {
            const term = search?.value.trim().toLocaleLowerCase() || "";
            list.querySelectorAll(".doctor-option").forEach((option) => {
                option.hidden = option.dataset.diagnosisMatch !== "true"
                    || !option.textContent.toLocaleLowerCase().includes(term);
            });

            const selected = checkboxes().filter((checkbox) => checkbox.checked);
            checkboxes().forEach((checkbox) => {
                checkbox.closest(".doctor-option")?.classList.toggle("is-selected", checkbox.checked);
                checkbox.setCustomValidity("");
            });
            radios().forEach((radio) => {
                radio.disabled = !checkboxes().some((checkbox) => checkbox.value === radio.value && checkbox.checked);
            });
            if (count) {
                count.textContent = `${selected.length} ${selected.length === 1 ? "seleccionado" : "seleccionados"}`;
            }
        };

        search?.addEventListener("input", update);

        selectVisibleButton?.addEventListener("click", () => {
            checkboxes().forEach((checkbox) => {
                if (!checkbox.closest(".doctor-option")?.hidden) {
                    checkbox.checked = true;
                }
            });
            if (!radios().some((radio) => radio.checked)) {
                const firstSelected = checkboxes().find((checkbox) => checkbox.checked);
                const firstRadio = firstSelected && radios().find((radio) => radio.value === firstSelected.value);
                if (firstRadio) firstRadio.checked = true;
            }
            update();
        });

        clearButton?.addEventListener("click", () => {
            checkboxes().forEach((checkbox) => {
                checkbox.checked = false;
            });
            radios().forEach((radio) => {
                radio.checked = false;
            });
            update();
        });

        form?.addEventListener("submit", (event) => {
            if (checkboxes().some((checkbox) => checkbox.checked)) return;

            event.preventDefault();
            const firstCheckbox = checkboxes()[0];
            if (firstCheckbox) {
                firstCheckbox.setCustomValidity("Selecciona al menos un médico.");
                firstCheckbox.reportValidity();
            }
        });

        list.addEventListener("change", (event) => {
            const checkbox = event.target.closest(".doctor-assignment-checkbox");
            if (checkbox) {
                const radio = radios().find((item) => item.value === checkbox.value);
                if (checkbox.checked && radio && !radios().some((item) => item.checked)) {
                    radio.checked = true;
                } else if (!checkbox.checked && radio?.checked) {
                    radio.checked = false;
                    const nextCheckbox = checkboxes().find((item) => item.checked);
                    const nextRadio = nextCheckbox && radios().find((item) => item.value === nextCheckbox.value);
                    if (nextRadio) nextRadio.checked = true;
                }
                update();
                return;
            }

            const radio = event.target.closest('input[name="medico_principal_id"]');
            if (radio) {
                const checkboxForPrincipal = checkboxes().find((item) => item.value === radio.value);
                if (checkboxForPrincipal) checkboxForPrincipal.checked = true;
                update();
            }
        });

        return {
            reset() {
                if (search) search.value = "";
                checkboxes().forEach((checkbox) => {
                    checkbox.checked = false;
                });
                radios().forEach((radio) => {
                    radio.checked = false;
                });
                update();
            },
            setSelection(ids, principalId) {
                if (search) search.value = "";
                const selectedIds = ids.map(String);
                checkboxes().forEach((checkbox) => {
                    checkbox.checked = selectedIds.includes(checkbox.value);
                });
                radios().forEach((radio) => {
                    radio.checked = radio.value === String(principalId || "");
                });

                if (!radios().some((radio) => radio.checked)) {
                    const firstSelected = checkboxes().find((checkbox) => checkbox.checked);
                    const firstRadio = firstSelected && radios().find((radio) => radio.value === firstSelected.value);
                    if (firstRadio) firstRadio.checked = true;
                }
                update();
            },
            update,
        };
    };

    const createDoctorAssignment = setupDoctorAssignment(
        "createDoctorAssignmentList",
        "createDoctorSelectionCount",
        "createDoctorSearch",
        "createSelectVisibleDoctors",
        "createClearDoctors",
        "patientForm",
    );
    const editDoctorAssignment = setupDoctorAssignment(
        "editDoctorAssignmentList",
        "editDoctorSelectionCount",
        "editDoctorSearch",
        "editSelectVisibleDoctors",
        "editClearDoctors",
        "editPatientForm",
    );

    const setupDiagnosisFilter = (diagnosisId, hintId, doctorListId, emptyId, assignment) => {
        const diagnosis = document.getElementById(diagnosisId);
        const hint = document.getElementById(hintId);
        const doctorList = document.getElementById(doctorListId);
        if (!diagnosis || !doctorList) return;
        const emptyMessage = document.getElementById(emptyId);
        const options = [...doctorList.querySelectorAll(".doctor-option")];

        const update = () => {
            const selectedDiagnosis = diagnosis.value;
            const compatibleOptions = options.filter((option) => {
                const diagnoses = JSON.parse(option.dataset.diagnosticos || "[]");
                const compatible = Boolean(selectedDiagnosis) && diagnoses.includes(selectedDiagnosis);
                option.dataset.diagnosisMatch = compatible ? "true" : "false";
                if (!compatible) {
                    option.querySelector(".doctor-assignment-checkbox").checked = false;
                    const radio = option.querySelector('input[name="medico_principal_id"]');
                    if (radio) radio.checked = false;
                }
                return compatible;
            });

            const lowestLoad = compatibleOptions.length
                ? Math.min(...compatibleOptions.map((option) => Number(option.dataset.pacientes || 0)))
                : null;
            options.forEach((option) => {
                const badge = option.querySelector(".doctor-load-badge");
                if (badge) {
                    badge.hidden = option.dataset.diagnosisMatch !== "true"
                        || Number(option.dataset.pacientes || 0) !== lowestLoad;
                }
            });

            assignment?.update();
            const checkedPrincipal = doctorList.querySelector('input[name="medico_principal_id"]:checked');
            if (selectedDiagnosis && !checkedPrincipal && compatibleOptions.length) {
                const selectedOption = compatibleOptions.find(
                    (option) => option.querySelector(".doctor-assignment-checkbox").checked,
                ) || compatibleOptions[0];
                const checkbox = selectedOption.querySelector(".doctor-assignment-checkbox");
                const radio = selectedOption.querySelector('input[name="medico_principal_id"]');
                checkbox.checked = true;
                if (radio) radio.checked = true;
                assignment?.update();
            }

            if (hint) {
                hint.textContent = !selectedDiagnosis
                    ? "Elige el diagnóstico para filtrar los médicos compatibles."
                    : compatibleOptions.length
                        ? "Médicos filtrados por diagnóstico; los de menor carga están marcados."
                        : "No hay médicos registrados para este diagnóstico.";
            }
            if (emptyMessage) {
                emptyMessage.hidden = compatibleOptions.length > 0;
                emptyMessage.textContent = selectedDiagnosis
                    ? "No hay médicos registrados para este diagnóstico."
                    : "Selecciona un diagnóstico para ver médicos compatibles.";
            }
        };

        diagnosis.addEventListener("change", update);
        update();
        return {
            update,
            reset() {
                diagnosis.value = "";
                update();
            },
        };
    };

    const createDiagnosisFilter = setupDiagnosisFilter(
        "diagnostico_principal",
        "createDiagnosisHint",
        "createDoctorAssignmentList",
        "createDoctorFilterEmpty",
        createDoctorAssignment,
    );
    const editDiagnosisFilter = setupDiagnosisFilter(
        "edit_diagnostico_principal",
        "editDiagnosisHint",
        "editDoctorAssignmentList",
        "editDoctorFilterEmpty",
        editDoctorAssignment,
    );

    if (addPatientBtn && modalOverlay) {
        addPatientBtn.addEventListener("click", () => {
            createDoctorAssignment?.reset();
            createDiagnosisFilter?.reset();
            modalOverlay.classList.remove("hidden");
        });
    }

    const closeCreateModal = () => {
        if (modalOverlay) modalOverlay.classList.add("hidden");
    };

    if (closeModalIcon) closeModalIcon.addEventListener("click", closeCreateModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener("click", closeCreateModal);
    if (modalOverlay) {
        modalOverlay.addEventListener("click", (e) => {
            if (e.target === modalOverlay) closeCreateModal();
        });
    }

    // ==========================================
    // MODAL EDITAR PACIENTE
    // ==========================================
    const editModalOverlay = document.getElementById("editModalOverlay");
    const closeEditModalIcon = document.getElementById("closeEditModalIcon");
    const cancelEditModalBtn = document.getElementById("cancelEditModalBtn");
    const editPatientForm = document.getElementById("editPatientForm");

    const closeEditModal = () => {
        if (editModalOverlay) editModalOverlay.classList.add("hidden");
    };

    if (closeEditModalIcon) closeEditModalIcon.addEventListener("click", closeEditModal);
    if (cancelEditModalBtn) cancelEditModalBtn.addEventListener("click", closeEditModal);
    if (editModalOverlay) {
        editModalOverlay.addEventListener("click", (e) => {
            if (e.target === editModalOverlay) closeEditModal();
        });
    }

    // Cargar datos en el modal de edición
    const openEditPatientModal = async (patientId) => {
        try {
            const response = await fetch(`/pacientes/${patientId}`);
            const data = await response.json();

            if (!data.success || !data.paciente) {
                alert("No se pudo cargar la información del paciente.");
                return;
            }

            const p = data.paciente;

            // Asignar el action del formulario
            if (editPatientForm) {
                editPatientForm.action = `/pacientes/${p.id}`;
            }

            // Llenar campos
            document.getElementById("edit_paciente_id").value = p.id;
            document.getElementById("edit_primer_nombre").value = p.primer_nombre || "";
            document.getElementById("edit_segundo_nombre").value = p.segundo_nombre || "";
            document.getElementById("edit_apellido_paterno").value = p.apellido_paterno || "";
            document.getElementById("edit_apellido_materno").value = p.apellido_materno || "";
            document.getElementById("edit_email").value = p.email || "";
            document.getElementById("edit_telefono_emergencia").value = p.telefono_emergencia || "";
            document.getElementById("edit_fecha_nacimiento").value = p.fecha_nacimiento || "";
            document.getElementById("edit_sexo").value = p.sexo || "Masculino";
            document.getElementById("edit_estado").value = p.estado || "Activo";
            const assignedDoctors = p.medicos || [];
            const assignedDoctorIds = assignedDoctors.length
                ? assignedDoctors.map((doctor) => doctor.id)
                : (p.medico_id ? [p.medico_id] : []);
            const principalDoctor = assignedDoctors.find((doctor) => doctor.es_principal);
            editDoctorAssignment?.setSelection(
                assignedDoctorIds,
                principalDoctor?.id || p.medico_id,
            );
            document.getElementById("edit_estatura").value = p.estatura || "";
            document.getElementById("edit_nivel_riesgo").value = p.nivel_riesgo || "Bajo";
            document.getElementById("edit_diagnostico_principal").value = p.diagnostico_principal || "";
            editDiagnosisFilter?.update();
            document.getElementById("edit_password").value = "";

            if (editModalOverlay) {
                editModalOverlay.classList.remove("hidden");
            }
        } catch (error) {
            console.error(error);
            alert("Error al obtener los datos del paciente.");
        }
    };

    // ==========================================
    // MODAL VER EXPEDIENTE CLÍNICO
    // ==========================================
    const viewModalOverlay = document.getElementById("viewModalOverlay");
    const closeViewModalIcon = document.getElementById("closeViewModalIcon");
    const closeViewBtn = document.getElementById("closeViewBtn");
    const btnEditFromView = document.getElementById("btnEditFromView");
    let currentViewingPatientId = null;

    const closeViewModal = () => {
        if (viewModalOverlay) viewModalOverlay.classList.add("hidden");
    };

    if (closeViewModalIcon) closeViewModalIcon.addEventListener("click", closeViewModal);
    if (closeViewBtn) closeViewBtn.addEventListener("click", closeViewModal);
    if (viewModalOverlay) {
        viewModalOverlay.addEventListener("click", (e) => {
            if (e.target === viewModalOverlay) closeViewModal();
        });
    }

    if (btnEditFromView) {
        btnEditFromView.addEventListener("click", () => {
            closeViewModal();
            if (currentViewingPatientId) {
                openEditPatientModal(currentViewingPatientId);
            }
        });
    }

    const openViewPatientModal = async (patientId) => {
        try {
            currentViewingPatientId = patientId;
            const response = await fetch(`/pacientes/${patientId}`);
            const data = await response.json();

            if (!data.success || !data.paciente) {
                alert("No se pudo cargar el expediente.");
                return;
            }

            const p = data.paciente;

            document.getElementById("view_avatar").textContent = (p.primer_nombre ? p.primer_nombre[0] : "P") + (p.apellido_paterno ? p.apellido_paterno[0] : "");
            document.getElementById("view_nombre_completo").textContent = p.nombre_completo;
            document.getElementById("view_email").textContent = p.email;
            document.getElementById("view_telefono").textContent = p.telefono_emergencia || "No registrado";
            document.getElementById("view_edad_sexo").textContent = `${p.edad || 0} años • ${p.sexo}`;
            document.getElementById("view_estatura").textContent = p.estatura ? `${p.estatura} m` : "No registrada";
            document.getElementById("view_medico").textContent = `Dr(a). ${p.medico_nombre}`;
            document.getElementById("view_medicos").textContent = (p.medicos || [])
                .map((doctor) => `Dr(a). ${doctor.nombre_completo}${doctor.es_principal ? " (Principal)" : ""}`)
                .join(" · ") || "Sin médicos asignados";
            document.getElementById("view_diagnostico").textContent = p.diagnostico_principal;

            // Badges
            const badgeRiesgo = document.getElementById("view_badge_riesgo");
            badgeRiesgo.className = `badge-risk badge-risk-${p.nivel_riesgo === "Alto" ? "high" : (p.nivel_riesgo === "Medio" ? "medium" : "low")}`;
            badgeRiesgo.textContent = `Riesgo ${p.nivel_riesgo}`;

            const badgeEstado = document.getElementById("view_badge_estado");
            badgeEstado.className = p.estado === "Activo" ? "badge-status-active" : "badge-status-inactive";
            badgeEstado.textContent = p.estado;

            if (viewModalOverlay) {
                viewModalOverlay.classList.remove("hidden");
            }
        } catch (error) {
            console.error(error);
            alert("Error al cargar el expediente clínico.");
        }
    };

    // ==========================================
    // MODAL ELIMINAR / INACTIVAR
    // ==========================================
    const deleteModal = document.getElementById("deleteModal");
    const closeModalDelete = document.getElementById("closeModalDelete");
    const cancelDelete = document.getElementById("cancelDelete");
    const deletePatientForm = document.getElementById("deletePatientForm");
    const deleteModalMessage = document.getElementById("deleteModalMessage");

    const closeDeleteModal = () => {
        if (deleteModal) deleteModal.classList.add("hidden");
    };

    if (closeModalDelete) closeModalDelete.addEventListener("click", closeDeleteModal);
    if (cancelDelete) cancelDelete.addEventListener("click", closeDeleteModal);
    if (deleteModal) {
        deleteModal.addEventListener("click", (e) => {
            if (e.target === deleteModal) closeDeleteModal();
        });
    }

    const openDeleteModal = (patientId, patientName) => {
        if (deletePatientForm) {
            deletePatientForm.action = `/pacientes/${patientId}`;
        }
        if (deleteModalMessage) {
            deleteModalMessage.innerHTML = `Estás a punto de modificar el estado o registro de <strong>${patientName}</strong>.`;
        }
        if (deleteModal) {
            deleteModal.classList.remove("hidden");
        }
    };

    // ==========================================
    // DELEGACIÓN DE EVENTOS DE CLIC EN TABLA
    // ==========================================
    document.addEventListener("click", (e) => {
        // 1. Ver expediente
        const viewBtn = e.target.closest(".btn-action-view, .view-patient-dropdown");
        if (viewBtn) {
            e.stopPropagation();
            const id = viewBtn.dataset.id;
            if (id) openViewPatientModal(id);
            closeAllActionMenus();
            return;
        }

        // 2. Editar paciente
        const editBtn = e.target.closest(".btn-action-edit, .edit-patient-dropdown");
        if (editBtn) {
            e.stopPropagation();
            const id = editBtn.dataset.id;
            if (id) openEditPatientModal(id);
            closeAllActionMenus();
            return;
        }

        // 3. Eliminar paciente
        const deleteBtn = e.target.closest(".delete-patient-btn");
        if (deleteBtn) {
            e.stopPropagation();
            const id = deleteBtn.dataset.id;
            const name = deleteBtn.dataset.name || "este paciente";
            if (id) openDeleteModal(id, name);
            closeAllActionMenus();
            return;
        }

        // 4. Alternar estado rápido
        const toggleBtn = e.target.closest(".toggle-status-btn");
        if (toggleBtn) {
            e.stopPropagation();
            const userId = toggleBtn.dataset.id;
            const currentStatus = toggleBtn.dataset.current;
            const newStatus = currentStatus === "Activo" ? "Inactivo" : "Activo";

            if (confirm(`¿Deseas cambiar el estado de este paciente a "${newStatus}"?`)) {
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

        // 5. Menú de 3 puntos (trigger)
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

        // 6. Clic fuera: cerrar cualquier menú
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