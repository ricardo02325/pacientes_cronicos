<div class="controls-bar">
    <div class="filter-pills">
        <h2>Listado de Pacientes</h2>
        <a href="?riesgo=todos" class="pill {{ request('riesgo', 'todos') == 'todos' ? 'active' : '' }}">Todos</a>
        <a href="?riesgo=bajo" class="pill {{ request('riesgo') == 'bajo' ? 'active' : '' }}">Riesgo Bajo</a>
        <a href="?riesgo=medio" class="pill {{ request('riesgo') == 'medio' ? 'active' : '' }}">Riesgo Medio</a>
        <a href="?riesgo=alto" class="pill {{ request('riesgo') == 'alto' ? 'active' : '' }}">Riesgo Alto</a>
    </div>

    <form method="GET" action="" class="search-box">
        <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="buscar" class="search-input" placeholder="Buscar paciente..." value="{{ request('buscar') }}">
        </div>
        <button type="submit" class="btn-search">Buscar</button>
    </form>
</div>