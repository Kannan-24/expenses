<x-app-layout>
    <x-slot name="title">
        {{ __('Transactions') }} - {{ config('app.name', 'transactions') }}
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

            <!-- Filters -->
            <form method="GET" class="mb-5 flex flex-wrap gap-3 items-end" id="expense-filter-form">
                <!-- Search -->
                <div class="relative flex-1 min-w-[180px]">
                    <label class="text-sm text-gray-600 block mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="By person, category, or note..."
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

                <!-- Quick Filter -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Quick Filter</label>
                    <select name="filter" onchange="this.form.submit()"
                        class="border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 h-10 min-w-[120px]">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month</option>
                    </select>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full h-10 min-w-[120px]" />
                </div>

                <!-- End Date -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full h-10 min-w-[120px]" />
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
                    <a href="{{ route('transactions.index') }}"
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
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Person</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Payment Method</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $expense)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $expense->person->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if ($expense->type === 'income')
                                        <span class="text-green-600 font-semibold">Income</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Expense</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if ($expense->payment_method === 'cash')
                                        <span class="text-yellow-600">Cash</span>
                                    @else
                                        <span class="text-blue-600">Bank</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="{{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        ₹{{ number_format($expense->amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('transactions.edit', $expense->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <a href="{{ route('transactions.show', $expense->id) }}"
                                        class="text-yellow-600 hover:underline">Show</a>
                                    <form action="{{ route('transactions.destroy', $expense->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Delete this transaction?')">
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
