<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Balance;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('category')->where('user_id', Auth::id());

        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '1month') {
            $query->where('date', '>=', now()->subMonth());
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(9);

        $totalIncome = Expense::where('user_id', Auth::id())->where('type', 'income')->sum('amount');
        $totalExpense = Expense::where('user_id', Auth::id())->where('type', 'expense')->sum('amount');
        $balanceAmount = $totalIncome - $totalExpense;

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        return view('expenses.index', compact('expenses', 'totalIncome', 'totalExpense', 'balanceAmount', 'balance'));
    }

    public function create()
    {
        $categories = Category::all();
        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        return view('expenses.create', compact('categories', 'balance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'     => 'nullable|exists:categories,id',
            'amount'          => 'required|numeric|min:0',
            'date'            => 'required|date',
            'note'            => 'nullable|string',
            'type'            => 'required|in:income,expense',
            'payment_method'  => 'required|in:cash,bank',
        ]);

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        // Validate available balance if expense
        if ($request->type === 'expense') {
            if ($request->amount > $balance->{$request->payment_method}) {
                return back()->withErrors(['amount' => 'Insufficient ' . ucfirst($request->payment_method) . ' balance.'])->withInput();
            }
        }

        $expense = Expense::create([
            'user_id'         => Auth::id(),
            'category_id'     => $request->category_id,
            'amount'          => $request->amount,
            'date'            => $request->date,
            'note'            => $request->note,
            'type'            => $request->type,
            'payment_method'  => $request->payment_method,
        ]);

        $cashBefore = $balance->cash;
        $bankBefore = $balance->bank;

        if ($request->type === 'income') {
            $balance->{$request->payment_method} += $request->amount;
        } else {
            $balance->{$request->payment_method} -= $request->amount;
        }

        $balance->save();

        BalanceHistory::create([
            'user_id'     => Auth::id(),
            'updated_by'  => Auth::id(),
            'cash_before' => $cashBefore,
            'cash_after'  => $balance->cash,
            'bank_before' => $bankBefore,
            'bank_after'  => $balance->bank,
        ]);

        return redirect()->route('expenses.index')->with(
            'success',
            ucfirst($request->type) . " added successfully. " . ucfirst($request->payment_method) . " balance updated."
        );
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        return view('expenses.edit', compact('expense', 'categories', 'balance'));
    }
public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id'     => 'nullable|exists:categories,id',
            'amount'          => 'required|numeric|min:0',
            'date'            => 'required|date',
            'note'            => 'nullable|string',
            'type'            => 'required|in:income,expense',
            'payment_method'  => 'required|in:cash,bank',
        ]);

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        // Validate available balance if expense
        if ($request->type === 'expense') {
            if ($request->amount > $balance->{$request->payment_method} + $expense->amount) {
                return back()->withErrors(['amount' => 'Insufficient ' . ucfirst($request->payment_method) . ' balance.'])->withInput();
            }
        }

        $cashBefore = $balance->cash;
        $bankBefore = $balance->bank;

        // Adjust balance before updating
        if ($expense->type === 'income') {
            $balance->{$expense->payment_method} -= $expense->amount;
        } else {
            $balance->{$expense->payment_method} += $expense->amount;
        }

        // Update expense
        $expense->update([
            'category_id'     => $request->category_id,
            'amount'          => $request->amount,
            'date'            => $request->date,
            'note'            => $request->note,
            'type'            => $request->type,
            'payment_method'  => $request->payment_method,
        ]);

        // Adjust balance after updating
        if ($request->type === 'income') {
            $balance->{$request->payment_method} += $request->amount;
        } else {
            $balance->{$request->payment_method} -= $request->amount;
        }

        $balance->save();

        BalanceHistory::create([
            'user_id'     => Auth::id(),
            'updated_by'  => Auth::id(),
            'cash_before' => $cashBefore,
            'cash_after'  => $balance->cash,
            'bank_before' => $bankBefore,
            'bank_after'  => $balance->bank,
        ]);
        return redirect()->route('expenses.index')->with(
            'success',
            ucfirst($request->type) . " updated successfully. " . ucfirst($request->payment_method) . " balance adjusted."
        );
    }

    public function show(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        return view('expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        $cashBefore = $balance->cash;
        $bankBefore = $balance->bank;

        if ($expense->type === 'income') {
            $balance->{$expense->payment_method} -= $expense->amount;
        } else {
            $balance->{$expense->payment_method} += $expense->amount;
        }

        $balance->save();
        $expense->delete();

        BalanceHistory::create([
            'user_id'     => Auth::id(),
            'updated_by'  => Auth::id(),
            'cash_before' => $cashBefore,
            'cash_after'  => $balance->cash,
            'bank_before' => $bankBefore,
            'bank_after'  => $balance->bank,
        ]);

        return redirect()->route('expenses.index')->with(
            'success',
            ucfirst($expense->type) . " deleted successfully. Balance restored."
        );
    }
}
