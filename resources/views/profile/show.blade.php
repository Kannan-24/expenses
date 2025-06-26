<x-app-layout>
    <x-slot name="title">
        {{ __('Profile') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full h-auto mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col">
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
                            <span class="text-gray-700">Profile</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <hr class="p-2 border-t border-gray-400">

            <!-- Profile Details -->
            <div class="flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Profile Details :</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Name</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $user->name }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Email</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Phone</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm font-bold text-gray-900">Address</span>
                        <span class="mx-1">:</span>
                        <span class="text-base text-gray-600">{{ $user->address ?? '-' }}</span>
                    </div>
                </div>

                <hr class="my-2 border-t border-gray-400">

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('profile.edit') }}"
                        class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded hover:bg-indigo-700 transition">
                        Edit
                    </a>
                    <a href="{{ route('account.settings') }}"
                        class="px-4 py-2 text-sm font-semibold text-blue-600 bg-gray-100 rounded hover:bg-gray-200 transition">
                        Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
