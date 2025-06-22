<x-app-layout>
    <x-slot name="title">
        {{ __('People List') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-8 flex flex-wrap gap-3 items-center sm:flex-row flex-col"
                    id="people-filter-form">
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name..."
                            class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition pr-10"
                            id="search-input">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-800"
                            aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto flex-col sm:flex-row">
                        <a href="{{ route('expense-people.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0 text-center">Reset</a>
                    </div>
                </form>

                <table class="w-full text-sm text-left text-gray-700 bg-white rounded-lg shadow overflow-hidden">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($people as $person)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $person->name }}</td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('expense-people.edit', $person->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('expense-people.destroy', $person->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete this person?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-400">No people found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-pagination :paginator="$people" />
            </div>
        </div>
    </div>
</x-app-layout>
