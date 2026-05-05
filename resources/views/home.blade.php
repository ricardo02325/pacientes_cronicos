<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CróniCare - Dashboard Admin</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js para el gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #131b2f;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-light: #eff6ff;
            
            /* Badge Colors */
            --badge-critico-bg: #fee2e2;
            --badge-critico-text: #ef4444;
            --badge-tratamiento-bg: #dbeafe;
            --badge-tratamiento-text: #2563eb;
            --badge-estable-bg: #dcfce7;
            --badge-estable-text: #22c55e;
            
            /* Icon BG Colors */
            --icon-blue-bg: #e0f2fe;
            --icon-blue-text: #0284c7;
            --icon-red-bg: #fee2e2;
            --icon-red-text: #ef4444;
            --icon-green-bg: #dcfce7;
            --icon-green-text: #16a34a;
            --icon-purple-bg: #f3e8ff;
            --icon-purple-text: #9333ea;
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

        .logo-text h2 {
            font-size: 18px;
            font-weight: 600;
        }
        .logo-text p {
            font-size: 12px;
            color: #94a3b8;
        }

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
            padding: 14px 16px;
            border-radius: 12px;
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
        }

        .nav-item:hover {
            background-color: rgba(255,255,255,0.05);
            color: white;
        }

        .nav-item.active {
            background-color: var(--primary);
            color: white;
        }

        .nav-item.logout {
            margin-top: auto;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* Top Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .stat-info h3 {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-info .number {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .stat-info p {
            font-size: 13px;
            color: var(--text-muted);
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
        .icon-red { background-color: var(--icon-red-bg); color: var(--icon-red-text); }
        .icon-green { background-color: var(--icon-green-bg); color: var(--icon-green-text); }
        .icon-purple { background-color: var(--icon-purple-bg); color: var(--icon-purple-text); }

        /* Bottom Section: Table + Chart */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .card {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            padding: 24px;
        }

        .card-header {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--text-main);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .patient-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        .patient-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
        }

        .patient-info p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .badge.critico { background-color: var(--badge-critico-bg); color: var(--badge-critico-text); }
        .badge.tratamiento { background-color: var(--badge-tratamiento-bg); color: var(--badge-tratamiento-text); }
        .badge.estable { background-color: var(--badge-estable-bg); color: var(--badge-estable-text); }

        .date-cell {
            color: var(--text-muted);
            font-size: 13px;
        }

        .actions {
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
            text-align: center;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <div class="logo-text">
                <h2>CróniCare</h2>
                <p>Panel de Admin</p>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-item active">
                <i class="fa-solid fa-border-all"></i> Dashboard
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-users"></i> Pacientes
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-user-doctor"></i> Médicos
            </a>
            <a href="#" class="nav-item">
                <i class="fa-regular fa-calendar-days"></i> Citas
            </a>

            <a href="#" class="nav-item logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Summary Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Pacientes</h3>
                    <div class="number">8</div>
                    <p>Registrados</p>
                </div>
                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-user-group"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Críticos</h3>
                    <div class="number">2</div>
                    <p>Requieren atención</p>
                </div>
                <div class="stat-icon icon-red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>En Tratamiento</h3>
                    <div class="number">2</div>
                    <p>Activos</p>
                </div>
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Citas Próximas</h3>
                    <div class="number">8</div>
                    <p>Pendientes</p>
                </div>
                <div class="stat-icon icon-purple">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="content-grid">
            
            <!-- Table Card -->
            <div class="card">
                <h2 class="card-header">Pacientes Recientes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>PACIENTE</th>
                            <th>CONDICIÓN</th>
                            <th>ESTADO</th>
                            <th>ÚLTIMA VISITA</th>
                            <th>PRÓXIMA CITA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="avatar">M</div>
                                    <div class="patient-info">
                                        <h4>Miguel Ángel Ortiz</h4>
                                        <p>75 años · Masculino</p>
                                    </div>
                                </div>
                            </td>
                            <td>Enfermedad Renal</td>
                            <td><span class="badge critico">Crítico</span></td>
                            <td class="date-cell">01 may<br>2026</td>
                            <td class="date-cell">05 may<br>2026</td>
                            <td class="actions"><i class="fa-solid fa-ellipsis"></i></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="avatar">M</div>
                                    <div class="patient-info">
                                        <h4>María García López</h4>
                                        <p>58 años · Femenino</p>
                                    </div>
                                </div>
                            </td>
                            <td>Diabetes</td>
                            <td><span class="badge tratamiento">En Tratamiento</span></td>
                            <td class="date-cell">19 abr<br>2026</td>
                            <td class="date-cell">09 may<br>2026</td>
                            <td class="actions"><i class="fa-solid fa-ellipsis"></i></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="avatar">C</div>
                                    <div class="patient-info">
                                        <h4>Carlos Rodríguez Martínez</h4>
                                        <p>67 años · Masculino</p>
                                    </div>
                                </div>
                            </td>
                            <td>Hipertensión</td>
                            <td><span class="badge estable">Estable</span></td>
                            <td class="date-cell">14 abr<br>2026</td>
                            <td class="date-cell">14 may<br>2026</td>
                            <td class="actions"><i class="fa-solid fa-ellipsis"></i></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="patient-cell">
                                    <div class="avatar">A</div>
                                    <div class="patient-info">
                                        <h4>Ana Fernández Ruiz</h4>
                                        <p>45 años · Femenino</p>
                                    </div>
                                </div>
                            </td>
                            <td>Asma</td>
                            <td><span class="badge estable">Estable</span></td>
                            <td class="date-cell">27 abr<br>2026</td>
                            <td class="date-cell">31 may<br>2026</td>
                            <td class="actions"><i class="fa-solid fa-ellipsis"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Chart Card -->
            <div class="card">
                <h2 class="card-header">Distribución por Condición</h2>
                <div class="chart-container">
                    <canvas id="conditionChart"></canvas>
                </div>
            </div>

        </div>
    </main>

    <!-- JavaScript para el Gráfico -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('conditionChart').getContext('2d');
            
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
                            '#3b82f6', // Azul - Renal
                            '#2dd4bf', // Turquesa - Diabetes
                            '#8b5cf6', // Morado - Hipertension
                            '#fbbf24', // Amarillo - Asma
                            '#ef4444', // Rojo - Insuficiencia
                            '#10b981', // Verde - EPOC
                            '#f97316'  // Naranja - Artritis
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%', // Grosor de la dona
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label.split(' (')[0] || '';
                                    return `${label}: ${context.raw} paciente(s)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>