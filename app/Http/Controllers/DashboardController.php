<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Balance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $balance = Balance::firstOrNew(['user_id' => $userId], [
            'cash' => 0,
            'bank' => 0,
        ]);

        $totalIncome = Expense::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $totalExpense = Expense::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyNetBalance = $totalIncome - $totalExpense;

        $recentExpenses = Expense::with('category')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $monthlyData = Expense::select(
            DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
            DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
            DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
        )
            ->where('user_id', $userId)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(6)
            ->get();

        $chartLabels = $monthlyData->pluck('month')->map(function ($month) {
            return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
        });

        $incomeData = $monthlyData->pluck('total_income');
        $expenseData = $monthlyData->pluck('total_expense');

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'monthlyNetBalance',
            'balance',
            'recentExpenses',
            'monthlyData',
            'chartLabels',
            'incomeData',
            'expenseData'
        ));
    }
}
