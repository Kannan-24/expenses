<x-app-layout>
    <x-slot name="title">
        {{ __('Reports & Analytics') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-black/10 dark:bg-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent dark:from-white/10 dark:to-transparent"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
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
                            <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20 dark:border-white/10">
                                <div class="text-2xl font-bold text-white">{{ now()->format('M Y') }}</div>
                                <div class="text-xs text-blue-200 dark:text-blue-300">Current Period</div>
                            </div>
                            <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20 dark:border-white/10">
                                <div class="text-2xl font-bold text-white">4</div>
                                <div class="text-xs text-blue-200 dark:text-blue-300">Report Types</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Types Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Transaction Report Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white">Transaction Report</h2>
                            <p class="text-green-100 dark:text-green-200 text-sm">Detailed transaction analysis</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Card Content -->
                <form action="{{ route('reports.generate') }}" method="GET" class="p-6 space-y-6" x-data="reportForm()">
                    @csrf
                    <input type="hidden" name="report_type" value="transactions">
                    <!-- Date Range Section -->
                    <div class="space-y-4" x-data="{ dateRange: '{{ old('date_range', 'all') }}' }">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date Range</label>
                            <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
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
                                    <option value="{{ $value }}" {{ old('date_range') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('date_range')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Custom Date Range -->
                        <div x-show="dateRange === 'custom'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start Date</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                @error('start_date')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End Date</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Transaction Type</label>
                            <select name="transaction_type"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('transaction_type') == 'all' ? 'selected' : '' }}>All Types</option>
                                <option value="income" {{ old('transaction_type') == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('transaction_type') == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('transaction_type')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Category</label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('category_id') == 'all' ? 'selected' : '' }}>All Categories</option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Wallet</label>
                            <select name="wallet_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('wallet_id') == 'all' ? 'selected' : '' }}>All Wallets</option>
                                @foreach ($wallets as $id => $name)
                                    <option value="{{ $id }}" {{ old('wallet_id') == $id ? 'selected' : '' }}>
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Person</label>
                            <select name="person_id"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('person_id') == 'all' ? 'selected' : '' }}>All People</option>
                                @foreach ($people as $id => $name)
                                    <option value="{{ $id }}" {{ old('person_id') == $id ? 'selected' : '' }}>
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
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Amount Filter (Optional)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Amount</label>
                                <input type="number" min="0" max="1000000" step="0.01" name="amount"
                                       value="{{ old('amount') }}" placeholder="e.g., 100.00"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                @error('amount')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Filter Type</label>
                                <select name="amount_filter"
                                        class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    <option value="=" {{ old('amount_filter') == '=' ? 'selected' : '' }}>Equal To</option>
                                    <option value="<" {{ old('amount_filter') == '<' ? 'selected' : '' }}>Less Than</option>
                                    <option value=">" {{ old('amount_filter') == '>' ? 'selected' : '' }}>Greater Than</option>
                                </select>
                                @error('amount_filter')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Report Format -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report Format</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @php
                                $reportFormats = [
                                    'pdf' => ['label' => 'PDF', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'red'],
                                    'csv' => ['label' => 'CSV', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'green'],
                                    'xlsx' => ['label' => 'Excel', 'icon' => 'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2', 'color' => 'blue'],
                                    'html' => ['label' => 'HTML', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'color' => 'orange']
                                ];
                            @endphp
                            @foreach ($reportFormats as $value => $format)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="report_format" value="{{ $value }}" 
                                           {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all 
                                        peer-checked:border-{{ $format['color'] }}-500 peer-checked:bg-{{ $format['color'] }}-50 
                                        dark:peer-checked:bg-{{ $format['color'] }}-900/30 
                                        hover:border-{{ $format['color'] }}-300">
                                        <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-{{ $format['color'] }}-600 dark:peer-checked:text-{{ $format['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $format['icon'] }}"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 peer-checked:text-{{ $format['color'] }}-700 dark:text-gray-300 dark:peer-checked:text-{{ $format['color'] }}-300">{{ $format['label'] }}</span>
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
                        <span class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                        <span class="relative flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generate Transaction Report
                        </span>
                    </button>
                </form>
            </div>
        
            {{-- <!-- Budget Report Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-900 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white">Budget Report</h2>
                            <p class="text-blue-100 dark:text-blue-200 text-sm">Budget analysis & tracking</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date Range</label>
                            <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                @foreach ($dateRanges as $value => $label)
                                    <option value="{{ $value }}" {{ old('date_range') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('date_range')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Custom Date Range -->
                        <div x-show="dateRange === 'custom'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start Date</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                @error('start_date')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End Date</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                @error('end_date')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Category</label>
                        <select name="budget_category_id"
                                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <option value="all" {{ old('budget_category_id') == 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('budget_category_id') == $id ? 'selected' : '' }}>
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
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report Format</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach ($reportFormats as $value => $format)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="report_format" value="{{ $value }}" 
                                           {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-blue-300">
                                        <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $format['icon'] }}"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 peer-checked:text-blue-700 dark:text-gray-300 dark:peer-checked:text-blue-300">{{ $format['label'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('report_format')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Info Note -->
                    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">Report Information</h4>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    This report shows all budgets created within the specified date range. 
                                    For detailed budget utilization, visit the 
                                    <a href="{{ route('budgets.index') }}" class="underline hover:no-underline font-medium">Budgets section</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Generate Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-900 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-blue-600 hover:to-indigo-700 dark:hover:from-blue-800 dark:hover:to-indigo-950 hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 group relative overflow-hidden">
                        <!-- Button shine effect -->
                        <span class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                        <span class="relative flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generate Budget Report
                        </span>
                    </button>
                </form>
            </div>
        
            <!-- Support Tickets Report Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-700 dark:to-pink-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-white">Support Ticket Report</h2>
                            <p class="text-purple-100 dark:text-purple-200 text-sm">Customer support analysis</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Date Range</label>
                            <select name="date_range" x-model="dateRange"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                @foreach ($dateRanges as $value => $label)
                                    <option value="{{ $value }}" {{ old('date_range') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('date_range')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Custom Date Range -->
                        <div x-show="dateRange === 'custom'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Start Date</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                @error('start_date')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">End Date</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}" max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
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
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Ticket Status</label>
                            <select name="status"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <option value="all" {{ old('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                <option value="opened" {{ old('status') == 'opened' ? 'selected' : '' }}>Open</option>
                                <option value="admin_replied" {{ old('status') == 'admin_replied' ? 'selected' : '' }}>Admin Replied</option>
                                <option value="customer_replied" {{ old('status') == 'customer_replied' ? 'selected' : '' }}>Customer Replied</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Include Trashed -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_trashed" value="1" {{ old('is_trashed') ? 'checked' : '' }}
                                       class="w-4 h-4 text-purple-600 dark:text-purple-400 bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-200">Include deleted tickets</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-7">Check this to include soft-deleted tickets in the report</p>
                            @error('is_trashed')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Report Format -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Report Format</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach ($reportFormats as $value => $format)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="report_format" value="{{ $value }}" 
                                           {{ old('report_format', 'pdf') == $value ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/30 hover:border-purple-300">
                                        <svg class="w-5 h-5 mx-auto mb-1 text-gray-400 peer-checked:text-purple-600 dark:peer-checked:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $format['icon'] }}"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-600 peer-checked:text-purple-700 dark:text-gray-300 dark:peer-checked:text-purple-300">{{ $format['label'] }}</span>
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
                        <span class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                        <span class="relative flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generate Ticket Report
                        </span>
                    </button>
                </form>
            </div> --}}
        </div>

        {{-- <!-- Recent Reports Section -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recent Reports
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Quick access to your recently generated reports</p>
            </div>
            
            <div class="p-6">
                <!-- Placeholder for recent reports -->
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Recent Reports</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Generate your first report using the forms above</p>
                    <div class="flex flex-col sm:flex-row gap-2 justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Fast Generation
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Multiple Formats
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Advanced Filters
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}
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
        console.log('Current date:', '{{ date("Y-m-d H:i:s") }}');
    </script>

    <!-- Enhanced Styles -->
    <style>
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Enhanced form styling */
        input:focus, select:focus {
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
            
            .space-y-8 > * + * {
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
        input[type="radio"]:checked + div {
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