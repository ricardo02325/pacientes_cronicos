<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CróniCare - Dashboard Médico</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js para el gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* Variables heredadas de home.blade.php */
            --bg-body: #f8fafc;
            --bg-sidebar: #131b2f;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            
            /* Nuevos colores para riesgos basados en tu diseño */
            --riesgo-bajo-bg: #dcfce7;
            --riesgo-bajo-text: #16a34a;
            --riesgo-medio-bg: #ffedd5;
            --riesgo-medio-text: #ea580c;
            --riesgo-alto-bg: #fee2e2;
            --riesgo-alto-text: #ef4444;
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

        /* --- SIDEBAR (Estructura base de home.blade.php) --- */
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

        .nav-item.logout { margin-top: auto; }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px 0 32px;
        }

        .header-top h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: right;
        }

        .user-text h4 {
            font-size: 14px;
            color: var(--text-main);
            font-weight: 600;
        }

        .user-text p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .main-content {
            flex: 1;
            padding: 24px 32px 32px 32px;
            overflow-y: auto;
        }

        /* --- VISTA 1: LISTADO DE PACIENTES --- */
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
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .stat-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .stat-card p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Controles (Pills y Buscador) */
        .controls-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 24px;
        }

        .filter-pills {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-pills h2 {
            font-size: 18px;
            font-weight: 600;
            margin-right: 12px;
        }

        .pill {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background-color: white;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .pill.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .search-box {
            display: flex;
            gap: 12px;
            flex: 1;
            max-width: 500px;
        }

        .search-input-wrapper {
            flex: 1;
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .btn-search {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 24px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-search:hover { background-color: var(--primary-hover); }

        /* Tabla Estilo Medico */
        .table-card {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        
        th {
            text-align: left;
            padding: 16px 24px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 14px;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #fbfcfd; }

        .td-paciente { font-weight: 600; color: var(--text-main); }
        .td-paciente span { display: block; font-weight: 400; font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-bajo { background-color: var(--riesgo-bajo-bg); color: var(--riesgo-bajo-text); border: 1px solid #bbf7d0; }
        .badge-medio { background-color: var(--riesgo-medio-bg); color: var(--riesgo-medio-text); border: 1px solid #fed7aa; }
        .badge-alto { background-color: var(--riesgo-alto-bg); color: var(--riesgo-alto-text); border: 1px solid #fecaca; }

        .action-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
        }
        .action-link:hover { text-decoration: underline; }

        /* --- VISTA 2: DETALLE PACIENTE (Monitoreo) --- */
        #vista-detalle { display: none; }

        .header-detalle {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .btn-back {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            transition: all 0.2s;
        }
        .btn-back:hover { background: #f1f5f9; }

        .patient-title h1 { font-size: 24px; color: var(--text-main); }
        .patient-title p { font-size: 14px; color: var(--text-muted); }

        .detalle-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        /* Panel Izquierdo (Gráficas) */
        .panel-graficas {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .filtros-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            display: flex;
            gap: 24px;
        }

        .filtro-grupo { flex: 1; }
        .filtro-grupo label { display: block; font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px; }
        
        .input-control {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            color: var(--text-main);
        }

        .fechas-grupo { display: flex; gap: 12px; }

        .grafica-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            min-height: 400px;
        }
        .grafica-card h3 { font-size: 16px; margin-bottom: 24px; }

        /* Panel Derecho (Reportes e Historial) */
        .panel-lateral {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .export-card {
            background-color: var(--primary);
            color: white;
            padding: 24px;
            border-radius: 16px;
            text-align: left;
        }

        .export-card h3 { font-size: 18px; margin-bottom: 8px; }
        .export-card p { font-size: 13px; color: var(--primary-light); margin-bottom: 20px; line-height: 1.5; }
        
        .btn-export {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: white;
            color: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .historial-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            flex: 1;
        }

        .historial-card h3 { font-size: 16px; margin-bottom: 16px; }

        .historial-table th { padding: 12px 0; background: white; border-bottom: 1px solid var(--border-color); }
        .historial-table td { padding: 12px 0; }
        .historial-table th:last-child, .historial-table td:last-child { text-align: right; }

    </style>
</head>
<body>
    
    <!-- Sidebar (Mantenemos la estructura oscura de home.blade.php) -->
    <aside class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <div class="logo-text">
                <h2>CróniCare</h2>
                <p>Panel Médico</p>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-item">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
            <a href="#" class="nav-item active">
                <i class="fa-solid fa-users"></i> Mis Pacientes
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-file-waveform"></i> Reportes
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-chart-line"></i> Estadísticas
            </a>
            <a href="#" class="nav-item">
                <i class="fa-solid fa-gear"></i> Configuración
            </a>

            <a href="#" class="nav-item logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
            </a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        
        <!-- Header Superior Dinámico -->
        <header class="header-top">
            <h1 id="titulo-header">Gestión de Pacientes</h1>
            
            <div class="user-info">
                <div class="user-text">
                    <h4>Hola, Dr. Administrador</h4>
                    <p>Lun, 13 Abr</p>
                </div>
                <div class="user-avatar">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
            </div>
        </header>

        <!-- Zona de Contenido Scrolleable -->
        <main class="main-content">
            
            <!-- ========================================== -->
            <!-- VISTA 1: LISTADO DE PACIENTES (index.blade)  -->
            <!-- ========================================== -->
            <div id="vista-listado">
                <!-- Summary Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon" style="background: #f1f5f9; color: #64748b;">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <p>Total de Pacientes</p>
                        <h3>6</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-icon" style="background: var(--riesgo-bajo-bg); color: var(--riesgo-bajo-text);">
                            <i class="fa-regular fa-circle-check"></i>
                        </div>
                        <p>Riesgo Bajo</p>
                        <h3>2</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-icon" style="background: var(--riesgo-medio-bg); color: var(--riesgo-medio-text);">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <p>Riesgo Medio</p>
                        <h3>2</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-icon" style="background: var(--riesgo-alto-bg); color: var(--riesgo-alto-text);">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <p>Riesgo Alto</p>
                        <h3>2</h3>
                    </div>
                </div>

                <!-- Controles: Filtros y Búsqueda -->
                <div class="controls-bar">
                    <div class="filter-pills">
                        <h2>Listado de Pacientes</h2>
                        <div class="pill active">Todos</div>
                        <div class="pill">Riesgo Bajo</div>
                        <div class="pill">Riesgo Medio</div>
                        <div class="pill">Riesgo Alto</div>
                    </div>

                    <div class="search-box">
                        <div class="search-input-wrapper">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" class="search-input" placeholder="Buscar paciente...">
                        </div>
                        <button class="btn-search">Buscar</button>
                    </div>
                </div>

                <!-- Tabla de Pacientes -->
                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Diagnóstico Principal</th>
                                <th>Último Registro</th>
                                <th>Nivel de Riesgo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="td-paciente">
                                    Juan Pérez García
                                    <span>juan.perez@paciente.local</span>
                                </td>
                                <td>Hipertensión Arterial</td>
                                <td>25/10/2023</td>
                                <td><span class="badge badge-medio"><i class="fa-solid fa-triangle-exclamation"></i> Medio</span></td>
                                <td><a class="action-link" onclick="abrirDetalle('Juan Pérez García')">Monitorear</a></td>
                            </tr>
                            <tr>
                                <td class="td-paciente">
                                    María Gómez López
                                    <span>maria.gomez@paciente.local</span>
                                </td>
                                <td>Diabetes Tipo 2</td>
                                <td>26/10/2023</td>
                                <td><span class="badge badge-alto"><i class="fa-solid fa-circle-exclamation"></i> Alto</span></td>
                                <td><a class="action-link" onclick="abrirDetalle('María Gómez López')">Monitorear</a></td>
                            </tr>
                            <tr>
                                <td class="td-paciente">
                                    Carlos Ruiz Sánchez
                                    <span>carlos.ruiz@paciente.local</span>
                                </td>
                                <td>Insuficiencia Cardíaca</td>
                                <td>20/10/2023</td>
                                <td><span class="badge badge-alto"><i class="fa-solid fa-circle-exclamation"></i> Alto</span></td>
                                <td><a class="action-link" onclick="abrirDetalle('Carlos Ruiz Sánchez')">Monitorear</a></td>
                            </tr>
                            <tr>
                                <td class="td-paciente">
                                    Ana Torres Vega
                                    <span>ana.torres@paciente.local</span>
                                </td>
                                <td>Obesidad</td>
                                <td>27/10/2023</td>
                                <td><span class="badge badge-bajo"><i class="fa-regular fa-circle-check"></i> Bajo</span></td>
                                <td><a class="action-link" onclick="abrirDetalle('Ana Torres Vega')">Monitorear</a></td>
                            </tr>
                            <tr>
                                <td class="td-paciente">
                                    Pedro Sola Test
                                    <span>pedro.test@paciente.local</span>
                                </td>
                                <td>Asma Crónica</td>
                                <td>28/10/2023</td>
                                <td><span class="badge badge-bajo"><i class="fa-regular fa-circle-check"></i> Bajo</span></td>
                                <td><a class="action-link" onclick="abrirDetalle('Pedro Sola Test')">Monitorear</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- VISTA 2: DETALLE DEL PACIENTE (show.blade) -->
            <!-- ========================================== -->
            <div id="vista-detalle">
                
                <div class="header-detalle">
                    <button class="btn-back" onclick="volverListado()">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <div class="patient-title">
                        <h1 id="nombre-paciente">Juan Pérez García</h1>
                        <p>Expediente Clínico Electrónico</p>
                    </div>
                </div>

                <div class="detalle-grid">
                    
                    <!-- Lado Izquierdo: Controles y Gráfica -->
                    <div class="panel-graficas">
                        
                        <!-- Filtros -->
                        <div class="filtros-card">
                            <div class="filtro-grupo">
                                <label>Métrica a evaluar</label>
                                <select class="input-control">
                                    <option>Presión Arterial (Sistólica)</option>
                                    <option>Presión Arterial (Diastólica)</option>
                                    <option>Glucosa en Sangre</option>
                                    <option>Peso</option>
                                </select>
                            </div>
                            <div class="filtro-grupo">
                                <label>Rango de Fechas</label>
                                <div class="fechas-grupo">
                                    <input type="date" class="input-control" value="2023-10-01">
                                    <input type="date" class="input-control" value="2023-10-31">
                                </div>
                            </div>
                        </div>

                        <!-- Gráfica -->
                        <div class="grafica-card">
                            <h3>Evolución de Presión Arterial (Sistólica)</h3>
                            <div style="position: relative; height: 300px; width: 100%;">
                                <canvas id="metricChart"></canvas>
                            </div>
                        </div>

                    </div>

                    <!-- Lado Derecho: Reporte y Tabla -->
                    <div class="panel-lateral">
                        
                        <!-- Tarjeta de Exportación -->
                        <div class="export-card">
                            <h3>Exportar Reporte</h3>
                            <p>Descarga el historial de métricas en formato PDF según el rango de fechas.</p>
                            <button class="btn-export">
                                <i class="fa-solid fa-download"></i> Descargar PDF
                            </button>
                        </div>

                        <!-- Historial Reciente -->
                        <div class="historial-card">
                            <h3>Registros Recientes</h3>
                            <table class="historial-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2023-10-20</td>
                                        <td style="font-weight: 600;">145</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-21</td>
                                        <td style="font-weight: 600;">140</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-22</td>
                                        <td style="font-weight: 600;">138</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-23</td>
                                        <td style="font-weight: 600;">135</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-24</td>
                                        <td style="font-weight: 600;">130</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-25</td>
                                        <td style="font-weight: 600;">128</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Scripts para interactividad y gráficos -->
    <script>
        // Funciones para simular navegación entre vistas de Laravel
        function abrirDetalle(nombre) {
            document.getElementById('vista-listado').style.display = 'none';
            document.getElementById('vista-detalle').style.display = 'block';
            document.getElementById('titulo-header').innerText = 'Monitoreo Clínico';
            document.getElementById('nombre-paciente').innerText = nombre;
            
            // Renderizar gráfica al abrir
            renderChart();
        }

        function volverListado() {
            document.getElementById('vista-detalle').style.display = 'none';
            document.getElementById('vista-listado').style.display = 'block';
            document.getElementById('titulo-header').innerText = 'Gestión de Pacientes';
        }

        // Variable global para evitar duplicados del chart
        let metricChartInstance = null;

        function renderChart() {
            const ctx = document.getElementById('metricChart').getContext('2d');
            
            if(metricChartInstance != null){
                metricChartInstance.destroy();
            }

            metricChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['19 oct', '20 oct', '21 oct', '22 oct', '23 oct', '24 oct', '25 oct'],
                    datasets: [{
                        label: 'Presión Arterial (Sistólica)',
                        data: [145, 140, 138, 135, 130, 128, 125],
                        borderColor: '#3b82f6', // Color primario
                        backgroundColor: '#ffffff',
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.1 // Curvatura ligera
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Oculta la leyenda superior para igualar el mockup
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' mmHg';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 40,
                            max: 150,
                            ticks: {
                                stepSize: 25,
                                color: '#94a3b8',
                                font: { size: 11, family: "'Inter', sans-serif" }
                            },
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [5, 5] // Líneas punteadas horizontales
                            },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11, family: "'Inter', sans-serif" }
                            },
                            grid: { display: false }, // Sin líneas verticales
                            border: { display: false }
                        }
                    },
                    animation: {
                        duration: 800
                    }
                }
            });
        }
    </script>
</body>
</html>