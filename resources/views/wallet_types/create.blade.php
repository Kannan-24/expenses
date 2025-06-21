<x-app-layout>
    <x-slot name="title">
        {{ __('Create Wallet Type') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto sm:px-4">
            <x-bread-crumb-navigation />

            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <form action="{{ route('wallet-types.store') }}" method="POST">
                    @csrf

                    <!-- Wallet Type Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Wallet Type Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="mb-4 flex items-center">
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
</x-app-layout>
