import '../../css/admin/app.css';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {

    /* =========================
       🔎 BUSCADOR DE CITAS
    ========================= */
    const searchInput = document.querySelector('.search-bar input');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const appointments = document.querySelectorAll('.appointment-item');

            appointments.forEach(appointment => {
                const nameEl = appointment.querySelector('.patient-details h3');
                const conditionEl = appointment.querySelector('.patient-details p');

                const patientName = nameEl?.textContent.toLowerCase() || '';
                const patientCondition = conditionEl?.textContent.toLowerCase() || '';

                const match = patientName.includes(searchTerm) || patientCondition.includes(searchTerm);

                appointment.style.display = match ? 'flex' : 'none';
            });
        });
    }


    /* =========================
       📊 CHART DASHBOARD
    ========================= */
    const canvas = document.getElementById('conditionChart');

    if (!canvas) return; // evita errores en otras vistas

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

});