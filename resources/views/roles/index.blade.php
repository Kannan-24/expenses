<x-app-layout>
    <x-slot name="title">
        {{ __('Roles') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Gaurd</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr class="border-b border-gray-600 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $role->name }}</td>
                                    <td class="px-4 py-2">{{ $role->guard_name }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex flex-col gap-3 sm:flex-row">
                                            <a href="{{ route('roles.show', $role) }}" aria-label="View Role">
                                                <button
                                                    class="px-4 py-2 text-sm text-white transition-all duration-300 bg-indigo-500 rounded-lg hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-700 hover:shadow-lg focus:ring-2 focus:ring-indigo-300">
                                                    View
                                                </button>
                                            </a>
                                            <a href="{{ route('roles.edit', $role) }}" aria-label="Edit Role">
                                                <button
                                                    class="px-4 py-2 text-sm text-white transition-all duration-300 rounded-lg bg-emerald-500 hover:bg-gradient-to-r hover:from-emerald-500 hover:to-emerald-700 hover:shadow-lg focus:ring-2 focus:ring-emerald-300">
                                                    Edit
                                                </button>
                                            </a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm text-white transition-all duration-300 rounded-lg bg-rose-500 hover:bg-gradient-to-r hover:from-rose-500 hover:to-rose-700 hover:shadow-lg focus:ring-2 focus:ring-rose-300"
                                                    onclick="return confirm('Are you sure you want to delete this?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b border-gray-600">
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-400">
                                        No roles found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-pagination :paginator="$roles" />
            </div>
        </div>
    </div>

</x-app-layout>
