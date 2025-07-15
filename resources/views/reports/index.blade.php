<x-app-layout>
    <x-slot name="title">
        {{ __('Reports & Analytics') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        @php
            $reportFormats = [
                'pdf' => [
                    'label' => 'PDF',
                    'icon' =>
                        'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                    'color' => 'red',
                ],
                'csv' => [
                    'label' => 'CSV',
                    'icon' =>
                        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'color' => 'green',
                ],
                'xlsx' => [
                    'label' => 'Excel',
                    'icon' =>
                        'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2',
                    'color' => 'blue',
                ],
                'html' => ['label' => 'HTML', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'color' => 'orange'],
            ];
        @endphp
        <!-- Enhanced Header Section -->
        <div
            class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-black/10 dark:bg-black/30"></div>
                <div
                    class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent dark:from-white/10 dark:to-transparent">
                </div>

                <!-- Content -->
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center">
                                <div
                                    class="w-10 h-10 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                Reports & Analytics
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-2 text-lg">
                                Generate comprehensive reports to analyze your financial data and track expenses
                            </p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                            <div
                                class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20 dark:border-white/10">
                                <div class="text-2xl font-bold text-white">{{ now()->format('M Y') }}</div>
                                <div class="text-xs text-blue-200 dark:text-blue-300">Current Period</div>
                            </div>
                            <div
                                class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20 dark:border-white/10">
                                <div class="text-2xl font-bold text-white">3</div>
                                <div class="text-xs text-blue-200 dark:text-blue-300">Report Types</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Types Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if (auth()->user()->hasRole('user'))
                <!-- Transaction Report Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <!-- Card Header -->
                    <div
                        class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-800 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-white">Transaction Report</h2>
                                <p class="text-green-100 dark:text-green-200 text-sm">Detailed transaction analysis</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card Content -->
                    <form action="{{ route('reports.generate') }}" method="GET" class="p-6 space-y-6"
                        x-data="reportForm()">
                        @csrf
                        <input type="hidden" name="report_type" value="transactions">
                        <!-- Date Range Section -->
                        <div class="space-y-4" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date
                                    Range</label>
                                <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    @php
                                        $dateRanges = [
                                            'all' => 'All Time',
                                            'today' => 'Today',
                                            'yesterday' => 'Yesterday',
                                            'this_week' => 'This Week',
                                            'this_month' => 'This Month',
                                            'last_month' => 'Last Month',
                                            'last_3_months' => 'Last 3 Months',
                                            'this_year' => 'This Year',
                                            'custom' => 'Custom Range',
                                        ];
                                    @endphp
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Custom Date Range -->
                            <div x-show="dateRange === 'custom'" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start
                                        Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('start_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End
                                        Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('end_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Filters Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Transaction Type -->
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Transaction
                                    Type</label>
                                <select name="transaction_type"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <option value="all" {{ old('transaction_type') == 'all' ? 'selected' : '' }}>All
                                        Types</option>
                                    <option value="income" {{ old('transaction_type') == 'income' ? 'selected' : '' }}>
                                        Income</option>
                                    <option value="expense"
                                        {{ old('transaction_type') == 'expense' ? 'selected' : '' }}>
                                        Expense</option>
                                </select>
                                @error('transaction_type')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Category -->
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Category</label>
                                <select name="category_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <option value="all" {{ old('category_id') == 'all' ? 'selected' : '' }}>All
                                        Categories</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('category_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Wallet -->
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Wallet</label>
                                <select name="wallet_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <option value="all" {{ old('wallet_id') == 'all' ? 'selected' : '' }}>All
                                        Wallets
                                    </option>
                                    @foreach ($wallets as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('wallet_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('wallet_id')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Person -->
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Person</label>
                                <select name="person_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <option value="all" {{ old('person_id') == 'all' ? 'selected' : '' }}>All People
                                    </option>
                                    @foreach ($people as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('person_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('person_id')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Amount Filter -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 space-y-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Amount Filter (Optional)
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="sm:col-span-2">
                                    <label
                                        class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Amount</label>
                                    <input type="number" min="0" max="1000000" step="0.01"
                                        name="amount" value="{{ old('amount') }}" placeholder="e.g., 100.00"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('amount')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Filter
                                        Type</label>
                                    <select name="amount_filter"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                        <option value="=" {{ old('amount_filter') == '=' ? 'selected' : '' }}>
                                            Equal
                                            To</option>
                                        <option value="<" {{ old('amount_filter') == '<' ? 'selected' : '' }}>
                                            Less
                                            Than</option>
                                        <option value=">" {{ old('amount_filter') == '>' ? 'selected' : '' }}>
                                            Greater
                                            Than</option>
                                    </select>
                                    @error('amount_filter')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Report Format -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report
                                Format</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">

                                @foreach ($reportFormats as $value => $format)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="report_format" value="{{ $value }}"
                                            {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all 
                                                peer-checked:border-green-500 peer-checked:bg-green-50 
                                                dark:peer-checked:bg-green-900/30 
                                                hover:border-green-300">
                                            <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-green-600 dark:peer-checked:text-green-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $format['icon'] }}"></path>
                                            </svg>
                                            <span
                                                class="text-xs font-medium text-gray-600 peer-checked:text-green-700 dark:text-gray-300 dark:peer-checked:text-green-300">{{ $format['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('report_format')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Generate Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-green-600 hover:to-emerald-700 dark:hover:from-green-800 dark:hover:to-emerald-900 hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-200 dark:focus:ring-green-700 group relative overflow-hidden">
                            <!-- Button shine effect -->
                            <span
                                class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                            <span class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Generate Transaction Report
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Budget Report Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <!-- Card Header -->
                    <div
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-900 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-white">Budget Report</h2>
                                <p class="text-blue-100 dark:text-blue-200 text-sm">Budget analysis & tracking</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card Content -->
                    <form action="{{ route('reports.generate') }}" method="GET" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="report_type" value="budgets">
                        <!-- Date Range Section -->
                        <div class="space-y-4" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date
                                    Range</label>
                                <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Custom Date Range -->
                            <div x-show="dateRange === 'custom'" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start
                                        Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('start_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End
                                        Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('end_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Category Filter -->
                        <div>
                            <label
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Category</label>
                            <select name="budget_category_id"
                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('budget_category_id') == 'all' ? 'selected' : '' }}>All
                                    Categories</option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('budget_category_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('budget_category_id')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Report Format -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report
                                Format</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                @foreach ($reportFormats as $value => $format)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="report_format" value="{{ $value }}"
                                            {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-blue-300">
                                            <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $format['icon'] }}"></path>
                                            </svg>
                                            <span
                                                class="text-xs font-medium text-gray-600 peer-checked:text-blue-700 dark:text-gray-300 dark:peer-checked:text-blue-300">{{ $format['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('report_format')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Info Note -->
                        <div
                            class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">Report
                                        Information</h4>
                                    <p class="text-sm text-blue-700 dark:text-blue-300">
                                        This report shows all budgets created within the specified date range.
                                        For detailed budget utilization, visit the
                                        <a href="{{ route('budgets.index') }}"
                                            class="underline hover:no-underline font-medium">Budgets section</a>.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-900 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-blue-600 hover:to-indigo-700 dark:hover:from-blue-800 dark:hover:to-indigo-950 hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 group relative overflow-hidden">
                            <!-- Button shine effect -->
                            <span
                                class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                            <span class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Generate Budget Report
                            </span>
                        </button>
                    </form>
                </div>
            @endif

            @if (auth()->user()->hasRole('admin'))
                <!-- Support Tickets Report Card -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <!-- Card Header -->
                    <div
                        class="bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-700 dark:to-pink-800 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-white">Support Ticket Report</h2>
                                <p class="text-purple-100 dark:text-purple-200 text-sm">Customer support analysis</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Card Content -->
                    <form action="{{ route('reports.generate') }}" method="GET" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="report_type" value="tickets">
                        <!-- Date Range Section -->
                        <div class="space-y-4" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date
                                    Range</label>
                                <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    @foreach ($dateRanges as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('date_range') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_range')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Custom Date Range -->
                            <div x-show="dateRange === 'custom'" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start
                                        Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('start_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End
                                        Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    @error('end_date')
                                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Filters Grid -->
                        <div class="space-y-4">
                            <!-- Ticket Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Ticket
                                    Status</label>
                                <select name="status"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                    <option value="all" {{ old('status') == 'all' ? 'selected' : '' }}>All Statuses
                                    </option>
                                    <option value="opened" {{ old('status') == 'opened' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="admin_replied"
                                        {{ old('status') == 'admin_replied' ? 'selected' : '' }}>Admin Replied</option>
                                    <option value="customer_replied"
                                        {{ old('status') == 'customer_replied' ? 'selected' : '' }}>Customer Replied
                                    </option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Include Trashed -->
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_trashed" value="1"
                                        {{ old('is_trashed') ? 'checked' : '' }}
                                        class="w-4 h-4 text-purple-600 dark:text-purple-400 bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded focus:ring-purple-500 focus:ring-1">
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-200">Include
                                        deleted
                                        tickets</span>
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-7">Check this to include
                                    soft-deleted tickets in the report</p>
                                @error('is_trashed')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Report Format -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report
                                Format</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                @foreach ($reportFormats as $value => $format)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="report_format" value="{{ $value }}"
                                            {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/30 hover:border-purple-300">
                                            <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-purple-600 dark:peer-checked:text-purple-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $format['icon'] }}"></path>
                                            </svg>
                                            <span
                                                class="text-xs font-medium text-gray-600 peer-checked:text-purple-700 dark:text-gray-300 dark:peer-checked:text-purple-300">{{ $format['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('report_format')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Generate Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-700 dark:to-pink-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-purple-600 hover:to-pink-700 dark:hover:from-purple-800 dark:hover:to-pink-900 hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-700 group relative overflow-hidden">
                            <!-- Button shine effect -->
                            <span
                                class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                            <span class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Generate Ticket Report
                            </span>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Recent Reports Section -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800">
            <div
                class="px-4 sm:px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 text-blue-600 dark:text-blue-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recent Reports
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 hidden sm:block">Quick access to your
                            recently generated reports</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @if ($reportHistories->count() > 0)
                    <div class="space-y-3 sm:space-y-4">
                        @foreach ($reportHistories as $report)
                            <div
                                class="group relative bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-750 rounded-xl p-4 sm:p-5 border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-300 hover:scale-[1.01]">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                    <!-- Report Info -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Badges Row -->
                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <!-- Report Type Badge -->
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold shadow-sm
                                        {{ $report->report_type === 'transactions'
                                            ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800'
                                            : ($report->report_type === 'budgets'
                                                ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800'
                                                : 'bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800') }}">
                                                @if ($report->report_type === 'transactions')
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                        </path>
                                                    </svg>
                                                    Transactions
                                                @elseif($report->report_type === 'budgets')
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                        </path>
                                                    </svg>
                                                    Budgets
                                                @else
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                                        </path>
                                                    </svg>
                                                    Tickets
                                                @endif
                                            </span>

                                            <!-- Format Badge -->
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 shadow-sm">
                                                @if ($report->report_format === 'pdf')
                                                    <svg class="w-3 h-3 mr-1.5 text-red-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                @elseif($report->report_format === 'html')
                                                    <svg class="w-3 h-3 mr-1.5 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
                                                        </path>
                                                    </svg>
                                                @elseif($report->report_format === 'csv')
                                                    <svg class="w-3 h-3 mr-1.5 text-green-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3 mr-1.5 text-emerald-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                @endif
                                                {{ strtoupper($report->report_format) }}
                                            </span>

                                            <!-- Date Range Badge -->
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-sm">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ ucfirst(str_replace('_', ' ', $report->date_range)) }}
                                            </span>
                                        </div>

                                        <!-- Report Title -->
                                        <div
                                            class="text-base sm:text-lg text-gray-900 dark:text-white font-semibold mb-2 truncate">
                                            {{ $report->getDisplayName() }}
                                        </div>

                                        <!-- Report Details -->
                                        <div class="space-y-2">
                                            @if ($report->start_date && $report->end_date)
                                                <div
                                                    class="flex items-center text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span class="truncate">
                                                        {{ \Carbon\Carbon::parse($report->start_date)->format('M d, Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($report->end_date)->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if ($report->filters && count(array_filter($report->filters)))
                                                <div
                                                    class="flex items-start text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                                        </path>
                                                    </svg>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach (array_filter($report->filters) as $key => $value)
                                                            <span
                                                                class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-md text-xs font-medium">
                                                                {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                                                {{ is_array($value) ? implode(', ', $value) : $value }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Timestamp -->
                                        <div class="flex items-center mt-3 text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Generated {{ $report->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-end space-x-2 lg:space-x-3 flex-shrink-0">
                                        <!-- Format Selector & Regenerate with Smart Positioning -->
                                        <div class="relative" x-data="{
                                            open: false,
                                            selectedFormat: '{{ $report->report_format }}',
                                            position: 'bottom-right',
                                            updatePosition() {
                                                const button = this.$refs.button;
                                                const dropdown = this.$refs.dropdown;
                                                if (!button || !dropdown) return;
                                        
                                                const buttonRect = button.getBoundingClientRect();
                                                const viewportWidth = window.innerWidth;
                                                const viewportHeight = window.innerHeight;
                                                const dropdownWidth = 200; // approximate width
                                                const dropdownHeight = 300; // approximate height
                                        
                                                // Determine horizontal position
                                                const spaceRight = viewportWidth - buttonRect.right;
                                                const spaceLeft = buttonRect.left;
                                                const horizontal = spaceRight >= dropdownWidth ? 'right' : 'left';
                                        
                                                // Determine vertical position
                                                const spaceBelow = viewportHeight - buttonRect.bottom;
                                                const spaceAbove = buttonRect.top;
                                                const vertical = spaceBelow >= dropdownHeight ? 'bottom' : 'top';
                                        
                                                this.position = vertical + '-' + horizontal;
                                            }
                                        }"
                                            @resize.window="updatePosition()">
                                            <button @click="open = !open; updatePosition()" x-ref="button"
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group-hover:shadow-md">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                                </svg>
                                                <span class="hidden sm:inline">Regenerate</span>
                                                <span class="sm:hidden">Regen</span>
                                                <svg class="w-4 h-4 ml-2 transition-transform duration-200"
                                                    :class="{ 'rotate-180': open }" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>

                                            <!-- Smart Positioned Dropdown Menu -->
                                            <div x-show="open" x-ref="dropdown"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95" @click.away="open = false"
                                                :class="{
                                                    'top-full right-0 mt-2': position === 'bottom-right',
                                                    'top-full left-0 mt-2': position === 'bottom-left',
                                                    'bottom-full right-0 mb-2': position === 'top-right',
                                                    'bottom-full left-0 mb-2': position === 'top-left'
                                                }"
                                                class="absolute w-52 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-[9999] overflow-hidden"
                                                style="z-index: 9999;">
                                                <div class="py-2">
                                                    <div
                                                        class="px-4 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                                                        Select Format & Regenerate
                                                    </div>
                                                    @foreach (['pdf', 'html', 'csv', 'xlsx'] as $format)
                                                        <form action="{{ route('reports.regenerate') }}"
                                                            method="POST" class="inline w-full">
                                                            @csrf
                                                            <input type="hidden" name="report_id"
                                                                value="{{ $report->id }}">
                                                            <input type="hidden" name="report_format"
                                                                value="{{ $format }}">
                                                            <button type="submit"
                                                                class="w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-150 flex items-center group">
                                                                @if ($format === 'pdf')
                                                                    <div
                                                                        class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 dark:group-hover:bg-red-900/50 transition-colors">
                                                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-medium">PDF Document</div>
                                                                        <div
                                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                                            Portable format</div>
                                                                    </div>
                                                                @elseif($format === 'html')
                                                                    <div
                                                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                                                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-medium">HTML View</div>
                                                                        <div
                                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                                            Web format</div>
                                                                    </div>
                                                                @elseif($format === 'csv')
                                                                    <div
                                                                        class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                                                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-medium">CSV File</div>
                                                                        <div
                                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                                            Comma separated</div>
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                                                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-medium">Excel File</div>
                                                                        <div
                                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                                            Spreadsheet format</div>
                                                                    </div>
                                                                @endif
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('reports.history.delete', $report->id) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this report? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center p-2.5 border border-transparent rounded-lg text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group/delete">
                                                <svg class="w-4 h-4 group-hover/delete:scale-110 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    @if ($reportHistories->hasPages())
                        <div
                            class="mt-6 bg-gradient-to-r from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                                <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    <span class="text-gray-500 dark:text-gray-400">Showing</span>
                                    <span
                                        class="text-blue-600 dark:text-blue-400 font-semibold">{{ $reportHistories->firstItem() }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">to</span>
                                    <span
                                        class="text-blue-600 dark:text-blue-400 font-semibold">{{ $reportHistories->lastItem() }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">of</span>
                                    <span
                                        class="text-blue-600 dark:text-blue-400 font-semibold">{{ $reportHistories->total() }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">Report Histories</span>
                                </div>
                                <div>
                                    <x-pagination :paginator="$reportHistories" />
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Enhanced Empty State -->
                    <div class="text-center py-12 sm:py-16">
                        <div class="max-w-md mx-auto">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">No Recent
                                Reports</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 text-sm sm:text-base">Start by generating
                                your first report using the forms above. Your report history will appear here for easy
                                access and management.</p>

                            <!-- Feature highlights -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
                                <div
                                    class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl p-4 border border-emerald-200 dark:border-emerald-800">
                                    <div
                                        class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-emerald-800 dark:text-emerald-300 text-sm mb-1">Fast
                                        Generation</h4>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400">Quick report creation in
                                        seconds</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                                    <div
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-blue-800 dark:text-blue-300 text-sm mb-1">Multiple
                                        Formats</h4>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">PDF, HTML, CSV, and Excel
                                        support</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                                    <div
                                        class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-purple-800 dark:text-purple-300 text-sm mb-1">
                                        Advanced Filters</h4>
                                    <p class="text-xs text-purple-600 dark:text-purple-400">Powerful filtering and
                                        customization</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        function reportForm() {
            return {
                loading: false,

                submitForm(event) {
                    this.loading = true;
                    const submitButton = event.target;
                    const originalText = submitButton.innerHTML;

                    submitButton.innerHTML = `
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Generating Report...
                    `;

                    submitButton.disabled = true;

                    // Reset after 30 seconds in case of issues
                    setTimeout(() => {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                        this.loading = false;
                    }, 30000);
                }
            }
        }

        // Date validation
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                const startDateInput = form.querySelector('input[name="start_date"]');
                const endDateInput = form.querySelector('input[name="end_date"]');

                if (startDateInput && endDateInput) {
                    startDateInput.addEventListener('change', function() {
                        if (this.value) {
                            endDateInput.min = this.value;
                        }
                    });

                    endDateInput.addEventListener('change', function() {
                        if (this.value) {
                            startDateInput.max = this.value;
                        }
                    });
                }
            });

            // Form submission loading states
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalContent = submitButton.innerHTML;

                    submitButton.innerHTML = `
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="relative">Generating Report...</span>
                    `;
                    submitButton.disabled = true;

                    // Show loading overlay
                    showLoadingOverlay();
                });
            });
        });

        // Loading overlay
        function showLoadingOverlay() {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            overlay.innerHTML = `
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center space-y-4 max-w-sm mx-4">
                    <svg class="w-12 h-12 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Generating Report</h3>
                        <p class="text-gray-600">Please wait while we prepare your report...</p>
                    </div>
                </div>
            `;
            document.body.appendChild(overlay);
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-600 text-white' : 
                type === 'error' ? 'bg-red-600 text-white' : 
                'bg-blue-600 text-white'
            }`;

            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' ? 
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                            type === 'error' ?
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Initialize page
        console.log('Reports page loaded for user: harithelord47');
        console.log('Current date:', '{{ date('Y-m-d H:i:s') }}');
    </script>

    <!-- Enhanced Styles -->
    <style>
        /* Custom animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Enhanced form styling */
        input:focus,
        select:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Button hover effects */
        button:hover {
            transform: translateY(-2px);
        }

        /* Card hover effects */
        .group:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .grid.grid-cols-1.lg\\:grid-cols-2.xl\\:grid-cols-3 {
                gap: 1rem;
            }

            .space-y-8>*+* {
                margin-top: 1.5rem;
            }

            .px-6 {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Format selection styling */
        input[type="radio"]:checked+div {
            border-width: 2px;
            transform: scale(1.02);
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</x-app-layout>
