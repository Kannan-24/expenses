<div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0 text-sm text-gray-600">
    <!-- Showing Info -->
    <div>
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </div>

    <!-- Pagination Controls -->
    <div class="flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded cursor-not-allowed">‹ Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1.5 bg-white border border-gray-300 rounded hover:bg-indigo-500 hover:text-white transition">
                ‹ Prev
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($paginator->links()->elements[0] as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="px-3 py-1.5 bg-indigo-600 text-white rounded shadow">{{ $page }}</span>
            @else
                <a href="{{ $url }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 rounded hover:bg-indigo-500 hover:text-white transition">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1.5 bg-white border border-gray-300 rounded hover:bg-indigo-500 hover:text-white transition">
                Next ›
            </a>
        @else
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded cursor-not-allowed">Next ›</span>
        @endif
    </div>
</div>