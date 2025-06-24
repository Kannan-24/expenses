<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

        // Recent expenses with eager loading (limit to expenses only)
        $recentExpenses = Transaction::with('category')
            ->where('user_id', $userId)
            ->where('type', 'expense')
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

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'monthlyNetBalance',
            'recentExpenses',
            'monthlyData',
            'chartLabels',
            'incomeData',
            'expenseData',
            'wallets',
            'topCategories'
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
