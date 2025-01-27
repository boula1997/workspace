@if ($paginator->hasPages())
<nav class="navigation" aria-label="Page navigation">
    <ul class="pagination mt-5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link  arrow text" aria-label="Previous"><span aria-hidden="true">&laquo;</span></span></li>
        @else
            <li class="page-item"><a class="page-link  arrow" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
        @endif
 
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif
 
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span  class="page-link bg-info border-info">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
 
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link arrow" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
        @else
            <li class="page-item disabled"><span class="page-link arrow" aria-label="Next"><span aria-hidden="true">&raquo;</span></span></li>
        @endif
    </ul>
</nav>
@endif
