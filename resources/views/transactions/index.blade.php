<x-app-layout>
    <x-slot name="title">
        {{ __('Transactions') }} - {{ config('app.name', 'transactions') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-4 flex flex-wrap gap-3 items-center sm:flex-row flex-col">
                    <select name="filter" onchange="this.form.submit()"
                        class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full sm:w-auto">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days
                        </option>
                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month
                        </option>
                    </select>

                    <div class="flex items-center gap-2 w-full sm:w-auto flex-col sm:flex-row">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800 w-full sm:w-auto">
                        <span class="text-gray-500 text-center sm:text-left">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0">Filter</button>
                        <a href="{{ route('transactions.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-1 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0 text-center">Reset</a>
                    </div>
                </form>

                <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2"> Person</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Payment Method</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $expense)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        @if ($expense->person)
                                            {{ $expense->person->name }}
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($expense->type === 'income')
                                            <span class="text-green-400 font-semibold">Income</span>
                                        @else
                                            <span class="text-red-400 font-semibold">Expense</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($expense->payment_method === 'cash')
                                            <span class="text-yellow-400">Cash</span>
                                        @else
                                            <span class="text-blue-400">Bank</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 ">
                                        @if ($expense->type === 'income')
                                            <span
                                                class="text-green-400">₹{{ number_format($expense->amount, 2) }}</span>
                                        @else
                                            <span class="text-red-400">₹{{ number_format($expense->amount, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center space-x-2">
                                        <a href="{{ route('transactions.edit', $expense->id) }}"
                                            class="text-blue-500 ">Edit</a>
                                        <a href="{{ route('transactions.show', $expense->id) }}"
                                            class="text-yellow-400">Show</a>
                                        <form action="{{ route('transactions.destroy', $expense->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Delete this transaction?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-400 hover:text-red-400">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-pagination :paginator="$transactions" />
            </div>
        </div>
    </div>

</x-app-layout>
