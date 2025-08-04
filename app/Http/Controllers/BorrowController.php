<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowHistory;
use App\Models\ExpensePerson;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage borrows');
    }

    // List all borrows/lends
    public function index(Request $request)
    {
        $query = Borrow::with(['person', 'wallet.currency'])
            ->where('user_id', Auth::id());

        // Search by person name, wallet name, or amount
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('person', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('wallet', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        // Filter by type (borrowed/lent)
        if ($request->filled('type')) {
            $query->where('borrow_type', $request->input('type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by wallet
        if ($request->filled('wallet')) {
            $query->where('wallet_id', $request->input('wallet'));
        }

        // Filter by person
        if ($request->filled('person')) {
            $query->where('person_id', $request->input('person'));
        }

        $borrows = $query->orderBy('date', 'desc')->paginate(10)->appends($request->query());
        $wallets = Wallet::where('user_id', Auth::id())->get();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        return view('borrows.index', compact('borrows', 'wallets', 'people'));
    }

    // Show create form
    public function create()
    {
        $people = ExpensePerson::where('user_id', Auth::id())->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('borrows.create', compact('people', 'wallets'));
    }

    // Store new borrow/lend
    public function store(Request $request)
    {
        $request->validate([
            'person_id'  => 'required|exists:expense_people,id',
            'amount'     => 'required|numeric|min:0.01',
            'date'       => 'required|date',
            'borrow_type' => 'required|in:borrowed,lent',
            'wallet_id'  => 'required|exists:wallets,id',
            'note'       => 'nullable|string',
        ]);

        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

        if ($request->borrow_type === 'lent') {
            if ($wallet->balance < $request->amount) {
                return back()->withErrors(['wallet' => 'Insufficient balance in wallet.'])->withInput();
            }
            $wallet->balance -= $request->amount;
        } else {
            $wallet->balance += $request->amount;
        }
        $wallet->save();

        Borrow::create([
            'user_id'         => Auth::id(),
            'person_id'       => $request->person_id,
            'amount'          => $request->amount,
            'returned_amount' => 0,
            'status'          => 'pending',
            'borrow_type'     => $request->borrow_type,
            'wallet_id'       => $request->wallet_id,
            'date'            => $request->date,
            'note'            => $request->note,
        ]);

        return redirect()->route('borrows.index')->with('success', 'Borrow/Lend added successfully.');
    }

    // Show details + history
    public function show(Borrow $borrow)
    {
        $this->authorizeBorrow($borrow);
        $wallets = Wallet::where('user_id', Auth::id())->get();
        // eager load histories and wallet for each history
        $borrow->load(['histories.wallet']);
        return view('borrows.show', compact('borrow', 'wallets'));
    }

    // Edit form
    public function edit(Borrow $borrow)
    {
        $this->authorizeBorrow($borrow);
        $people = ExpensePerson::where('user_id', Auth::id())->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('borrows.edit', compact('borrow', 'people', 'wallets'));
    }

    // Update borrow/lend
    public function update(Request $request, Borrow $borrow)
    {
        $this->authorizeBorrow($borrow);

        $request->validate([
            'person_id'   => 'required|exists:expense_people,id',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'borrow_type' => 'required|in:borrowed,lent',
            'wallet_id'   => 'required|exists:wallets,id',
            'note'        => 'nullable|string',
        ]);

        // Validate that the new wallet belongs to the authenticated user
        $newWallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

        // Check if returned amount exceeds new borrow amount
        if ($borrow->returned_amount > $request->amount) {
            return back()->withErrors(['amount' => 'Returned amount exceeds new borrow amount.'])->withInput();
        }

        // Only update wallet balances if wallet, amount, or borrow_type changed
        if (
            $borrow->wallet_id != $request->wallet_id ||
            $borrow->amount != $request->amount ||
            $borrow->borrow_type != $request->borrow_type
        ) {

            // Get old wallet (ensure it belongs to the user)
            $oldWallet = Wallet::where('user_id', Auth::id())->findOrFail($borrow->wallet_id);

            // Calculate the net effect of the old transaction
            $oldNetEffect = ($borrow->borrow_type === 'lent') ? -$borrow->amount : $borrow->amount;

            // Calculate the net effect of the new transaction
            $newNetEffect = ($request->borrow_type === 'lent') ? -$request->amount : $request->amount;

            // If wallet changed, reverse the old transaction and apply new one
            if ($borrow->wallet_id != $request->wallet_id) {
                // Reverse old transaction
                $oldWallet->balance -= $oldNetEffect;
                $oldWallet->save();

                // Check if new wallet has sufficient balance for lending
                if ($request->borrow_type === 'lent' && $newWallet->balance < $request->amount) {
                    return back()->withErrors(['wallet' => 'Insufficient balance in wallet.'])->withInput();
                }

                // Apply new transaction
                $newWallet->balance += $newNetEffect;
                $newWallet->save();
            } else {
                // Same wallet, just adjust the difference
                $balanceDifference = $newNetEffect - $oldNetEffect;

                // Check if wallet has sufficient balance for the change
                if ($balanceDifference < 0 && $newWallet->balance < abs($balanceDifference)) {
                    return back()->withErrors(['wallet' => 'Insufficient balance in wallet for this change.'])->withInput();
                }

                $newWallet->balance += $balanceDifference;
                $newWallet->save();
            }
        }

        // Calculate status based on returned amount vs new amount
        $status = 'pending';
        if ($borrow->returned_amount >= $request->amount) {
            $status = 'returned';
        } elseif ($borrow->returned_amount > 0) {
            $status = 'partial';
        }

        // Update the borrow record
        $borrow->update([
            'person_id'   => $request->person_id,
            'amount'      => $request->amount,
            'borrow_type' => $request->borrow_type,
            'wallet_id'   => $request->wallet_id,
            'date'        => $request->date,
            'note'        => $request->note,
            'status'      => $status,
        ]);

        return redirect()->route('borrows.index')->with('success', 'Borrow/Lend updated successfully.');
    }

    // Delete borrow and restore all related balances
    public function destroy(Borrow $borrow)
    {
        $this->authorizeBorrow($borrow);

        // Roll back all repayment histories first
        foreach ($borrow->histories as $history) {
            $wallet = Wallet::where('user_id', Auth::id())->find($history->wallet_id);
            if ($wallet) {
                if ($borrow->borrow_type === 'lent') {
                    // When lent, repayments were added back to wallet, so remove them
                    $wallet->balance -= $history->amount;
                } else {
                    // When borrowed, repayments were subtracted from wallet, so add them back
                    $wallet->balance += $history->amount;
                }
                $wallet->save();
            }
        }

        // Now roll back the original transaction
        $wallet = Wallet::where('user_id', Auth::id())->find($borrow->wallet_id);
        if ($wallet) {
            if ($borrow->borrow_type === 'lent') {
                $wallet->balance += $borrow->amount;
            } else {
                $wallet->balance -= $borrow->amount;
            }
            $wallet->save();
        }

        // Delete all histories (if not cascaded)
        $borrow->histories()->delete();

        // Delete the borrow
        $borrow->delete();

        return redirect()->route('borrows.index')->with('success', 'Borrow/Lend and all related returns deleted and balances restored.');
    }

    // Repay: Record repayment & history
    public function repay(Request $request, Borrow $borrow)
    {
        $this->authorizeBorrow($borrow);

        $maxReturn = $borrow->amount - $borrow->returned_amount;
        $request->validate([
            'repay_amount' => "required|numeric|min:0.01|max:$maxReturn",
            'wallet_id'    => 'required|exists:wallets,id',
            'date'         => 'required|date',
        ]);

        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

        if ($borrow->borrow_type === 'lent') {
            $wallet->balance += $request->repay_amount;
        } else {
            if ($wallet->balance < $request->repay_amount) {
                return back()->withErrors(['wallet' => 'Insufficient balance in wallet.'])->withInput();
            }
            $wallet->balance -= $request->repay_amount;
        }
        $wallet->save();

        // log repayment
        BorrowHistory::create([
            'borrow_id' => $borrow->id,
            'wallet_id' => $request->wallet_id,
            'amount' => $request->repay_amount,
            'date' => $request->date,
        ]);

        $borrow->returned_amount += $request->repay_amount;
        if ($borrow->returned_amount >= $borrow->amount) {
            $borrow->status = 'returned';
        } elseif ($borrow->returned_amount > 0) {
            $borrow->status = 'partial';
        }
        $borrow->save();

        return redirect()->route('borrows.show', $borrow->id)->with('success', 'Repayment recorded.');
    }

    // Edit a return/repayment entry (used for popups, not a separate page)
    public function editReturn(Borrow $borrow, BorrowHistory $history)
    {
        $this->authorizeBorrow($borrow);
        if ($history->borrow_id !== $borrow->id) abort(404);
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('borrows.edit_return', compact('borrow', 'history', 'wallets'));
    }

    // Update a return/repayment entry (can be used via popup/modal in show)
    public function updateReturn(Request $request, Borrow $borrow, BorrowHistory $history)
    {
        $this->authorizeBorrow($borrow);
        if ($history->borrow_id !== $borrow->id) abort(404);

        $otherTotal = $borrow->histories()->where('id', '!=', $history->id)->sum('amount');
        $maxAmount = $borrow->amount - $otherTotal;

        $request->validate([
            'amount' => "required|numeric|min:0.01|max:$maxAmount",
            'wallet_id' => 'required|exists:wallets,id',
            'date' => 'required|date',
        ]);

        // (Optionally) adjust previous wallet, but for simplicity, only update the new wallet
        $history->update([
            'amount' => $request->amount,
            'wallet_id' => $request->wallet_id,
            'date' => $request->date,
        ]);

        // Update borrow returned_amount and status
        $borrow->returned_amount = $borrow->histories()->sum('amount');
        $borrow->status = $borrow->returned_amount >= $borrow->amount
            ? 'returned'
            : ($borrow->returned_amount > 0 ? 'partial' : 'pending');
        $borrow->save();

        return redirect()->route('borrows.show', $borrow->id)->with('success', 'Return entry updated.');
    }

    // Delete an individual return/repayment and restore wallet balance
    public function destroyReturn(Borrow $borrow, BorrowHistory $history)
    {
        $this->authorizeBorrow($borrow);
        if ($history->borrow_id !== $borrow->id) abort(404);

        $wallet = Wallet::where('user_id', Auth::id())->find($history->wallet_id);
        if ($wallet) {
            if ($borrow->borrow_type === 'lent') {
                // Repayments were added to wallet, so remove them
                $wallet->balance -= $history->amount;
            } else {
                // Repayments were subtracted from wallet, so add them back
                $wallet->balance += $history->amount;
            }
            $wallet->save();
        }

        $history->delete();

        // Update borrow returned_amount and status
        $borrow->returned_amount = $borrow->histories()->sum('amount');
        $borrow->status = $borrow->returned_amount >= $borrow->amount
            ? 'returned'
            : ($borrow->returned_amount > 0 ? 'partial' : 'pending');
        $borrow->save();

        return redirect()->route('borrows.show', $borrow->id)->with('success', 'Return entry deleted and balance restored.');
    }

    protected function authorizeBorrow(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) abort(403, 'Unauthorized action.');
    }
}
