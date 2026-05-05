<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CróniCare - Citas</title>
    
    <!-- Fuentes e Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Estilos CSS usando Vite --}}
    @vite(['resources/css/admin/app.css'])

</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-area">
            <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
            <div class="logo-text">
                <h2>CróniCare</h2>
                <p>Panel de Admin</p>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-users"></i> Pacientes</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-user-doctor"></i> Médicos</a>
            <a href="#" class="nav-item active"><i class="fa-regular fa-calendar-days"></i> Citas</a>
            
            <a href="#" class="nav-item logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <div class="header">
            <div class="page-title">
                <h1>Citas</h1>
                <p>Seguimiento de citas de pacientes crónicos</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fa-regular fa-calendar"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">8</span>
                    <span class="stat-label">Próximas</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-gray">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Pasadas</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-number">2</span>
                    <span class="stat-label">Pacientes Críticos</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-row">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Buscar paciente...">
            </div>
            
            <select class="select-filter">
                <option value="proximas">Próximas</option>
                <option value="pasadas">Pasadas</option>
                <option value="todas">Todas</option>
            </select>

            <select class="select-filter">
                <option value="todos">Todos los estados</option>
                <option value="estable">Estable</option>
                <option value="tratamiento">En Tratamiento</option>
                <option value="critico">Crítico</option>
            </select>
        </div>

        <!-- Appointments List -->
        <div class="appointments-list">
            
            <!-- Item 1 -->
            <div class="appointment-item">
                <div class="patient-info-container">
                    <div class="avatar">A</div>
                    <div class="patient-details">
                        <h3>Ana Fernández Ruiz</h3>
                        <p>Asma · 45 años</p>
                    </div>
                </div>
                <div class="appointment-info-container">
                    <span class="badge estable">Estable</span>
                    <span class="date-short">31 may</span>
                    <span class="date-full">31 de mayo, 2026</span>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="appointment-item">
                <div class="patient-info-container">
                    <div class="avatar">I</div>
                    <div class="patient-details">
                        <h3>Isabel Ramírez Vargas</h3>
                        <p>Artritis · 49 años</p>
                    </div>
                </div>
                <div class="appointment-info-container">
                    <span class="badge estable">Estable</span>
                    <span class="date-short">29 may</span>
                    <span class="date-full">29 de mayo, 2026</span>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="appointment-item">
                <div class="patient-info-container">
                    <div class="avatar">P</div>
                    <div class="patient-details">
                        <h3>Pedro Jiménez Torres</h3>
                        <p>Diabetes · 61 años</p>
                    </div>
                </div>
                <div class="appointment-info-container">
                    <span class="badge tratamiento">En Tratamiento</span>
                    <span class="date-short">19 may</span>
                    <span class="date-full">19 de mayo, 2026</span>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="appointment-item">
                <div class="patient-info-container">
                    <div class="avatar">C</div>
                    <div class="patient-details">
                        <h3>Carlos Rodríguez Martínez</h3>
                        <p>Hipertensión · 67 años</p>
                    </div>
                </div>
                <div class="appointment-info-container">
                    <span class="badge estable">Estable</span>
                    <span class="date-short">14 may</span>
                    <span class="date-full">14 de mayo, 2026</span>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="appointment-item">
                <div class="patient-info-container">
                    <div class="avatar">M</div>
                    <div class="patient-details">
                        <h3>María García López</h3>
                        <p>Diabetes · 58 años</p>
                    </div>
                </div>
                <div class="appointment-info-container">
                    <span class="badge tratamiento">En Tratamiento</span>
                    <span class="date-short">09 may</span>
                    <span class="date-full">09 de mayo, 2026</span>
                </div>
            </div>

        </div>

    </main>

    <script>
        // JS Básico para la búsqueda visual (opcional)
        document.querySelector('.search-bar input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const appointments = document.querySelectorAll('.appointment-item');
            
            appointments.forEach(appointment => {
                const patientName = appointment.querySelector('.patient-details h3').textContent.toLowerCase();
                const patientCondition = appointment.querySelector('.patient-details p').textContent.toLowerCase();
                
                if (patientName.includes(searchTerm) || patientCondition.includes(searchTerm)) {
                    appointment.style.display = 'flex';
                } else {
                    appointment.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>