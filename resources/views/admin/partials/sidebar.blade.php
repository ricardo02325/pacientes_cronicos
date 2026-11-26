<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="logo-text">
            <h2>CroniCare</h2>
            <p>Gestión Clínica</p>
        </div>
    </div>

    <div class="sidebar-user-pill">
        <div class="user-avatar-mini">
            {{ strtoupper(substr(auth()->user()->primer_nombre ?? 'A', 0, 1)) }}
        </div>
        <div class="user-meta-mini">
            <span class="user-name-mini">{{ auth()->user()->nombre_completo ?? 'Administrador' }}</span>
            <span class="user-role-mini">Administrador</span>
        </div>
    </div>

    <nav class="nav-menu">
        <div class="nav-section-title">PRINCIPAL</div>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.pacientes') }}"
            class="nav-item {{ request()->routeIs('admin.pacientes*') ? 'active' : '' }}">
            <i class="fa-solid fa-hospital-user"></i>
            <span>Pacientes</span>
        </a>

        <a href="{{ route('admin.medicos') }}"
            class="nav-item {{ request()->routeIs('admin.medicos*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-doctor"></i>
            <span>Médicos</span>
        </a>

        <div class="nav-section-title" style="margin-top: 18px;">SESIÓN</div>

        <a href="{{ route('logout') }}" class="nav-item logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Cerrar Sesión</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <div class="sidebar-footer">
        <span class="version-badge">v2.0 • Tesis</span>
    </div>
</aside>