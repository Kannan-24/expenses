<div class="mb-6">
    <nav class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard') }}" class="font-medium text-blue-800 hover:text-blue-900">
                    Dashboard
                </a>
            </li>
            @php
                $segments = request()->segments(); // Get URL segments
                $url = '';
                $lastSegment = end($segments); // Get last segment
            @endphp
            @foreach ($segments as $index => $segment)
                @php
                    $url .= '/' . $segment; // Build dynamic URL
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

        <!-- Show "Create" and "Import" Buttons Only on Index Pages -->
        @if (count($segments) == 1 &&
                !in_array($lastSegment, ['profile', 'account-settings', 'track-buses', 'attendance', 'reports']))
            <div class="flex space-x-2">
                <a href="{{ url($url . '/create') }}"
                    class="px-5 py-2 text-sm text-white transition duration-300 bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                    Create {{ ucfirst(str_replace('-', ' ', $lastSegment)) }}
                </a>
            </div>
        @endif

    </nav>
</div>
