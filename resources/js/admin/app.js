import '../../css/admin/app.css';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {

    // ======================
    // MODAL EDITAR
    // ======================

    const editModalOverlay = document.getElementById("editModalOverlay");
    const closeEditModalIcon = document.getElementById("closeEditModalIcon");
    const cancelEditModalBtn = document.getElementById("cancelEditModalBtn");
    const savePatientBtn = document.getElementById("savePatientBtn");

    // ======================
    // BUSCADOR
    // ======================

    const searchInput = document.querySelector('.search-bar input');

    if (searchInput) {

        searchInput.addEventListener('input', (e) => {

            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {

                const patientName =
                    row.querySelector('.patient-info h4')?.textContent.toLowerCase() || '';

                const condition =
                    row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';

                const match =
                    patientName.includes(searchTerm) ||
                    condition.includes(searchTerm);

                row.style.display = match ? '' : 'none';

            });

        });

    }

    // ======================
    // CHART
    // ======================

    const canvas = document.getElementById('conditionChart');

    if (canvas) {

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Enfermedad Renal (1)',
                    'Diabetes (2)',
                    'Hipertensión (1)',
                    'Asma (1)',
                    'Insuficiencia Cardíaca (1)',
                    'EPOC (1)',
                    'Artritis (1)'
                ],
                datasets: [{
                    data: [1, 2, 1, 1, 1, 1, 1],
                    backgroundColor: [
                        '#3b82f6',
                        '#2dd4bf',
                        '#8b5cf6',
                        '#fbbf24',
                        '#ef4444',
                        '#10b981',
                        '#f97316'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

    }

    // ======================
    // MENU ACCIONES
    // ======================

    const actionButtons = document.querySelectorAll(".actions-btn");

    actionButtons.forEach((button) => {

        button.addEventListener("click", (e) => {

            e.stopPropagation();

            document.querySelectorAll(".actions-menu").forEach(menu => {

                if (menu !== button.nextElementSibling) {
                    menu.classList.add("hidden");
                }

            });

            button.nextElementSibling.classList.toggle("hidden");

        });

    });

    // ======================
    // ABRIR MODAL EDITAR
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
});