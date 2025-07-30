<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name').' Error')</title>
        @vite('resources/css/app.css')
        <!-- If not using Vite, include your Tailwind build here -->
    </head>
    <body class="antialiased bg-gradient-to-br from-purple-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center">
        <main class="w-full max-w-lg mx-auto px-4 py-12">
            <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 flex flex-col items-center text-center border border-gray-100 dark:border-gray-800">
                <div class="mb-6">
                    @yield('icon')
                </div>
                <div class="flex flex-col items-center mb-2">
                    <span class="text-5xl font-extrabold text-purple-700 dark:text-purple-300 tracking-wide">
                        @yield('code')
                    </span>
                    <span class="mt-2 text-xl font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
                        @yield('title')
                    </span>
                </div>
                <div class="mt-4 text-base text-gray-600 dark:text-gray-300 leading-relaxed">
                    @yield('message')
                </div>
                @yield('actions')
            </div>
        </main>
    </body>
</html>