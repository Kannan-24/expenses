<!DOCTYPE html>
<html>

<head>
    <title>Report</title>
    <style>
        /* @page {
            margin: 20mm 15mm 30mm 15mm;
        } */

        body {
            font-family: 'Times New Roman', Times, serif, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .summary {
            width: 100%;
            margin: 0 auto;
            margin-top: 15px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            padding: 5px 20px;
            font-size: 11px;
            border-top: 1px solid #ccc;
        }

        .footer span {
            display: inline-block;
            width: 49%;
        }

        .footer .left {
            text-align: left;
        }

        .footer .right {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>
        @if ($reportType === 'person' && isset($expenses) && $expenses->count() === 1)
            {{ $expenses->keys()->first() }} Expences Report
        @elseif ($reportType === 'expenses_only')
            Expense Report
        @elseif ($reportType === 'income')
            Income Report
        @elseif ($reportType === 'income_and_expense' || $reportType === 'all')
            Income & Expense Report
        @else
            Report
        @endif
    </h2>

    <table style="width: 100%; margin-bottom: 15px; padding:0; font-size: 11px; border: none;">
        <tr>
            <td style="text-align: left; vertical-align: top; border: none;">
                <strong>Account Balance:</strong> {{ number_format($accountBalance, 2) }}<br>
                <strong>Cash Balance:</strong> {{ number_format($cashBalance, 2) }}<br>
                <strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }}
            </td>
            <td style="text-align: right; vertical-align: top; border: none;">
                <strong>Report Type:</strong> {{ ucfirst(str_replace('_', ' ', $reportType)) }}<br>
                <strong>Report Period:</strong> {{ $filterRange ?? 'Full Report' }}
            </td>
        </tr>
    </table>


    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Person</th>
                <th>Date</th>
                <th>Type</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandIncome = 0;
                $grandExpense = 0;
                $counter = 1;
            @endphp

            @forelse($expenses as $person => $records)
                @foreach ($records as $exp)
                    @php
                        $amount = $exp->amount;
                        $isIncome = $exp->type === 'income';
                        $isIncome ? ($grandIncome += $amount) : ($grandExpense += $amount);
                    @endphp
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $person }}</td>
                        <td>{{ \Carbon\Carbon::parse($exp->date)->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($exp->type) }}</td>
                        <td>{{ $exp->category->name ?? 'N/A' }}</td>
                        <td>{{ number_format($amount, 2) }}</td>
                        <td>{{ ucfirst($exp->payment_method) }}</td>
                        <td>
                            @php $j = 1; @endphp
                            @foreach (explode('#', $exp->note) as $note)
                                @if (trim($note) !== '')
                                    {{ $j++ }}. {{ trim($note) }}<br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No records found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($reportType === 'income_and_expense' || $reportType === 'all')
        <div class="summary">
            <p>Total Income: {{ number_format($grandIncome, 2) }}</p>
            <p>Total Expense: {{ number_format($grandExpense, 2) }}</p>
        </div>
    @elseif ($reportType === 'expenses_only' || $reportType === 'expense' || $reportType === 'person')
        <div class="summary">
            <p>Total Expense: {{ number_format($grandExpense, 2) }}</p>
        </div>
    @elseif ($reportType === 'income')
        <div class="summary">
            <p>Total Income: {{ number_format($grandIncome, 2) }}</p>
        </div>
    @endif

    <div class="footer">
        <span class="left">
            Generated by: {{ auth()->user()->name ?? 'System' }}
        </span>
        <span class="right">
            Generated on: {{ \Carbon\Carbon::now()->format('d-m-Y h:i A') }}
        </span>
    </div>
</body>

</html>
