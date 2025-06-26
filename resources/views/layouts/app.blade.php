<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'expenses') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js-->
    <script src="//unpkg.com/alpinejs" defer></script>

    @isset($head)
        {{ $head }}
    @endisset

    <x-google-analytics-head />
</head>

<body class="font-sans antialiased bg-blue-200 min-h-screen">
    <x-google-analytics-body />

    <div class="pt-16 bg-blue-200">
        @if (Route::currentRouteName() !== 'welcome')
            @include('layouts.navigation')
        @endif

        <div id="message-alert"
            class="fixed inset-x-2 bottom-5 right-2 left-2 sm:inset-x-0 sm:right-5 sm:left-auto z-50 transition-all ease-in-out duration-300 message-alert">
            <!-- Message Alert -->
            @if (session()->has('response'))
                @php
                    $message = session()->get('response') ?? [];
                    $status = match ($message['status'] ?? 'info') {
                        'success' => 'green',
                        'error' => 'red',
                        'warning' => 'yellow',
                        'info' => 'blue',
                        default => 'gray',
                    };
                @endphp

                <div class="bg-{{ $status }}-100 border border-{{ $status }}-400 text-{{ $status }}-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                    role="alert">
                    <span class="block sm:inline">{{ $message['message'] }}</span>
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                        role="alert">
                        <span class="block sm:inline">{{ $error }}</span>
                    </div>
                @endforeach
            @endif
        </div>

        @isset($header)
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 py-4 sm:py-6 w-full sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="px-4 sm:px-6 lg:px-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
