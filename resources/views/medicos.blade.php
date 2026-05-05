<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CróniCare - Médicos</title>
    
    <!-- Fuentes e Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #f4f7fb;
            --bg-sidebar: #131b2f;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            
            /* Badges */
            --badge-yellow-bg: #fef3c7;
            --badge-yellow-text: #b45309;
            --badge-gray-bg: #f1f5f9;
            --badge-gray-text: #475569;
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
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .page-title p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-bar {
            position: relative;
            width: 300px;
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

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }

        .btn-primary:hover { background-color: var(--primary-hover); }

        /* --- DOCTORS GRID & CARDS --- */
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .doctor-card {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            position: relative;
        }

        .card-menu {
            position: absolute;
            top: 24px;
            right: 24px;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
        }

        .doctor-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
        }

        .doctor-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-main);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-specialty { background-color: var(--badge-yellow-bg); color: var(--badge-yellow-text); }
        .badge-status { background-color: var(--badge-gray-bg); color: var(--badge-gray-text); }

        .doctor-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .detail-item i { width: 16px; font-size: 14px; text-align: center; }

        .divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 20px 0;
        }

        /* --- MODAL --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            width: 100%;
            max-width: 550px;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width { grid-column: span 2; }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: var(--text-main);
            background-color: white;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-secondary:hover { background-color: #f8fafc; }

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
            <a href="#" class="nav-item active"><i class="fa-solid fa-user-doctor"></i> Médicos</a>
            <a href="#" class="nav-item"><i class="fa-regular fa-calendar-days"></i> Citas</a>
            <a href="#" class="nav-item logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div class="page-title">
                <h1>Médicos</h1>
                <p>1 médicos registrados</p>
            </div>
            
            <div class="actions">
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Buscar por nombre o especialidad...">
                </div>
                <button class="btn-primary" id="btnOpenModal">
                    <i class="fa-solid fa-plus"></i> Nuevo Médico
                </button>
            </div>
        </div>

        <!-- Doctors Grid -->
        <div class="doctors-grid">
            
            <!-- Doctor Card -->
            <div class="doctor-card">
                <i class="fa-solid fa-ellipsis card-menu"></i>
                
                <div class="doctor-header">
                    <div class="avatar">H</div>
                    <div class="doctor-info">
                        <h3>Hola</h3>
                        <span class="badge badge-specialty">Endocrinología</span>
                    </div>
                </div>

                <div class="doctor-details">
                    <div class="detail-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>3141983525</span>
                    </div>
                    <div class="detail-item">
                        <i class="fa-regular fa-envelope"></i>
                        <span>ma@gmail.com</span>
                    </div>
                    <div class="detail-item">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Cédula: 292838</span>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="doctor-footer">
                    <span class="badge badge-status">Inactivo</span>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Form -->
    <div class="modal-overlay" id="doctorModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Nuevo Médico</h2>
                <button class="btn-close" id="btnCloseModal"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Nombre Completo *</label>
                    <input type="text" class="form-control" autofocus style="border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);">
                </div>

                <div class="form-group">
                    <label>Especialidad *</label>
                    <select class="form-control">
                        <option value="">Seleccionar</option>
                        <option value="endocrinologia">Endocrinología</option>
                        <option value="cardiologia">Cardiología</option>
                        <option value="general">Medicina General</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control">
                </div>

                <div class="form-group full-width">
                    <label>Cédula Profesional</label>
                    <input type="text" class="form-control">
                </div>

                <div class="form-group full-width">
                    <label>Notas</label>
                    <textarea class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" id="btnCancelModal">Cancelar</button>
                <button class="btn-primary">Crear Médico</button>
            </div>
        </div>
    </div>

    <!-- Scripts for Modal Logic -->
    <script>
        const modal = document.getElementById('doctorModal');
        const btnOpen = document.getElementById('btnOpenModal');
        const btnClose = document.getElementById('btnCloseModal');
        const btnCancel = document.getElementById('btnCancelModal');

        // Función para abrir el modal
        btnOpen.addEventListener('click', () => {
            modal.classList.add('active');
        });

        // Funciones para cerrar el modal
        const closeModal = () => {
            modal.classList.remove('active');
        };

        btnClose.addEventListener('click', closeModal);
        btnCancel.addEventListener('click', closeModal);

        // Cerrar modal al hacer clic fuera del contenido
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>