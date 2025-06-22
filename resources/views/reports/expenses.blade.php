<x-app-layout>
    <x-slot name="title">
        Expense Report - {{ config('app.name') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" action="{{ route('reports.expenses') }}" class="mb-8 flex flex-wrap gap-3 items-center sm:flex-row flex-col" id="expense-filter-form">
                    {{-- Report Type --}}
                    <div class="w-full sm:w-48">
                        <select name="type" onchange="this.form.submit()"
                            class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All (Income + Expense)</option>
                            <option value="expenses_only" {{ request('type') == 'expenses_only' ? 'selected' : '' }}>All People (Expenses Only)</option>
                            <option value="person" {{ request('type') == 'person' ? 'selected' : '' }}>Specific Person (Expenses Only)</option>
                        </select>
                    </div>

                    {{-- Person Filter --}}
                    @if(request('type') == 'person')
                        <div class="w-full sm:w-48">
                            <select name="person" onchange="this.form.submit()"
                                class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                                <option value="">Select Person</option>
                                @foreach($people as $p)
                                    <option value="{{ $p->name }}" {{ request('person') == $p->name ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Predefined Date Filter --}}
                    <div class="w-full sm:w-40">
                        <select name="filter" onchange="this.form.submit()"
                            class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                            <option value="">All</option>
                            <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                            <option value="30days" {{ request('filter') == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                        </select>
                    </div>

                    {{-- Custom Date Range --}}
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
                        <a href="{{ route('reports.expenses') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0 text-center">Reset</a>
                        <a href="{{ route('reports.expenses_report', request()->query()) }}" target="_blank"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm w-full sm:w-auto mt-2 sm:mt-0 text-center">Export PDF</a>
                    </div>
                </form>

                <table class="w-full text-sm text-left text-gray-700 bg-white rounded-lg shadow overflow-hidden">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-600">
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
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exp->date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">
                                    @if ($exp->type === 'income')
                                        <span class="text-green-600 font-semibold">Income</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Expense</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $exp->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    {{ $exp->person->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($exp->type === 'income')
                                        <span class="text-green-600">₹{{ number_format($exp->amount, 2) }}</span>
                                    @else
                                        <span class="text-red-600">₹{{ number_format($exp->amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if ($exp->payment_method === 'cash')
                                        <span class="text-yellow-600">Cash</span>
                                    @else
                                        <span class="text-blue-600">Bank</span>
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

                <x-pagination :paginator="$expenses" />
            </div>
        </div>
    </div>
</x-app-layout>
