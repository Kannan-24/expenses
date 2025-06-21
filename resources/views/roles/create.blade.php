<x-app-layout>
    <x-slot name="title">
        {{ __('Create Role') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto sm:px-4">
            <x-bread-crumb-navigation />

            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Role Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Permissions -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Permissions</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($permissions as $permission)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <span>{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('permissions')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
