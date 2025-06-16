<x-app-layout>
    <x-slot name="title">
        {{ __('People List') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

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
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($people as $person)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $person->name }}</td>
                                    <td class="px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('expense-people.edit', $person->id) }}"
                                            class="text-blue-400 hover:text-blue-200">Edit</a>
                                        <form action="{{ route('expense-people.destroy', $person->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Delete this person?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-400 hover:text-red-200">Delete</button>
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
                </div>
                <x-pagination :paginator="$people" />
            </div>
        </div>
    </div>
</x-app-layout>
