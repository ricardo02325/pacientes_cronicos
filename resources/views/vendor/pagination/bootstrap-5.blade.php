<nav class="pagination-nav" aria-label="Paginación">
    @if ($paginator->total() > 0)
        <div class="pagination-summary">
            Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} pacientes
        </div>
    @endif

    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="Página anterior">
                <span class="page-link">Anterior</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Página anterior">Anterior</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page" aria-label="Página {{ $page }}">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}" aria-label="Página {{ $page }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Página siguiente">Siguiente</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="Página siguiente">
                <span class="page-link">Siguiente</span>
            </li>
        @endif
    </ul>
</nav>
