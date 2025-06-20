<div class="mb-6">
    <nav class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md" aria-label="Breadcrumb">
        <!-- Breadcrumb for all devices -->
        <ol class="inline-flex items-center space-x-2 flex">
            <li>
                <a href="{{ route('dashboard') }}" class="font-medium text-blue-800 hover:text-blue-900">
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
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    @if ($index !== count($segments) - 1)
                        <a href="{{ url($url) }}" class="font-medium text-blue-800 capitalize hover:text-blue-900">
                            {{ str_replace('-', ' ', $segment) }}
                        </a>
                    @else
                        <span class="font-semibold text-blue-900 capitalize">
                            {{ str_replace('-', ' ', $segment) }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>

        <!-- "+" icon for mobile only -->
        <div class="sm:hidden flex items-center">
            @if (count($segments) == 1 &&
                !in_array($lastSegment, ['profile', 'account-settings', 'track-buses', 'attendance', 'reports', 'balance']))
                <a href="{{ url($url . '/create') }}"
                    class="inline-flex items-center justify-center w-10 h-10 text-white bg-green-600 rounded-full shadow-md hover:bg-green-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Show "Create" Button Only on Index Pages (desktop/tablet) -->
        @if (count($segments) == 1 &&
                !in_array($lastSegment, ['profile', 'account-settings', 'track-buses', 'attendance', 'reports']))
            <div class="hidden sm:flex space-x-2">
                <a href="{{ url($url . '/create') }}"
                    class="px-5 py-2 text-sm text-white transition duration-300 bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                    Create {{ ucfirst(str_replace('-', ' ', $lastSegment)) }}
                </a>
            </div>
        @endif

    </nav>
</div>