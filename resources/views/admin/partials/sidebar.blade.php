<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="logo-text">
            <h2>CróniCare</h2>
            <p>Panel de Admin</p>
        </div>
    </div>

    <nav class="nav-menu">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-border-all"></i> Dashboard
        </a>

        <a href="{{ route('admin.pacientes') }}"
            class="nav-item {{ request()->routeIs('admin.pacientes*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Pacientes
        </a>

        <a href="{{ route('admin.medicos') }}"
            class="nav-item {{ request()->routeIs('admin.medicos*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-doctor"></i> Médicos
        </a>

        <a href="{{ route('admin.citas') }}" class="nav-item {{ request()->routeIs('admin.citas*') ? 'active' : '' }}">
            <i class="fa-regular fa-calendar-days"></i> Citas
        </a>
        <a href="#" class="nav-item logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión
        </a>
    </nav>
</aside>