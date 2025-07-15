<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;

class BudgetReportExport implements WithMultipleSheets
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function sheets(): array
    {
        return [
            'Executive Summary' => new BudgetSummarySheet($this->reportData),
            'Budget Details' => new BudgetDetailsSheet($this->reportData),
            'Performance Analysis' => new BudgetPerformanceSheet($this->reportData),
            'Budget History' => new BudgetHistorySheet($this->reportData),
            'Category Insights' => new CategoryInsightsSheet($this->reportData),
            // 'Charts & Visualizations' => new BudgetChartsSheet($this->reportData),
        ];
    }
}

// // Executive Summary Sheet
// class BudgetSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
// {
//     private array $reportData;

//     public function __construct(array $reportData)
//     {
//         $this->reportData = $reportData;
//     }

//     public function collection()
//     {
//         $summary = $this->reportData['summary'];
//         $dateRange = $this->reportData['dateRange'];

//         return collect([
//             // Report Header
//             ['FINANCIAL BUDGET REPORT - EXECUTIVE SUMMARY'],
//             ['Generated on: ' . now()->format('F d, Y H:i:s T')],
//             ['Report Period: ' . $this->getDateRangeText($dateRange)],
//             [''],

//             // Key Metrics
//             ['KEY PERFORMANCE INDICATORS'],
//             ['Metric', 'Value', 'Status'],
//             ['Total Budgets', $summary['total_budgets'], $this->getPerformanceStatus($summary['total_budgets'], 'count')],
//             ['Total Budgeted Amount', Auth::user()->preferences->defaultCurrency->symbol . number_format($summary['total_budgeted'], 2), 'Baseline'],
//             ['Total Spent Amount', Auth::user()->preferences->defaultCurrency->symbol . number_format($summary['total_spent'], 2), $this->getSpendingStatus($summary)],
//             ['Total Remaining', Auth::user()->preferences->defaultCurrency->symbol . number_format($summary['total_remaining'], 2), $this->getRemainingStatus($summary)],
//             ['Overall Utilization', number_format($summary['overall_utilization'], 1) . '%', $this->getUtilizationStatus($summary['overall_utilization'])],
//             ['Average Utilization', number_format($summary['average_utilization'], 1) . '%', $this->getUtilizationStatus($summary['average_utilization'])],
//             ['Budgets Over Limit', $summary['over_budget_count'], $this->getOverBudgetStatus($summary['over_budget_count'])],
//             ['Budgets On Track', $summary['on_track_count'], 'Good'],
//             [''],

//             // Performance Summary
//             ['PERFORMANCE SUMMARY'],
//             ['Budget Health Score', $this->calculateHealthScore(), $this->getHealthScoreStatus()],
//             ['Variance from Plan', Auth::user()->preferences->defaultCurrency->symbol . number_format($summary['total_spent'] - $summary['total_budgeted'], 2), $this->getVarianceStatus($summary)],
//             ['Efficiency Rating', $this->getEfficiencyRating(), $this->getEfficiencyStatus()],
//             [''],

//             // Risk Assessment
//             ['RISK ASSESSMENT'],
//             ['Risk Level', $this->getRiskLevel(), ''],
//             ['Critical Budgets', $this->getCriticalBudgetsCount(), ''],
//             ['Warning Budgets', $this->getWarningBudgetsCount(), ''],
//             [''],

//             // Recommendations
//             ['RECOMMENDATIONS'],
//             ...$this->getRecommendations()
//         ]);
//     }

//     public function headings(): array
//     {
//         return [];
//     }

//     public function title(): string
//     {
//         return 'Executive Summary';
//     }

