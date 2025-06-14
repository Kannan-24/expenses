<x-app-layout>
    <x-slot name="title">
        Expense Report - {{ config('app.name') }}
    </x-slot>

    <div class="py-6 ml-4 sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" action="{{ route('reports.expenses') }}" class="mb-4 flex flex-wrap gap-3 items-center">
                    <select name="filter" onchange="this.form.submit()"
                        class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                        <option value="30days" {{ request('filter') == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                    </select>

                    <div class="flex items-center gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                        <span class="text-gray-500">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm">Filter</button>
                        <a href="{{ route('reports.expenses') }}"
                            class="bg-gray-300 text-gray-800 px-4 py-1 rounded text-sm ml-2">Reset</a>
                        <a href="{{ route('reports.expenses.pdf', request()->query()) }}" target="_blank"
                            class="bg-red-500 text-white px-4 py-1 rounded text-sm ml-2">Export PDF</a>
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
                                <th class="px-4 py-2">Person</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $exp)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exp->date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2">
                                        @if ($exp->type === 'income')
                                            <span class="text-green-400 font-semibold">Income</span>
                                        @else
                                            <span class="text-red-400 font-semibold">Expense</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $exp->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        @if ($exp->person)
                                            {{ $exp->person->name }}
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($exp->type === 'income')
                                            <span class="text-green-400">₹{{ number_format($exp->amount, 2) }}</span>
                                        @else
                                            <span class="text-red-400">₹{{ number_format($exp->amount, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($exp->payment_method === 'cash')
                                            <span class="text-yellow-400">Cash</span>
                                        @else
                                            <span class="text-blue-400">Bank</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-400">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if(method_exists($expenses, 'links'))
                        <div class="mt-4">
                            {{ $expenses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
