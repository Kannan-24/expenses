<x-app-layout>
    <x-slot name="title">
        {{ __('Batch List') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-8 flex flex-wrap gap-3 items-center sm:flex-row flex-col" id="expense-filter-form">
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by person, category, or note..."
                            class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition pr-10"
                            id="search-input">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-800"
                            aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>

                    <select name="filter" onchange="this.form.submit()"
                        class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full sm:w-auto focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month</option>
                    </select>

                    <div class="flex items-center gap-2 w-full sm:w-auto flex-col sm:flex-row">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full sm:w-auto focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                        <span class="text-gray-500 text-center sm:text-left">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-800 w-full sm:w-auto focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto flex-col sm:flex-row">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0">Filter</button>
                        <a href="{{ route('expenses.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0 text-center">Reset</a>
                    </div>
                </form>

                <table class="w-full text-sm text-left text-gray-700 bg-white rounded-lg shadow overflow-hidden">
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
                        @forelse ($expenses as $expense)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    @if ($expense->person)
                                        {{ $expense->person->name }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
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
                                    @if ($expense->type === 'income')
                                        <span class="text-green-600">₹{{ number_format($expense->amount, 2) }}</span>
                                    @else
                                        <span class="text-red-600">₹{{ number_format($expense->amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('expenses.edit', $expense->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <a href="{{ route('expenses.show', $expense->id) }}"
                                        class="text-yellow-600 hover:underline">Show</a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
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

                <x-pagination :paginator="$expenses" />
            </div>
        </div>
    </div>

</x-app-layout>
