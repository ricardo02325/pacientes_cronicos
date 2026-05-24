<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background: #f1f5f9; color: #64748b;"><i class="fa-solid fa-user-group"></i></div>
        <p>Total de Pacientes</p>
        <h3>{{ $stats['total'] }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: var(--riesgo-bajo-bg); color: var(--riesgo-bajo-text);"><i class="fa-regular fa-circle-check"></i></div>
        <p>Riesgo Bajo</p>
        <h3>{{ $stats['bajo'] }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: var(--riesgo-medio-bg); color: var(--riesgo-medio-text);"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <p>Riesgo Medio</p>
        <h3>{{ $stats['medio'] }}</h3>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: var(--riesgo-alto-bg); color: var(--riesgo-alto-text);"><i class="fa-solid fa-circle-exclamation"></i></div>
        <p>Riesgo Alto</p>
        <h3>{{ $stats['alto'] }}</h3>
    </div>
    </div>