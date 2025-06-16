<div class="mb-6">
    <nav class="flex flex-row items-center justify-between p-4 bg-white rounded-lg shadow-md" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center max-w-full overflow-x-auto space-x-0 sm:space-x-2 scrollbar-thin scrollbar-thumb-gray-300">
            <li class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="font-medium text-blue-800 hover:text-blue-900 text-base lg:text-lg">
                    Dashboard
                </a>
            </li>
            @php
                $segments = request()->segments();
                $url = '';
                $lastSegment = end($segments);
            @endphp
            @foreach ($segments as $index => $segment)
                @php
                    $url .= '/' . $segment;
                @endphp
                <li class="flex items-center flex-shrink-0">
                    <svg class="w-4 h-4 mx-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    @if ($index !== count($segments) - 1)
                        <a href="{{ url($url) }}" class="font-medium text-blue-800 capitalize hover:text-blue-900 text-base lg:text-lg">
                            {{ str_replace('-', ' ', $segment) }}
                        </a>
                    @else
                        <span class="font-semibold text-blue-900 capitalize text-base lg:text-lg">
                            {{ str_replace('-', ' ', $segment) }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>

        @if (count($segments) == 1 &&
                !in_array($lastSegment, ['profile', 'account-settings', 'track-buses', 'attendance', 'reports']))
            <div class="flex space-x-2 ml-4">
                <!-- Mobile: Show + icon -->
                <a href="{{ url($url . '/create') }}"
                    class="inline-flex items-center justify-center w-9 h-9 text-white bg-green-600 rounded-full shadow-md hover:bg-green-700 transition sm:hidden"
                    title="Create {{ ucfirst(str_replace('-', ' ', $lastSegment)) }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <!-- Desktop: Show text button -->
                <a href="{{ url($url . '/create') }}"
                    class="hidden sm:inline-flex px-4 py-2 text-sm lg:text-base text-white transition duration-300 bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                    Create {{ ucfirst(str_replace('-', ' ', $lastSegment)) }}
                </a>
            </div>
        @endif

    </nav>
</div>
