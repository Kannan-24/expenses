<div class="flex flex-col justify-between mt-4">
    <!-- Showing Results -->
    @if ($paginator->total() > 0)
        <div class="text-sm text-gray-600 items-center flex justify-center mb-2">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    @endif

    <div class="flex items-center justify-between space-x-2">
        <!-- Previous Button -->
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">‹ Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition">
                ‹ Prev
            </a>
        @endif

        <!-- Page Numbers -->
        <div class="flex space-x-1">
            @foreach ($paginator->links()->elements[0] as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2 text-white bg-indigo-600 rounded-lg shadow-md">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Next Button -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-indigo-500 hover:text-white transition">
                Next ›
            </a>
        @else
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next ›</span>
        @endif
    </div>
</div>