//     public function columnWidths(): array
//     {
//         return [
//             'A' => 25,
//             'B' => 20,
//             'C' => 15,
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         return [
//             1 => [
//                 'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E79']],
//                 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
//             ],
//             5 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ],
//             6 => [
//                 'font' => ['bold' => true],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']],
//                 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
//             ],
//             15 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ],
//             20 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ],
//             25 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ]
//         ];
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $sheet = $event->sheet->getDelegate();

//                 // Apply conditional formatting for status columns
//                 $this->applyConditionalFormatting($sheet);

//                 // Add borders to data ranges
//                 $sheet->getStyle('A6:C14')->applyFromArray([
//                     'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
//                 ]);
//             },
//         ];
//     }

//     private function getDateRangeText($dateRange): string
//     {
//         if ($dateRange[0] && $dateRange[1]) {
//             return $dateRange[0]->format('M d, Y') . ' to ' . $dateRange[1]->format('M d, Y');
//         }
//         return 'All Time';
//     }

//     private function calculateHealthScore(): string
//     {
//         $summary = $this->reportData['summary'];
//         $score = 100;

//         // Deduct points for over budget
//         $score -= ($summary['over_budget_count'] * 15);

//         // Deduct points for high utilization
//         if ($summary['overall_utilization'] > 90) {
//             $score -= 20;
//         } elseif ($summary['overall_utilization'] > 80) {
//             $score -= 10;
//         }

//         // Deduct points for low utilization
//         if ($summary['overall_utilization'] < 30) {
//             $score -= 15;
//         }

//         return max(0, $score) . '/100';
//     }

//     private function getRecommendations(): array
//     {
//         $recommendations = [];
//         $summary = $this->reportData['summary'];

//         if ($summary['over_budget_count'] > 0) {
//             $recommendations[] = ['• Review and adjust over-budget categories immediately'];
//         }

//         if ($summary['overall_utilization'] > 90) {
//             $recommendations[] = ['• Consider increasing budget allocations for high-utilization categories'];
//         }

//         if ($summary['overall_utilization'] < 50) {
//             $recommendations[] = ['• Redistribute unused budget to higher-priority categories'];
//         }

//         $recommendations[] = ['• Implement monthly budget review meetings'];
//         $recommendations[] = ['• Set up automated alerts for budget thresholds'];

//         return $recommendations;
//     }

//     // Additional helper methods for status calculations...
//     private function getPerformanceStatus($value, $type): string
//     {
//         return $type === 'count' ? ($value > 0 ? 'Active' : 'None') : 'Good';
//     }

//     private function getSpendingStatus($summary): string
//     {
//         $utilization = $summary['overall_utilization'];
//         if ($utilization > 100) return 'Over Budget';
//         if ($utilization > 90) return 'High';
//         if ($utilization > 70) return 'Normal';
//         return 'Low';
//     }

//     private function getRemainingStatus($summary): string
//     {
//         return $summary['total_remaining'] >= 0 ? 'Positive' : 'Deficit';
//     }

//     private function getUtilizationStatus($utilization): string
//     {
//         if ($utilization > 100) return 'Over Budget';
//         if ($utilization > 90) return 'Critical';
//         if ($utilization > 80) return 'Warning';
//         if ($utilization > 50) return 'Good';
//         return 'Under-utilized';
//     }

//     private function getOverBudgetStatus($count): string
//     {
//         if ($count == 0) return 'Excellent';
//         if ($count <= 2) return 'Warning';
//         return 'Critical';
//     }

//     private function getHealthScoreStatus(): string
//     {
//         $score = (int) explode('/', $this->calculateHealthScore())[0];
//         if ($score >= 90) return 'Excellent';
//         if ($score >= 80) return 'Good';
//         if ($score >= 70) return 'Fair';
//         return 'Poor';
//     }

//     private function getVarianceStatus($summary): string
//     {
//         $variance = $summary['total_spent'] - $summary['total_budgeted'];
//         if ($variance > 0) return 'Over Budget';
//         if (abs($variance) / $summary['total_budgeted'] < 0.1) return 'On Target';
//         return 'Under Budget';
//     }

//     private function getEfficiencyRating(): string
//     {
//         $summary = $this->reportData['summary'];
//         $efficiency = 100 - abs($summary['overall_utilization'] - 85); // Optimal at 85%
//         return number_format(max(0, $efficiency), 1) . '%';
//     }

//     private function getEfficiencyStatus(): string
//     {
//         $efficiency = (float) str_replace('%', '', $this->getEfficiencyRating());
//         if ($efficiency >= 90) return 'Excellent';
//         if ($efficiency >= 80) return 'Good';
//         if ($efficiency >= 70) return 'Fair';
//         return 'Poor';
//     }

//     private function getRiskLevel(): string
//     {
//         $summary = $this->reportData['summary'];
//         if ($summary['over_budget_count'] > 3) return 'High';
//         if ($summary['over_budget_count'] > 1) return 'Medium';
//         if ($summary['overall_utilization'] > 95) return 'Medium';
//         return 'Low';
//     }

//     private function getCriticalBudgetsCount(): int
//     {
//         return collect($this->reportData['budgets'])->where('status', 'over_budget')->count();
//     }

//     private function getWarningBudgetsCount(): int
//     {
//         return collect($this->reportData['budgets'])->where('status', 'warning')->count();
//     }

//     private function applyConditionalFormatting(Worksheet $sheet)
//     {
//         // Add conditional formatting for status columns
//         $sheet->getStyle('C7:C14')->getConditionalStyles();
//     }
// }

// Budget Details Sheet
class BudgetDetailsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['budgets']);
    }

    public function headings(): array
    {
        return [
            'Category',
            'Budgeted Amount',
            'Spent Amount',
            'Remaining Amount',
            'Utilization %',
            'Status',
            'Start Date',
            'End Date',
            'Frequency',
            'Roll Over',
            'Variance',
            'Performance Rating',
            'Last Updated',
            'Days Active',
            'Avg Daily Spend'
        ];
    }

    public function map($budget): array
    {
        $variance = $budget->total_spent - $budget->amount;
        $daysActive = max(1, now()->diffInDays($budget->start_date));
        $avgDailySpend = $budget->total_spent / $daysActive;

        return [
            $budget->category->name ?? $budget->category_name,
            Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->amount, 2),
            Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->total_spent, 2),
            Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->remaining_amount, 2),
            number_format($budget->budget_utilization, 1) . '%',
            ucfirst(str_replace('_', ' ', $budget->status)),
            $budget->start_date,
            $budget->end_date,
            ucfirst($budget->frequency),
            $budget->roll_over ? 'Yes' : 'No',
            ($variance >= 0 ? '+' : '') . Auth::user()->preferences->defaultCurrency->symbol . number_format($variance, 2),
            $this->getPerformanceRating($budget),
            now()->format('Y-m-d H:i:s'),
            $daysActive,
            Auth::user()->preferences->defaultCurrency->symbol . number_format($avgDailySpend, 2)
        ];
    }

    public function title(): string
    {
        return 'Budget Details';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 12,
            'F' => 15,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 10,
            'K' => 15,
            'L' => 18,
            'M' => 18,
            'N' => 12,
            'O' => 15
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '366092']],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]
        ];
    }

    private function getPerformanceRating($budget): string
    {
        $utilization = $budget->budget_utilization;

        if ($utilization > 100) return 'Over Budget';
        if ($utilization >= 90) return 'Excellent';
        if ($utilization >= 75) return 'Good';
        if ($utilization >= 50) return 'Fair';
        return 'Under-utilized';
    }
}

// Performance Analysis Sheet
class BudgetPerformanceSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $budgets = collect($this->reportData['budgets']);

        return collect([
            // Top Performers
            ['TOP PERFORMING BUDGETS (By Efficiency)'],
            ['Rank', 'Category', 'Utilization %', 'Amount Spent', 'Status'],
            ...$budgets->sortByDesc('budget_utilization')->take(10)->values()->map(function ($budget, $index) {
                return [
                    $index + 1,
                    $budget->category->name ?? $budget->category_name,
                    number_format($budget->budget_utilization, 1) . '%',
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->total_spent, 2),
                    ucfirst(str_replace('_', ' ', $budget->status))
                ];
            }),
            [''],

            // Bottom Performers
            ['UNDER-PERFORMING BUDGETS (Needs Attention)'],
            ['Rank', 'Category', 'Utilization %', 'Amount Spent', 'Remaining', 'Recommendation'],
            ...$budgets->sortBy('budget_utilization')->take(5)->values()->map(function ($budget, $index) {
                return [
                    $index + 1,
                    $budget->category->name ?? $budget->category_name,
                    number_format($budget->budget_utilization, 1) . '%',
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->total_spent, 2),
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->remaining_amount, 2),
                    $this->getRecommendation($budget)
                ];
            }),
            [''],

            // Over Budget Analysis
            ['OVER-BUDGET ANALYSIS'],
            ['Category', 'Budget', 'Spent', 'Overage', 'Overage %', 'Action Required'],
            ...$budgets->where('status', 'over_budget')->map(function ($budget) {
                $overage = $budget->total_spent - $budget->amount;
                $overagePercent = ($overage / $budget->amount) * 100;
                return [
                    $budget->category->name ?? $budget->category_name,
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->amount, 2),
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($budget->total_spent, 2),
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($overage, 2),
                    number_format($overagePercent, 1) . '%',
                    $this->getActionRequired($overagePercent)
                ];
            })
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Performance Analysis';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2F5597']]],
            2 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']]],
            14 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2F5597']]],
            15 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'FCE4D6']]],
        ];
    }

    private function getRecommendation($budget): string
    {
        if ($budget->budget_utilization < 25) return 'Consider reducing budget allocation';
        if ($budget->budget_utilization < 50) return 'Monitor and potentially reallocate';
        return 'Increase spending or reallocate funds';
    }

    private function getActionRequired($overagePercent): string
    {
        if ($overagePercent > 50) return 'Immediate review required';
        if ($overagePercent > 25) return 'Budget adjustment needed';
        if ($overagePercent > 10) return 'Monitor closely';
        return 'Minor variance - monitor';
    }
}

