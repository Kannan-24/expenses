<x-app-layout>
    <x-slot name="title">
        {{ __('Borrows & Lends Management') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-indigo-600 via-blue-700 to-blue-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Borrow & Lend Management</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Borrows</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Total Records</p>
                                <p class="text-2xl font-bold text-white">{{ $borrows->total() }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Current Date</p>
                                <p class="text-lg font-bold text-white">{{ now()->format('M d, Y') }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <a href="{{ route('borrows.create') }}"
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-white dark:bg-gray-100 text-indigo-700 dark:text-blue-800 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="hidden sm:inline">Add Borrow/Lend</span>
                                <span class="sm:hidden">Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6" x-data="{ showAdvanced: false }">
                <form method="GET" class="space-y-4" id="form-filter">
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by person, wallet, or amount..."
                               class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               autocomplete="off" />
                        @php
                            $hasFilters = request('search') || request('type') || request('status') || request('wallet') || request('person');
                        @endphp
                        @if($hasFilters)
                            <a href="{{ route('borrows.index') }}"
                               class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="document.querySelector('select[name=type]').value='lent'; document.getElementById('form-filter').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('type') == 'lent' ? 'bg-green-600 text-white border-green-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Lent
                            </button>
                            <button type="button" @click="document.querySelector('select[name=type]').value='borrowed'; document.getElementById('form-filter').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('type') == 'borrowed' ? 'bg-red-600 text-white border-red-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Borrowed
                            </button>
                        </div>
                        <button type="button" @click="showAdvanced = !showAdvanced"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                            Advanced Filters
                            <svg x-show="!showAdvanced" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <svg x-show="showAdvanced" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                    </div>
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <select name="type" class="hidden">
                            <option value="">All</option>
                            <option value="lent" {{ request('type') == 'lent' ? 'selected' : '' }}>Lent</option>
                            <option value="borrowed" {{ request('type') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        </select>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wallet</label>
                            <select name="wallet"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Wallets</option>
                                @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" {{ request('wallet') == $wallet->id ? 'selected' : '' }}>
                                        {{ $wallet->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Person</label>
                            <select name="person"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All People</option>
                                @foreach ($people as $person)
                                    <option value="{{ $person->id }}" {{ request('person') == $person->id ? 'selected' : '' }}>
                                        {{ $person->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col items-end sm:flex-row gap-2">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Apply Filters
                            </button>
                            <a href="{{ route('borrows.index') }}"
                               class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-lg text-center transition-colors">
                                Reset
                            </a>
                        </div>
                    </div>
                    @if(request('search') || $hasFilters)
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if(request('search'))
                                    Showing results for "<span class="font-semibold text-blue-600 dark:text-blue-400">{{ request('search') }}</span>"
                                    <span class="mx-2">•</span>
                                @endif
                                {{ $borrows->total() }} {{ Str::plural('record', $borrows->total()) }} found
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Table/Card Content -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Person</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Wallet</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Returned</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($borrows as $borrow)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">{{ $loop->iteration + ($borrows->currentPage() - 1) * $borrows->perPage() }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrow->date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">{{ $borrow->person->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $borrow->borrow_type === 'lent' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                            {{ ucfirst($borrow->borrow_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $borrow->wallet->name ?? '-' }}</td>
                                    <td class="px-6 py-4 font-semibold">
                                        {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->returned_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($borrow->status === 'returned') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @elseif($borrow->status === 'partial') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                                            {{ ucfirst($borrow->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('borrows.show', $borrow->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 text-xs font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors">
                                                View
                                            </a>
                                            <a href="{{ route('borrows.edit', $borrow->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this borrow?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 text-xs font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        No borrows/lends found.
                                        <a href="{{ route('borrows.create') }}" class="text-blue-600 dark:text-blue-400">Add one now</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($borrows as $borrow)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $borrow->person->name ?? '-' }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">#{{ $borrow->id }} • {{ ucfirst($borrow->borrow_type) }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $borrow->borrow_type === 'lent' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    {{ ucfirst($borrow->borrow_type) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Amount</p>
                                    <p class="font-bold text-xl text-blue-600 dark:text-blue-400">{{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($borrow->date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($borrow->status === 'returned') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($borrow->status === 'partial') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                                    {{ ucfirst($borrow->status) }}
                                </span>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('borrows.show', $borrow->id) }}" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 text-sm font-medium">View</a>
                                    <a href="{{ route('borrows.edit', $borrow->id) }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">Edit</a>
                                    <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this borrow?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 dark:text-red-400 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No borrows/lends found</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first borrow/lend.</p>
                                <a href="{{ route('borrows.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Borrow/Lend
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Pagination -->
            @if($borrows->hasPages())
                <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $borrows->firstItem() }} to {{ $borrows->lastItem() }} of {{ $borrows->total() }} records
                        </div>
                        <div>
                            <x-pagination :paginator="$borrows" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>