<x-html-report-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="w-full">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Financial Transactions Report</h1>
                    <p class="text-gray-600 mb-2">
                        Detailed analysis of your financial activities and transaction patterns
                    </p>
                    <p class="text-sm text-gray-500">
                        @if ($dateRange === 'custom')
                            {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
                        @else
                            {{ $dateRanges[$dateRange] ?? 'All Time' }}
                        @endif
                    </p>
                </div>
                <div class="flex justify-end flex-wrap gap-2 sm:gap-3 w-full lg:w-auto">
                    <button onclick="window.print()"
                        class="flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 w-full sm:w-auto">
                        Print
                    </button>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'pdf']) }}"
                        class="flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 w-full sm:w-auto">
                        Export PDF
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'xlsx']) }}"
                        class="flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 w-full sm:w-auto">
                        Export Excel
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'csv']) }}"
                        class="flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 w-full sm:w-auto">
                        Export CSV
                    </a>
                </div>
            </div>
        </div>


        <!-- Report Filters -->
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mb-8">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Applied Filters</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Date Range:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                        @if ($dateRange === 'custom')
                            {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
                        @else
                            {{ $dateRanges[$dateRange] ?? 'All Time' }}
                        @endif
                    </span>
                </div>

                <div>
                    <span class="font-medium text-gray-600">Type:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                        {{ $transactionType === 'all' ? 'All Types' : ucfirst($transactionType) }}
                    </span>
                </div>

                @if ($category)
                    <div>
                        <span class="font-medium text-gray-600">Category:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ $category->name }}</span>
                    </div>
                @endif

                @if ($wallet)
                    <div>
                        <span class="font-medium text-gray-600">Wallet:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ $wallet->name }}</span>
                    </div>
                @endif

                @if ($person)
                    <div>
                        <span class="font-medium text-gray-600">Person:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ $person->name }}</span>
                    </div>
                @endif

                @if ($amountFilter)
                    <div>
                        <span class="font-medium text-gray-600">Amount Filter:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                            {{ $amountFilter['operator'] }} {{ number_format($amountFilter['amount'], 2) }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Financial Health Score -->
        @php
            $totalTransactions = $transactions->count();
            $incomeTransactions = $transactions->where('type', 'income')->count();
            $expenseTransactions = $transactions->where('type', 'expense')->count();
            $incomeRatio =
                $totalTransactions > 0
                    ? ($summary['total_income'] / ($summary['total_income'] + $summary['total_expense'])) * 100
                    : 0;
            $savingsRate =
                $summary['total_income'] > 0
                    ? (($summary['total_income'] - $summary['total_expense']) / $summary['total_income']) * 100
                    : 0;

            // Calculate financial health score
            $healthScore = 0;
            if ($summary['net_total'] > 0) {
                $healthScore += 40;
            } // Positive net worth
            if ($savingsRate > 20) {
                $healthScore += 30;
            }
            // Good savings rate
            elseif ($savingsRate > 10) {
                $healthScore += 20;
            } elseif ($savingsRate > 0) {
                $healthScore += 10;
            }

            if ($incomeRatio > 60) {
                $healthScore += 20;
            }
            // Good income ratio
            elseif ($incomeRatio > 40) {
                $healthScore += 10;
            }

            if ($totalTransactions > 0) {
                $healthScore += 10;
            } // Active financial management

            $healthScore = min(100, max(0, $healthScore));
            $healthStatus =
                $healthScore >= 80
                    ? 'Excellent'
                    : ($healthScore >= 60
                        ? 'Good'
                        : ($healthScore >= 40
                            ? 'Fair'
                            : 'Needs Improvement'));
            $healthColor =
                $healthScore >= 80 ? 'green' : ($healthScore >= 60 ? 'blue' : ($healthScore >= 40 ? 'yellow' : 'red'));
        @endphp

        <!-- Financial Health Dashboard -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex gap-2">
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M5 14.9999H6.39445C7.1804 14.9999 7.57337 14.9999 7.90501 15.1774C8.23665 15.3549 8.45463 15.6819 8.8906 16.3358L9.05039 16.5755C9.47306 17.2095 9.68439 17.5265 9.97087 17.5095C10.2573 17.4925 10.4297 17.1527 10.7743 16.4731L12.7404 12.5964C13.0987 11.8898 13.2779 11.5365 13.5711 11.5247C13.8642 11.5129 14.0711 11.8508 14.485 12.5264L15.1222 13.5668C15.5512 14.2671 15.7656 14.6172 16.1072 14.8086C16.4487 14.9999 16.8593 14.9999 17.6805 14.9999H19"
                                stroke="#2563eb" stroke-width="1.5" stroke-linecap="round"></path>
                            <path
                                d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                stroke="#2563eb" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                    Financial Health Score
                </h3>
                <div class="text-right">
                    <div class="text-3xl font-bold text-{{ $healthColor }}-600">{{ $healthScore }}/100</div>
                    <div class="text-sm text-{{ $healthColor }}-600 font-medium">{{ $healthStatus }}</div>
                </div>
            </div>

            <!-- Health Score Bar -->
            <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                <div class="bg-{{ $healthColor }}-500 h-3 rounded-full transition-all duration-500"
                    style="width: {{ $healthScore }}%"></div>
            </div>

            <!-- Health Insights -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Savings Rate</span>
                        <span class="text-lg font-bold {{ $savingsRate > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($savingsRate, 1) }}%
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        @if ($savingsRate > 20)
                            Excellent! Keep it up
                        @elseif($savingsRate > 10)
                            Good savings habit
                        @elseif($savingsRate > 0)
                            Room for improvement
                        @else
                            Consider reducing expenses
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Income Ratio</span>
                        <span class="text-lg font-bold text-blue-600">{{ number_format($incomeRatio, 1) }}%</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $incomeRatio > 60 ? 'Strong income flow' : ($incomeRatio > 40 ? 'Balanced portfolio' : 'Focus on income') }}
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Activity Level</span>
                        <span class="text-lg font-bold text-purple-600">{{ $totalTransactions }}</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $totalTransactions > 50 ? 'Very active' : ($totalTransactions > 20 ? 'Active' : 'Low activity') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-arrow-up text-green-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Total Income</p>
                        <p class="text-2xl font-bold text-green-900">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_income'], 2) }}
                        </p>
                        <p class="text-xs text-green-700 mt-1">
                            {{ $incomeTransactions }} transactions
                            @if ($incomeTransactions > 0)
                                • Avg:
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_income'] / $incomeTransactions, 2) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-arrow-down text-red-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-red-600">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-900">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_expense'], 2) }}
                        </p>
                        <p class="text-xs text-red-700 mt-1">
                            {{ $expenseTransactions }} transactions
                            @if ($expenseTransactions > 0)
                                • Avg:
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_expense'] / $expenseTransactions, 2) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-balance-scale text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Net Amount</p>
                        <p
                            class="text-2xl font-bold {{ $summary['net_total'] >= 0 ? 'text-green-900' : 'text-red-900' }}">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['net_total'], 2) }}
                        </p>
                        <p class="text-xs text-blue-700 mt-1">
                            {{ $summary['net_total'] >= 0 ? 'Surplus' : 'Deficit' }}
                            @if ($summary['total_income'] > 0)
                                • {{ number_format($savingsRate, 1) }}% savings rate
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Insights Banner -->
        @if ($transactions->count() > 0)
            @php
                $topCategory = collect($categorySummary)->sortByDesc('amount')->first();
                $topCategoryName = collect($categorySummary)->sortByDesc('amount')->keys()->first();
                $largestTransaction = $transactions->sortByDesc('amount')->first();
                $mostActiveDay = $transactions
                    ->groupBy(function ($t) {
                        return $t->date->format('l');
                    })
                    ->sortByDesc(function ($group) {
                        return $group->count();
                    })
                    ->keys()
                    ->first();
            @endphp

            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                    Key Insights & Recommendations
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if ($topCategory)
                        <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                            <h4 class="font-semibold text-gray-900">Highest Spending Category</h4>
                            <p class="text-2xl font-bold text-purple-600">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($topCategory['amount'], 2) }}
                            </p>
                            <p class="text-sm text-gray-600">{{ $topCategoryName ?: 'Uncategorized' }}
                                ({{ number_format($topCategory['percentage'], 1) }}% of expenses)</p>
                        </div>
                    @endif

                    @if ($largestTransaction)
                        <div class="bg-white rounded-lg p-4 border-l-4 border-indigo-500">
                            <h4 class="font-semibold text-gray-900">Largest Single Transaction</h4>
                            <p
                                class="text-2xl font-bold {{ $largestTransaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($largestTransaction->amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600">{{ ucfirst($largestTransaction->type) }} on
                                {{ $largestTransaction->date->format('M d, Y') }}</p>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                        <h4 class="font-semibold text-gray-900">Most Active Day</h4>
                        <p class="text-2xl font-bold text-blue-600">{{ $mostActiveDay ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $mostActiveDay? $transactions->groupBy(function ($t) {return $t->date->format('l');})->get($mostActiveDay)->count() . ' transactions': 'No data' }}
                        </p>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mt-4 p-4 bg-white rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-2">💡 Smart Recommendations</h4>
                    <div class="text-sm text-gray-700 space-y-1">
                        @if ($savingsRate < 10)
                            <p>• Consider reducing expenses or increasing income to improve your savings rate (currently
                                {{ number_format($savingsRate, 1) }}%)</p>
                        @endif
                        @if ($topCategory && $topCategory['percentage'] > 40)
                            <p>• Your spending in "{{ $topCategoryName }}" is quite high
                                ({{ number_format($topCategory['percentage'], 1) }}%). Consider reviewing these
                                expenses.</p>
                        @endif
                        @if ($summary['net_total'] < 0)
                            <p>• You're currently spending more than earning. Focus on expense reduction or income
                                increase.</p>
                        @endif
                        @if ($transactions->count() < 10)
                            <p>• Consider tracking more transactions for better financial insights.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($transactions->count() > 0)
            <!-- Enhanced Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Income vs Expenses with Trends -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                        Income vs Expenses Breakdown
                    </h3>
                    <canvas id="typeChart" height="300"></canvas>
                    <div class="mt-4 text-center">
                        <div class="inline-flex items-center space-x-4 text-sm">
                            <span class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                Income: {{ number_format($incomeRatio, 1) }}%
                            </span>
                            <span class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                Expenses: {{ number_format(100 - $incomeRatio, 1) }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category Distribution Chart -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-doughnut text-purple-500 mr-2"></i>
                        Expense Categories
                    </h3>
                    <canvas id="categoryChart" height="300"></canvas>
                </div>

                <!-- Income Sources Analysis -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-bar text-green-500 mr-2"></i>
                        Income Sources Analysis
                    </h3>
                    <canvas id="incomeChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Monthly Trend with Forecasting -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-line text-indigo-500 mr-2"></i>
                        Monthly Financial Trends & Analysis
                    </h3>
                    <canvas id="trendChart" height="250"></canvas>

                    <!-- Trend Analysis Summary -->
                    @php
                        $monthlyData = $transactions
                            ->groupBy(function ($transaction) {
                                return $transaction->date->format('Y-m');
                            })
                            ->map(function ($group) {
                                return [
                                    'income' => $group->where('type', 'income')->sum('amount'),
                                    'expense' => $group->where('type', 'expense')->sum('amount'),
                                    'count' => $group->count(),
                                ];
                            });

                        $avgMonthlyIncome = $monthlyData->avg('income');
                        $avgMonthlyExpense = $monthlyData->avg('expense');
                        $trend =
                            $monthlyData->count() > 1
                                ? $monthlyData->last()['income'] -
                                    $monthlyData->last()['expense'] -
                                    ($monthlyData->first()['income'] - $monthlyData->first()['expense'])
                                : 0;
                    @endphp

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <h4 class="text-sm font-semibold text-green-700">Avg Monthly Income</h4>
                            <p class="text-xl font-bold text-green-800">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($avgMonthlyIncome, 2) }}
                            </p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4 text-center">
                            <h4 class="text-sm font-semibold text-red-700">Avg Monthly Expenses</h4>
                            <p class="text-xl font-bold text-red-800">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($avgMonthlyExpense, 2) }}
                            </p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <h4 class="text-sm font-semibold text-blue-700">Net Trend</h4>
                            <p class="text-xl font-bold {{ $trend >= 0 ? 'text-green-800' : 'text-red-800' }}">
                                {{ $trend >= 0 ? '+' : '' }}{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($trend, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Weekly Pattern Analysis -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calendar-week text-orange-500 mr-2"></i>
                        Weekly Spending Patterns
                    </h3>
                    <canvas id="weeklyChart" height="200"></canvas>
                </div>
            </div>

            <!-- Detailed Transaction Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-table text-gray-600 mr-2"></i>
                            Transaction Details
                        </h3>
                        <div class="text-sm text-gray-500">
                            Showing {{ $transactions->count() }} transactions
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                @if ($category == null)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                @endif
                                @if ($person == null)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Person</th>
                                @endif
                                @if ($wallet == null)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Wallet</th>
                                @endif
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Notes</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Running Balance</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $runningBalance = 0; @endphp
                            @foreach ($transactions->sortBy('date') as $transaction)
                                @php
                                    $runningBalance +=
                                        $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>
                                            {{ $transaction->date->format('M d, Y') }}
                                            <div class="text-xs text-gray-500">{{ $transaction->date->format('l') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i
                                                class="fas fa-arrow-{{ $transaction->type === 'income' ? 'up' : 'down' }} mr-1"></i>
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold 
                                        {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    @if ($category == null)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 rounded-full mr-2"
                                                    style="background-color: {{ $transaction->category->color ?? '#6B7280' }}">
                                                </div>
                                                <span
                                                    class="text-sm text-gray-900">{{ $transaction->category->name ?? 'Uncategorized' }}</span>
                                            </div>
                                        </td>
                                    @endif
                                    @if ($person == null)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->person->name ?? '-' }}
                                        </td>
                                    @endif
                                    @if ($wallet == null)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->wallet->name ?? 'Default' }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                        <div class="truncate" title="{{ $transaction->note }}">
                                            {{ $transaction->note ?? '-' }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $runningBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($runningBalance, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Category Summary with Enhanced Insights -->
            @if (!$category && count($categorySummary) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-chart-bar text-gray-600 mr-2"></i>
                            Category Analysis & Insights
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Count</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Avg per Transaction</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Percentage</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Trend</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Visual</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($categorySummary as $categoryName => $data)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-4 h-4 rounded-full mr-3 bg-red-500"></div>
                                                <div>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $categoryName ?: 'Uncategorized' }}</span>
                                                    @if ($data['percentage'] > 30)
                                                        <span
                                                            class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">High
                                                            Spend</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($data['amount'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $data['count'] }} transactions
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($data['amount'] / $data['count'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $data['percentage'] ? number_format($data['percentage'], 1) . '%' : '0%' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $trendIcon =
                                                    $data['percentage'] > 20
                                                        ? '📈'
                                                        : ($data['percentage'] > 10
                                                            ? '➡️'
                                                            : '📉');
                                                $trendText =
                                                    $data['percentage'] > 20
                                                        ? 'High'
                                                        : ($data['percentage'] > 10
                                                            ? 'Medium'
                                                            : 'Low');
                                            @endphp
                                            <span class="text-sm">{{ $trendIcon }} {{ $trendText }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-full bg-gray-200 rounded-full h-3">
                                                <div class="bg-gradient-to-r from-red-400 to-red-600 h-3 rounded-full transition-all duration-500"
                                                    style="width: {{ $data['percentage'] }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Advanced Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Daily Average with Insights -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                        Daily Financial Analytics
                    </h3>
                    <div class="space-y-4">
                        @php
                            $daysDiff =
                                $dateRange === 'custom' && $startDate && $endDate
                                    ? $startDate->diffInDays($endDate) + 1
                                    : ($transactions->count() > 0
                                        ? $transactions->min('date')->diffInDays($transactions->max('date')) + 1
                                        : 1);
                        @endphp

                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Daily Average Income</span>
                                <span
                                    class="text-lg font-bold text-green-600">{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_income'] / $daysDiff, 2) }}</span>
                            </div>
                            <div class="text-xs text-green-600 mt-1">
                                {{ number_format($incomeTransactions / $daysDiff, 1) }} income transactions per day
                            </div>
                        </div>

                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Daily Average Expense</span>
                                <span
                                    class="text-lg font-bold text-red-600">{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_expense'] / $daysDiff, 2) }}</span>
                            </div>
                            <div class="text-xs text-red-600 mt-1">
                                {{ number_format($expenseTransactions / $daysDiff, 1) }} expense transactions per day
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Daily Net Average</span>
                                <span
                                    class="text-lg font-bold {{ $summary['net_total'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['net_total'] / $daysDiff, 2) }}
                                </span>
                            </div>
                            <div
                                class="text-xs {{ $summary['net_total'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                {{ $summary['net_total'] >= 0 ? 'Building wealth' : 'Depleting funds' }} daily
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Frequency & Patterns -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-clock text-purple-500 mr-2"></i>
                        Transaction Patterns & Insights
                    </h3>
                    <div class="space-y-4">
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Transactions per Day</span>
                                <span
                                    class="text-lg font-bold text-purple-600">{{ number_format($transactions->count() / $daysDiff, 1) }}</span>
                            </div>
                            <div class="text-xs text-purple-600 mt-1">
                                {{ $transactions->count() / $daysDiff > 3 ? 'Very active' : ($transactions->count() / $daysDiff > 1 ? 'Active' : 'Low activity') }}
                                spending pattern
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Most Active Day</span>
                                <span class="text-lg font-bold text-indigo-600">
                                    {{ $transactions->groupBy(function ($t) {return $t->date->format('l');})->sortByDesc(function ($group) {return $group->count();})->keys()->first() ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="text-xs text-indigo-600 mt-1">
                                Plan budget reviews accordingly
                            </div>
                        </div>

                        <div class="bg-teal-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Analysis Period</span>
                                <span class="text-lg font-bold text-teal-600">{{ $daysDiff }} days</span>
                            </div>
                            <div class="text-xs text-teal-600 mt-1">
                                {{ $daysDiff > 30 ? 'Long-term trend available' : 'Short-term snapshot' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Enhanced No Data State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-receipt text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Transactions Found</h3>
                    <p class="text-gray-500 mb-6">No transactions match the selected criteria. Try adjusting your
                        filters to see more data.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Try This</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Expand date range</li>
                                <li>• Remove category filters</li>
                                <li>• Check "All Types"</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Quick Actions</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Add new transaction</li>
                                <li>• Import from CSV</li>
                                <li>• Check other wallets</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Professional Report Footer -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-6 mt-8">
            <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center">
                <div class="mb-4 md:mb-0">
                    <h4 class="font-semibold text-gray-900 mb-2">Report Summary</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                        <span><strong>Transactions:</strong> {{ $transactions->count() }}</span>
                        <span><strong>Categories:</strong>
                            {{ $transactions->pluck('category.name')->unique()->count() }}</span>
                        <span><strong>Date Range:</strong> {{ $daysDiff ?? 'N/A' }} days</span>
                        <span><strong>Health Score:</strong> {{ $healthScore }}/100</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600 mb-1">
                        <strong>Generated:</strong> {{ now()->format('M d, Y H:i:s') }}
                    </div>
                    <div class="text-sm text-gray-600 mb-1">
                        <strong>User:</strong> {{ auth()->user()->name }}
                    </div>
                    <div class="text-xs text-gray-500">
                        This report contains confidential financial information
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Chart.js Configuration
        Chart.defaults.plugins.legend.display = true;
        Chart.defaults.plugins.legend.position = 'bottom';

        // Income vs Expenses Chart with enhanced styling
        const typeCtx = document.getElementById('typeChart').getContext('2d');
        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    data: [{{ $summary['total_income'] }}, {{ $summary['total_expense'] }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = {{ $summary['total_income'] + $summary['total_expense'] }};
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return context.label +
                                    ': {{ auth()->user()->preferences->defaultCurrency->symbol }}' + value
                                    .toLocaleString() + ' (' + percentage +
                                    '%)';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = {!! json_encode($categorySummary) !!};

        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(categoryData).map(name => name || 'Uncategorized'),
                datasets: [{
                    data: Object.values(categoryData).map(item => item.amount),
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(132, 204, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(6, 182, 212, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = Object.values(categoryData).reduce((sum, item) => sum + item
                                    .amount, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return context.label +
                                    ': {{ auth()->user()->preferences->defaultCurrency->symbol }}' + value
                                    .toLocaleString() + ' (' + percentage +
                                    '%)';
                            }
                        }
                    }
                }
            }
        });

        // Income Sources Chart
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        const incomeByCategory = {!! json_encode(
            $transactions->where('type', 'income')->groupBy('category.name')->map(function ($group) {
                    return $group->sum('amount');
                }),
        ) !!};

        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(incomeByCategory).map(name => name || 'Uncategorized'),
                datasets: [{
                    label: 'Income by Category',
                    data: Object.values(incomeByCategory),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '{{ auth()->user()->preferences->defaultCurrency->symbol }}' + value
                                    .toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Enhanced Monthly Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const monthlyData = {!! json_encode(
            $transactions->groupBy(function ($transaction) {
                    return $transaction->date->format('Y-m');
                })->map(function ($group) {
                    return [
                        'income' => $group->where('type', 'income')->sum('amount'),
                        'expense' => $group->where('type', 'expense')->sum('amount'),
                        'net' =>
                            $group->where('type', 'income')->sum('amount') - $group->where('type', 'expense')->sum('amount'),
                    ];
                }),
        ) !!};

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: Object.keys(monthlyData),
                datasets: [{
                    label: 'Income',
                    data: Object.values(monthlyData).map(item => item.income),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: false,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Expenses',
                    data: Object.values(monthlyData).map(item => item.expense),
                    borderColor: 'rgba(239, 68, 68, 1)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: false,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Net Amount',
                    data: Object.values(monthlyData).map(item => item.net),
                    borderColor: 'rgba(99, 102, 241, 1)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: false,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    borderDash: [5, 5]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '{{ auth()->user()->preferences->defaultCurrency->symbol }}' + value
                                    .toLocaleString();
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Weekly Pattern Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyData = {!! json_encode(
            $transactions->groupBy(function ($transaction) {
                    return $transaction->date->format('l');
                })->map(function ($group) {
                    return $group->sum('amount');
                }),
        ) !!};

        new Chart(weeklyCtx, {
            type: 'radar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Total Transaction Amount',
                    data: [
                        weeklyData['Monday'] || 0,
                        weeklyData['Tuesday'] || 0,
                        weeklyData['Wednesday'] || 0,
                        weeklyData['Thursday'] || 0,
                        weeklyData['Friday'] || 0,
                        weeklyData['Saturday'] || 0,
                        weeklyData['Sunday'] || 0
                    ],
                    fill: true,
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(99, 102, 241, 1)'
                }]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: false
                        },
                        suggestedMin: 0
                    }
                }
            }
        });
    </script>
</x-html-report-layout>