// Additional sheets would follow similar patterns...
// Budget History Sheet, Category Insights Sheet, Charts Sheet

class BudgetHistorySheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $budgets = collect($this->reportData['budgets'])->whereNotNull('latest_history');

        return $budgets->map(function ($budget) {
            $history = $budget->latest_history;
            return [
                $budget->category->name ?? $budget->category_name,
                Auth::user()->preferences->defaultCurrency->symbol . number_format($history['allocated_amount'] ?? 0, 2),
                Auth::user()->preferences->defaultCurrency->symbol . number_format($history['roll_over_amount'] ?? 0, 2),
                Auth::user()->preferences->defaultCurrency->symbol . number_format($history['spent_amount'] ?? 0, 2),
                ucfirst($history['status'] ?? 'N/A'),
                $budget->start_date,
                $budget->end_date
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Category',
            'Allocated Amount',
            'Roll-over Amount',
            'Spent Amount',
            'Status',
            'Period Start',
            'Period End'
        ];
    }

    public function title(): string
    {
        return 'Budget History';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '366092']],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ]
        ];
    }
}

class CategoryInsightsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    private array $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $budgets = collect($this->reportData['budgets']);
        $summary = $this->reportData['summary'];

        // Group budgets by category for analysis
        $categoryStats = $budgets->groupBy(function ($budget) {
            return $budget->category->name ?? $budget->category_name;
        })->map(function ($categoryBudgets, $categoryName) use ($summary) {
            $totalBudgeted = $categoryBudgets->sum('amount');
            $totalSpent = $categoryBudgets->sum('total_spent');
            $avgUtilization = $categoryBudgets->avg('budget_utilization');
            $budgetCount = $categoryBudgets->count();

            return [
                'name' => $categoryName,
                'budget_count' => $budgetCount,
                'total_budgeted' => $totalBudgeted,
                'total_spent' => $totalSpent,
                'total_remaining' => $totalBudgeted - $totalSpent,
                'avg_utilization' => $avgUtilization,
                'budget_share' => ($totalBudgeted / $summary['total_budgeted']) * 100,
                'spending_share' => ($totalSpent / $summary['total_spent']) * 100,
                'efficiency_score' => $this->calculateEfficiencyScore($avgUtilization),
                'risk_level' => $this->calculateRiskLevel($categoryBudgets),
                'trend' => $this->calculateTrend($categoryBudgets),
                'recommendation' => $this->getRecommendation($categoryBudgets, $avgUtilization)
            ];
        })->sortByDesc('total_spent');

        return collect([
            // Header
            ['CATEGORY INSIGHTS & ANALYSIS'],
            ['Generated by: ' . Auth::user()->name ?? 'System'],
            ['Report Date: ' . now()->format('F d, Y H:i:s T')],
            ['Total Categories Analyzed: ' . $categoryStats->count()],
            [''],

            // Category Overview
            ['CATEGORY OVERVIEW'],
            [
                'Category Name',
                'Budget Count',
                'Total Budgeted',
                'Total Spent',
                'Remaining',
                'Avg Utilization',
                'Budget Share %',
                'Spending Share %',
                'Efficiency Score',
                'Risk Level',
                'Trend',
                'Recommendation'
            ],
            ...$categoryStats->map(function ($stats) {
                return [
                    $stats['name'],
                    $stats['budget_count'],
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($stats['total_budgeted'], 2),
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($stats['total_spent'], 2),
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($stats['total_remaining'], 2),
                    number_format($stats['avg_utilization'], 1) . '%',
                    number_format($stats['budget_share'], 1) . '%',
                    number_format($stats['spending_share'], 1) . '%',
                    $stats['efficiency_score'],
                    $stats['risk_level'],
                    $stats['trend'],
                    $stats['recommendation']
                ];
            }),
            [''],

            // Top Spending Categories
            ['TOP 5 SPENDING CATEGORIES'],
            ['Rank', 'Category', 'Amount Spent', '% of Total', 'Utilization', 'Status'],
            ...$categoryStats->take(5)->values()->map(function ($stats, $index) {
                return [
                    $index + 1,
                    $stats['name'],
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($stats['total_spent'], 2),
                    number_format($stats['spending_share'], 1) . '%',
                    number_format($stats['avg_utilization'], 1) . '%',
                    $this->getStatusFromUtilization($stats['avg_utilization'])
                ];
            }),
            [''],

            // Most Efficient Categories
            ['MOST EFFICIENT CATEGORIES'],
            ['Rank', 'Category', 'Efficiency Score', 'Utilization', 'Budget Amount', 'Variance'],
            ...$categoryStats->sortByDesc(function ($stats) {
                return $stats['efficiency_score'] === 'Excellent' ? 100 : ($stats['efficiency_score'] === 'Good' ? 80 : ($stats['efficiency_score'] === 'Fair' ? 60 : 40));
            })->take(5)->values()->map(function ($stats, $index) {
                $variance = $stats['total_spent'] - $stats['total_budgeted'];
                return [
                    $index + 1,
                    $stats['name'],
                    $stats['efficiency_score'],
                    number_format($stats['avg_utilization'], 1) . '%',
                    Auth::user()->preferences->defaultCurrency->symbol . number_format($stats['total_budgeted'], 2),
                    ($variance >= 0 ? '+' : '') . Auth::user()->preferences->defaultCurrency->symbol . number_format($variance, 2)
                ];
            }),
            [''],

            // Risk Analysis by Category
            ['CATEGORY RISK ANALYSIS'],
            ['Category', 'Risk Level', 'Reason', 'Mitigation Strategy', 'Priority'],
            ...$categoryStats->filter(function ($stats) {
                return in_array($stats['risk_level'], ['High', 'Medium']);
            })->map(function ($stats) {
                return [
                    $stats['name'],
                    $stats['risk_level'],
                    $this->getRiskReason($stats),
                    $this->getMitigationStrategy($stats),
                    $this->getPriority($stats['risk_level'])
                ];
            }),
            [''],

            // Category Frequency Analysis
            ['BUDGET FREQUENCY DISTRIBUTION BY CATEGORY'],
            ['Category', 'Monthly', 'Quarterly', 'Yearly', 'One-time', 'Total Budgets'],
            ...$this->getCategoryFrequencyAnalysis($budgets),
            [''],

            // Roll-over Analysis
            ['CATEGORY ROLL-OVER ANALYSIS'],
            ['Category', 'Roll-over Enabled', 'No Roll-over', 'Roll-over Rate %', 'Impact Assessment'],
            ...$this->getCategoryRolloverAnalysis($budgets)
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Category Insights';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 12,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 15,
            'J' => 12,
            'K' => 12,
            'L' => 25
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E79']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            6 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
            ],
            7 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Apply conditional formatting for risk levels
                $this->applyRiskConditionalFormatting($sheet);

                // Apply borders to main data table
                $dataRange = 'A7:L' . (7 + collect($this->reportData['budgets'])->groupBy('category.name')->count());
                $sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);
            },
        ];
    }

    private function calculateEfficiencyScore($utilization): string
    {
        // Optimal utilization is around 75-85%
        if ($utilization >= 75 && $utilization <= 85) return 'Excellent';
        if ($utilization >= 65 && $utilization <= 95) return 'Good';
        if ($utilization >= 50 && $utilization < 100) return 'Fair';
        return 'Poor';
    }

    private function calculateRiskLevel($categoryBudgets): string
    {
        $overBudgetCount = $categoryBudgets->where('status', 'over_budget')->count();
        $avgUtilization = $categoryBudgets->avg('budget_utilization');

        if ($overBudgetCount > 0 || $avgUtilization > 100) return 'High';
        if ($avgUtilization > 90 || $categoryBudgets->where('status', 'warning')->count() > 0) return 'Medium';
        return 'Low';
    }

    private function calculateTrend($categoryBudgets): string
    {
        // This would ideally compare with historical data
        // For now, we'll base it on current utilization
        $avgUtilization = $categoryBudgets->avg('budget_utilization');

        if ($avgUtilization > 90) return 'Increasing';
        if ($avgUtilization < 50) return 'Decreasing';
        return 'Stable';
    }

    private function getRecommendation($categoryBudgets, $avgUtilization): string
    {
        $overBudgetCount = $categoryBudgets->where('status', 'over_budget')->count();

        if ($overBudgetCount > 0) return 'Immediate budget review required';
        if ($avgUtilization > 95) return 'Consider increasing budget allocation';
        if ($avgUtilization < 30) return 'Reduce budget or reallocate funds';
        if ($avgUtilization >= 75 && $avgUtilization <= 85) return 'Maintain current allocation';
        return 'Monitor and adjust as needed';
    }

    private function getStatusFromUtilization($utilization): string
    {
        if ($utilization > 100) return 'Over Budget';
        if ($utilization > 90) return 'Critical';
        if ($utilization > 80) return 'Warning';
        if ($utilization > 50) return 'Good';
        return 'Under-utilized';
    }

    private function getRiskReason($stats): string
    {
        if ($stats['avg_utilization'] > 100) return 'Over budget spending';
        if ($stats['avg_utilization'] > 90) return 'High utilization rate';
        if ($stats['spending_share'] > 30) return 'High spending concentration';
        return 'Multiple factors';
    }

    private function getMitigationStrategy($stats): string
    {
        if ($stats['avg_utilization'] > 100) return 'Immediate spending freeze and review';
        if ($stats['avg_utilization'] > 90) return 'Increase budget or reduce spending';
        if ($stats['spending_share'] > 30) return 'Diversify spending across categories';
        return 'Regular monitoring and controls';
    }

    private function getPriority($riskLevel): string
    {
        return match ($riskLevel) {
            'High' => 'Urgent',
            'Medium' => 'Important',
            default => 'Monitor'
        };
    }

    private function getCategoryFrequencyAnalysis($budgets)
    {
        return $budgets->groupBy(function ($budget) {
            return $budget->category->name ?? $budget->category_name;
        })->map(function ($categoryBudgets, $categoryName) {
            $frequencies = $categoryBudgets->groupBy('frequency');
            return [
                $categoryName,
                $frequencies->get('monthly', collect())->count(),
                $frequencies->get('quarterly', collect())->count(),
                $frequencies->get('yearly', collect())->count(),
                $frequencies->get('one-time', collect())->count() + $frequencies->get('once', collect())->count(),
                $categoryBudgets->count()
            ];
        })->values();
    }

    private function getCategoryRolloverAnalysis($budgets)
    {
        return $budgets->groupBy(function ($budget) {
            return $budget->category->name ?? $budget->category_name;
        })->map(function ($categoryBudgets, $categoryName) {
            $rolloverEnabled = $categoryBudgets->where('roll_over', true)->count();
            $noRollover = $categoryBudgets->where('roll_over', false)->count();
            $total = $categoryBudgets->count();
            $rolloverRate = $total > 0 ? ($rolloverEnabled / $total) * 100 : 0;

            return [
                $categoryName,
                $rolloverEnabled,
                $noRollover,
                number_format($rolloverRate, 1) . '%',
                $this->getRolloverImpact($rolloverRate)
            ];
        })->values();
    }

    private function getRolloverImpact($rolloverRate): string
    {
        if ($rolloverRate > 75) return 'High flexibility, good for variable expenses';
        if ($rolloverRate > 50) return 'Moderate flexibility, balanced approach';
        if ($rolloverRate > 25) return 'Limited flexibility, structured spending';
        return 'Strict budgeting, no carry-over';
    }

    private function applyRiskConditionalFormatting(Worksheet $sheet)
    {
        // This would apply conditional formatting for risk levels
        // Implementation would depend on specific cell ranges
    }
}

