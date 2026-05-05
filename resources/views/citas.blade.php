<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CróniCare - Citas</title>
    
    <!-- Fuentes e Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #131b2f;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            
            /* Badges & Icons */
            --badge-green-bg: #dcfce7;
            --badge-green-text: #16a34a;
            --badge-blue-bg: #dbeafe;
            --badge-blue-text: #2563eb;
            
            --icon-blue-bg: #e0f2fe;
            --icon-blue-text: #0284c7;
            --icon-gray-bg: #f1f5f9;
            --icon-gray-text: #475569;
            --icon-red-bg: #fee2e2;
            --icon-red-text: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 250px;
            background-color: var(--bg-sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 12px;
        }

        .logo-icon {
            background-color: #3b82f6;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .logo-text h2 { font-size: 18px; font-weight: 600; }
        .logo-text p { font-size: 12px; color: #94a3b8; }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }

        .nav-item i { width: 20px; text-align: center; font-size: 16px; }
        .nav-item:hover { background-color: rgba(255,255,255,0.05); color: white; }
        .nav-item.active { background-color: var(--primary); color: white; }
        .nav-item.logout { margin-top: auto; }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            padding: 32px 40px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* --- STATS CARDS --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .stat-card {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-blue { background-color: var(--icon-blue-bg); color: var(--icon-blue-text); }
        .icon-gray { background-color: var(--icon-gray-bg); color: var(--icon-gray-text); }
        .icon-red { background-color: var(--icon-red-bg); color: var(--icon-red-text); }

        .stat-info .stat-number {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        .stat-info .stat-label {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* --- FILTERS ROW --- */
        .filters-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .search-bar {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-bar i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-bar input:focus { border-color: var(--primary); }

        .select-filter {
            padding: 10px 36px 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            cursor: pointer;
        }

        /* --- APPOINTMENTS LIST --- */
        .appointments-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .appointment-item {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: transform 0.1s, box-shadow 0.1s;
        }

        .appointment-item:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transform: translateY(-1px);
        }

        .patient-info-container {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        .patient-details h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .patient-details p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .appointment-info-container {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            min-width: 90px;
        }

        .badge.estable { background-color: var(--badge-green-bg); color: var(--badge-green-text); }
        .badge.tratamiento { background-color: var(--badge-blue-bg); color: var(--badge-blue-text); }

        .date-short {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            width: 60px;
        }

        .date-full {
            font-size: 14px;
            color: var(--text-muted);
            width: 140px;
            text-align: right;
        }

    </style>
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