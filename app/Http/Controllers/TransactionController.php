<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\ExpensePerson;
use App\Models\Wallet;
use App\Models\WalletType;
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

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();

        return view('transactions.create', compact('categories', 'people', 'wallets', 'walletTypes'));
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

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $request->wallet_id)
            ->first();
        if ($request->type === 'expense') {
            $balance = $wallet->balance - $request->amount;
            if ($balance < 0) {
                return back()->withErrors(['amount' => 'Insufficient wallet balance.'])->withInput();
            }
            $wallet->balance -= $request->amount;
        } else if ($request->type === 'income') {
            $wallet->balance += $request->amount;
        }
        $wallet->save();

        $transaction = Transaction::create([
            'user_id'           => Auth::id(),
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'    => $request->wallet_id,
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

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();

        return view('transactions.edit', compact('expense', 'categories', 'people', 'wallets', 'walletTypes'));
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

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $request->wallet_id)
            ->first();
        if ($request->type === 'expense') {
            $balance = $wallet->balance - $request->amount;
            if ($balance < 0) {
                return back()->withErrors(['amount' => 'Insufficient wallet balance.'])->withInput();
            }
            $wallet->balance -= $request->amount;
        } else if ($request->type === 'income') {
            $wallet->balance += $request->amount;
        }
        $wallet->save();

        $transaction->update([
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'    => $request->wallet_id,
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

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $transaction->wallet_id)
            ->first();

        if ($transaction->type === 'income') {
            $wallet->balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $wallet->balance += $transaction->amount;
        }
        $wallet->save();
        $transaction->delete();

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($transaction->type) . " deleted successfully. Balance restored."
        );
    }
}
