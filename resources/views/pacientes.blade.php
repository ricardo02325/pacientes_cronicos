<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CróniCare - Pacientes</title>
<style>
  :root {
    --sidebar-bg: #111827;
    --sidebar-text: #ffffff;
    --sidebar-text-muted: #9ca3af;
    --sidebar-active-item: #2563eb;
    --content-bg: #f3f4f6;
    --main-title-color: #111827;
    --text-color: #4b5563;
    --text-muted: #6b7280;
    --primary-blue: #3b82f6;
    --white: #ffffff;
    --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --border-color: #e5e7eb;
    --badge-red: #fee2e2;
    --badge-red-text: #ef4444;
    --badge-green: #dcfce7;
    --badge-green-text: #16a34a;
    --badge-orange: #fef3c7;
    --badge-orange-text: #ea580c;
    --badge-blue: #dbeafe;
    --badge-blue-text: #2563eb;
  }

  body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    background-color: var(--content-bg);
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* --- Sidebar --- */
  .sidebar {
    width: 250px;
    background-color: var(--sidebar-bg);
    color: var(--sidebar-text);
    padding: 2rem 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.3s ease;
  }

  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 3rem;
  }

  .logo-icon {
    width: 36px;
    height: 36px;
    background-color: var(--primary-blue);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 20px;
  }

  .logo-text-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
  }

  .logo-text-subtitle {
    font-size: 12px;
    color: var(--sidebar-text-muted);
    margin: 0;
  }

  .sidebar-nav {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    color: var(--sidebar-text-muted);
    font-size: 15px;
    transition: background-color 0.2s;
  }

  .nav-item:hover {
    background-color: #374151;
    color: var(--white);
  }

  .nav-item.active {
    background-color: var(--sidebar-active-item);
    color: var(--white);
    font-weight: 600;
  }

  .nav-icon {
    width: 20px;
    text-align: center;
  }

  .sidebar-logout {
    margin-top: auto;
  }

  /* --- Main Content --- */
  .main-content {
    flex-grow: 1;
    padding: 2rem;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }

  .title-group h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--main-title-color);
    margin: 0 0 0.5rem 0;
  }

  .title-group p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
  }

  .header-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
  }

  .search-bar {
    display: flex;
    align-items: center;
    position: relative;
    flex-grow: 1;
    max-width: 400px;
  }

  .search-icon {
    position: absolute;
    left: 12px;
    color: var(--text-muted);
    font-size: 16px;
  }

  .search-input {
    width: 100%;
    padding: 10px 10px 10px 38px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background-color: var(--white);
    font-size: 14px;
    color: var(--text-color);
  }

  .search-input::placeholder {
    color: var(--text-muted);
  }

  .new-patient-btn {
    background-color: var(--primary-blue);
    color: var(--white);
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
  }

  /* --- Patient Table --- */
  .patient-card {
    background-color: var(--white);
    border-radius: 16px;
    box-shadow: var(--card-shadow);
    padding: 1.5rem;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .table-header-row th {
    text-align: left;
    color: var(--text-muted);
    font-weight: 600;
    font-size: 12px;
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
  }

  .table-row {
    border-bottom: 1px solid #f3f4f6;
  }

  .table-row td {
    padding: 1rem;
    color: var(--text-color);
  }

  .table-row td:nth-child(4),
  .table-row td:nth-child(5) {
    color: var(--text-muted);
  }

  .patient-info {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e0f2fe;
    color: var(--primary-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
  }

  .patient-details h4 {
    margin: 0 0 4px 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--main-title-color);
  }

  .patient-details p {
    margin: 0;
    font-size: 12px;
    color: var(--text-muted);
  }

  .status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
  }

  .status-critico {
    background-color: var(--badge-red);
    color: var(--badge-red-text);
  }

  .status-estable {
    background-color: var(--badge-green);
    color: var(--badge-green-text);
  }

  .status-observacion {
    background-color: var(--badge-orange);
    color: var(--badge-orange-text);
  }

  .status-tratamiento {
    background-color: var(--badge-blue);
    color: var(--badge-blue-text);
  }

  .actions-icon {
    font-size: 18px;
    color: var(--text-muted);
    cursor: pointer;
  }

  /* --- Modal --- */
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
    visibility: visible;
    opacity: 1;
    transition: visibility 0.2s, opacity 0.2s;
  }

  .modal-overlay.hidden {
    visibility: hidden;
    opacity: 0;
  }

  .modal-card {
    background-color: var(--white);
    width: 90%;
    max-width: 600px;
    border-radius: 16px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    overflow-y: auto;
    max-height: 90vh;
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }

  .modal-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--main-title-color);
    margin: 0;
  }

  .close-modal-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--text-muted);
    cursor: pointer;
  }

  .modal-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .form-group-full {
    width: 100%;
  }

  .form-row {
    display: flex;
    gap: 1rem;
  }

  .form-group-half {
    flex: 1;
  }

  .modal-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--main-title-color);
    margin-bottom: 0.25rem;
    display: block;
  }

  .required-star {
    color: var(--badge-red-text);
  }

  .modal-input,
  .modal-select,
  .modal-textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background-color: var(--white);
    font-size: 14px;
    color: var(--text-color);
    box-sizing: border-box;
  }

  .modal-input::placeholder,
  .modal-select,
  .modal-textarea::placeholder {
    color: var(--text-muted);
  }

  .modal-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%236b7280" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 18px;
    padding-right: 30px;
  }

  .modal-input-date {
    appearance: none;
    -webkit-appearance: none;
    color: var(--text-muted);
    background-image: url('data:image/svg+xml;utf8,<svg fill="%236b7280" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 18px;
    padding-right: 30px;
  }

  .modal-textarea {
    resize: vertical;
    height: 80px;
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1rem;
  }

  .cancel-modal-btn {
    background-color: var(--content-bg);
    color: var(--text-color);
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
  }

  .create-patient-modal-btn {
    background-color: var(--primary-blue);
    color: var(--white);
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
  }

</style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-top">
      <div class="sidebar-logo">
        <div class="logo-icon">&#11138;</div>
        <div class="logo-text">
          <h2 class="logo-text-title">CróniCare</h2>
          <p class="logo-text-subtitle">Panel de Admin</p>
        </div>
      </div>
      <nav class="sidebar-nav">
        <a href="#" class="nav-item">
          <span class="nav-icon">&#11123;</span> Dashboard
        </a>
        <a href="#" class="nav-item active">
          <span class="nav-icon">&#128100;</span> Pacientes
        </a>
        <a href="#" class="nav-item">
          <span class="nav-icon">&#128101;</span> Médicos
        </a>
        <a href="#" class="nav-item">
          <span class="nav-icon">&#128197;</span> Citas
        </a>
      </nav>
    </div>
    <div class="sidebar-logout">
      <a href="#" class="nav-item logout-link">
        <span class="nav-icon">&#128274;</span> Cerrar Sesión
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="header">
      <div class="title-group">
        <h1>Pacientes</h1>
        <p>8 pacientes registrados</p>
      </div>
      <div class="header-actions">
        <div class="search-bar">
          <span class="search-icon">&#128269;</span>
          <input type="text" class="search-input" placeholder="Buscar por nombre, condición o estado...">
        </div>
        <button id="addPatientBtn" class="new-patient-btn">
          <span class="plus-icon">&#43;</span> Nuevo Paciente
        </button>
      </div>
    </div>

    <!-- Patient Table -->
    <div class="patient-card">
      <table class="table">
        <thead class="table-header">
          <tr class="table-header-row">
            <th>PACIENTE</th>
            <th>CONDICIÓN</th>
            <th>ESTADO</th>
            <th>ÚLTIMA VISITA</th>
            <th>PRÓXIMA CITA</th>
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">M</div>
                <div class="patient-details">
                  <h4>Miguel Ángel Ortiz</h4>
                  <p>75 años · Masculino</p>
                </div>
              </div>
            </td>
            <td>Enfermedad Renal</td>
            <td><span class="status-badge status-critico">Crítico</span></td>
            <td>01 may 2026</td>
            <td>05 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">M</div>
                <div class="patient-details">
                  <h4>María García López</h4>
                  <p>58 años · Femenino</p>
                </div>
              </div>
            </td>
            <td>Diabetes</td>
            <td><span class="status-badge status-tratamiento">En Tratamiento</span></td>
            <td>19 abr 2026</td>
            <td>09 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">C</div>
                <div class="patient-details">
                  <h4>Carlos Rodríguez Martínez</h4>
                  <p>67 años · Masculino</p>
                </div>
              </div>
            </td>
            <td>Hipertensión</td>
            <td><span class="status-badge status-estable">Estable</span></td>
            <td>14 abr 2026</td>
            <td>14 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">A</div>
                <div class="patient-details">
                  <h4>Ana Fernández Ruiz</h4>
                  <p>45 años · Femenino</p>
                </div>
              </div>
            </td>
            <td>Asma</td>
            <td><span class="status-badge status-estable">Estable</span></td>
            <td>27 abr 2026</td>
            <td>31 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">R</div>
                <div class="patient-details">
                  <h4>Roberto Hernández Díaz</h4>
                  <p>72 años · Masculino</p>
                </div>
              </div>
            </td>
            <td>Insuficiencia Cardíaca</td>
            <td><span class="status-badge status-critico">Crítico</span></td>
            <td>30 abr 2026</td>
            <td>04 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">L</div>
                <div class="patient-details">
                  <h4>Laura Sánchez Morales</h4>
                  <p>53 años · Femenino</p>
                </div>
              </div>
            </td>
            <td>EPOC</td>
            <td><span class="status-badge status-observacion">En Observación</span></td>
            <td>09 abr 2026</td>
            <td>07 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
          <tr class="table-row">
            <td>
              <div class="patient-info">
                <div class="avatar">P</div>
                <div class="patient-details">
                  <h4>Pedro Jiménez Torres</h4>
                  <p>61 años · Masculino</p>
                </div>
              </div>
            </td>
            <td>Diabetes</td>
            <td><span class="status-badge status-tratamiento">En Tratamiento</span></td>
            <td>24 abr 2026</td>
            <td>19 may 2026</td>
            <td><span class="actions-icon">&#10247;</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Modal -->
  <div id="modalOverlay" class="modal-overlay">
    <div class="modal-card">
      <div class="modal-header">
        <h3 class="modal-title">Nuevo Paciente</h3>
        <button id="closeModalIcon" class="close-modal-btn">&times;</button>
      </div>
      <div class="modal-form">
        <div class="form-group-full">
          <label class="modal-label" for="full_name">Nombre Completo <span class="required-star">*</span></label>
          <input type="text" id="full_name" class="modal-input" placeholder="Miguel Ángel Ortiz">
        </div>
        <div class="form-row">
          <div class="form-group-half">
            <label class="modal-label" for="age">Edad</label>
            <input type="text" id="age" class="modal-input" placeholder="">
          </div>
          <div class="form-group-half">
            <label class="modal-label" for="gender">Género</label>
            <select id="gender" class="modal-select">
              <option value="">Seleccionar</option>
              <option value="masculino">Masculino</option>
              <option value="femenino">Femenino</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group-half">
            <label class="modal-label" for="chronic_condition">Condición Crónica <span class="required-star">*</span></label>
            <select id="chronic_condition" class="modal-select">
              <option value="">Seleccionar</option>
              <option value="diabetes">Diabetes</option>
              <option value="hipertension">Hipertensión</option>
              <option value="renal">Enfermedad Renal</option>
            </select>
          </div>
          <div class="form-group-half">
            <label class="modal-label" for="status">Estado</label>
            <select id="status" class="modal-select">
              <option value="estable">Estable</option>
              <option value="tratamiento">En Tratamiento</option>
              <option value="critico">Crítico</option>
              <option value="observacion">En Observación</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group-half">
            <label class="modal-label" for="phone">Teléfono</label>
            <input type="text" id="phone" class="modal-input" placeholder="">
          </div>
          <div class="form-group-half">
            <label class="modal-label" for="email">Correo</label>
            <input type="email" id="email" class="modal-input" placeholder="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group-half">
            <label class="modal-label" for="last_visit">ÚLTIMA VISITA</label>
            <input type="date" id="last_visit" class="modal-input modal-input-date" placeholder="dd/mm/aaaa">
          </div>
          <div class="form-group-half">
            <label class="modal-label" for="next_appointment">PRÓXIMA CITA</label>
            <input type="date" id="next_appointment" class="modal-input modal-input-date" placeholder="dd/mm/aaaa">
          </div>
        </div>
        <div class="form-group-full">
          <label class="modal-label" for="notes">Notas</label>
          <textarea id="notes" class="modal-textarea" placeholder=""></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button id="cancelModalBtn" class="cancel-modal-btn">Cancelar</button>
        <button id="createPatientBtn" class="create-patient-modal-btn">Crear Paciente</button>
      </div>
    </div>
  </div>

  <script>
    const addPatientBtn = document.getElementById('addPatientBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalIcon = document.getElementById('closeModalIcon');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const createPatientBtn = document.getElementById('createPatientBtn');

    // Add function to toggle modal
    function toggleModal() {
      modalOverlay.classList.toggle('hidden');
    }

    // Event listeners
    addPatientBtn.addEventListener('click', toggleModal);
    closeModalIcon.addEventListener('click', toggleModal);
    cancelModalBtn.addEventListener('click', toggleModal);
    createPatientBtn.addEventListener('click', toggleModal); // Just close for demonstration

    // Close modal if clicking outside the card
    modalOverlay.addEventListener('click', (event) => {
      if (event.target === modalOverlay) {
        toggleModal();
      }
    });

  </script>
</body>
</html>