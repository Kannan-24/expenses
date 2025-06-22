<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Balance;
use App\Models\BalanceHistory;
use App\Models\ExpensePerson;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage transactions');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['category', 'person'])->where('user_id', Auth::id());

        // Search by person, category, or note
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('person', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('category', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('note', 'like', '%' . $search . '%');
            });
        }

        // Date filters
        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '1month') {
            $query->where('date', '>=', now()->subMonth());
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(9);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories', 'balance', 'people', 'wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'        => 'nullable|exists:categories,id',
            'expense_person_id'  => 'nullable|exists:expense_people,id',
            'amount'             => 'required|numeric|min:0',
            'date'               => 'required|date',
            'note'               => 'nullable|string',
            'type'               => 'required|in:income,expense',
            'wallet_id'     => 'required|exists:wallets,id',
        ]);

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        if ($request->type === 'expense') {
            if ($request->amount > $balance->{$request->payment_method}) {
                return back()->withErrors(['amount' => 'Insufficient ' . ucfirst($request->payment_method) . ' balance.'])->withInput();
            }
        }

        $transaction = Transaction::create([
            'user_id'           => Auth::id(),
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'    => $request->payment_method,
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

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " added successfully. " . ucfirst($request->payment_method) . " balance updated."
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();
        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('expense', 'categories', 'balance', 'people', 'wallets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id'        => 'nullable|exists:categories,id',
            'expense_person_id'  => 'nullable|exists:expense_people,id',
            'amount'             => 'required|numeric|min:0',
            'date'               => 'required|date',
            'note'               => 'nullable|string',
            'type'               => 'required|in:income,expense',
            'wallet_id'     => 'required|exists:wallets,id',
        ]);

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        if ($request->type === 'expense') {
            if ($request->amount > $balance->{$request->payment_method} + $transaction->amount) {
                return back()->withErrors(['amount' => 'Insufficient ' . ucfirst($request->payment_method) . ' balance.'])->withInput();
            }
        }

        $cashBefore = $balance->cash;
        $bankBefore = $balance->bank;

        // Reverse previous
        if ($transaction->type === 'income') {
            $balance->{$transaction->payment_method} -= $transaction->amount;
        } else {
            $balance->{$transaction->payment_method} += $transaction->amount;
        }

        $transaction->update([
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'    => $request->wallet_id,
        ]);

        // Apply updated
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

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " updated successfully. " . ucfirst($request->payment_method) . " balance adjusted."
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('transactions.show', compact('expense'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $balance = Balance::firstOrCreate(
            ['user_id' => Auth::id()],
            ['cash' => 0, 'bank' => 0]
        );

        $cashBefore = $balance->cash;
        $bankBefore = $balance->bank;

        if ($transaction->type === 'income') {
            $balance->{$transaction->payment_method} -= $transaction->amount;
        } else {
            $balance->{$transaction->payment_method} += $transaction->amount;
        }

        $balance->save();
        $transaction->delete();

        BalanceHistory::create([
            'user_id'     => Auth::id(),
            'updated_by'  => Auth::id(),
            'cash_before' => $cashBefore,
            'cash_after'  => $balance->cash,
            'bank_before' => $bankBefore,
            'bank_after'  => $balance->bank,
        ]);

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($transaction->type) . " deleted successfully. Balance restored."
        );
    }
}
