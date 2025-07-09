<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetHistory;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\ExpensePerson;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletType;
use Carbon\Carbon;
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
     * 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

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

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Person filter
        if ($request->filled('person')) {
            $query->where('expense_person_id', $request->person);
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(10);

        return view('transactions.index', compact('transactions', 'categories', 'people'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     *  @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();
        $currencies = Currency::get();

        return view('transactions.create', compact('categories', 'people', 'wallets', 'walletTypes', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\RedirectResponse
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

        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

        // Check wallet balance
        if ($request->type === 'expense' && $wallet->balance < $request->amount) {
            return redirect()->back()->withErrors(['wallet' => 'Insufficient balance in the selected wallet.']);
        }

        // Adjust wallet balance based on transaction type
        $wallet->balance += ($request->type === 'income') ? $request->amount : -$request->amount;
        $wallet->save();

        if ($request->type == 'expense' && $request->category_id) {
            $this->updateBudgetHistory($request->category_id, $request->amount, $request->date);
        }

        $transaction = Transaction::create([
            'user_id'           => Auth::id(),
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'         => $request->wallet_id,
        ]);

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " added successfully. " . ucfirst($request->payment_method) . " balance updated."
        );
    }

    /**
     * Show the form for editing the specified resource.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();
        $currencies = Currency::get();

        return view('transactions.edit', compact('transaction', 'categories', 'people', 'wallets', 'walletTypes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *   @param  \App\Models\Transaction  $transaction
     *   @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

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

        // Rollback previous transaction amount from wallet
        $wallet->balance += ($transaction->type === 'income') ? -$transaction->amount : $transaction->amount;

        // Apply new transaction amount to wallet
        if ($request->type == 'expense' && $wallet->balance < $request->amount) {
            return redirect()->back()->withErrors(['wallet' => 'Insufficient balance in the selected wallet.'])->withInput();
        }

        $wallet->balance += ($request->type === 'income') ? $request->amount : -$request->amount;
        $wallet->save();

        if ($transaction->type === 'expense' && $transaction->category_id) {
            $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date);
        }


        if ($request->type == 'expense' && $request->category_id) {
            $this->updateBudgetHistory($request->category_id, $request->amount, $request->date);
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

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " updated successfully. " . ucfirst($request->payment_method) . " balance adjusted."
        );
    }

    /**
     * Display the specified resource.
     * 
     *   @param  \App\Models\Transaction  $transaction
     *   @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $transaction->wallet_id)
            ->first();

        if ($transaction->type === 'income') {
            $wallet->balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $wallet->balance += $transaction->amount;

            if ($transaction->category_id) {
                $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date);
            }
        }
        $wallet->save();
        $transaction->delete();

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($transaction->type) . " deleted successfully. Balance restored."
        );
    }

    /**
     * Authorize the user has access to the transaction.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return void
     */
    protected function authorizeTransaction(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }


    /**
     * Update budget history based on the transaction.
     * 
     *  @param int $categoryId
     *  @param float $amount
     *  @param string $date
     *  @return void
     */
    protected function updateBudgetHistory($categoryId, $amount, $date)
    {
        $userId = Auth::id();

        $budget = Budget::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        if (!$budget) return;

        $budgetHistory = BudgetHistory::where('budget_id', $budget->id)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        if (!$budgetHistory) {
            // Calculate period aligned to budget's plan start_date
            $budgetStart = Carbon::parse($budget->start_date);
            $periodStart = match ($budget->frequency) {
                'daily' => Carbon::parse($date)->startOfDay(),
                'weekly' => Carbon::parse($budgetStart)->copy()->startOfWeek()->addWeeks(
                    Carbon::parse($budgetStart)->diffInWeeks($date)
                ),
                'monthly' => Carbon::parse($budgetStart)->copy()->startOfMonth()->addMonthsNoOverflow(
                    Carbon::parse($budgetStart)->diffInMonths($date)
                ),
                'yearly' => Carbon::parse($budgetStart)->copy()->startOfYear()->addYears(
                    Carbon::parse($budgetStart)->diffInYears($date)
                ),
            };

            $periodEnd = match ($budget->frequency) {
                'daily' => $periodStart->copy()->endOfDay(),
                'weekly' => $periodStart->copy()->endOfWeek(),
                'monthly' => $periodStart->copy()->endOfMonth(),
                'yearly' => $periodStart->copy()->endOfYear(),
            };

            // Fetch previous history (if exists)
            $previousHistory = BudgetHistory::where('budget_id', $budget->id)
                ->where('end_date', '<', $periodStart)
                ->latest('end_date')
                ->first();

            $rollOverAmount = 0;

            if ($previousHistory && $budget->roll_over) {
                $unspent = $previousHistory->allocated_amount + $previousHistory->roll_over_amount - $previousHistory->spent_amount;
                $rollOverAmount = max(0, $unspent);
            }

            BudgetHistory::create([
                'budget_id'        => $budget->id,
                'allocated_amount' => $budget->amount,
                'roll_over_amount' => $rollOverAmount,
                'spent_amount'     => $amount,
                'start_date'       => $periodStart,
                'end_date'         => $periodEnd,
                'status'           => 'active',
            ]);
        } else {
            $budgetHistory->spent_amount += $amount;
            $budgetHistory->save();
        }

        // Notify user if budget is exceeded above 100% or 90%
        if ($budgetHistory->allocated_amount <= 0) {
            return;
        }
        $exceededPercent =  ($budgetHistory->spent_amount / $budgetHistory->allocated_amount) * 100;
        $user = User::find($userId);
        if ($exceededPercent >= 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
        } elseif ($exceededPercent >= 90 && $exceededPercent < 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
        }
    }
}
