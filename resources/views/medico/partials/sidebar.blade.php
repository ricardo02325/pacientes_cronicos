<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="logo-text">
            <h2>CróniCare</h2>
            <p>Panel Médico</p>
        </div>
    </div>

    <nav class="nav-menu">
        <a href="{{ route('medico.pacientes.index') ?? '#' }}" class="nav-item {{ request()->routeIs('medico.pacientes*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Mis Pacientes
        </a>
        <a href="{{ route('medico.reportes') ?? '#' }}" class="nav-item {{ request()->routeIs('medico.reportes') ? 'active' : '' }}">
            <i class="fa-solid fa-file-waveform"></i> Reportes
        </a>
        <a href="#" class="nav-item logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
        </a>
    </nav>
</aside>