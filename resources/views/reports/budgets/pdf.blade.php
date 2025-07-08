<x-pdf-layout>
    <x-slot name="title">Budget Report</x-slot>

    <style>
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }

        .filters-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 10px 0;
            margin-bottom: 25px;
        }

        .filters-title {
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .filter-item {
            margin-top: 10px;
            display: inline-block;
            margin-right: 20px;
        }

        .filter-label {
            display: inline-block;
            color: #4b5563;
            font-weight: bold;
            font-size: 10px;
        }

        .filter-value {
            display: inline-block;
            color: #111827;
            padding: 2px 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            font-size: 10px;
        }

        .summary-cards {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary-card {
            width: calc(20% - 29.08px);
            display: inline-block;
            vertical-align: top;
            padding: 8px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            text-align: center;
            margin-right: 10px;
        }

        .summary-card:last-child {
            margin-right: 0;
        }

        .summary-card.budgeted {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .summary-card.spent {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .summary-card.remaining {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .summary-card.utilization {
            background: #fefce8;
            border-color: #fde047;
        }

        .summary-card.status {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .summary-card h3 {
            margin: 0 0 5px 0;
            font-size: 9px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-card .amount {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .budgeted .amount {
            color: #2563eb;
        }

        .spent .amount {
            color: #dc2626;
        }

        .remaining .amount {
            color: #059669;
        }

        .utilization .amount {
            color: #d97706;
        }

        .status .amount {
            color: #6b7280;
        }

        .insights-section {
            background: #fefefe;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 25px;
        }

        .insights-title {
            color: #374151;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .insight-item {
            font-size: 10px;
            margin-bottom: 8px;
            padding: 5px;
            border-left: 3px solid #2563eb;
            background: #f8fafc;
        }

        .insight-item.warning {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .insight-item.danger {
            border-left-color: #dc2626;
            background: #fef2f2;
        }

        .table-container {
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        thead th {
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 8px;
            border-right: 1px solid #cbd5e1;
        }

        thead th:last-child {
            border-right: none;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody td {
            padding: 5px 4px;
            border-right: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tbody td:last-child {
            border-right: none;
        }

        .amount-positive {
            color: #059669;
            font-weight: bold;
        }

        .amount-negative {
            color: #dc2626;
            font-weight: bold;
        }

        .amount-neutral {
            color: #374151;
            font-weight: bold;
        }

        .utilization-bar {
            width: 40px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }

        .utilization-progress {
            height: 100%;
            display: block;
            border-radius: 3px;
        }

        .status-badge {
            padding: 2px 4px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .status-on-track {
            background: #dcfce7;
            color: #166534;
        }

        .status-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .status-over-budget {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-under-utilized {
            background: #f3f4f6;
            color: #374151;
        }

        .category-color {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }

        .frequency-badge {
            padding: 1px 3px;
            font-size: 7px;
            background: #e5e7eb;
            color: #374151;
            border-radius: 2px;
        }

        .roll-over-indicator {
            font-size: 7px;
            color: #059669;
            font-weight: bold;
        }

        .budget-history {
            margin-top: 25px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
        }

        .budget-history h3 {
            color: #374151;
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .history-item {
            font-size: 9px;
            border-bottom: 1px solid #e5e7eb;
            padding: 4px 0;
            display: flex;
            justify-content: space-between;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .footer-grid {
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
        }

        .page-break {
            page-break-before: always;
        }

        .two-column {
            display: flex;
            justify-content: space-between;
        }

        .column {
            width: 48%;
        }
    </style>

    <div class="header">
        <h1>Financial Budget Report</h1>
        <p class="subtitle">Comprehensive analysis of budget performance and utilization</p>
    </div>

    <div class="filters-section">
        <h3 class="filters-title">Report Parameters</h3>
        <div class="filter-grid">
            <div class="filter-item">
                <span class="filter-label">Date Range:</span>
                <span class="filter-value">
                    @if($dateRange[0] && $dateRange[1])
                        {{ $dateRange[0]->format('M d, Y') }} to {{ $dateRange[1]->format('M d, Y') }}
                    @else
                        All Time
                    @endif
                </span>
            </div>

            <div class="filter-item">
                <span class="filter-label">Total Budgets:</span>
                <span class="filter-value">{{ $summary['total_budgets'] }}</span>
            </div>

            @if(isset($filters['budget_category_id']))
                <div class="filter-item">
                    <span class="filter-label">Category Filter:</span>
                    <span class="filter-value">
                        @if($filters['budget_category_id'] == 'all')
                            All Categories
                        @else
                            {{ $category->name ?? 'N/A' }}
                        @endif
                    </span>
                </div>
            @endif

            <div class="filter-item">
                <span class="filter-label">Generated:</span>
                <span class="filter-value">{{ now()->format('M d, Y H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card budgeted">
            <h3>Total Budgeted</h3>
            <p class="amount">{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_budgeted'], 2) }}</p>
        </div>
        <div class="summary-card spent">
            <h3>Total Spent</h3>
            <p class="amount">{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_spent'], 2) }}</p>
        </div>
        <div class="summary-card remaining">
            <h3>Total Remaining</h3>
            <p class="amount">{{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($summary['total_remaining'], 2) }}</p>
        </div>
        <div class="summary-card utilization">
            <h3>Avg Utilization</h3>
            <p class="amount">{{ number_format($summary['average_utilization'], 1) }}%</p>
        </div>
        <div class="summary-card status">
            <h3>Over Budget</h3>
            <p class="amount">{{ $summary['over_budget_count'] }}/{{ $summary['total_budgets'] }}</p>
        </div>
    </div>

    <div class="insights-section">
        <h3 class="insights-title">Budget Insights</h3>
        
        @if($summary['over_budget_count'] > 0)
            <div class="insight-item danger">
                <strong>Alert:</strong> {{ $summary['over_budget_count'] }} budget(s) are over their allocated amount.
            </div>
        @endif

        @if($summary['overall_utilization'] > 90)
            <div class="insight-item warning">
                <strong>High Utilization:</strong> Overall budget utilization is {{ number_format($summary['overall_utilization'], 1) }}%.
            </div>
        @elseif($summary['overall_utilization'] < 50)
            <div class="insight-item">
                <strong>Low Utilization:</strong> Overall budget utilization is {{ number_format($summary['overall_utilization'], 1) }}%. Consider budget reallocation.
            </div>
        @else
            <div class="insight-item">
                <strong>Good Performance:</strong> Budget utilization is at a healthy {{ number_format($summary['overall_utilization'], 1) }}%.
            </div>
        @endif

        @php
            $topSpendingBudget = $budgets->sortByDesc('total_spent')->first();
            $mostEfficientBudget = $budgets->where('budget_utilization', '>', 0)->where('budget_utilization', '<', 100)->sortByDesc('budget_utilization')->first();
        @endphp

        @if($topSpendingBudget)
            <div class="insight-item">
                <strong>Highest Spending:</strong> <b><i>{{ $topSpendingBudget->category->name }}</i></b> category with {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($topSpendingBudget->total_spent, 2) }} spent.
            </div>
        @endif

        @if($mostEfficientBudget)
            <div class="insight-item">
                <strong>Most Efficient:</strong> <b><i>{{ $mostEfficientBudget->category->name }}</i></b> category with {{ number_format($mostEfficientBudget->budget_utilization, 1) }}% utilization.
            </div>
        @endif
    </div>

    @if($budgets->isEmpty())
        <div class="no-data">No budgets found for the selected filters.</div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 12%;">Budgeted</th>
                        <th style="width: 12%;">Spent</th>
                        <th style="width: 12%;">Remaining</th>
                        <th style="width: 15%;">Utilization</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 12%;">Period</th>
                        <th style="width: 8%;">Frequency</th>
                        <th style="width: 4%;">Roll</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <td>
                                <span class="category-color" style="background-color: #6B7280;"></span>
                                {{ $budget->category->name }}
                            </td>
                            <td class="amount-neutral">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->amount, 2) }}
                            </td>
                            <td class="amount-negative">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->total_spent, 2) }}
                            </td>
                            <td class="{{ $budget->remaining_amount >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->remaining_amount, 2) }}
                            </td>
                            <td>
                                <div class="utilization-bar">
                                    <span class="utilization-progress" 
                                        style="width: {{ min($budget->budget_utilization, 100) }}%; 
                                               background: {{ $budget->budget_utilization >= 100 ? '#dc2626' : ($budget->budget_utilization >= 80 ? '#f59e0b' : '#10b981') }};">
                                    </span>
                                </div>
                                {{ number_format($budget->budget_utilization, 1) }}%
                            </td>
                            <td>
                                <span class="status-badge status-{{ str_replace('_', '-', $budget->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $budget->status)) }}
                                </span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($budget->start_date)->format('M d') }} - 
                                {{ \Carbon\Carbon::parse($budget->end_date)->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="frequency-badge">{{ ucfirst($budget->frequency) }}</span>
                            </td>
                            <td>
                                @if($budget->roll_over)
                                    <span class="roll-over-indicator">
                                        &#10004;
                                    </span>
                                @else
                                    <span style="color: #9ca3af;">
                                        &#10008;
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Budget History Summary --}}
        @if($budgets->whereNotNull('latest_history')->count() > 0)
            <div class="budget-history page-break">
                <h3>Budget History Summary</h3>
                @foreach($budgets->whereNotNull('latest_history')->take(10) as $budget)
                    @if($budget->latest_history)
                        <div class="history-item">
                            <span><strong>{{ $budget->category->name }}</strong></span>
                            <span>
                                Allocated: {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->latest_history['allocated_amount'] ?? 0, 2) }} | 
                                Roll-over: {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->latest_history['roll_over_amount'] ?? 0, 2) }} | 
                                Status: {{ ucfirst($budget->latest_history['status'] ?? 'N/A') }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Category Performance Summary --}}
        <div class="budget-history">
            <h3>Category Performance Analysis</h3>
            @php
                $sortedBudgets = $budgets->sortByDesc('budget_utilization');
            @endphp
            @foreach($sortedBudgets->take(8) as $budget)
                <div class="history-item">
                    <span>
                        <span class="category-color" style="background-color: {{ $budget->category_color ?? '#6B7280' }};"></span>
                        <strong>{{ $budget->category->name }}</strong>
                    </span>
                    <span>
                        {{ number_format($budget->budget_utilization, 1) }}% utilized | 
                        {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->total_spent, 2) }} of {{ auth()->user()->preferences->defaultCurrency->symbol }}{{ number_format($budget->amount, 2) }} | 
                        <span class="status-badge status-{{ str_replace('_', '-', $budget->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $budget->status)) }}
                        </span>
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        <div class="footer-grid">
            <div>Report Generated: {{ now()->format('M d, Y H:i:s T') }}</div>
            <div>User: {{ auth()->user()->name ?? 'System User' }}</div>
            <div>Page 1 of 1</div>
        </div>
        <p>This report contains confidential financial information. Handle with care and ensure secure storage.</p>
    </div>
</x-pdf-layout>