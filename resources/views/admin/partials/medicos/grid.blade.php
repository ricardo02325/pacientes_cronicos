<div class="medicos-container-wrapper">
    <!-- Toolbar de filtros -->
    <div class="table-toolbar" style="border-radius: 16px 16px 0 0; margin-bottom: 20px; border: 1px solid var(--border-color); background: #ffffff;">
        <div class="filter-pills-group">
            <a href="{{ route('admin.medicos', request()->only('buscar')) }}" 
               class="filter-pill {{ !request('turno') && !request('estado') ? 'active' : '' }}">
                Todos los Médicos
            </a>
            <a href="{{ route('admin.medicos', array_merge(request()->only('buscar'), ['turno' => 'Matutino'])) }}" 
               class="filter-pill {{ request('turno') == 'Matutino' ? 'active' : '' }}">
                <i class="fa-solid fa-sun" style="color: #f59e0b;"></i> Matutino
            </a>
            <a href="{{ route('admin.medicos', array_merge(request()->only('buscar'), ['turno' => 'Vespertino'])) }}" 
               class="filter-pill {{ request('turno') == 'Vespertino' ? 'active' : '' }}">
                <i class="fa-solid fa-cloud-sun" style="color: #7e22ce;"></i> Vespertino
            </a>
            <a href="{{ route('admin.medicos', array_merge(request()->only('buscar'), ['turno' => 'Nocturno'])) }}" 
               class="filter-pill {{ request('turno') == 'Nocturno' ? 'active' : '' }}">
                <i class="fa-solid fa-moon" style="color: #0284c7;"></i> Nocturno
            </a>
            <a href="{{ route('admin.medicos', array_merge(request()->only('buscar'), ['estado' => 'Inactivo'])) }}" 
               class="filter-pill pill-muted {{ request('estado') == 'Inactivo' ? 'active' : '' }}">
                Inactivos
            </a>
        </div>

        <div class="table-count-label">
            Mostrando <strong>{{ $medicos->count() }}</strong> profesionales
        </div>
    </div>

    <!-- Grid de Médicos -->
    <div class="doctors-grid-modern">
        @include('admin.partials.medicos.card')
    </div>

    @if($medicos->hasPages())
        <div class="pagination-container">
            {{ $medicos->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>