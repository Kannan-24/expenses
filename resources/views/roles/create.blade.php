<x-app-layout>
    <x-slot name="title">
        {{ __('Create Role') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="bg-white p-6 rounded-2xl shadow flex flex-col"
        style="height: auto; overflow: auto;">
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
                        <a href="{{ route('roles.index') }}" class="inline-flex items-center hover:text-blue-600">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            Roles
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-700">Create Role</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Form -->
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <!-- Role Name -->
            <div class="mb-5 mt-3">
                <label for="name" class="block text-sm font-semibold text-gray-700">Role Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required maxlength="255">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Permissions -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Permissions</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach ($permissions as $permission)
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
                <x-primary-button>
                    {{ __('Create Role') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    
</x-app-layout>
