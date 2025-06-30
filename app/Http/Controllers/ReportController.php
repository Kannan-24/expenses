<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ExpensePerson;
use App\Models\SupportTicket;
use App\Models\Wallet;
use App\Services\TransactionReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct()
    {
        $this->reportService = new TransactionReportService();
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

        return view('reports.index', compact('categories', 'people', 'wallets'));
    }

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

            // Budgets specific filters
            'budget_category_id' => 'nullable|exists:categories,id',

            // Support tickets specific filters
            'status' => 'nullable|in:all,opened,closed,admin_replied,customer_replied',
            'is_trashed' => 'nullable|boolean',
        ]);


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
        return $this->reportService->generateTransactionsReport($request);
    }

    // Generate budgets report
    private function generateBudgetsReport(Request $request)
    {
        $dateRange = $this->getDateRange($request->date_range, $request->start_date, $request->end_date);
        $query = Category::where('user_id', Auth::id())
            ->whereBetween('created_at', $dateRange);

        // Filter by category
        if ($request->budget_category_id) {
            $query->where('id', $request->budget_category_id);
        }

        // Get categories
        $categories = $query->with(['transactions' => function ($q) use ($dateRange) {
            $q->whereBetween('date', $dateRange);
        }])->get();

        // Generate report based on format
        switch ($request->report_format) {
            case 'pdf':
                return Pdf::loadView('reports.budgets.pdf', compact('dateRange', 'categories'))
                    ->setPaper('a4', 'portrait')
                    ->stream('budgets_report.pdf');
                break;
            case 'html':
                return view('reports.budgets.html', compact('categories'));
                break;
            case 'csv':
                $filename = 'budgets_report_' . now()->format('Ymd_His') . '.csv';
                break;
            case 'xlsx':
                $filename = 'budgets_report_' . now()->format('Ymd_His') . '.xlsx';
                break;
        }
    }

    // Generate tickets report
    private function generateTicketsReport(Request $request)
    {
        $dateRange = $this->getDateRange($request->date_range, $request->start_date, $request->end_date);

        $query = SupportTicket::where('user_id', Auth::id())
            ->whereBetween('created_at', $dateRange);

        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by trashed tickets
        if ($request->is_trashed) {
            $query->withTrashed();
        }

        // Get tickets
        $tickets = $query->with(['customer', 'admin'])->get();

        // Generate report based on format
        switch ($request->report_format) {
            case 'pdf':
                return Pdf::loadView('reports.tickets.pdf', compact('dateRange', 'tickets'))
                    ->setPaper('a4', 'portrait')
                    ->stream('tickets_report.pdf');
                break;
            case 'html':
                return view('reports.tickets.html', compact('tickets'));
                break;
            case 'csv':
                $filename = 'tickets_report_' . now()->format('Ymd_His') . '.csv';
                break;
            case 'xlsx':
                $filename = 'tickets_report_' . now()->format('Ymd_His') . '.xlsx';
                break;
        }
    }

    // Get Date Range
    private function getDateRange(String $dateRange, ?string $startDate = null, ?string $endDate = null): array
    {
        switch ($dateRange) {
            case 'all':
                return [null, null];
            case 'today':
                return [now()->startOfDay(), now()->endOfDay()];
            case 'yesterday':
                return [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()];
            case 'this_week':
                return [now()->startOfWeek(), now()->endOfWeek()];
            case 'last_week':
                return [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()];
            case 'this_month':
                return [now()->startOfMonth(), now()->endOfMonth()];
            case 'last_month':
                return [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()];
            case 'custom':
                return [$startDate, $endDate];
            default:
                return [null, null];
        }
    }
}
