<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ExpensePerson;
use App\Models\ReportHistory;
use App\Models\Wallet;
use App\Services\BudgetReportService;
use App\Services\TicketReportService;
use App\Services\TransactionReportService;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $transactionReportService;
    protected $budgetReportService;
    protected $ticketReportService;


    public function __construct()
    {
        $this->transactionReportService = new TransactionReportService();
        $this->budgetReportService = new BudgetReportService();
        $this->ticketReportService = new TicketReportService();

        $this->middleware('can:generate reports');
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

        return view('reports.index', compact('categories', 'people', 'wallets', 'reportHistories'));
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
}
