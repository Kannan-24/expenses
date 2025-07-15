<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ExpensePerson;
use App\Models\ReportHistory;
use App\Models\ReportTemplate;
use App\Models\Wallet;
use App\Services\BudgetReportService;
use App\Services\TicketReportService;
use App\Services\TransactionReportService;
use App\Services\DynamicQueryBuilder;
use App\Services\ReportTemplateService;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $transactionReportService;
    protected $budgetReportService;
    protected $ticketReportService;
    protected $dynamicQueryBuilder;
    protected $templateService;


    public function __construct()
    {
        $this->transactionReportService = new TransactionReportService();
        $this->budgetReportService = new BudgetReportService();
        $this->ticketReportService = new TicketReportService();
        $this->dynamicQueryBuilder = new DynamicQueryBuilder();
        $this->templateService = new ReportTemplateService();
    }

    // Show report index page
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')->get()->pluck('name', 'id');

        $people = ExpensePerson::where('user_id', Auth::id())
            ->select('id', 'name')->distinct()->orderBy('name')->get()->pluck('name', 'id');

        $wallets = Wallet::where('user_id', Auth::id())
            ->select('id', 'name')->distinct()->orderBy('name')->get()->pluck('name', 'id');

        $reportHistories = ReportHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get available templates for quick access
        $templates = $this->templateService->getAccessibleTemplates()->take(5);

        return view('reports.index', compact('categories', 'people', 'wallets', 'reportHistories', 'templates'));
    }

    // Add this method for regenerating reports
    public function regenerate(Request $request)
    {
        $reportHistory = ReportHistory::where('id', $request->report_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Create a new request with the stored filters and new format
        $regenerateRequest = new Request();
        $regenerateRequest->replace([
            'report_type' => $reportHistory->report_type,
            'report_format' => $request->input('report_format', $reportHistory->report_format),
            'date_range' => $reportHistory->date_range,
            'start_date' => $reportHistory->start_date,
            'end_date' => $reportHistory->end_date,
            ...$reportHistory->filters
        ]);

        return $this->generate($regenerateRequest);
    }

    /**
     * Delete a report from history
     */
    public function deleteReport($id)
    {
        $report = ReportHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $report->delete();

        return redirect()->back()->with('success', 'Report deleted successfully.');
    }

    /**
     * Generate report using data from server
     */

    public function generate(Request $request)
    {
        // Check if this is a template-based report
        if ($request->has('template_id')) {
            return $this->generateTemplateReport($request);
        }

        // Original validation for legacy reports
        $request->validate([
            'report_type' => 'required|in:transactions,budgets,tickets',
            'report_format' => 'required|in:pdf,html,csv,xlsx',

            'date_range' => 'required|in:all,today,yesterday,this_week,last_week,this_month,last_month,custom',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            // Transactions specific filters
            'transaction_type' => 'required_if:report_type,transactions|in:income,expense,all',
            'amount' => 'nullable|numeric',
            'amount_filter' => 'nullable|in:<,>,=',

            // Support tickets specific filters
            'status' => 'nullable|in:all,opened,closed,admin_replied,customer_replied',
            'is_trashed' => 'nullable|boolean',
        ]);

        ReportHistory::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'report_type' => $request->report_type,
                'report_format' => $request->report_format,
                'date_range' => $request->date_range,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'filters' => $request->only([
                    'transaction_type',
                    'amount',
                    'amount_filter',
                    'category_id',
                    'wallet_id',
                    'person_id',
                    'budget_category_id',
                    'include_inactive',
                    'status',
                    'priority',
                    'category',
                    'is_trashed',
                ]),
            ]
        );

        switch ($request->report_type) {
            case 'transactions':
                return $this->generateTransactionsReport($request);
                break;
            case 'budgets':
                return $this->generateBudgetsReport($request);
                break;
            case 'tickets':
                return $this->generateTicketsReport($request);
                break;
            default:
                return redirect()->back()->withErrors(['report_type' => 'Invalid report type selected.']);
        }
    }

    /**
     * Generate report using template configuration.
     */
    private function generateTemplateReport(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:report_templates,id',
            'report_format' => 'required|in:pdf,html,csv,xlsx',
        ]);

        $template = ReportTemplate::with(['templateFields', 'templateCategory'])
            ->findOrFail($request->template_id);

        // Record template usage
        $template->recordUsage();

        // Build dynamic query based on template
        $filters = $request->except(['template_id', 'report_format']);
        $data = $this->dynamicQueryBuilder->getAggregatedData($template, $filters);

        // Store in report history
        ReportHistory::create([
            'user_id' => Auth::id(),
            'report_type' => $template->report_type,
            'report_format' => $request->report_format,
            'date_range' => $filters['date_range'] ?? 'all',
            'start_date' => $filters['start_date'] ?? null,
            'end_date' => $filters['end_date'] ?? null,
            'filters' => array_merge($filters, ['template_id' => $template->id]),
        ]);

        // Generate report using template
        return $this->generateReportFromTemplate($template, $data, $request->report_format);
    }

    // Generate transactions report
    private function generateTransactionsReport(Request $request)
    {
        return $this->transactionReportService->generateTransactionsReport($request);
    }

    // Generate budgets report
    private function generateBudgetsReport(Request $request)
    {
        return $this->budgetReportService->generateBudgetsReport($request);
    }

    // Generate tickets report
    private function generateTicketsReport(Request $request)
    {
        return $this->ticketReportService->generateTicketReport($request);
    }

    /**
     * Generate report from template configuration.
     */
    private function generateReportFromTemplate(ReportTemplate $template, array $data, string $format)
    {
        // For now, use the existing report services but with template data
        // This could be enhanced to use a dedicated template report service
        switch ($template->report_type) {
            case 'transactions':
                return $this->generateTemplateTransactionReport($template, $data, $format);
            case 'budgets':
                return $this->generateTemplateBudgetReport($template, $data, $format);
            case 'tickets':
                return $this->generateTemplateTicketReport($template, $data, $format);
            default:
                return $this->generateCustomTemplateReport($template, $data, $format);
        }
    }

    /**
     * Generate transaction report from template.
     */
    private function generateTemplateTransactionReport(ReportTemplate $template, array $data, string $format)
    {
        // Create a mock request for compatibility with existing service
        $mockRequest = new Request();
        $mockRequest->merge([
            'report_type' => 'transactions',
            'report_format' => $format,
            'template_data' => $data,
            'template_config' => $template
        ]);

        return $this->transactionReportService->generateTransactionsReport($mockRequest);
    }

    /**
     * Generate budget report from template.
     */
    private function generateTemplateBudgetReport(ReportTemplate $template, array $data, string $format)
    {
        $mockRequest = new Request();
        $mockRequest->merge([
            'report_type' => 'budgets',
            'report_format' => $format,
            'template_data' => $data,
            'template_config' => $template
        ]);

        return $this->budgetReportService->generateBudgetsReport($mockRequest);
    }

    /**
     * Generate ticket report from template.
     */
    private function generateTemplateTicketReport(ReportTemplate $template, array $data, string $format)
    {
        $mockRequest = new Request();
        $mockRequest->merge([
            'report_type' => 'tickets',
            'report_format' => $format,
            'template_data' => $data,
            'template_config' => $template
        ]);

        return $this->ticketReportService->generateTicketReport($mockRequest);
    }

    /**
     * Generate custom template report.
     */
    private function generateCustomTemplateReport(ReportTemplate $template, array $data, string $format)
    {
        // For custom templates, generate a basic report
        $reportData = [
            'template' => $template,
            'data' => $data,
            'generated_at' => now(),
            'user' => Auth::user()
        ];

        switch ($format) {
            case 'html':
                return view('reports.templates.generated.html', $reportData);
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('reports.templates.generated.pdf', $reportData);
                return $pdf->download($template->name . '_report.pdf');
            case 'csv':
                return $this->generateCSVFromTemplateData($template, $data);
            case 'xlsx':
                return $this->generateExcelFromTemplateData($template, $data);
            default:
                return redirect()->back()->withErrors(['format' => 'Unsupported format for custom template.']);
        }
    }

    /**
     * Generate CSV from template data.
     */
    private function generateCSVFromTemplateData(ReportTemplate $template, array $data)
    {
        $filename = $template->name . '_report.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($template, $data) {
            $file = fopen('php://output', 'w');
            
            // Write headers
            $headers = $template->visibleFields->pluck('field_label')->toArray();
            fputcsv($file, $headers);
            
            // Write data
            if (isset($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $row) {
                    $csvRow = [];
                    foreach ($template->visibleFields as $field) {
                        $csvRow[] = $row[$field->field_name] ?? '';
                    }
                    fputcsv($file, $csvRow);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate Excel from template data.
     */
    private function generateExcelFromTemplateData(ReportTemplate $template, array $data)
    {
        // This would use Laravel Excel package
        // For now, return CSV format
        return $this->generateCSVFromTemplateData($template, $data);
    }
}
