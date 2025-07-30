<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12 px-6">
        <div
            class="max-w-md w-full bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 flex flex-col items-center text-center border border-gray-100 dark:border-gray-800">
            <div
                class="flex items-center justify-center w-20 h-20 rounded-full bg-purple-100 dark:bg-purple-900 mb-6 shadow">
                <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                    viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="22" stroke-width="2"
                        class="text-purple-200 dark:text-purple-800" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M24 16v8m0 8h.01" />
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold text-purple-700 dark:text-purple-300 mb-2">403 Forbidden</h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                {{ $exception->getMessage() ?: __('You do not have permission to access this page.') }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                If you believe this is a mistake, please <a href="mailto:contact@duodev.in" class="text-purple-600 dark:text-purple-400 hover:underline">contact support</a> for assistance.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 w-full">
                <a href="{{ auth()->check() && auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-700 transition focus:outline-none focus:ring-2 focus:ring-purple-400 w-full">
                    Go to Dashboard
                </a>
                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transition focus:outline-none focus:ring-2 focus:ring-purple-400 w-full">
                    Go to Home
                </a>
            </div>
            <div class="mt-6">
                <a href="{{ request()->headers->get('referer') && !str_contains(request()->headers->get('referer'), '/ajax') ? request()->headers->get('referer') : url('/') }}"
                    class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                    &larr; Go Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
