<x-app-layout>
    <x-slot name="title">
        Expense Report - {{ config('app.name') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" action="{{ route('reports.expenses') }}" class="mb-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                    {{-- Report Type --}}
                    <div class="w-full sm:w-auto">
                        <select name="type" onchange="this.form.submit()"
                            class="w-full bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All (Income + Expense)</option>
                            <option value="expenses_only" {{ request('type') == 'expenses_only' ? 'selected' : '' }}>All People (Expenses Only)</option>
                            <option value="person" {{ request('type') == 'person' ? 'selected' : '' }}>Specific Person (Expenses Only)</option>
                        </select>
                    </div>

                    {{-- Person Filter --}}
                    @if(request('type') == 'person')
                        <div class="w-full sm:w-auto">
                            <select name="person" onchange="this.form.submit()"
                                class="w-full bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900">
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
                    <div class="w-full sm:w-auto">
                        <select name="filter" onchange="this.form.submit()"
                            class="w-full bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900">
                            <option value="">All</option>
                            <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                            <option value="30days" {{ request('filter') == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                        </select>
                    </div>

                    {{-- Custom Date Range --}}
                    <div class="w-full flex flex-col gap-2 sm:flex-row sm:items-center sm:w-auto">
                        <div class="flex flex-col gap-2 sm:flex-row sm:gap-2 w-full">
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                            <span class="text-gray-500 flex items-center justify-center">to</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border border-gray-300 rounded px-3 py-1 text-sm text-gray-800">
                        </div>
                        <div class="flex flex-col gap-2 sm:flex-row sm:gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm">Filter</button>
                            <a href="{{ route('reports.expenses') }}"
                                class="w-full sm:w-auto bg-gray-300 text-gray-800 px-4 py-1 rounded text-sm text-center">Reset</a>
                            <a href="{{ route('reports.expenses_report', request()->query()) }}" target="_blank"
                                class="w-full sm:w-auto bg-red-500 text-white px-4 py-1 rounded text-sm text-center">Export PDF</a>
                        </div>
                    </div>
                </form>

                {{-- Table --}}
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
                                        {{ $exp->person->name ?? 'N/A' }}
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
                </div>

                <x-pagination :paginator="$expenses" />
            </div>
        </div>
    </div>
</x-app-layout>
