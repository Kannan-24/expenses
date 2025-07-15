<?php

namespace App\Services;

use App\Exports\BudgetReportCsvExport;
use App\Models\Budget;
use App\Models\BudgetHistory;
use App\Models\Category;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BudgetReportExport;
use Maatwebsite\Excel\Excel as ExcelExcel;

class BudgetReportService
{
    /**
     * Generate budgets report based on the request parameters.
     */
    public function generateBudgetsReport($request)
    {
        $userId = Auth::id();
        $validatedData = $this->validateRequest($request);

        // Get processed budget data
        $reportData = $this->getProcessedBudgetData($userId, $validatedData);

        return $this->generateReport($validatedData['report_format'], $reportData, $validatedData);
    }

    /**
     * Build query to get budgets with optimized joins and aggregations.
     */
    private function buildQuery(int $userId, array $validatedData)
    {
        $query = Budget::select([
            'budgets.id',
            'budgets.category_id',
            'budgets.amount',
            'budgets.start_date',
            'budgets.end_date',
            'budgets.roll_over',
            'budgets.frequency',
        ])->with(['category', 'histories'])
            ->where('budgets.user_id', $userId);

        $dateRange = $this->getDateRange(
            $validatedData['date_range'],
            $validatedData['start_date'] ?? null,
            $validatedData['end_date'] ?? null
        );

        if ($dateRange[0] && $dateRange[1]) {
            $query->where(function ($q) use ($dateRange) {
                $q->whereBetween('budgets.start_date', $dateRange)
                    ->orWhereBetween('budgets.end_date', $dateRange)
                    ->orWhere(function ($subQuery) use ($dateRange) {
                        $subQuery->where('budgets.start_date', '<=', $dateRange[0])
                            ->where('budgets.end_date', '>=', $dateRange[1]);
                    });
            });
        }

        // Apply category filter if specified
        if (isset($validatedData['budget_category_id']) && $validatedData['budget_category_id'] !== 'all') {
            $query->where('budgets.category_id', $validatedData['budget_category_id']);
        }

        return $query;
    }

    /**
     * Get processed budget data with optimized queries
     */
    private function getProcessedBudgetData(int $userId, array $validatedData): array
    {
        $budgets = $this->buildQuery($userId, $validatedData)->get()->map(function ($budget) {
            // Calculate budget performance metrics
            $budget->total_spent = $budget->histories->sum('spent_amount');
            $budget->budget_utilization = $budget->amount > 0
                ? min(($budget->total_spent / $budget->amount) * 100, 100)
                : 0;

            $budget->remaining_amount = max($budget->amount - $budget->total_spent, 0);
            $budget->is_over_budget = $budget->total_spent > $budget->amount;
            $budget->status = $this->getBudgetStatus($budget);

            return $budget;
        });

        // Calculate summary statistics
        $summary = $this->calculateSummaryStats($budgets);

        return [
            'budgets' => $budgets,
            'summary' => $summary,
            'dateRange' => $this->getDateRange(
                $validatedData['date_range'],
                $validatedData['start_date'] ?? null,
                $validatedData['end_date'] ?? null
            ),
            'filters' => $validatedData,
            'category' => $validatedData['budget_category_id'] != 'all' ? Category::find($validatedData['budget_category_id']) : null,
        ];
    }

    /**
     * Calculate summary statistics
     */
    private function calculateSummaryStats(Collection $budgets): array
    {
        $totalBudgeted = $budgets->sum('amount');
        $totalSpent = $budgets->sum('total_spent');
        $totalRemaining = $budgets->sum('remaining_amount');
        $overBudgetCount = $budgets->where('is_over_budget', true)->count();

        return [
            'total_budgets' => $budgets->count(),
            'total_budgeted' => $totalBudgeted,
            'total_spent' => $totalSpent,
            'total_remaining' => $totalRemaining,
            'overall_utilization' => $totalBudgeted > 0 ? ($totalSpent / $totalBudgeted) * 100 : 0,
            'over_budget_count' => $overBudgetCount,
            'on_track_count' => $budgets->count() - $overBudgetCount,
            'average_utilization' => $budgets->avg('budget_utilization') ?? 0,
        ];
    }

    /**
     * Determine budget status
     */
    private function getBudgetStatus($budget): string
    {
        if ($budget->is_over_budget) {
            return 'over_budget';
        }

        if ($budget->budget_utilization >= 80) {
            return 'warning';
        }

        if ($budget->budget_utilization >= 50) {
            return 'on_track';
        }

        return 'under_utilized';
    }

    /**
     * Generate report based on format
     */
    private function generateReport(string $format, array $reportData, array $validatedData)
    {
        $fileName = 'budgets_report_' . now()->format('Ymd_His');
        switch ($format) {
            case 'pdf':
                return $this->generatePdfReport($reportData, $fileName);

            case 'html':
                return $this->generateHtmlReport($reportData);

            case 'csv':
                return $this->generateCsvReport($reportData, $fileName);

            case 'xlsx':
                return $this->generateExcelReport($reportData, $fileName);

            default:
                throw new \InvalidArgumentException('Invalid report format selected.');
        }
    }

    /**
     * Generate PDF report
     */
    private function generatePdfReport(array $reportData, string $fileName)
    {
        return Pdf::loadView('reports.budgets.pdf', $reportData)
            ->setPaper('a4', 'landscape') // Landscape for better table layout
            ->setOptions([
                'dpi' => 96,
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'chroot' => public_path(),
            ])
            ->stream($fileName . '.pdf');
    }

    /**
     * Generate HTML report
     */
    private function generateHtmlReport(array $reportData)
    {
        return view('reports.budgets.html', $reportData);
    }

    /**
     * Generate CSV report
     */
    private function generateCsvReport(array $reportData, string $fileName)
    {
        return Excel::download(new BudgetReportCsvExport($reportData), $fileName . '.csv', ExcelExcel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Generate Excel report
     */
    private function generateExcelReport(array $reportData, string $fileName)
    {
        return Excel::download(new BudgetReportExport($reportData), $fileName . '.xlsx', ExcelExcel::XLSX, [
            'charts' => true,
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Validate the request parameters with enhanced validation
     */
    private function validateRequest($request): array
    {
        $rules = [
            'report_format' => 'required|in:pdf,html,csv,xlsx',
            'date_range' => 'required|in:all,today,yesterday,this_week,last_week,this_month,last_month,this_quarter,last_quarter,this_year,last_year,custom',
            'start_date' => 'nullable|date|before_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date|before_or_equal:today',
            'budget_category_id' => 'nullable|in:all,' . Category::pluck('id')->implode(','),
            'include_inactive' => 'nullable|boolean',
        ];

        if ($request->has('budget_category_id') && $request->budget_category_id !== 'all') {
            $rules['budget_category_id'] = 'nullable|exists:categories,id';
        }

        $messages = [
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'budget_category_id.exists' => 'Selected category does not exist.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Get optimized date range with additional options
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
}
