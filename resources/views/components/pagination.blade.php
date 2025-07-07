<div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0 text-sm text-gray-600 dark:text-gray-300">
    <!-- Showing Info -->
    <div>
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </div>

    <!-- Pagination Controls -->
    <div class="flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 rounded cursor-not-allowed">‹ Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600 transition">
                ‹ Prev
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($paginator->links()->elements[0] as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="px-3 py-1.5 bg-indigo-600 text-white rounded shadow">{{ $page }}</span>
            @else
                <a href="{{ $url }}"
                   class="px-3 py-1.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600 transition">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600 transition">
                Next ›
            </a>
        @else
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 rounded cursor-not-allowed">Next ›</span>
        @endif
    </div>
</div>
