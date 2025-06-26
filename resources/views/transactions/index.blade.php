<x-app-layout>
    <x-slot name="title">
        {{ __('Transactions') }} - {{ config('app.name', 'transactions') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between" style="height: 88vh;">

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
                            <span class="text-gray-700">Transactions</span>
                        </li>
                    </ol>
                </nav>

                <!-- Create Button -->
                <a href="{{ route('transactions.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
            </div>

            <!-- Alpine Wrapper -->
            <div>
                <form method="GET" class="relative w-full sm:w-1/2 mb-4 mx-auto flex items-center" x-data="{ showModal: false }">
                    <!-- Lens Icon (left) -->
                    <span class="absolute left-4 text-gray-500 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ..."
                        class="w-full rounded-full border border-gray-300 bg-white py-2.5 pl-12 pr-10 text-l text-gray-900 shadow-sm focus:ring-blue-100 focus:border-blue-400"
                        id="searchInput" autocomplete="off" />
                    <!-- Show X mark if any filter/search is applied -->
                    @php
                        $hasFilters = request('search') || request('filter') || request('start_date') || request('end_date') || request('category') || request('person') || request('type');
                    @endphp
                    <a href="{{ route('transactions.index') }}"
                        class="absolute right-12 top-1.5 text-gray-400 hover:bg-gray-200 rounded-full p-1 hover:text-red-500 cursor-pointer
                        {{ $hasFilters ? '' : 'pointer-events-none opacity-50' }}"
                        title="Clear filters and search">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>

                    <!-- Advanced Search Button (right) -->
                    <div class="absolute right-1.5 top-1.5">
                        <button type="button" @click="showModal = true"
                            class="flex items-center justify-center h-9 w-9 rounded-full hover:bg-gray-200 hover:text-white transition"
                            title="Advanced Search">
                            <svg viewBox="0 0 600 600" class="h-5 w-5">
                                <g>
                                    <g>
                                        <g>
                                            <path
                                                style="color:#888888;fill:#888888;stroke-linecap:round;-inkscape-stroke:none"
                                                d="M 447.70881 -12.781343 A 42.041451 42.041451 0 0 0 405.66786 29.260344 L 405.66786 50.301721 L 27.434765 50.301721 A 42.041302 42.041302 0 0 0 -14.606185 92.341354 A 42.041302 42.041302 0 0 0 27.434765 134.38304 L 405.66786 134.38304 L 405.66786 155.44906 A 42.041451 42.041451 0 0 0 447.70881 197.49075 A 42.041451 42.041451 0 0 0 489.74976 155.44906 L 489.74976 134.38304 L 573.78036 134.38304 A 42.041302 42.041302 0 0 0 615.82336 92.341354 A 42.041302 42.041302 0 0 0 573.78036 50.301721 L 489.74976 50.301721 L 489.74976 29.260344 A 42.041451 42.041451 0 0 0 447.70881 -12.781343 z M 143.0012 197.48869 A 42.041451 42.041451 0 0 0 100.9582 239.53038 L 100.9582 260.5697 L 27.447078 260.5697 A 42.041302 42.041302 0 0 0 -14.593872 302.61139 A 42.041302 42.041302 0 0 0 27.447078 344.65308 L 100.9582 344.65308 L 100.9582 365.7191 A 42.041451 42.041451 0 0 0 143.0012 407.76078 A 42.041451 42.041451 0 0 0 185.04215 365.7191 L 185.04215 344.65308 L 573.79472 344.65308 A 42.041302 42.041302 0 0 0 615.83567 302.61139 A 42.041302 42.041302 0 0 0 573.79472 260.5697 L 185.04215 260.5697 L 185.04215 239.53038 A 42.041451 42.041451 0 0 0 143.0012 197.48869 z M 279.59427 407.76078 A 42.041451 42.041451 0 0 0 237.55332 449.80042 L 237.55332 470.83974 L 27.447078 470.83974 A 42.041302 42.041302 0 0 0 -14.593872 512.88143 A 42.041302 42.041302 0 0 0 27.447078 554.92106 L 237.55332 554.92106 L 237.55332 575.98913 A 42.041451 42.041451 0 0 0 279.59427 618.02877 A 42.041451 42.041451 0 0 0 321.63522 575.98913 L 321.63522 554.92106 L 573.79472 554.92106 A 42.041302 42.041302 0 0 0 615.83567 512.88143 A 42.041302 42.041302 0 0 0 573.79472 470.83974 L 321.63522 470.83974 L 321.63522 449.80042 A 42.041451 42.041451 0 0 0 279.59427 407.76078 z ">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </button>

                        <!-- Popup Modal (Hidden by default) -->
                        <div x-show="showModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                            @keydown.escape.window="showModal = false">

                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6"
                                @click.away="showModal = false">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Advanced Search</h2>
                                    <button @click="showModal = false" class="text-gray-600 hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Filter Form -->
                                <form method="GET" id="transaction-filter-form" class="space-y-4">
                                    <!-- Quick Filter -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Quick Filter</label>
                                        <select name="filter"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                            <option value="">All</option>
                                            <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>
                                                Last 7 Days</option>
                                            <option value="15days"
                                                {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days
                                            </option>
                                            <option value="1month"
                                                {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Start Date -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Start Date</label>
                                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500" />
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">End Date</label>
                                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500" />
                                    </div>

                                    <!-- Category Filter -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Category</label>
                                        <select name="category"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Person Filter -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Person</label>
                                        <select name="person"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                            <option value="">All People</option>
                                            @foreach ($people as $person)
                                                <option value="{{ $person->id }}"
                                                    {{ request('person') == $person->id ? 'selected' : '' }}>
                                                    {{ $person->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Type Filter -->
                                    <div>
                                        <label class="text-sm text-gray-600 block mb-1">Type</label>
                                        <select name="type"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                            <option value="">All Types</option>
                                            <option value="income"
                                                {{ request('type') == 'income' ? 'selected' : '' }}>
                                                Income
                                            </option>
                                            <option value="expense"
                                                {{ request('type') == 'expense' ? 'selected' : '' }}>
                                                Expense
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex items-center justify-between pt-2">
                                        <a href="{{ route('transactions.index') }}"
                                            class="text-sm text-gray-600 hover:text-gray-800 underline">Reset</a>
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                                            Apply Filters
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Scrollable Table Area -->
            <div class="overflow-auto flex-1">
                <table class="w-full text-sm text-left text-gray-700 bg-white">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Person</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Wallet</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-2">{{ $transaction->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $transaction->person->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if ($transaction->type === 'income')
                                        <span class="text-green-600 font-semibold">Income</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Expense</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $transaction->wallet->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="{{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        ₹{{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                        class="text-yellow-600 hover:underline">View</a>
                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                        method="POST" class="inline-block"
                                        onsubmit="return confirm('Delete this transaction?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-400">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$transactions" />
            </div>
        </div>
    </div>
</x-app-layout>
