<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BudgetReportCsvExport implements FromCollection, WithHeadings, WithMapping
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
            'Utilization Percentage',
            'Status',
            'Start Date',
            'End Date',
            'Frequency',
            'Roll Over',
            'Variance Amount',
            'Performance Rating',
            'Days Active',
            'Average Daily Spend',
            'Last Updated'
        ];
    }

    public function map($budget): array
    {
        $variance = $budget->total_spent - $budget->amount;
        $daysActive = max(1, now()->diffInDays($budget->start_date));
        $avgDailySpend = $budget->total_spent / $daysActive;
        
        return [
            $budget->category->name ?? $budget->category_name,
            number_format($budget->amount, 2),
            number_format($budget->total_spent, 2),
            number_format($budget->remaining_amount, 2),
            number_format($budget->budget_utilization, 1),
            ucfirst(str_replace('_', ' ', $budget->status)),
            $budget->start_date,
            $budget->end_date,
            ucfirst($budget->frequency),
            $budget->roll_over ? 'Yes' : 'No',
            number_format($variance, 2),
            $this->getPerformanceRating($budget),
            $daysActive,
            number_format($avgDailySpend, 2),
            now()->format('Y-m-d H:i:s')
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