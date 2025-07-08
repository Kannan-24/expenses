<x-html-report-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Financial Budget Report</h1>
                    <p class="text-gray-600 mb-2">
                        Comprehensive analysis of budget performance and utilization
                    </p>
                    <p class="text-sm text-gray-500">
                        @if($dateRange[0] && $dateRange[1])
                            {{ $dateRange[0]->format('M d, Y') }} - {{ $dateRange[1]->format('M d, Y') }}
                        @else
                            All Time
                        @endif
                    </p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'pdf']) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export PDF
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['report_format' => 'xlsx']) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Report Parameters -->
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mb-8">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Report Parameters</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Date Range:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                        @if($dateRange[0] && $dateRange[1])
                            {{ $dateRange[0]->format('M d, Y') }} to {{ $dateRange[1]->format('M d, Y') }}
                        @else
                            All Time
                        @endif
                    </span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Total Budgets:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ $summary['total_budgets'] }}</span>
                </div>
                @if(isset($filters['budget_category_id']))
                    <div>
                        <span class="font-medium text-gray-600">Category Filter:</span>
                        <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">
                            @if($filters['budget_category_id'] == 'all')
                                All Categories
                            @else
                                {{ $category->name ?? 'N/A' }}
                            @endif
                        </span>
                    </div>
                @endif
                <div>
                    <span class="font-medium text-gray-600">Generated:</span>
                    <span class="ml-2 px-2 py-1 bg-white border rounded text-gray-800">{{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-wallet text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Total Budgeted</p>
                        <p class="text-2xl font-bold text-blue-900">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_budgeted'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-credit-card text-red-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-red-600">Total Spent</p>
                        <p class="text-2xl font-bold text-red-900">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_spent'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-piggy-bank text-green-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Total Remaining</p>
                        <p class="text-2xl font-bold text-green-900">
                            {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_remaining'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-yellow-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Avg Utilization</p>
                        <p class="text-2xl font-bold text-yellow-900">
                            {{ number_format($summary['average_utilization'], 1) }}%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-gray-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Over Budget</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $summary['over_budget_count'] }}/{{ $summary['total_budgets'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Insights Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                Budget Insights
            </h3>
            <div class="space-y-3">
                @if($summary['over_budget_count'] > 0)
                    <div class="border-l-4 border-red-500 bg-red-50 p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-red-800 font-semibold">Alert</h4>
                                <p class="text-red-700">{{ $summary['over_budget_count'] }} budget(s) are over their allocated amount.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($summary['overall_utilization'] > 90)
                    <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-warning text-yellow-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-yellow-800 font-semibold">High Utilization</h4>
                                <p class="text-yellow-700">Overall budget utilization is {{ number_format($summary['overall_utilization'], 1) }}%.</p>
                            </div>
                        </div>
                    </div>
                @elseif($summary['overall_utilization'] < 50)
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-blue-800 font-semibold">Low Utilization</h4>
                                <p class="text-blue-700">Overall budget utilization is {{ number_format($summary['overall_utilization'], 1) }}%. Consider budget reallocation.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-l-4 border-green-500 bg-green-50 p-4">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-green-800 font-semibold">Good Performance</h4>
                                <p class="text-green-700">Budget utilization is at a healthy {{ number_format($summary['overall_utilization'], 1) }}%.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @php
                    $topSpendingBudget = $budgets->sortByDesc('total_spent')->first();
                    $mostEfficientBudget = $budgets->where('budget_utilization', '>', 0)->where('budget_utilization', '<', 100)->sortByDesc('budget_utilization')->first();
                @endphp

                @if($topSpendingBudget)
                    <div class="border-l-4 border-purple-500 bg-purple-50 p-4">
                        <div class="flex">
                            <i class="fas fa-trophy text-purple-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-purple-800 font-semibold">Highest Spending</h4>
                                <p class="text-purple-700">
                                    <strong>{{ $topSpendingBudget->category->name }}</strong> category with 
                                    {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($topSpendingBudget->total_spent, 2) }} spent.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($mostEfficientBudget)
                    <div class="border-l-4 border-indigo-500 bg-indigo-50 p-4">
                        <div class="flex">
                            <i class="fas fa-star text-indigo-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-indigo-800 font-semibold">Most Efficient</h4>
                                <p class="text-indigo-700">
                                    <strong>{{ $mostEfficientBudget->category->name }}</strong> category with 
                                    {{ number_format($mostEfficientBudget->budget_utilization, 1) }}% utilization.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Enhanced Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
            <!-- Budget Utilization Doughnut Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                    Budget vs Spent
                </h3>
                <canvas id="utilizationChart" height="300"></canvas>
            </div>

            <!-- Budget Status Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-bar text-green-500 mr-2"></i>
                    Status Distribution
                </h3>
                <canvas id="statusChart" height="300"></canvas>
            </div>

            <!-- Category Performance Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-line text-purple-500 mr-2"></i>
                    Top Categories by Spending
                </h3>
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>

        <!-- Additional Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Budget Utilization Percentage Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-percentage text-orange-500 mr-2"></i>
                    Utilization Percentages
                </h3>
                <canvas id="utilizationPercentageChart" height="250"></canvas>
            </div>

            <!-- Budget Frequency Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-calendar text-indigo-500 mr-2"></i>
                    Budget Frequency Distribution
                </h3>
                <canvas id="frequencyChart" height="250"></canvas>
            </div>
        </div>

        @if(!$budgets->isEmpty())
            <!-- Detailed Budget Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-table text-gray-600 mr-2"></i>
                        Budget Details
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budgeted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilization</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll Over</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($budgets as $budget)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $budget->category_color ?? '#6B7280' }}"></div>
                                            <div class="text-sm font-medium text-gray-900">{{ $budget->category->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->total_spent, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $budget->remaining_amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->remaining_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2.5 mr-3">
                                                <div class="h-2.5 rounded-full transition-all duration-300"
                                                    style="width: {{ min($budget->budget_utilization, 100) }}%; 
                                                           background-color: {{ $budget->budget_utilization >= 100 ? '#dc2626' : ($budget->budget_utilization >= 80 ? '#f59e0b' : '#10b981') }};">
                                                </div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ number_format($budget->budget_utilization, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $budget->status === 'over_budget' ? 'bg-red-100 text-red-800' : 
                                               ($budget->status === 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($budget->status === 'on_track' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $budget->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($budget->start_date)->format('M d') }} -
                                        {{ \Carbon\Carbon::parse($budget->end_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">
                                            {{ ucfirst($budget->frequency) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($budget->roll_over)
                                            <span class="text-green-600 font-bold">✓</span>
                                        @else
                                            <span class="text-gray-400">✗</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Budget History and Performance Analysis -->
            @if($budgets->whereNotNull('latest_history')->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Budget History Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-history text-blue-500 mr-2"></i>
                            Budget History Summary
                        </h3>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($budgets->whereNotNull('latest_history')->take(10) as $budget)
                                @if($budget->latest_history)
                                    <div class="border-l-4 border-blue-500 bg-gray-50 p-3 rounded-r">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-semibold text-gray-900">{{ $budget->category->name }}</h4>
                                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">
                                                {{ ucfirst($budget->latest_history['status'] ?? 'N/A') }}
                                            </span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600">
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <span class="font-medium">Allocated:</span>
                                                    {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->latest_history['allocated_amount'] ?? 0, 2) }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">Roll-over:</span>
                                                    {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->latest_history['roll_over_amount'] ?? 0, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Performance Analysis -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-chart-line text-green-500 mr-2"></i>
                            Category Performance Analysis
                        </h3>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @php $sortedBudgets = $budgets->sortByDesc('budget_utilization'); @endphp
                            @foreach($sortedBudgets->take(8) as $budget)
                                <div class="border-l-4 border-green-500 bg-gray-50 p-3 rounded-r">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $budget->category_color ?? '#6B7280' }}"></div>
                                            <h4 class="font-semibold text-gray-900">{{ $budget->category->name }}</h4>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded
                                            {{ $budget->status === 'over_budget' ? 'bg-red-100 text-red-800' : 
                                               ($budget->status === 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($budget->status === 'on_track' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $budget->status)) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <span>{{ number_format($budget->budget_utilization, 1) }}% utilized</span>
                                            <span>
                                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->total_spent, 2) }} of 
                                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->amount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <i class="fas fa-chart-pie text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Budget Data</h3>
                <p class="text-gray-500">No budgets found for the selected filters.</p>
            </div>
        @endif
    </div>

    <script>
        // Enhanced Chart Configurations
        Chart.defaults.plugins.legend.display = true;
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.responsive = true;

        // Budget Utilization Doughnut Chart
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        new Chart(utilizationCtx, {
            type: 'doughnut',
            data: {
                labels: ['Spent', 'Remaining'],
                datasets: [{
                    data: [{{ $summary['total_spent'] }}, {{ $summary['total_remaining'] }}],
                    backgroundColor: ['#EF4444', '#10B981'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = {{ $summary['total_budgeted'] }};
                                const percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': $' + value.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusData = {!! json_encode($budgets->groupBy('status')->map->count()) !!};
        
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(statusData).map(status => status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())),
                datasets: [{
                    label: 'Budget Count',
                    data: Object.values(statusData),
                    backgroundColor: ['#EF4444', '#F59E0B', '#10B981', '#6B7280'],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Category Performance Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const topCategories = {!! $budgets->sortByDesc('total_spent')->take(6)->values() !!};
        
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: topCategories.map(budget => budget.category.name),
                datasets: [{
                    label: 'Amount Spent',
                    data: topCategories.map(budget => budget.total_spent),
                    backgroundColor: '#8B5CF6',
                    borderWidth: 0,
                    borderRadius: 4
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
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Utilization Percentage Chart
        const utilizationPercentageCtx = document.getElementById('utilizationPercentageChart').getContext('2d');
        
        new Chart(utilizationPercentageCtx, {
            type: 'bar',
            data: {
                labels: {!! $budgets->pluck('category.name') !!},
                datasets: [{
                    label: 'Utilization %',
                    data: {!! $budgets->pluck('budget_utilization') !!},
                    backgroundColor: {!! $budgets->map(function($budget) {
                        return $budget->budget_utilization >= 100 ? '#dc2626' : ($budget->budget_utilization >= 80 ? '#f59e0b' : '#10b981');
                    }) !!},
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 120,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45
                        }
                    }
                }
            }
        });

        // Budget Frequency Distribution
        const frequencyCtx = document.getElementById('frequencyChart').getContext('2d');
        const frequencyData = {!! json_encode($budgets->groupBy('frequency')->map->count()) !!};
        
        new Chart(frequencyCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(frequencyData).map(freq => freq.charAt(0).toUpperCase() + freq.slice(1)),
                datasets: [{
                    data: Object.values(frequencyData),
                    backgroundColor: ['#6366F1', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</x-html-report-layout>