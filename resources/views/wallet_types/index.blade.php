<x-app-layout>
    <x-slot name="title">
        {{ __('Wallet Types') }} - {{ config('app.name', 'expenses') }}
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
                            <span class="text-gray-700">Wallet Types</span>
                        </li>
                    </ol>
                </nav>

                <!-- Create Button -->
                <a href="{{ route('wallet-types.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" class="mb-5 flex flex-wrap gap-3 items-end" id="wallet-type-filter-form">
                <!-- Search -->
                <div class="relative flex-1 min-w-[180px]">
                    <label class="text-sm text-gray-600 block mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search wallet types..."
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
                    <a href="{{ route('wallet-types.index') }}"
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
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2 text-center">Is Active</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($walletTypes as $walletType)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $loop->iteration + ($walletTypes->currentPage() - 1) * $walletTypes->perPage() }}
                                </td>
                                <td class="px-4 py-2">{{ $walletType->name }}</td>
                                <td class="px-4 py-2">{{ $walletType->description }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $walletType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $walletType->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('wallet-types.edit', $walletType) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('wallet-types.destroy', $walletType) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">
                                    No wallet types found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$walletTypes" />
            </div>
        </div>
    </div>
</x-app-layout>
