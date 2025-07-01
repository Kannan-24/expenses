<x-pdf-layout>
    <x-slot name="title">Transactions Report</x-slot>

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
            padding: 10px;
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
            margin-bottom: 5px;
        }

        .filter-label {
            display: inline-block;
            color: #4b5563;
            font-weight: bold;
            width: 80px;
        }

        .filter-value {
            display: inline-block;
            color: #111827;
            padding: 2px 6px;
            border: 1px solid #d1d5db;
            background: #fff;
        }

        .summary-cards {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary-card {
            width: calc(100% / 3 - 31.5px);
            display: inline-block;
            vertical-align: top;
            padding: 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            text-align: center;
        }

        .summary-card:first-child {
            margin-right: 10px;
        }

        .summary-card:last-child {
            margin-left: 10px;
        }

        .summary-card.income {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .summary-card.expense {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .summary-card.net {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .summary-card h3 {
            margin: 0 0 5px 0;
            font-size: 11px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-card .amount {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .income .amount {
            color: #059669;
        }

        .expense .amount {
            color: #dc2626;
        }

        .net .amount {
            color: #2563eb;
        }

        .table-container {
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        thead th {
            padding: 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
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
            padding: 6px;
            border-right: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tbody td:last-child {
            border-right: none;
        }

        .transaction-type {
            padding: 2px 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .type-income {
            background: #dcfce7;
            color: #166534;
        }

        .type-expense {
            background: #fee2e2;
            color: #991b1b;
        }

        .amount-positive {
            color: #059669;
            font-weight: bold;
        }

        .amount-negative {
            color: #dc2626;
            font-weight: bold;
        }

        .notes {
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .category-summary {
            margin-top: 25px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
        }

        .category-summary h3 {
            color: #374151;
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .category-item {
            font-size: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding: 4px 0;
        }

        .category-item:last-child {
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
    </style>


    <div class="header">
        <h1>Financial Transactions Report</h1>
        <p class="subtitle">Detailed analysis of your financial activities</p>
    </div>

    <div class="filters-section">
        <h3 class="filters-title">Report Filters</h3>
        <div class="filter-grid">
            <div class="filter-item">
                <span class="filter-label">Date Range:</span>
                <span class="filter-value">
                    @if ($dateRange === 'custom')
                        {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
                    @else
                        {{ $dateRanges[$dateRange] ?? 'All Time' }}
                    @endif
                </span>
            </div>

            <div class="filter-item">
                <span class="filter-label">Type:</span>
                <span
                    class="filter-value">{{ $transactionType === 'all' ? 'All Types' : ucfirst($transactionType) }}</span>
            </div>

            @if ($category)
                <div class="filter-item">
                    <span class="filter-label">Category:</span>
                    <span class="filter-value">{{ $category->name }}</span>
                </div>
            @endif

            @if ($wallet)
                <div class="filter-item">
                    <span class="filter-label">Wallet:</span>
                    <span class="filter-value">{{ $wallet->name }}</span>
                </div>
            @endif

            @if ($person)
                <div class="filter-item">
                    <span class="filter-label">Person:</span>
                    <span class="filter-value">{{ $person->name }}</span>
                </div>
            @endif

            @if ($amountFilter)
                <div class="filter-item">
                    <span class="filter-label">Amount Filter:</span>
                    <span class="filter-value">{{ $amountFilter['operator'] }}
                        {{ number_format($amountFilter['amount'], 2) }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card income">
            <h3>Total Income</h3>
            <p class="amount">{{ number_format($summary['total_income'], 2) }}</p>
        </div>
        <div class="summary-card expense">
            <h3>Total Expenses</h3>
            <p class="amount">{{ number_format($summary['total_expense'], 2) }}</p>
        </div>
        <div class="summary-card net">
            <h3>Net Amount</h3>
            <p class="amount">{{ number_format($summary['net_total'], 2) }}</p>
        </div>
    </div>

    @if ($transactions->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 12%">Date</th>
                        <th style="width: 10%">Type</th>
                        <th style="width: 12%">Amount</th>
                        @if ($category == null)
                            <th style="width: 15%">Category</th>
                        @endif
                        @if ($person == null)
                            <th style="width: 12%">Person</th>
                        @endif
                        @if ($wallet == null)
                            <th style="width: 12%">Wallet</th>
                        @endif
                        <th style="width: 22%">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->date->format('M d, Y') }}</td>
                            <td>
                                <span class="transaction-type type-{{ $transaction->type }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td class="{{ $transaction->type === 'income' ? 'amount-positive' : 'amount-negative' }}">
                                {{ number_format($transaction->amount, 2) }}
                            </td>
                            @if ($category == null)
                                <td>{{ $transaction->category->name ?? 'Uncategorized' }}</td>
                            @endif
                            @if ($person == null)
                                <td>{{ $transaction->person->name ?? '-' }}</td>
                            @endif
                            @if ($wallet == null)
                                <td>{{ $transaction->wallet->name ?? 'Default' }}</td>
                            @endif
                            <td class="notes">{{ $transaction->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!$category && count($categorySummary) > 0)
            <div class="category-summary">
                <h3>Expense by Category</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50%">Category</th>
                            <th style="width: 20%">Amount</th>
                            <th style="width: 10%">Count</th>
                            <th style="width: 20%">Percentage</th>
                        </tr>
                    </thead>
                    @foreach ($categorySummary as $categoryName => $amount)
                        <tbody>
                            <tr>
                                <td>{{ $categoryName ?: 'Uncategorized' }}</td>
                                <td class="amount-negative">{{ number_format($amount['amount'], 2) }}</td>
                                <td>{{ $amount['count'] }}</td>
                                <td>
                                    {{ $amount['percentage'] ? number_format($amount['percentage'], 2) . '%' : '0%' }}
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        @endif
    @else
        <div class="no-data">
            <p>No transactions found matching the selected criteria.</p>
        </div>
    @endif

    <div class="footer">
        <div class="footer-grid">
            <div>Total Transactions: {{ $transactions->count() }}</div>
            <div>Report Generated: {{ now()->format('M d, Y H:i:s') }}</div>
            <div>Page 1 of 1</div>
        </div>
        <p>This report is automatically generated and contains confidential financial information.</p>
    </div>
</x-pdf-layout>