// // Budget Charts Sheet Implementation
// class BudgetChartsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
// {
//     private array $reportData;

//     public function __construct(array $reportData)
//     {
//         $this->reportData = $reportData;
//     }

//     public function collection()
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $summary = $this->reportData['summary'];

//         return collect([
//             // Chart Data Section
//             ['CHARTS & VISUALIZATIONS DATA'],
//             ['This sheet contains data formatted for creating charts and graphs'],
//             ['Generated: ' . now()->format('F d, Y H:i:s T')],
//             [''],

//             // Budget vs Spent Chart Data
//             ['BUDGET VS SPENT COMPARISON'],
//             ['Category', 'Budgeted', 'Spent', 'Remaining', 'Utilization %'],
//             ...$budgets->map(function ($budget) {
//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->amount,
//                     $budget->total_spent,
//                     $budget->remaining_amount,
//                     $budget->budget_utilization
//                 ];
//             }),
//             [''],

//             // Status Distribution Data
//             ['STATUS DISTRIBUTION'],
//             ['Status', 'Count', 'Percentage'],
//             ...$budgets->groupBy('status')->map(function ($statusBudgets, $status) use ($budgets) {
//                 $count = $statusBudgets->count();
//                 $percentage = ($count / $budgets->count()) * 100;
//                 return [
//                     ucfirst(str_replace('_', ' ', $status)),
//                     $count,
//                     number_format($percentage, 1)
//                 ];
//             }),
//             [''],

