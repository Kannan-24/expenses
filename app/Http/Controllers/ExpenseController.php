<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Reader\Xls\RC4;

class ExpenseController extends Controller
{
    // Show all expenses and incomes for the authenticated user
    public function index(Request $request)
    {
        $query = Expense::with('category')->where('user_id', Auth::id());

        // Date Filters
        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '1month') {
            $query->where('date', '>=', now()->subMonth());
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(10);

        return view('expenses.index', compact('expenses'));
    }


    // Show form to create new expense/income
    public function create()
    {
        $categories = Category::all();
        return view('expenses.create', compact('categories'));
    }

    // Store a new expense or income
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'type' => 'required|in:income,expense',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
            'type' => $request->type,
        ]);

        return redirect()->route('expenses.index')->with('success', ucfirst($request->type) . ' added successfully.');
    }

    // Show form to edit an existing expense/income
    public function edit(Expense $expense)
    {
        $categories = Category::all();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    // Update an expense or income
    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
            'type' => 'required|in:income,expense',
        ]);

        $expense->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
            'type' => $request->type,
        ]);

        return redirect()->route('expenses.index')->with('success', ucfirst($request->type) . ' updated successfully.');
    }

    // Show a single expense or income
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    // Delete an expense or income
    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', ucfirst($expense->type) . ' deleted successfully.');
    }
}
