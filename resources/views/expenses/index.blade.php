<x-app-layout>
    <x-slot name="title">
        {{ __('Batch List') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="py-6    ml-4 sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-4 flex flex-wrap gap-3 items-center">
                    <select name="filter" onchange="this.form.submit()"
                        class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days
                        </option>
                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month
                        </option>
                    </select>

                    <div class="flex items-center gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                        <span class="text-gray-500">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm">Filter</button>
                    </div>
                </form>

                <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Note</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($expense->type === 'income')
                                            <span class="text-green-400 font-semibold">Income</span>
                                        @else
                                            <span class="text-red-400 font-semibold">Expense</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        @if ($expense->type === 'income')
                                            <span
                                                class="text-green-400">₹{{ number_format($expense->amount, 2) }}</span>
                                        @else
                                            <span class="text-red-400">₹{{ number_format($expense->amount, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('expenses.edit', $expense->id) }}"
                                            class="text-blue-400 hover:text-blue-200">Edit</a>
                                        <a href="{{ route('expenses.show', $expense->id) }}"
                                            class="text-indigo-400 hover:text-indigo-200">Show</a>s
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Delete this transaction?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-400 hover:text-red-200">Delete</button>
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

                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>
                </div>

                <x-pagination :paginator="$expenses" />
            </div>
        </div>
    </div>

</x-app-layout>