//             // Monthly Spending Trend (if historical data available)
//             ['UTILIZATION BY CATEGORY'],
//             ['Category', 'Utilization %', 'Status Color Code'],
//             ...$budgets->sortByDesc('budget_utilization')->map(function ($budget) {
//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->budget_utilization,
//                     $this->getColorCode($budget->status)
//                 ];
//             }),
//             [''],

//             // Frequency Distribution
//             ['BUDGET FREQUENCY DISTRIBUTION'],
//             ['Frequency', 'Count', 'Total Amount'],
//             ...$budgets->groupBy('frequency')->map(function ($frequencyBudgets, $frequency) {
//                 return [
//                     ucfirst($frequency),
//                     $frequencyBudgets->count(),
//                     $frequencyBudgets->sum('amount')
//                 ];
//             }),
//             [''],

//             // Top 10 Categories by Spending
//             ['TOP 10 CATEGORIES BY SPENDING'],
//             ['Rank', 'Category', 'Amount Spent', 'Budget', 'Variance'],
//             ...$budgets->sortByDesc('total_spent')->take(10)->values()->map(function ($budget, $index) {
//                 return [
//                     $index + 1,
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->total_spent,
//                     $budget->amount,
//                     $budget->total_spent - $budget->amount
//                 ];
//             }),
//             [''],

//             // Performance Quadrant Data
//             ['PERFORMANCE QUADRANT ANALYSIS'],
//             ['Category', 'Budget Size', 'Utilization %', 'Quadrant'],
//             ...$budgets->map(function ($budget) {
//                 $budgetSize = $budget->amount > $this->getMedianBudget() ? 'High' : 'Low';
//                 $utilization = $budget->budget_utilization > 75 ? 'High' : 'Low';
//                 $quadrant = $this->getQuadrant($budgetSize, $utilization);

//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->amount,
//                     $budget->budget_utilization,
//                     $quadrant
//                 ];
//             }),
//             [''],

//             // Roll-over Impact Analysis
//             ['ROLL-OVER IMPACT ANALYSIS'],
//             ['Category', 'Roll-over Enabled', 'Budget Amount', 'Spent Amount', 'Flexibility Score'],
//             ...$budgets->map(function ($budget) {
//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->roll_over ? 'Yes' : 'No',
//                     $budget->amount,
//                     $budget->total_spent,
//                     $this->calculateFlexibilityScore($budget)
//                 ];
//             }),
//             [''],

//             // Summary Statistics for Charts
//             ['SUMMARY STATISTICS'],
//             ['Metric', 'Value'],
//             ['Total Categories', $budgets->count()],
//             ['Total Budgeted', $summary['total_budgeted']],
//             ['Total Spent', $summary['total_spent']],
//             ['Overall Utilization', $summary['overall_utilization']],
//             ['Over Budget Count', $summary['over_budget_count']],
//             ['Average Budget Size', $budgets->avg('amount')],
//             ['Median Budget Size', $this->getMedianBudget()],
//             ['Standard Deviation', $this->getStandardDeviation()],
//             ['Highest Spending Category', $budgets->sortByDesc('total_spent')->first()->category->name ?? 'N/A'],
//             ['Most Efficient Category', $this->getMostEfficientCategory()]
//         ]);
//     }

//     public function headings(): array
//     {
//         return [];
//     }

//     public function title(): string
//     {
//         return 'Charts & Visualizations';
//     }

