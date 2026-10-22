<div class="dashboard-stats-strip">
    <div class="dash-stat-card">
        <div class="dash-stat-top">
            <span class="dash-stat-title">Pacientes Totales</span>
            <div class="dash-stat-icon icon-blue">
                <i class="fa-solid fa-hospital-user"></i>
            </div>
        </div>
        <div class="dash-stat-main">
            <h2 class="dash-stat-val">{{ $totalPacientes ?? 0 }}</h2>
            <span class="dash-stat-badge bg-blue-subtle">
                <i class="fa-solid fa-folder-open"></i> Activos en sistema
            </span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-top">
            <span class="dash-stat-title">Casos Críticos (Alto Riesgo)</span>
            <div class="dash-stat-icon icon-red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>
        <div class="dash-stat-main">
            <h2 class="dash-stat-val text-red">{{ $riesgoAlto ?? 0 }}</h2>
            <span class="dash-stat-badge bg-red-subtle">
                <span class="dot-pulse"></span> Atención prioritaria
            </span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-top">
            <span class="dash-stat-title">Pacientes Estables</span>
            <div class="dash-stat-icon icon-green">
                <i class="fa-solid fa-heart-circle-check"></i>
            </div>
        </div>
        <div class="dash-stat-main">
            <h2 class="dash-stat-val text-green">{{ $pacientesEstables ?? 0 }}</h2>
            <span class="dash-stat-badge bg-green-subtle">
                <i class="fa-regular fa-circle-check"></i> Riesgo bajo
            </span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-top">
            <span class="dash-stat-title">Cuerpo Médico</span>
            <div class="dash-stat-icon icon-purple">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
        <div class="dash-stat-main">
            <h2 class="dash-stat-val" style="color: #7e22ce;">{{ $totalMedicos ?? 0 }}</h2>
            <span class="dash-stat-badge" style="background: #f3e8ff; color: #7e22ce;">
                <i class="fa-solid fa-stethoscope"></i> Especialistas
            </span>
        </div>
    </div>
</div>
