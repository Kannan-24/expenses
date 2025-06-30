<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCharts;

class TransactionsReportExport implements WithMultipleSheets
{

    /**
     * The data to be exported.
     *
     * @var array
     */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [
            new TransactionsSummarySheet($this->data),
            new TransactionsDetailSheet($this->data),
        ];

        // Add category analysis sheet if category summary exists
        if (!empty($this->data['categorySummary'])) {
            $sheets[] = new CategoryAnalysisSheet($this->data);
        }

        // Add monthly trends sheet if enough data
        if ($this->data['transactions']->count() > 0) {
            $sheets[] = new MonthlyTrendsSheet($this->data);
        }

        return $sheets;
    }
}


class TransactionsSummarySheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithCustomStartCell, WithEvents
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $summary = collect();

        // Report Information
        $summary->push(['Report Information', '']);
        $summary->push(['Generated On', $this->data['generatedAt']->format('Y-m-d H:i:s')]);
        $summary->push(['Date Range', $this->getDateRangeText()]);
        $summary->push(['Transaction Type', $this->data['transactionType'] === 'all' ? 'All Types' : ucfirst($this->data['transactionType'])]);

        if ($this->data['category']) {
            $summary->push(['Category Filter', $this->data['category']->name]);
        }
        if ($this->data['wallet']) {
            $summary->push(['Wallet Filter', $this->data['wallet']->name]);
        }
        if ($this->data['person']) {
            $summary->push(['Person Filter', $this->data['person']->name]);
        }
        if ($this->data['amountFilter']) {
            $summary->push(['Amount Filter', $this->data['amountFilter']['operator'] . ' ' . number_format($this->data['amountFilter']['amount'], 2)]);
        }

        $summary->push(['', '']); // Empty row

        // Financial Summary
        $summary->push(['Financial Summary', '']);
        $summary->push(['Total Income', number_format($this->data['summary']['total_income'], 2)]);
        $summary->push(['Total Expenses', number_format($this->data['summary']['total_expense'], 2)]);
        $summary->push(['Net Amount', number_format($this->data['summary']['net_total'], 2)]);
        $summary->push(['', '']); // Empty row

        // Transaction Statistics
        $summary->push(['Transaction Statistics', '']);
        $summary->push(['Total Transactions', $this->data['summary']['transaction_count']]);
        $summary->push(['Income Transactions', $this->data['summary']['income_count']]);
        $summary->push(['Expense Transactions', $this->data['summary']['expense_count']]);
        $summary->push(['Average Transaction', number_format($this->data['summary']['average_transaction'], 2)]);
        $summary->push(['Largest Transaction', number_format($this->data['summary']['largest_transaction'], 2)]);
        $summary->push(['Smallest Transaction', number_format($this->data['summary']['smallest_transaction'], 2)]);

        return $summary;
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
            ],
            // Section headers
            'A2:A2' => ['font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '4F81BD']]],
            'A10:A10' => ['font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '4F81BD']]],
            'A15:A15' => ['font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '4F81BD']]],
            // Financial summary values
            'B11:B13' => [
                'font' => ['bold' => true],
                'numberFormat' => ['formatCode' => '#,##0.00'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add borders to all data
                $sheet->getStyle('A1:B' . $sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Color code financial summary
                $sheet->getStyle('B11')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('90EE90'); // Light green for income
                $sheet->getStyle('B12')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFB6C1'); // Light red for expenses
                $sheet->getStyle('B13')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('ADD8E6'); // Light blue for net
            },
        ];
    }

    private function getDateRangeText(): string
    {
        if ($this->data['dateRange'] === 'custom') {
            return $this->data['startDate']->format('Y-m-d') . ' to ' . $this->data['endDate']->format('Y-m-d');
        }

        return $this->data['dateRanges'][$this->data['dateRange']] ?? 'All Time';
    }
}

class TransactionsDetailSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data['transactions']->map(function ($transaction, $index) {
            return [
                'sr_no' => $index + 1,
                'date' => $transaction->date->format('Y-m-d'),
                'type' => ucfirst($transaction->type),
                'amount' => $transaction->amount,
                'category' => $transaction->category->name ?? 'Uncategorized',
                'wallet' => $transaction->wallet->name ?? 'Default',
                'person' => $transaction->person->name ?? '',
                'notes' => $transaction->notes ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Date',
            'Type',
            'Amount',
            'Category',
            'Wallet',
            'Person',
            'Notes'
        ];
    }

    public function title(): string
    {
        return 'Transaction Details';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 12,
            'C' => 10,
            'D' => 12,
            'E' => 15,
            'F' => 12,
            'G' => 12,
            'H' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->data['transactions']->count() + 1;

        return [
            // Header row
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Amount column formatting
            'D2:D' . $rowCount => [
                'numberFormat' => ['formatCode' => '#,##0.00'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            // Center align Sr. No. and Type columns
            'A2:A' . $rowCount => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'C2:C' . $rowCount => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }
}

class CategoryAnalysisSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithEvents, WithCharts
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $categories = [];

        foreach ($this->data['categorySummary'] as $categoryName => $categoryData) {
            $categories[] = [
                $categoryName ?: 'Uncategorized',
                $categoryData['amount'],
                $categoryData['count'],
                $categoryData['percentage'],
                $categoryData['count'] > 0 ? $categoryData['amount'] / $categoryData['count'] : 0,
            ];
        }

        return $categories;
    }

    public function headings(): array
    {
        return [
            'Category',
            'Total Amount',
            'Transaction Count',
            'Percentage (%)',
            'Avg Transaction'
        ];
    }

    public function title(): string
    {
        return 'Category Analysis';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->data['categorySummary']) + 1;

        return [
            // Header row
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Amount columns
            'B2:B' . $rowCount => [
                'numberFormat' => ['formatCode' => '#,##0.00'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            'E2:E' . $rowCount => [
                'numberFormat' => ['formatCode' => '#,##0.00'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            // Percentage column
            'D2:D' . $rowCount => [
                'numberFormat' => ['formatCode' => '0.00%'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            // Count column
            'C2:C' . $rowCount => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = count($this->data['categorySummary']) + 1;

                if ($rowCount <= 2) {
                    return; // Skip chart if not enough data
                }

                // Add borders
                $sheet->getStyle('A1:E' . $rowCount)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Create a pie chart for category distribution
                $this->createCategoryChart($sheet, $rowCount);
            },
        ];
    }

    private function createCategoryChart(Worksheet $sheet, int $rowCount)
    {
        // Data for the chart
        $categories = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Category Analysis'!\$A\$2:\$A\$" . $rowCount, null, $rowCount - 1);
        $values = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'Category Analysis'!\$B\$2:\$B\$" . $rowCount, null, $rowCount - 1);

        $plotOrder = range(0, $rowCount - 2);
        if (empty($plotOrder)) {
            $plotOrder = [0];
        }

        // Build the data series
        $series = new DataSeries(
            DataSeries::TYPE_PIECHART,
            DataSeries::GROUPING_STANDARD,
            $plotOrder,
            [$categories],
            [],
            [$values]
        );


        // Set up the chart
        $plotArea = new PlotArea(null, [$series]);
        $title = new Title('Expense Distribution by Category');
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);

        $chart = new Chart(
            'categoryChart',
            $title,
            $legend,
            $plotArea
        );

        // Position the chart
        $chart->setTopLeftPosition('G2');
        $chart->setBottomRightPosition('M15');

        $sheet->addChart($chart);
    }

    public function charts(): array
    {
        return [];
    }
}

class MonthlyTrendsSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithEvents, WithCharts
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $monthlyData = $this->data['transactions']
            ->groupBy(function ($transaction) {
                return $transaction->date->format('Y-m');
            })
            ->map(function ($transactions, $month) {
                $income = $transactions->where('type', 'income')->sum('amount');
                $expense = $transactions->where('type', 'expense')->sum('amount');

                return [
                    'month' => $month,
                    'month_name' => \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y'),
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                    'transaction_count' => $transactions->count(),
                ];
            })
            ->sortBy('month')
            ->values();

        return $monthlyData->map(function ($data) {
            return [
                $data['month_name'],
                $data['income'],
                $data['expense'],
                $data['net'],
                $data['transaction_count'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Month',
            'Income',
            'Expenses',
            'Net Amount',
            'Transactions'
        ];
    }

    public function title(): string
    {
        return 'Monthly Trends';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $monthCount = $this->data['transactions']
            ->groupBy(function ($transaction) {
                return $transaction->date->format('Y-m');
            })->count();

        $rowCount = $monthCount + 1;

        return [
            // Header row
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Amount columns
            'B2:D' . $rowCount => [
                'numberFormat' => ['formatCode' => '#,##0.00'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            // Transaction count column
            'E2:E' . $rowCount => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $monthCount = $this->data['transactions']
                    ->groupBy(function ($transaction) {
                        return $transaction->date->format('Y-m');
                    })->count();

                $rowCount = $monthCount + 1;

                // Add borders
                $sheet->getStyle('A1:E' . $rowCount)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Create line chart for trends
                if ($rowCount > 2) {
                    $this->createTrendsChart($sheet, $rowCount);
                }
            },
        ];
    }

    private function createTrendsChart(Worksheet $sheet, int $rowCount)
    {
        // Data for the chart
        $months = new DataSeriesValues('String', "'Monthly Trends'!\$A\$2:\$A\$" . $rowCount, null, $rowCount - 1);
        $income = new DataSeriesValues('Number', "'Monthly Trends'!\$B\$2:\$B\$" . $rowCount, null, $rowCount - 1);
        $expense = new DataSeriesValues('Number', "'Monthly Trends'!\$C\$2:\$C\$" . $rowCount, null, $rowCount - 1);
        $net = new DataSeriesValues('Number', "'Monthly Trends'!\$D\$2:\$D\$" . $rowCount, null, $rowCount - 1);

        // Build the data series
        $series = new DataSeries(
            DataSeries::TYPE_LINECHART,
            DataSeries::GROUPING_STANDARD,
            [0, 1, 2],
            [],
            [$months],
            [$income, $expense, $net]
        );

        // Set up the chart
        $plotArea = new PlotArea(null, [$series]);
        $title = new Title('Monthly Financial Trends');
        $legend = new Legend(Legend::POSITION_BOTTOM, null, false);

        $chart = new Chart(
            'trendsChart',
            $title,
            $legend,
            $plotArea
        );

        // Position the chart
        $chart->setTopLeftPosition('G2');
        $chart->setBottomRightPosition('N20');

        $sheet->addChart($chart);
    }

    public function charts(): array
    {
        return [];
    }
}
