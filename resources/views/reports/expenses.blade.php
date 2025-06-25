<x-app-layout>
    <x-slot name="title">
        {{ __('Expense Report') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between" style="height: 88vh;">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-3">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Expense Report</span>
                        </li>
                    </ol>
                </nav>
                <a href="{{ route('reports.expenses_report', request()->query()) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 shadow">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Export PDF
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('reports.expenses') }}" class="mb-5 flex flex-wrap gap-3 items-end" id="expense-filter-form">
                <!-- Report Type -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Report Type</label>
                    <select name="type" onchange="this.form.submit()"
                        class="border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 h-10 min-w-[120px]">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All (Income + Expense)</option>
                        <option value="expenses_only" {{ request('type') == 'expenses_only' ? 'selected' : '' }}>All People (Expenses Only)</option>
                        <option value="person" {{ request('type') == 'person' ? 'selected' : '' }}>Specific Person (Expenses Only)</option>
                    </select>
                </div>
                <!-- Person Filter -->
                @if(request('type') == 'person')
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Person</label>
                    <select name="person" onchange="this.form.submit()"
                        class="border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 h-10 min-w-[120px]">
                        <option value="">Select Person</option>
                        @foreach($people as $p)
                            <option value="{{ $p->name }}" {{ request('person') == $p->name ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <!-- Quick Filter -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Quick Filter</label>
                    <select name="filter" onchange="this.form.submit()"
                        class="border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 h-10 min-w-[120px]">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                        <option value="30days" {{ request('filter') == '30days' ? 'selected' : '' }}>Last 30 Days</option>
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
                    <a href="{{ route('reports.expenses') }}"
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
                                <td class="px-4 py-2">{{ $exp->person->name ?? 'N/A' }}</td>
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
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$expenses" />
            </div>
        </div>
    </div>
</x-app-layout>
