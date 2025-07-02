<div class=" space-y-6">

    <!-- Enhanced Welcome Message with Time-based Greeting -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute -top-4 -right-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        <div class="relative p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold mb-2">
                        Good <span id="greeting"></span>, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 text-lg mb-4 lg:mb-0">
                        Here's your financial overview for this month
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-4">
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Current Date</p>
                        <p class="text-xl font-semibold" id="currentDate"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Income Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month's</p>
                            <p class="text-lg font-bold text-gray-900">Income</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalIncome, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">+12% from last month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ↗ +12%
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-green-400 to-green-600"></div>
        </div>

        <!-- Expense Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month's</p>
                            <p class="text-lg font-bold text-gray-900">Expense</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-red-600">₹{{ number_format($totalExpense, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">-8% from last month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            ↘ -8%
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
        </div>

        <!-- Net Balance Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Net</p>
                            <p class="text-lg font-bold text-gray-900">Balance</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold {{ $monthlyNetBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                            ₹{{ number_format($monthlyNetBalance, 2) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Current month</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $monthlyNetBalance >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                            {{ $monthlyNetBalance >= 0 ? '📈 Profit' : '📉 Loss' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r {{ $monthlyNetBalance >= 0 ? 'from-blue-400 to-blue-600' : 'from-red-400 to-red-600' }}"></div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Transactions - Takes 2 columns -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Recent Transactions
                    </h3>
                    <a href="{{ route('transactions.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">#</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Date</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Type</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Method</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($recentExpenses as $expense)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $expense->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $expense->type === 'income' ? '↗ Income' : '↘ Expense' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if ($expense->payment_method === 'cash')
                                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                                                <span class="text-sm text-gray-600">Cash</span>
                                            @else
                                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                                <span class="text-sm text-gray-600">Bank</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-sm font-semibold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $expense->type === 'income' ? '+' : '-' }}₹{{ number_format($expense->amount, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">No recent transactions</p>
                                            <p class="text-gray-400 text-sm">Your transactions will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Enhanced Wallets Widget -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        My Wallets
                    </h3>
                    <a href="{{ route('wallets.index') }}"
                        class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center">
                        Manage
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @foreach ($wallets as $wallet)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $wallet->name }}</p>
                                <p class="text-sm text-gray-500">{{ $wallet->type ?? 'Savings' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg text-gray-900">₹{{ number_format($wallet->balance, 2) }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Total Balance</p>
                                <p class="text-sm text-gray-600">All wallets combined</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($wallets->sum('balance'), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Categories Chart -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Top Spending Categories
                </h3>
            </div>
            <div class="p-6">
                <canvas id="topCategoriesChart" height="150"></canvas>
            </div>
        </div>

        <!-- Budget Usage Chart -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Budget vs Spending
                </h3>
            </div>
            <div class="p-6">
                <canvas id="budgetChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Overview Table -->
    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                </svg>
                Monthly Financial Summary
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">#</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Month</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Income</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Expense</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-700 text-sm">Net</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($monthlyData as $month)
                            @php
                                $netAmount = $month->total_income - $month->total_expense;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('F Y') }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-green-600">
                                        +₹{{ number_format($month->total_income, 2) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-red-600">
                                        -₹{{ number_format($month->total_expense, 2) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-bold {{ $netAmount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $netAmount >= 0 ? '+' : '' }}₹{{ number_format($netAmount, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">No monthly data available</p>
                                        <p class="text-gray-400 text-sm">Start adding transactions to see your monthly summary</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart Section -->
    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Income vs Expense Trends
                </h3>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Period:</label>
                    <select id="dateRangeSelector"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="7d" selected>Last 7 Days</option>
                        <option value="30d">Last 30 Days</option>
                        <option value="3m">Last 3 Months</option>
                        <option value="6m">Last 6 Months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="relative">
                <canvas id="incomeExpenseChart" height="100"></canvas>
            </div>
        </div>
    </div>

</div>


@if (session('just_registered'))
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            event: 'expense_register_success',
            method: '{{ session('registration_method', 'email') }}'
        });
    </script>

    {{-- Clear the session so it only fires once --}}
    @php
        session()->forget('just_registered');
        session()->forget('registration_method');
    @endphp
@endif

<script>
    // Dynamic greeting and date
    function updateGreetingAndDate() {
        const now = new Date();
        const hour = now.getHours();
        let greeting;
        
        if (hour < 12) greeting = 'Morning';
        else if (hour < 17) greeting = 'Afternoon';
        else greeting = 'Evening';
        
        document.getElementById('greeting').textContent = greeting;
        
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
    }
    
    updateGreetingAndDate();

    let incomeExpenseChart;

    async function loadChart(range = '7d') {
        try {
            const response = await fetch(`{{ route('chart.data') }}?range=${range}`);
            const res = await response.json();

            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');

            if (incomeExpenseChart) {
                incomeExpenseChart.destroy();
            }

            incomeExpenseChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: res.labels,
                    datasets: [{
                            label: 'Income',
                            data: res.income,
                            backgroundColor: 'rgba(34,197,94,0.1)',
                            borderColor: 'rgba(34,197,94,1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(34,197,94,1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Expense',
                            data: res.expense,
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            borderColor: 'rgba(239,68,68,1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(239,68,68,1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#374151',
                            bodyColor: '#374151',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₹' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: value => '₹' + value.toLocaleString()
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error loading chart data:', error);
        }
    }

    document.getElementById('dateRangeSelector').addEventListener('change', function() {
        loadChart(this.value);
    });

    window.addEventListener('load', () => {
        loadChart();
    });

    // Enhanced Top Categories Chart
    const topCategoriesCTX = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCategoriesCTX, {
        type: 'bar',
        data: {
            labels: @json($topCategories->pluck('name')),
            datasets: [{
                label: 'Total Amount',
                data: @json($topCategories->pluck('total_amount')),
                backgroundColor: [
                    'rgba(59,130,246,0.8)',
                    'rgba(16,185,129,0.8)',
                    'rgba(245,158,11,0.8)',
                    'rgba(239,68,68,0.8)',
                    'rgba(139,92,246,0.8)'
                ],
                borderColor: [
                    'rgba(59,130,246,1)',
                    'rgba(16,185,129,1)',
                    'rgba(245,158,11,1)',
                    'rgba(239,68,68,1)',
                    'rgba(139,92,246,1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Spent: ₹' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Enhanced Budget Chart
    const budgetChartCTX = document.getElementById('budgetChart').getContext('2d');
    const budgetData = @json($budgetData);

    const labels = budgetData.map(item => item.category);
    const allocated = budgetData.map(item => item.allocated);
    const spent = budgetData.map(item => item.spent);

    const budgetChart = new Chart(budgetChartCTX, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Budget Allocated',
                    data: allocated,
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                },
                {
                    label: 'Amount Spent',
                    data: spent,
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#374151',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ₹${context.parsed.y.toFixed(2)}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>