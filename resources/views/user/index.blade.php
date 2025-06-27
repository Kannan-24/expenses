<x-app-layout>
    <x-slot name="title">
        {{ __('Users') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between"
            style="height: 88vh;">

            <!-- Breadcrumb & Create Button -->
            <div class="flex justify-between items-center mb-3">
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
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Users</span>
                        </li>
                    </ol>
                </nav>

                <!-- Create Button -->
                <a href="{{ route('user.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow">
                    <svg class="w-5 h-5 sm:w-4 sm:h-4 mr-0 sm:mr-1 sm:mr-1" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Create</span>
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" class="relative w-full sm:w-1/2 mb-4 mx-auto flex items-center">
                <!-- Lens Icon (left) -->
                <span class="absolute left-4 text-gray-500 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ..."
                    class="w-full rounded-full border border-gray-300 bg-white py-2.5 pl-14 pr-10 text-lg text-gray-900 shadow-sm focus:ring-blue-100 focus:border-blue-400"
                    id="searchInput" autocomplete="off" />
                @if (request('search'))
                    <!-- Reset (close) icon, only show if search is not empty -->
                    <a href="{{ route('user.index') }}"
                        class="absolute right-1.5 top-1.3 text-gray-400 hover:bg-gray-200 rounded-full p-1 hover:text-red-500 cursor-pointer"
                        title="Clear search">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </form>

            <!-- Scrollable Table Area -->
            <div class="overflow-auto flex-1">
                <table class="w-full text-sm text-left text-gray-700 bg-white">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="text-yellow-600 hover:underline">View</a>
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$users" />
            </div>
        </div>
    </div>
</x-app-layout>
