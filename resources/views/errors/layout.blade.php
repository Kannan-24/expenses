<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>
        @vite('resources/css/app.css')
        <!-- If not using Vite, include your Tailwind build here -->
    </head>
    <body class="bg-gradient-to-br from-purple-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center">
        <main class="w-full max-w-xl mx-auto p-8">
            <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl px-8 py-10 flex flex-col items-center text-center border border-gray-100 dark:border-gray-800">
                {{-- Icon slot for error pages --}}
                @yield('icon')
                <h1 class="text-4xl font-extrabold text-purple-700 dark:text-purple-300 mb-2">
                    @yield('code')
                </h1>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">
                    @yield('title')
                </h2>
                <div class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    @yield('message')
                </div>
                @yield('actions')
            </div>
        </main>
    </body>
</html>