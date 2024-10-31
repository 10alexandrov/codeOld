@if ($paginator->hasPages())
    <nav aria-label="Minimal Pagination" class="d-flex justify-content-center align-items-center my-3">
        <ul class="pagination mb-0">
            {{-- First Page Link --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">&lsaquo;&lsaquo;</a>
            </li>

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Current Page Indicator --}}
            <li class="page-item disabled mx-3">
                <span class="page-link bg-light border-0 text-muted current-page">
                    {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
                </span>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" aria-label="@lang('pagination.next')">
                        &rsaquo;
                    </span>
                </li>
            @endif

            {{-- Last Page Link --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">&rsaquo;&rsaquo;</a>
            </li>
        </ul>
    </nav>
@endif