//     public function columnWidths(): array
//     {
//         return [
//             'A' => 25,
//             'B' => 15,
//             'C' => 15,
//             'D' => 15,
//             'E' => 15
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         return [
//             1 => [
//                 'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E79']],
//                 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
//             ],
//             5 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ],
//             6 => [
//                 'font' => ['bold' => true],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']],
//                 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
//             ]
//         ];
//     }

//     private function getColorCode($status): string
//     {
//         return match ($status) {
//             'over_budget' => 'Red',
//             'warning' => 'Orange',
//             'on_track' => 'Green',
//             'under_utilized' => 'Gray',
//             default => 'Blue'
//         };
//     }

//     private function getMedianBudget(): float
//     {
//         $amounts = collect($this->reportData['budgets'])->pluck('amount')->sort()->values();
//         $count = $amounts->count();

//         if ($count === 0) return 0;
//         if ($count % 2 === 0) {
//             return ($amounts[$count / 2 - 1] + $amounts[$count / 2]) / 2;
//         }
//         return $amounts[floor($count / 2)];
//     }

//     private function getQuadrant($budgetSize, $utilization): string
//     {
//         if ($budgetSize === 'High' && $utilization === 'High') return 'High Impact - High Usage';
//         if ($budgetSize === 'High' && $utilization === 'Low') return 'High Impact - Low Usage';
//         if ($budgetSize === 'Low' && $utilization === 'High') return 'Low Impact - High Usage';
//         return 'Low Impact - Low Usage';
//     }

//     private function calculateFlexibilityScore($budget): float
//     {
//         $baseScore = 50;
//         if ($budget->roll_over) $baseScore += 30;
//         if ($budget->frequency === 'monthly') $baseScore += 20;
//         if ($budget->budget_utilization < 90) $baseScore += 10;

//         return min(100, $baseScore);
//     }

//     private function getStandardDeviation(): float
//     {
//         $amounts = collect($this->reportData['budgets'])->pluck('amount');
//         $mean = $amounts->avg();
//         $variance = $amounts->map(function ($amount) use ($mean) {
//             return pow($amount - $mean, 2);
//         })->avg();

//         return sqrt($variance);
//     }

//     private function getMostEfficientCategory(): string
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $mostEfficient = $budgets->filter(function ($budget) {
//             return $budget->budget_utilization >= 75 && $budget->budget_utilization <= 85;
//         })->sortByDesc('budget_utilization')->first();

//         return $mostEfficient ? ($mostEfficient->category->name ?? $mostEfficient->category_name) : 'N/A';
//     }
// }


// class BudgetChartsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents, WithCharts
// {
//     private array $reportData;

//     public function __construct(array $reportData)
//     {
//         $this->reportData = $reportData;
//     }

//     public function collection()
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $summary = $this->reportData['summary'];

//         return collect([
//             // Chart Data Section
//             ['CHARTS & VISUALIZATIONS DASHBOARD'],
//             ['This sheet contains interactive charts and data visualizations'],
//             ['Generated: ' . now()->format('F d, Y H:i:s T')],
//             ['User: ' . Auth::user()->name],
//             [''],
//             [''],
//             [''],
//             [''],
//             [''],
//             [''],

//             // Budget vs Spent Chart Data (Starting at row 11)
//             ['BUDGET VS SPENT COMPARISON DATA'],
//             ['Category', 'Budgeted', 'Spent', 'Remaining', 'Utilization %'],
//             ...$budgets->take(10)->map(function ($budget) {
//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->amount,
//                     $budget->total_spent,
//                     $budget->remaining_amount,
//                     round($budget->budget_utilization, 1)
//                 ];
//             }),
//             [''],
//             [''],
//             [''],
//             [''],
//             [''],

//             // Status Distribution Data (Starting around row 30)
//             ['STATUS DISTRIBUTION DATA'],
//             ['Status', 'Count', 'Percentage'],
//             ...$budgets->groupBy('status')->map(function ($statusBudgets, $status) use ($budgets) {
//                 $count = $statusBudgets->count();
//                 $percentage = ($count / $budgets->count()) * 100;
//                 return [
//                     ucfirst(str_replace('_', ' ', $status)),
//                     $count,
//                     round($percentage, 1)
//                 ];
//             }),
//             [''],
//             [''],
//             [''],
//             [''],
//             [''],

//             // Top Categories Data (Starting around row 45)
//             ['TOP SPENDING CATEGORIES DATA'],
//             ['Category', 'Amount Spent', 'Budget', 'Utilization %'],
//             ...$budgets->sortByDesc('total_spent')->take(8)->map(function ($budget) {
//                 return [
//                     $budget->category->name ?? $budget->category_name,
//                     $budget->total_spent,
//                     $budget->amount,
//                     round($budget->budget_utilization, 1)
//                 ];
//             }),
//             [''],
//             [''],
//             [''],
//             [''],
//             [''],

//             // Frequency Distribution Data (Starting around row 60)
//             ['BUDGET FREQUENCY DISTRIBUTION DATA'],
//             ['Frequency', 'Count', 'Total Amount'],
//             ...$budgets->groupBy('frequency')->map(function ($frequencyBudgets, $frequency) {
//                 return [
//                     ucfirst($frequency),
//                     $frequencyBudgets->count(),
//                     $frequencyBudgets->sum('amount')
//                 ];
//             }),
//             [''],
//             [''],
//             [''],

//             // Summary Statistics
//             ['SUMMARY STATISTICS'],
//             ['Metric', 'Value'],
//             ['Total Categories', $budgets->count()],
//             ['Total Budgeted', $summary['total_budgeted']],
//             ['Total Spent', $summary['total_spent']],
//             ['Overall Utilization', round($summary['overall_utilization'], 1) . '%'],
//             ['Over Budget Count', $summary['over_budget_count']],
//             ['Average Budget Size', round($budgets->avg('amount'), 2)],
//             ['Median Budget Size', $this->getMedianBudget()],
//             ['Most Efficient Category', $this->getMostEfficientCategory()]
//         ]);
//     }

//     public function headings(): array
//     {
//         return [];
//     }

//     public function title(): string
//     {
//         return 'Charts & Visualizations';
//     }

//     public function columnWidths(): array
//     {
//         return [
//             'A' => 25,
//             'B' => 15,
//             'C' => 15,
//             'D' => 15,
//             'E' => 15,
//             'F' => 20,
//             'G' => 20,
//             'H' => 20,
//             'I' => 20,
//             'J' => 20
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         return [
//             1 => [
//                 'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E79']],
//                 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
//             ],
//             11 => [
//                 'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
//             ],
//             12 => [
//                 'font' => ['bold' => true],
//                 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']],
//                 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
//             ]
//         ];
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $this->addChartsToSheet($event->sheet->getDelegate());
//             },
//         ];
//     }

//     private function addChartsToSheet(Worksheet $sheet)
//     {
//         // Chart 1: Budget vs Spent Comparison (Column Chart)
//         $this->createBudgetVsSpentChart($sheet);

//         // Chart 2: Status Distribution (Pie Chart)
//         $this->createStatusDistributionChart($sheet);

//         // Chart 3: Top Categories (Bar Chart)
//         $this->createTopCategoriesChart($sheet);

//         // Chart 4: Frequency Distribution (Doughnut Chart)
//         $this->createFrequencyDistributionChart($sheet);
//     }

//     private function createBudgetVsSpentChart(Worksheet $sheet)
//     {
//         $budgets = collect($this->reportData['budgets'])->take(10);
//         $dataCount = min(10, $budgets->count());

//         // Data series for categories (X-axis labels)
//         $categories = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_STRING,
//             'Charts & Visualizations!$A$13:$A$' . (12 + $dataCount),
//             null,
//             $dataCount
//         );

//         // Data series for budgeted amounts
//         $budgetedValues = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_NUMBER,
//             'Charts & Visualizations!$B$13:$B$' . (12 + $dataCount),
//             null,
//             $dataCount
//         );

//         // Data series for spent amounts
//         $spentValues = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_NUMBER,
//             'Charts & Visualizations!$C$13:$C$' . (12 + $dataCount),
//             null,
//             $dataCount
//         );

//         // Create the data series
//         $series = new DataSeries(
//             DataSeries::TYPE_BARCHART,
//             DataSeries::GROUPING_CLUSTERED,
//             range(0, 1),
//             ['Budgeted', 'Spent'],
//             [$categories, $categories],
//             [$budgetedValues, $spentValues]
//         );

//         // Create the plot area
//         $plotArea = new PlotArea(null, [$series]);

//         // Create the legend
//         $legend = new Legend(Legend::POSITION_BOTTOM, null, false);

//         // Create the title
//         $title = new Title('Budget vs Spent Comparison');

//         // Create the chart
//         $chart = new Chart(
//             'budgetVsSpentChart',
//             $title,
//             $legend,
//             $plotArea
//         );

//         // Set the position and size of the chart
//         $chart->setTopLeftPosition('F1');
//         $chart->setBottomRightPosition('K10');

//         // Add the chart to the worksheet
//         $sheet->addChart($chart);
//     }

//     private function createStatusDistributionChart(Worksheet $sheet)
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $statusData = $budgets->groupBy('status');
//         $dataCount = $statusData->count();

//         if ($dataCount == 0) return;

//         // Calculate starting row for status data
//         $startRow = 31;
//         $endRow = $startRow + $dataCount;

//         // Data series for status labels
//         $categories = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_STRING,
//             'Charts & Visualizations!$A$' . ($startRow + 1) . ':$A$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Data series for counts
//         $values = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_NUMBER,
//             'Charts & Visualizations!$B$' . ($startRow + 1) . ':$B$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Create the data series
//         $series = new DataSeries(
//             DataSeries::TYPE_PIECHART,
//             null,
//             range(0, $dataCount - 1),
//             ['Status Distribution'],
//             [$categories],
//             [$values]
//         );

//         // Create the plot area
//         $plotArea = new PlotArea(null, [$series]);

//         // Create the legend
//         $legend = new Legend(Legend::POSITION_RIGHT, null, false);

//         // Create the title
//         $title = new Title('Budget Status Distribution');

//         // Create the chart
//         $chart = new Chart(
//             'statusDistributionChart',
//             $title,
//             $legend,
//             $plotArea
//         );

//         // Set the position and size of the chart
//         $chart->setTopLeftPosition('F11');
//         $chart->setBottomRightPosition('K20');

//         // Add the chart to the worksheet
//         $sheet->addChart($chart);
//     }

//     private function createTopCategoriesChart(Worksheet $sheet)
//     {
//         $budgets = collect($this->reportData['budgets'])->sortByDesc('total_spent')->take(8);
//         $dataCount = min(8, $budgets->count());

//         if ($dataCount == 0) return;

//         // Calculate starting row for top categories data
//         $startRow = 46;
//         $endRow = $startRow + $dataCount;

//         // Data series for category names
//         $categories = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_STRING,
//             'Charts & Visualizations!$A$' . ($startRow + 1) . ':$A$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Data series for spending amounts
//         $values = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_NUMBER,
//             'Charts & Visualizations!$B$' . ($startRow + 1) . ':$B$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Create the data series
//         $series = new DataSeries(
//             DataSeries::TYPE_BARCHART,
//             DataSeries::GROUPING_CLUSTERED,
//             range(0, 0),
//             ['Amount Spent'],
//             [$categories],
//             [$values]
//         );

//         // Create the plot area
//         $plotArea = new PlotArea(null, [$series]);

//         // Create the legend
//         $legend = new Legend(Legend::POSITION_BOTTOM, null, false);

//         // Create the title
//         $title = new Title('Top Spending Categories');

//         // Create the chart
//         $chart = new Chart(
//             'topCategoriesChart',
//             $title,
//             $legend,
//             $plotArea
//         );

//         // Set the position and size of the chart
//         $chart->setTopLeftPosition('F21');
//         $chart->setBottomRightPosition('K30');

//         // Add the chart to the worksheet
//         $sheet->addChart($chart);
//     }

//     private function createFrequencyDistributionChart(Worksheet $sheet)
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $frequencyData = $budgets->groupBy('frequency');
//         $dataCount = $frequencyData->count();

//         if ($dataCount == 0) return;

//         // Calculate starting row for frequency data
//         $startRow = 61;
//         $endRow = $startRow + $dataCount;

//         // Data series for frequency labels
//         $categories = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_STRING,
//             'Charts & Visualizations!$A$' . ($startRow + 1) . ':$A$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Data series for counts
//         $values = new DataSeriesValues(
//             DataSeriesValues::DATASERIES_TYPE_NUMBER,
//             'Charts & Visualizations!$B$' . ($startRow + 1) . ':$B$' . $endRow,
//             null,
//             $dataCount
//         );

//         // Create the data series
//         $series = new DataSeries(
//             DataSeries::TYPE_DOUGHNUTCHART,
//             null,
//             range(0, $dataCount - 1),
//             ['Frequency Distribution'],
//             [$categories],
//             [$values]
//         );

//         // Create the plot area
//         $plotArea = new PlotArea(null, [$series]);

//         // Create the legend
//         $legend = new Legend(Legend::POSITION_RIGHT, null, false);

//         // Create the title
//         $title = new Title('Budget Frequency Distribution');

//         // Create the chart
//         $chart = new Chart(
//             'frequencyDistributionChart',
//             $title,
//             $legend,
//             $plotArea
//         );

//         // Set the position and size of the chart
//         $chart->setTopLeftPosition('F31');
//         $chart->setBottomRightPosition('K40');

//         // Add the chart to the worksheet
//         $sheet->addChart($chart);
//     }

//     // Helper methods remain the same...
//     private function getMedianBudget(): float
//     {
//         $amounts = collect($this->reportData['budgets'])->pluck('amount')->sort()->values();
//         $count = $amounts->count();

//         if ($count === 0) return 0;
//         if ($count % 2 === 0) {
//             return ($amounts[$count / 2 - 1] + $amounts[$count / 2]) / 2;
//         }
//         return $amounts[floor($count / 2)];
//     }

//     private function getMostEfficientCategory(): string
//     {
//         $budgets = collect($this->reportData['budgets']);
//         $mostEfficient = $budgets->filter(function ($budget) {
//             return $budget->budget_utilization >= 75 && $budget->budget_utilization <= 85;
//         })->sortByDesc('budget_utilization')->first();

//         return $mostEfficient ? ($mostEfficient->category->name ?? $mostEfficient->category_name) : 'N/A';
//     }

//     public function charts(): array
//     {
//         return [];
//     }
// }

// Enhanced Executive Summary Sheet with Summary Chart
class BudgetSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents, WithCharts
{
    private array $reportData;
    private $summaryChart;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $summary = $this->reportData['summary'];
        $dateRange = $this->reportData['dateRange'];

        return collect([
            // Report Header
            ['FINANCIAL BUDGET REPORT - EXECUTIVE SUMMARY'],
            ['Generated on: ' . now()->format('F d, Y H:i:s T')],
            ['Report Period: ' . $this->getDateRangeText($dateRange)],
            ['User: ' . Auth::user()->name],
            [''],
            [''],
            [''],
            [''],

            // Key Metrics
            ['KEY PERFORMANCE INDICATORS'],
            ['Metric', 'Value', 'Status'],
            ['Total Budgets', $summary['total_budgets'], $this->getPerformanceStatus($summary['total_budgets'], 'count')],
            ['Total Budgeted Amount', $summary['total_budgeted'], 'Baseline'],
            ['Total Spent Amount', $summary['total_spent'], $this->getSpendingStatus($summary)],
            ['Total Remaining', $summary['total_remaining'], $this->getRemainingStatus($summary)],
            ['Overall Utilization', round($summary['overall_utilization'], 1), $this->getUtilizationStatus($summary['overall_utilization'])],
            ['Average Utilization', round($summary['average_utilization'], 1), $this->getUtilizationStatus($summary['average_utilization'])],
            ['Budgets Over Limit', $summary['over_budget_count'], $this->getOverBudgetStatus($summary['over_budget_count'])],
            ['Budgets On Track', $summary['on_track_count'], 'Good'],
            [''],

            // Chart Data for Summary Visualization
            ['SUMMARY CHART DATA'],
            ['Category', 'Amount'],
            ['Total Budgeted', $summary['total_budgeted']],
            ['Total Spent', $summary['total_spent']],
            ['Total Remaining', $summary['total_remaining']],
            [''],

            // Performance Summary
            ['PERFORMANCE SUMMARY'],
            ['Budget Health Score', $this->calculateHealthScore(), $this->getHealthScoreStatus()],
            ['Variance from Plan', $summary['total_spent'] - $summary['total_budgeted'], $this->getVarianceStatus($summary)],
            ['Efficiency Rating', $this->getEfficiencyRating(), $this->getEfficiencyStatus()],
            [''],

            // Risk Assessment
            ['RISK ASSESSMENT'],
            ['Risk Level', $this->getRiskLevel(), ''],
            ['Critical Budgets', $this->getCriticalBudgetsCount(), ''],
            ['Warning Budgets', $this->getWarningBudgetsCount(), ''],
            [''],

            // Recommendations
            ['RECOMMENDATIONS'],
            ...$this->getRecommendations()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Apply formatting
                $this->applyConditionalFormatting($sheet);
                $this->summaryChart = $this->addSummaryChart($sheet);

                // Add borders to data ranges
                $sheet->getStyle('A10:C18')->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);
            },
        ];
    }

    private function addSummaryChart(Worksheet $sheet)
    {
        // Create a summary pie chart showing budget allocation
        $categories = new DataSeriesValues(
            DataSeriesValues::DATASERIES_TYPE_STRING,
            "'Executive Summary'!\$A\$22:\$A\$24",
            null,
            3
        );

        $values = new DataSeriesValues(
            DataSeriesValues::DATASERIES_TYPE_NUMBER,
            "Executive Summary'!\$B\$22:\$B\$24",
            null,
            3
        );

        $series = new DataSeries(
            DataSeries::TYPE_PIECHART,
            DataSeries::GROUPING_STANDARD,
            [0, 1, 2],
            [],
            [$categories],
            [$values]
        );

        $title = new Title('Budget Summary Overview');
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $plotArea = new PlotArea(null, [$series]);

        $chart = new Chart(
            'summaryChart',
            $title,
            $legend,
            $plotArea
        );

        $chart->setTopLeftPosition('E1');
        $chart->setBottomRightPosition('J8');

        $sheet->addChart($chart);
    }

    // ... [Rest of the methods remain the same] ...

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Executive Summary';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E79']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            9 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2F5597']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7F3FF']]
            ],
            10 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E2F3']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]
        ];
    }

    // ... [All the helper methods remain the same] ...
    private function getDateRangeText($dateRange): string
    {
        if ($dateRange[0] && $dateRange[1]) {
            return $dateRange[0]->format('M d, Y') . ' to ' . $dateRange[1]->format('M d, Y');
        }
        return 'All Time';
    }

    private function calculateHealthScore(): string
    {
        $summary = $this->reportData['summary'];
        $score = 100;

        $score -= ($summary['over_budget_count'] * 15);

        if ($summary['overall_utilization'] > 90) {
            $score -= 20;
        } elseif ($summary['overall_utilization'] > 80) {
            $score -= 10;
        }

        if ($summary['overall_utilization'] < 30) {
            $score -= 15;
        }

        return max(0, $score) . '/100';
    }

    private function getRecommendations(): array
    {
        $recommendations = [];
        $summary = $this->reportData['summary'];

        if ($summary['over_budget_count'] > 0) {
            $recommendations[] = ['• Review and adjust over-budget categories immediately'];
        }

        if ($summary['overall_utilization'] > 90) {
            $recommendations[] = ['• Consider increasing budget allocations for high-utilization categories'];
        }

        if ($summary['overall_utilization'] < 50) {
            $recommendations[] = ['• Redistribute unused budget to higher-priority categories'];
        }

        $recommendations[] = ['• Implement monthly budget review meetings'];
        $recommendations[] = ['• Set up automated alerts for budget thresholds'];

        return $recommendations;
    }

    private function getPerformanceStatus($value, $type): string
    {
        return $type === 'count' ? ($value > 0 ? 'Active' : 'None') : 'Good';
    }

    private function getSpendingStatus($summary): string
    {
        $utilization = $summary['overall_utilization'];
        if ($utilization > 100) return 'Over Budget';
        if ($utilization > 90) return 'High';
        if ($utilization > 70) return 'Normal';
        return 'Low';
    }

    private function getRemainingStatus($summary): string
    {
        return $summary['total_remaining'] >= 0 ? 'Positive' : 'Deficit';
    }

    private function getUtilizationStatus($utilization): string
    {
        if ($utilization > 100) return 'Over Budget';
        if ($utilization > 90) return 'Critical';
        if ($utilization > 80) return 'Warning';
        if ($utilization > 50) return 'Good';
        return 'Under-utilized';
    }

    private function getOverBudgetStatus($count): string
    {
        if ($count == 0) return 'Excellent';
        if ($count <= 2) return 'Warning';
        return 'Critical';
    }

    private function getHealthScoreStatus(): string
    {
        $score = (int) explode('/', $this->calculateHealthScore())[0];
        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Good';
        if ($score >= 70) return 'Fair';
        return 'Poor';
    }

    private function getVarianceStatus($summary): string
    {
        $variance = $summary['total_spent'] - $summary['total_budgeted'];
        if ($variance > 0) return 'Over Budget';
        if (abs($variance) / $summary['total_budgeted'] < 0.1) return 'On Target';
        return 'Under Budget';
    }

    private function getEfficiencyRating(): string
    {
        $summary = $this->reportData['summary'];
        $efficiency = 100 - abs($summary['overall_utilization'] - 85);
        return number_format(max(0, $efficiency), 1) . '%';
    }

    private function getEfficiencyStatus(): string
    {
        $efficiency = (float) str_replace('%', '', $this->getEfficiencyRating());
        if ($efficiency >= 90) return 'Excellent';
        if ($efficiency >= 80) return 'Good';
        if ($efficiency >= 70) return 'Fair';
        return 'Poor';
    }

    private function getRiskLevel(): string
    {
        $summary = $this->reportData['summary'];
        if ($summary['over_budget_count'] > 3) return 'High';
        if ($summary['over_budget_count'] > 1) return 'Medium';
        if ($summary['overall_utilization'] > 95) return 'Medium';
        return 'Low';
    }

    private function getCriticalBudgetsCount(): int
    {
        return collect($this->reportData['budgets'])->where('status', 'over_budget')->count();
    }

    private function getWarningBudgetsCount(): int
    {
        return collect($this->reportData['budgets'])->where('status', 'warning')->count();
    }

    private function applyConditionalFormatting(Worksheet $sheet)
    {
        // Add conditional formatting for status columns
        $sheet->getStyle('C11:C18')->getConditionalStyles();
    }

    public function charts(): array
    {
        return [];
    }
}
