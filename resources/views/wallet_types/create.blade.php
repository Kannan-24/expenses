<x-app-layout>
    <x-slot name="title">
        {{ __('Create Wallet Type') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col"
            style="height: 88vh;">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-4">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('wallet-types.index') }}"
                                class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                </svg>
                                Wallet Types
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Create Wallet Type</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <hr class="p-2 border-t border-gray-400">

            <!-- Form -->
            <div class="flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Create Wallet Type :</h2>
                <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <form action="{{ route('wallet-types.store') }}" method="POST">
                        @csrf

                        <!-- Wallet Type Name -->
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Wallet Type Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            @error('name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-5">
                            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="mb-5 flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="mr-2" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="text-sm font-semibold text-gray-700">Active</label>
                            @error('is_active')
                                <span class="text-sm text-red-600 ml-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                                Create Wallet Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
