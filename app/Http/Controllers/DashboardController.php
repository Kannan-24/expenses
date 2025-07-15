<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Currency;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalUsers = User::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', '=', 'user');
            })
            ->count();
        $recentlyRegisteredUsers = User::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', '=', 'user');
            })
            ->where('created_at', '>=', CarbonImmutable::now()->subDays(7))
            ->orderByDesc('created_at')
            ->get();

        $totalOpenedSupportTickets = SupportTicket::where('status', 'opened')
            ->count();

        $supportTickets = SupportTicket::with('user')
            ->where('status', '!=', 'closed')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $mostUsedCurrencies = Wallet::select('currency_id', DB::raw('COUNT(*) as count'))
            ->groupBy('currency_id')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'name' => Currency::find($item->currency_id)->name ?? 'Unknown',
                    'code' => Currency::find($item->currency_id)->code ?? 'Unknown',
                    'count' => $item->count,
                ];
            });

        $inactiveUsers = $this->findInactiveUsers();

        return view('dashboard.dashboard', compact(
            'totalUsers',
            'recentlyRegisteredUsers',
            'inactiveUsers',
            'totalOpenedSupportTickets',
            'supportTickets',
            'mostUsedCurrencies'
        ));
    }

    private function findInactiveUsers()
    {
        $cutoffDate = CarbonImmutable::now()->subMonths(6)->startOfDay();

        $inactiveUsers = User::with(['transactions', 'supportTickets', 'budgets', 'wallets', 'categories', 'expensePeople'])
            ->whereDoesntHave('transactions', function ($query) use ($cutoffDate) {
                $query->where('date', '>=', $cutoffDate);
            })
            ->whereDoesntHave('supportTickets', function ($query) use ($cutoffDate) {
                $query->where('created_at', '>=', $cutoffDate);
            })
            ->whereDoesntHave('budgets', function ($query) use ($cutoffDate) {
                $query->where('start_date', '>=', $cutoffDate);
            })
            ->whereDoesntHave('wallets', function ($query) use ($cutoffDate) {
                $query->where('created_at', '>=', $cutoffDate);
            })
            ->whereDoesntHave('categories', function ($query) use ($cutoffDate) {
                $query->where('created_at', '>=', $cutoffDate);
            })
            ->whereDoesntHave('expensePeople', function ($query) use ($cutoffDate) {
                $query->where('created_at', '>=', $cutoffDate);
            })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->get();

        if ($inactiveUsers->isEmpty()) {
            return collect();
        }

        return $inactiveUsers->map(function ($user) {
            return (object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'last_active' => $user->transactions()->max('date') ?? $user->supportTickets()->max('created_at'),
            ];
        });
    }

    private function userDashboard()
    {
        $userId = Auth::id();
        $now = CarbonImmutable::now();

        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth = $now->endOfMonth()->toDateString();

        // Fetch total income & expense together
        $totals = Transaction::selectRaw("
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense
        ")
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->first();

        $totalIncome = $totals->total_income ?? 0;
        $totalExpense = $totals->total_expense ?? 0;
        $monthlyNetBalance = $totalIncome - $totalExpense;

        $lastMonthStart = $now->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = $now->subMonth()->endOfMonth()->toDateString();

        // Fetch last month's total income & expense
        $lastMonthTotals = Transaction::selectRaw("
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense
        ")
            ->where('user_id', $userId)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->first();

        $lastMonthIncome = $lastMonthTotals->total_income ?? 0;
        $lastMonthExpense = $lastMonthTotals->total_expense ?? 0;

        // Calculate monthly net balance for last month
        $lastMonthNetBalance = $lastMonthIncome - $lastMonthExpense;

        // Insight calculation comparing this month to last month
        $incomePercentageChange = $lastMonthIncome > 0
            ? round((($totalIncome - $lastMonthIncome) / $lastMonthIncome) * 100, 2)
            : 0;
        $expensePercentageChange = $lastMonthExpense > 0
            ? round((($totalExpense - $lastMonthExpense) / $lastMonthExpense) * 100, 2)
            : 0;
        $insights = [
            'income_change' => $incomePercentageChange,
            'expense_change' => $expensePercentageChange,
        ];

        // Recent expenses with eager loading (limit to expenses only)
        $recentExpenses = Transaction::with('category')
            ->where('user_id', $userId)
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        // Monthly summary for last 6 months (auto-calculated range)
        $monthlyData = Transaction::selectRaw("
            DATE_FORMAT(date, '%Y-%m') as month,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense
        ")
            ->where('user_id', $userId)
            ->where('date', '>=', $now->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = $monthlyData->pluck('month')->map(
            fn($month) =>
            CarbonImmutable::createFromFormat('Y-m', $month)->format('M Y')
        );

        $incomeData = $monthlyData->pluck('total_income');
        $expenseData = $monthlyData->pluck('total_expense');

        // Load wallets
        $wallets = Wallet::where('user_id', $userId)->get();

        $topCategories = Transaction::select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->with('category:id,name')
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->orderByDesc('total_amount')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'name' => $item->category->name ?? 'Uncategorized',
                    'total_amount' => $item->total_amount,
                ];
            });


        $budgetData = Budget::with(['category', 'histories' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('start_date', '<=', $startOfMonth)
                ->where('end_date', '>=', $endOfMonth);
        }])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($budget) {
                $history = $budget->histories->first();
                $allocated = $history ? $history->allocated_amount + $history->roll_over_amount : 0;
                $spent = $history ? $history->spent_amount : 0;

                return [
                    'category' => $budget->category->name,
                    'allocated' => round($allocated, 2),
                    'spent' => round($spent, 2),
                ];
            })
            ->filter(fn($item) => $item['allocated'] > 0)
            ->values();


        return view('dashboard.dashboard', compact(
            'totalIncome',
            'totalExpense',
            'monthlyNetBalance',
            'recentExpenses',
            'monthlyData',
            'chartLabels',
            'incomeData',
            'expenseData',
            'wallets',
            'topCategories',
            'budgetData',
            'insights'
        ));
    }

    public function getChartData(Request $request)
    {
        $userId = Auth::id();
        $range = $request->input('range', '30d'); // default 30 days
        $now = CarbonImmutable::now();
        $start = $now;
        $end = $now;

        switch ($range) {
            case 'today':
                $start = $now->startOfDay();
                $end = $now->endOfDay();
                $interval = 'hour';
                break;
            case 'yesterday':
                $start = $now->subDay()->startOfDay();
                $end = $now->subDay()->endOfDay();
                $interval = 'hour';
                break;
            case '7d':
                $start = $now->subDays(6)->startOfDay();
                $end = $now->endOfDay();
                $interval = 'day';
                break;
            case '30d':
                $start = $now->subDays(29)->startOfDay();
                $end = $now->endOfDay();
                $interval = 'day';
                break;
            case '3m':
                $start = $now->subMonths(2)->startOfMonth();
                $end = $now->endOfMonth();
                $interval = 'week';
                break;
            case '6m':
                $start = $now->subMonths(5)->startOfMonth();
                $end = $now->endOfMonth();
                $interval = 'month';
                break;
            default:
                abort(400, 'Invalid range');
        }

        // Adjust formatting based on interval
        $format = match ($interval) {
            'hour' => '%Y-%m-%d %H',
            'day' => '%Y-%m-%d',
            'week' => '%x-%v', // ISO year-week
            'month' => '%Y-%m',
        };

        $data = Transaction::selectRaw("
            DATE_FORMAT(date, '{$format}') as label,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense
        ")
            ->where('user_id', $userId)
            ->whereBetween('date', [$start, $end])
            ->groupBy('label')
            ->orderBy('label', 'asc')
            ->get();

        // Map label for user-friendly display
        $chartLabels = $data->pluck('label')->map(function ($label) use ($interval) {
            return match ($interval) {
                'hour' => Carbon::createFromFormat('Y-m-d H', $label)->format('H:i'),
                'day' => Carbon::createFromFormat('Y-m-d', $label)->format('d M'),
                'week' => 'Week ' . explode('-', $label)[1],
                'month' => Carbon::createFromFormat('Y-m', $label)->format('M Y'),
            };
        });

        return response()->json([
            'labels' => $chartLabels,
            'income' => $data->pluck('total_income'),
            'expense' => $data->pluck('total_expense'),
        ]);
    }
}
