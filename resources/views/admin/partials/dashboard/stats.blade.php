<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Pacientes</h3>

            <div class="number">
                {{ $totalPacientes }}
            </div>

            <p>Registrados</p>
        </div>
        <div class="stat-icon icon-blue">
            <i class="fa-solid fa-user-group"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Críticos</h3>

            <div class="number">
                {{ $riesgoAlto }}
            </div>

            <p>Requieren atención</p>
        </div>

        <div class="stat-icon icon-red">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Riesgo Bajo</h3>

            <div class="number">
                {{ $pacientesEstables }}
            </div>

            <p>Pacientes estables</p>
        </div>

        <div class="stat-icon icon-green">
            <i class="fa-solid fa-heart-pulse"></i>
        </div>
    </div>
</div>
