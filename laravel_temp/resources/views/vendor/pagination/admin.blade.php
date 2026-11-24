@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    $start = max(1, $current - 2);
    $end = min($last, $current + 2);
@endphp

<div class="em-pagination">

    {{-- INFORMASI JUMLAH DATA --}}
    <div class="em-pagination-info">
        Menampilkan
        <strong>{{ $paginator->firstItem() ?? 0 }}</strong>
        -
        <strong>{{ $paginator->lastItem() ?? 0 }}</strong>
        dari
        <strong>{{ $paginator->total() }}</strong>
        data
    </div>

    {{-- NAVIGASI HALAMAN --}}
    @if ($last > 1)
        <nav class="em-pagination-nav" aria-label="Navigasi halaman">

            {{-- PREVIOUS --}}
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled">
                    <i class="fa-solid fa-chevron-left"></i>
                    Previous
                </span>
            @else
                <a class="page-btn"
                   href="{{ $paginator->previousPageUrl() }}">
                    <i class="fa-solid fa-chevron-left"></i>
                    Previous
                </a>
            @endif

            {{-- HALAMAN PERTAMA --}}
            @if ($start > 1)
                <a class="page-number"
                   href="{{ $paginator->url(1) }}">1</a>

                @if ($start > 2)
                    <span class="page-dots">...</span>
                @endif
            @endif

            {{-- NOMOR HALAMAN --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span class="page-number active"
                          aria-current="page">
                        {{ $page }}
                    </span>
                @else
                    <a class="page-number"
                       href="{{ $paginator->url($page) }}">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- HALAMAN TERAKHIR --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="page-dots">...</span>
                @endif

                <a class="page-number"
                   href="{{ $paginator->url($last) }}">
                    {{ $last }}
                </a>
            @endif

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())
                <a class="page-btn"
                   href="{{ $paginator->nextPageUrl() }}">
                    Next
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="page-btn disabled">
                    Next
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif

        </nav>
    @endif

</div>
