@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link paginationCheckbox" href="{{ $paginator->url(1) }}" rel="prev"
                        aria-label="@lang('pagination.previous')">回第一頁</a>
                </li>
            @endif
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">-</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link paginationCheckbox" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">往前一頁</a>
                </li>
            @endif



            @php
                $start = max($paginator->currentPage() - 5, 1);
                $end = min($paginator->currentPage() + 5, $paginator->lastPage());
            @endphp


            @if ($start > 1)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item"><a class="page-link paginationCheckbox"
                            href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- "..." for skipped pages after current window --}}
            @if ($end < $paginator->lastPage())
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif




            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link paginationCheckbox" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">往後一頁</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">-</span>
                </li>
            @endif
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link paginationCheckbox" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next"
                        aria-label="@lang('pagination.next')">最後一頁</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
