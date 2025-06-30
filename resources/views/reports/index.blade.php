<x-app-layout>
    <x-slot name="title">
        {{ __('Reports') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl rounded-2xl m-4 flex flex-col justify-between">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!--  Transactions Report -->
                <form action="{{ route('reports.generate') }}" method="GET"
                    class="bg-white p-6 rounded-lg shadow space-y-4">
                    @csrf

                    <h2 class="text-xl font-bold text-gray-800 mb-2">Transaction Report</h2>
                    <input type="hidden" name="report_type" value="transactions">

                    <div class="grid grid-cols-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div class="col-span-2">
                                @php
                                    $dateRanges = [
                                        'all' => 'All',
                                        'today' => 'Today',
                                        'yesterday' => 'Yesterday',
                                        'this_week' => 'This Week',
                                        'this_month' => 'This Month',
                                        'last_month' => 'Last Month',
                                        'custom' => 'Custom Range',
                                    ];
                                @endphp
                                <label for="date_range" class="block text-sm font-semibold text-gray-700">Date Range</label>
                                <select name="date_range" id="date_range" x-model="dateRange"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow
                                    focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="transaction_type" class="block text-sm font-semibold text-gray-700">
                                Transaction Type
                            </label>
                            <select name="transaction_type" id="transaction_type"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('transaction_type') == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                <option value="income" {{ old('transaction_type') == 'income' ? 'selected' : '' }}>
                                    Income
                                </option>
                                <option value="expense" {{ old('transaction_type') == 'expense' ? 'selected' : '' }}>
                                    Expense
                                </option>
                            </select>
                            @error('transaction_type')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="category_id" id="category_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('category_id') == 'all' ? 'selected' : '' }}>
                                    All Categories
                                </option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('category_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="wallet_id" class="block text-sm font-semibold text-gray-700">Wallet</label>
                            <select name="wallet_id" id="wallet_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('wallet_id') == 'all' ? 'selected' : '' }}>
                                    All Wallets
                                </option>
                                @foreach ($wallets as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('wallet_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wallet_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="person_id" class="block text-sm font-semibold text-gray-700">Person</label>
                            <select name="person_id" id="person_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('person_id') == 'all' ? 'selected' : '' }}>
                                    All People
                                </option>
                                @foreach ($people as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('person_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('person_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full flex gap-2">
                            <div class="mb-5 flex-1">
                                <label for="amount" class="block text-sm font-semibold text-gray-700">
                                    Amount
                                </label>
                                <input type="number" min="0" max="1000000" step="0.01" name="amount"
                                    id="amount" value="{{ old('amount') }}" placeholder="E.g: 100.00"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error($name)
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="amount_filter"
                                    class="block text-sm font-semibold text-gray-700">Filter</label>
                                <select name="amount_filter" id="amount_filter"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="=" {{ old('amount_filter') == '=' ? 'selected' : '' }}>
                                        Equal To
                                    </option>
                                    <option value="<" {{ old('amount_filter') == '<' ? 'selected' : '' }}>
                                        Less Than
                                    </option>
                                    <option value=">" {{ old('amount_filter') == '>' ? 'selected' : '' }}>
                                        Greater Than
                                    </option>
                                </select>
                                @error('amount_filter')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            @php
                                $reportFormats = ['pdf' => 'PDF', 'csv' => 'CSV', 'xlsx' => 'Excel', 'html' => 'HTML'];
                            @endphp
                            <label for="report_format" class="block text-sm font-semibold text-gray-700">Report
                                Format</label>
                            <select name="report_format" id="report_format"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($reportFormats as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('report_format') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if (old('report_type') == 'transactions')
                                @error('report_format')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>
                    </div>

                    <x-primary-button class="mt-4 w-full md:w-auto">Generate Report</x-primary-button>
                </form>


                {{-- <div class="flex flex-col gap-6">
                    <!-- Budgets Report -->
                    <form action="{{ route('reports.generate') }}" method="GET"
                        class="bg-white p-6 rounded-lg shadow space-y-4">
                        @csrf

                        <h2 class="text-xl font-bold text-gray-800 mb-2">Budget Report</h2>
                        <input type="hidden" name="report_type" value="budgets">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div class="col-span-2">
                                @php
                                    $dateRanges = [
                                        'all' => 'All',
                                        'today' => 'Today',
                                        'yesterday' => 'Yesterday',
                                        'this_week' => 'This Week',
                                        'this_month' => 'This Month',
                                        'last_month' => 'Last Month',
                                        'custom' => 'Custom Range',
                                    ];
                                @endphp
                                <label for="date_range" class="block text-sm font-semibold text-gray-700">Date
                                    Range</label>
                                <select name="date_range" id="date_range" x-model="dateRange"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow
                                    focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="budget_category_id"
                                class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="budget_category_id" id="budget_category_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('budget_category_id') == 'all' ? 'selected' : '' }}>
                                    All Categories
                                </option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('budget_category_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('budget_category_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            @php
                                $reportFormats = ['pdf' => 'PDF', 'csv' => 'CSV', 'xlsx' => 'Excel', 'html' => 'HTML'];
                            @endphp
                            <label for="report_format" class="block text-sm font-semibold text-gray-700">Report
                                Format</label>
                            <select name="report_format" id="report_format"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($reportFormats as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('report_format') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if (old('report_type') == 'budgets')
                                @error('report_format')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 mb-4">
                            Note: This report will show all budgets created within the specified date range, regardless
                            of whether they have been fully utilized or not. To generate a report of specific budget you
                            created or utilized, please use the <a href="{{ route('budgets.index') }}"
                                class="text-blue-500 hover:underline">Budgets</a> section.
                        </p>

                        <x-primary-button class="mt-3">Generate</x-primary-button>
                    </form>

                    <!-- Support Tickets Report -->
                    <form action="{{ route('reports.generate') }}" method="GET"
                        class="bg-white p-6 rounded-lg shadow space-y-4">
                        @csrf

                        <h2 class="text-xl font-bold text-gray-800 mb-2">Support Ticket Report</h2>
                        <input type="hidden" name="report_type" value="tickets">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div class="col-span-2">
                                @php
                                    $dateRanges = [
                                        'all' => 'All',
                                        'today' => 'Today',
                                        'yesterday' => 'Yesterday',
                                        'this_week' => 'This Week',
                                        'this_month' => 'This Month',
                                        'last_month' => 'Last Month',
                                        'custom' => 'Custom Range',
                                    ];
                                @endphp
                                <label for="date_range" class="block text-sm font-semibold text-gray-700">Date
                                    Range</label>
                                <select name="date_range" id="date_range" x-model="dateRange"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow
                                    focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-show="dateRange === 'custom'" x-transition>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="status" class="block text-sm font-semibold text-gray-700">Ticket
                                Status</label>
                            <select name="status" id="status"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="all" {{ old('status') == 'all' ? 'selected' : '' }}>
                                    All Statuses
                                </option>
                                <option value="opened" {{ old('status') == 'opened' ? 'selected' : '' }}>
                                    Opened
                                </option>
                                <option value="admin replied"
                                    {{ old('status') == 'admin_replied' ? 'selected' : '' }}>
                                    Admin Replied
                                </option>
                                <option value="customer replied"
                                    {{ old('status') == 'customer_replied' ? 'selected' : '' }}>
                                    Customer Replied
                                </option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>
                                    Closed
                                </option>
                            </select>
                            @error('status')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_trashed" id="is_trashed" value="1"
                                    {{ old('is_trashed') ? 'checked' : '' }}
                                    class="mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <label for="is_trashed" class="block text-sm font-semibold text-gray-700">Include
                                    Trashed?</label>
                            </div>
                            @error('is_trashed')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-5">
                            @php
                                $reportFormats = ['pdf' => 'PDF', 'csv' => 'CSV', 'xlsx' => 'Excel', 'html' => 'HTML'];
                            @endphp
                            <label for="report_format" class="block text-sm font-semibold text-gray-700">Report
                                Format</label>
                            <select name="report_format" id="report_format"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($reportFormats as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('report_format') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if (old('report_type') == 'tickets')
                                @error('report_format')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>

                        <x-primary-button class="mt-3">Generate</x-primary-button>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
