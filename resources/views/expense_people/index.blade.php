<x-app-layout>
    <x-slot name="title">
        {{ __('Person List') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-3 items-stretch sm:items-center" id="people-filter-form">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by name..."
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-900 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                    </div>
                    <div class="flex flex-row gap-2 sm:gap-3">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto transition"
                        >
                            Search
                        </button>
                        <a
                            href="{{ route('expense-people.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm w-full sm:w-auto text-center transition"
                        >
                            Reset
                        </a>
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
