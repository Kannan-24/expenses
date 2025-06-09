<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with summary and recent expenses.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get recent transactions with category
        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Calculate total income
        $totalIncome = Expense::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        // Calculate total expense
        $totalExpense = Expense::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        // Calculate balance
        $balance = $totalIncome - $totalExpense;

        return view('dashboard', compact('expenses', 'totalIncome', 'totalExpense', 'balance'));
    }
}
