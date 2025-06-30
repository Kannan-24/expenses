<?php

namespace App\Services;

use App\Exports\TransactionsReportExport;
use App\Models\Category;
use App\Models\ExpensePerson;
use App\Models\Transaction;
use App\Models\Wallet;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;

class TransactionReportService
{
    private $dateRanges = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'this_week' => 'This Week',
        'last_week' => 'Last Week',
        'this_month' => 'This Month',
        'last_month' => 'Last Month',
        'this_quarter' => 'This Quarter',
        'last_quarter' => 'Last Quarter',
        'this_year' => 'This Year',
        'last_year' => 'Last Year',
    ];

    /**
     * Generate transactions report with optimized performance
     */
    public function generateTransactionsReport(Request $request)
    {
        // try {
        // Validate request
        $validatedData = $this->validateReportRequest($request);

        // Build optimized query
        $query = $this->buildOptimizedQuery($validatedData);

        // Get transactions with pagination for large datasets
        $transactions = $this->getTransactions($query, $validatedData);

        // Calculate summary statistics
        $summary = $this->calculateSummary($transactions);

        // Get category summary if needed
        $categorySummary = $this->getCategorySummary($transactions, $validatedData);

        // Generate report based on format
        return $this->generateReport($validatedData, $transactions, $summary, $categorySummary);
        // } catch (Exception $e) {
        //     Log::error('Transaction report generation failed', [
        //         'error' => $e->getMessage(),
        //         'user_id' => Auth::id(),
        //         'request_data' => $request->all()
        //     ]);

        //     return redirect()->back()->withErrors(['error' => 'Failed to generate report. Please try again.']);
        // }
    }

    /**
     * Validate and sanitize request data
     */
    private function validateReportRequest(Request $request): array
    {
        $rules = [
            'date_range' => 'required|string|in:all,' . implode(',', array_keys($this->dateRanges)) . ',custom',
            'start_date' => 'required_if:date_range,custom|nullable|date',
            'end_date' => 'required_if:date_range,custom|nullable|date|after_or_equal:start_date',
            'transaction_type' => 'required|string|in:all,income,expense',
            'amount' => 'nullable|numeric|min:0',
            'amount_filter' => 'nullable|string|in:<,>,=,<=,>=',
            'report_format' => 'required|string|in:pdf,html,csv,xlsx',
        ];

        return $request->validate($rules);
    }

    /**
     * Build optimized database query with proper indexing
     */
    private function buildOptimizedQuery(array $data): Builder
    {
        $query = Transaction::select([
            'id',
            'date',
            'type',
            'amount',
            'note',
            'category_id',
            'wallet_id',
            'expense_person_id',
            'created_at'
        ])
            ->where('user_id', Auth::id());

        // Date range filter (most selective first for better performance)
        $dateRange = $this->getDateRange($data['date_range'], $data['start_date'] ?? null, $data['end_date'] ?? null);
        if ($dateRange[0] && $dateRange[1]) {
            $query->whereBetween('date', $dateRange);
        }

        // Transaction type filter
        if ($data['transaction_type'] !== 'all') {
            $query->where('type', $data['transaction_type']);
        }

        // Amount filter
        if (!empty($data['amount']) && !empty($data['amount_filter'])) {
            $query->where('amount', $data['amount_filter'], $data['amount']);
        }

        // Category filter
        if (!empty($data['category_id']) && $data['category_id'] !== 'all') {
            $query->where('category_id', $data['category_id']);
        }

        // Wallet filter
        if (!empty($data['wallet_id']) && $data['wallet_id'] !== 'all') {
            $query->where('wallet_id', $data['wallet_id']);
        }

        // Person filter
        if (!empty($data['person_id']) && $data['person_id'] !== 'all') {
            $query->where('expense_person_id', $data['person_id']);
        }

        // Eager load relationships to avoid N+1 queries
        $query->with([
            'category:id,name',
            'wallet:id,name',
            'person:id,name'
        ]);

        return $query;
    }

    /**
     * Get transactions with optional pagination for large datasets
     */
    private function getTransactions(Builder $query, array $data): Collection
    {
        // Sort options
        $sortBy = $data['sort_by'] ?? 'date';
        $sortDirection = $data['sort_direction'] ?? 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // Add secondary sort for consistency
        if ($sortBy !== 'date') {
            $query->orderBy('date', 'desc');
        }

        // Apply limit if specified
        if (!empty($data['limit'])) {
            $query->limit($data['limit']);
        }

        return $query->get();
    }

    /**
     * Calculate summary statistics efficiently
     */
    private function calculateSummary(Collection $transactions): array
    {
        $incomeTransactions = $transactions->where('type', 'income');
        $expenseTransactions = $transactions->where('type', 'expense');

        return [
            'total_income' => $incomeTransactions->sum('amount'),
            'total_expense' => $expenseTransactions->sum('amount'),
            'net_total' => $incomeTransactions->sum('amount') - $expenseTransactions->sum('amount'),
            'transaction_count' => $transactions->count(),
            'income_count' => $incomeTransactions->count(),
            'expense_count' => $expenseTransactions->count(),
            'average_transaction' => $transactions->count() > 0 ? $transactions->avg('amount') : 0,
            'largest_transaction' => $transactions->max('amount') ?? 0,
            'smallest_transaction' => $transactions->min('amount') ?? 0,
        ];
    }

    /**
     * Get category summary for expenses
     */
    private function getCategorySummary(Collection $transactions, array $data): array
    {
        if (!empty($data['category_id']) && $data['category_id'] !== 'all') {
            return [];
        }

        return $transactions
            ->where('type', 'expense')
            ->groupBy('category.name')
            ->map(function ($group) {
                return [
                    'amount' => $group->sum('amount'),
                    'count' => $group->count(),
                    'percentage' => 0
                ];
            })
            ->sortByDesc('amount')
            ->toArray();
    }

    /**
     * Generate report in requested format
     */
    private function generateReport(array $data, Collection $transactions, array $summary, array $categorySummary)
    {
        $reportData = $this->prepareReportData($data, $transactions, $summary, $categorySummary);

        switch ($data['report_format']) {
            case 'pdf':
                return $this->generatePdfReport($reportData);
            case 'html':
                return $this->generateHtmlReport($reportData);
            case 'csv':
                return $this->generateCsvReport($reportData);
            case 'xlsx':
                return $this->generateExcelReport($reportData);
            default:
                throw new InvalidArgumentException('Invalid report format');
        }
    }

    /**
     * Prepare data for report generation
     */
    private function prepareReportData(array $data, Collection $transactions, array $summary, array $categorySummary): array
    {
        // Calculate category percentages
        $totalExpense = $summary['total_expense'];
        if ($totalExpense > 0) {
            foreach ($categorySummary as $category => &$categoryData) {
                $categoryData['percentage'] = ($categoryData['amount'] / $totalExpense) * 100;
            }
        }

        return [
            'dateRange' => $data['date_range'],
            'dateRanges' => $this->dateRanges,
            'startDate' => $data['start_date'] ? Carbon::parse($data['start_date']) : null,
            'endDate' => $data['end_date'] ? Carbon::parse($data['end_date']) : null,
            'transactionType' => $data['transaction_type'],
            'transactions' => $transactions,
            'summary' => $summary,
            'categorySummary' => $categorySummary,
            'category' => $this->getFilteredCategory($data['category_id'] ?? null),
            'wallet' => $this->getFilteredWallet($data['wallet_id'] ?? null),
            'person' => $this->getFilteredPerson($data['person_id'] ?? null),
            'amountFilter' => $this->getAmountFilter($data),
            'generatedAt' => now(),
        ];
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport(array $data)
    {
        $pdf = Pdf::loadView('reports.transactions.pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
            ]);

        $filename = 'transactions_report_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate HTML report
     */
    private function generateHtmlReport(array $data)
    {
        return view('reports.transactions.html', $data);
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport(array $data)
    {
        $filename = 'transactions_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fwrite($handle, "\xEF\xBB\xBF");

            // Headers
            $headers = ['Date', 'Type', 'Amount', 'Category', 'Wallet', 'Person', 'Notes'];
            fputcsv($handle, $headers);

            // Data rows
            foreach ($data['transactions'] as $transaction) {
                fputcsv($handle, [
                    $transaction->date->format('Y-m-d'),
                    ucfirst($transaction->type),
                    number_format($transaction->amount, 2),
                    $transaction->category->name ?? 'Uncategorized',
                    $transaction->wallet->name ?? 'Default',
                    $transaction->person->name ?? '',
                    $transaction->note ?? '',
                ]);
            }

            // Summary rows
            fputcsv($handle, []);
            fputcsv($handle, ['Summary']);
            fputcsv($handle, ['Total Income', '', number_format($data['summary']['total_income'], 2)]);
            fputcsv($handle, ['Total Expenses', '', number_format($data['summary']['total_expense'], 2)]);
            fputcsv($handle, ['Net Total', '', number_format($data['summary']['net_total'], 2)]);

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Generate Excel report
     */
    private function generateExcelReport(array $data)
    {
        $filename = 'transactions_report_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new TransactionsReportExport($data), $filename, \Maatwebsite\Excel\Excel::XLSX, [
            'charts' => true,
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Get optimized date range
     */
    private function getDateRange(string $range, ?string $startDate = null, ?string $endDate = null): array
    {
        if ($range === 'custom') {
            return [
                $startDate ? Carbon::parse($startDate)->startOfDay() : null,
                $endDate ? Carbon::parse($endDate)->endOfDay() : null
            ];
        }

        $now = now();

        return match ($range) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'yesterday' => [$now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()],
            'this_week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'last_week' => [$now->copy()->subWeek()->startOfWeek(), $now->copy()->subWeek()->endOfWeek()],
            'this_month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'last_month' => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            'this_quarter' => [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()],
            'last_quarter' => [$now->copy()->subQuarter()->startOfQuarter(), $now->copy()->subQuarter()->endOfQuarter()],
            'this_year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'last_year' => [$now->copy()->subYear()->startOfYear(), $now->copy()->subYear()->endOfYear()],
            default => [null, null]
        };
    }

    /**
     * Get filtered category
     */
    private function getFilteredCategory(?string $categoryId)
    {
        if (!$categoryId || $categoryId === 'all') {
            return null;
        }

        return Category::where('user_id', Auth::id())->find($categoryId);
    }

    /**
     * Get filtered wallet
     */
    private function getFilteredWallet(?string $walletId)
    {
        if (!$walletId || $walletId === 'all') {
            return null;
        }

        return Wallet::where('user_id', Auth::id())->find($walletId);
    }

    /**
     * Get filtered person
     */
    private function getFilteredPerson(?string $personId)
    {
        if (!$personId || $personId === 'all') {
            return null;
        }

        return ExpensePerson::where('user_id', Auth::id())->find($personId);
    }

    /**
     * Get amount filter info
     */
    private function getAmountFilter(array $data): ?array
    {
        if (empty($data['amount']) || empty($data['amount_filter'])) {
            return null;
        }

        return [
            'amount' => $data['amount'],
            'operator' => $data['amount_filter']
        ];
    }
}
