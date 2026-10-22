<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="logo-text">
            <h2>CroniCare</h2>
            <p>Portal Médico</p>
        </div>
    </div>

    <!-- Mini Perfil del Médico -->
    <div class="sidebar-user-pill">
        <div class="user-avatar-mini">
            {{ strtoupper(substr(auth()->user()->primer_nombre ?? 'M', 0, 1)) }}
        </div>
        <div class="user-meta-mini">
            <span class="user-name-mini">Dr(a). {{ auth()->user()->nombre_completo ?? 'Médico' }}</span>
            <span class="user-role-mini">{{ auth()->user()->medico->especialidad ?? 'Especialista' }}</span>
        </div>
    </div>

    <nav class="nav-menu">
        <div class="nav-section-title">CONSULTORIO</div>

        <a href="{{ route('medico.pacientes.index') }}" 
           class="nav-item {{ request()->routeIs('medico.pacientes*') ? 'active' : '' }}">
            <i class="fa-solid fa-hospital-user"></i>
            <span>Mis Pacientes</span>
        </a>

        <a href="{{ route('medico.reportes') }}" 
           class="nav-item {{ request()->routeIs('medico.reportes') ? 'active' : '' }}">
            <i class="fa-solid fa-file-waveform"></i>
            <span>Reportes Clínicos</span>
        </a>

        <div class="nav-section-title" style="margin-top: 18px;">SESIÓN</div>

        <a href="{{ route('logout') }}" class="nav-item logout"
            onclick="event.preventDefault(); document.getElementById('logout-form-medico').submit();">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Cerrar Sesión</span>
        </a>

        <form id="logout-form-medico" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <div class="sidebar-footer">
        <span class="version-badge">v2.0 • Módulo Clínico</span>
    </div>
</aside>