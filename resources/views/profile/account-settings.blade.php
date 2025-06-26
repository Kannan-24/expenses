<x-app-layout>
    <x-slot name="title">
        {{ __('Account Settings') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col" style="min-height: 88vh;">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-4">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Account Settings</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Update Password Form -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Update Password Form -->
                <div class="p-1 sm:p-8 w-full md:w-1/2">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Separation Line -->
                <div class="flex md:hidden items-center">
                    <div class="w-full h-px bg-gray-200 my-4"></div>
                </div>
                <div class="hidden md:flex items-center">
                    <div class="w-px h-full bg-gray-200"></div>
                </div>

                <!-- Delete User Form -->
                <div class="p-1 sm:p-8 w-full md:w-1/2">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
