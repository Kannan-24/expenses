<x-app-layout>
    <x-slot name="title">
        {{ __('Wallets') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-4 flex flex-wrap gap-3 items-center sm:flex-row flex-col" id="wallet-filter-form">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search wallets..."
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
                            href="{{ route('wallets.index') }}"
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
                            <th class="px-4 py-2">Wallet Type</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Currency</th>
                            <th class="px-4 py-2">Balance</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wallets as $wallet)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $loop->iteration + ($wallets->currentPage() - 1) * $wallets->perPage() }}
                                </td>
                                <td class="px-4 py-2">{{ $wallet->walletType->name }}</td>
                                <td class="px-4 py-2">{{ $wallet->name }}</td>
                                <td class="px-4 py-2">{{ $wallet->currency->code }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $wallet->balance >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $wallet->currency->symbol }} {{ number_format($wallet->balance, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $wallet->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $wallet->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('wallets.show', $wallet) }}"
                                        class="text-indigo-600 hover:underline">View</a>
                                    <a href="{{ route('wallets.edit', $wallet) }}"
                                        class="text-emerald-600 hover:underline">Edit</a>
                                    <form action="{{ route('wallets.destroy', $wallet) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-400">No wallets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-pagination :paginator="$wallets" />
            </div>
        </div>
    </div>
</x-app-layout>
