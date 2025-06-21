<x-app-layout>
    <x-slot name="title">
        {{ __('Create Currency') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto sm:px-4">
            <x-bread-crumb-navigation />

            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <form action="{{ route('currencies.store') }}" method="POST">
                    @csrf

                    <!-- Currency Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Currency Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Currency Code -->
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-semibold text-gray-700">Currency Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('code')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Currency Symbol -->
                    <div class="mb-4">
                        <label for="symbol" class="block text-sm font-semibold text-gray-700">Currency Symbol</label>
                        <input type="text" name="symbol" id="symbol" value="{{ old('symbol') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('symbol')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Create Currency
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
