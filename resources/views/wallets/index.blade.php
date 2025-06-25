<x-app-layout>
    <x-slot name="title">
        {{ __('Wallets') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between"
            style="height: 88vh;">

            <!-- Breadcrumb & Create Button -->
            <div class="flex justify-between items-center mb-3">
                <x-bread-crumb-navigation />

                <!-- Create Button -->
                <a href="{{ route('wallets.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" class="mb-5 flex flex-wrap gap-3 items-end" id="wallet-filter-form">
                <!-- Search -->
                <div class="relative flex-1 min-w-[180px]">
                    <label class="text-sm text-gray-600 block mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search wallets..."
                        class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 pr-10 h-10" />
                    <button type="submit" class="absolute right-3 top-11 -translate-y-1/2 text-blue-600 hover:text-blue-800"
                        aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </button>
                </div>

                <!-- Filter Button -->
                <div class="flex flex-col justify-end">
                    <label class="text-sm text-transparent block mb-1">Filter</label>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm w-full h-10 min-w-[80px]">
                        Filter
                    </button>
                </div>

                <!-- Reset Button -->
                <div class="flex flex-col justify-end">
                    <label class="text-sm text-transparent block mb-1">Reset</label>
                    <a href="{{ route('wallets.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm w-full text-center h-10 flex items-center justify-center min-w-[80px]">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Scrollable Table Area -->
            <div class="overflow-auto flex-1">
                <table class="w-full text-sm text-left text-gray-700 bg-white">
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
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$wallets" />
            </div>
        </div>
    </div>
</x-app-layout>
