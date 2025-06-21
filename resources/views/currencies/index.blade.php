<x-app-layout>
    <x-slot name="title">
        {{ __('Currencies') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <!-- Filter/Search Form -->
                <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-3 items-stretch sm:items-center">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search currencies..."
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
                            href="{{ route('currencies.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm w-full sm:w-auto text-center transition"
                        >
                            Reset
                        </a>
                    </div>
                </form>

                <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Code</th>
                                <th class="px-4 py-2">Symbol</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($currencies as $currency)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $currency->name }}</td>
                                    <td class="px-4 py-2">{{ $currency->code }}</td>
                                    <td class="px-4 py-2">{{ $currency->symbol }}</td>
                                    <td class="px-4 py-2 text-center space-x-2">
                                        <a href="{{ route('currencies.edit', $currency) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('currencies.destroy', $currency) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Are you sure you want to delete this?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-400 hover:text-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-400">No currencies found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-pagination :paginator="$currencies" />
            </div>
        </div>
    </div>
</x-app-layout>
