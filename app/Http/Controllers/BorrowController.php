<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowHistory;
use App\Services\BorrowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->middleware('auth');
        $this->middleware('can:manage borrows');
        $this->borrowService = $borrowService;
    }

    // List all borrows/lends
    public function index(Request $request)
    {
        try {
            $filters = $request->only([
                'search', 'type', 'status', 'wallet', 'person', 
                'start_date', 'end_date', 'min_amount', 'max_amount',
                'sort_by', 'sort_order', 'per_page'
            ]);
            
            // Map request parameters to filter keys
            if (isset($filters['wallet'])) {
                $filters['wallet_id'] = $filters['wallet'];
                unset($filters['wallet']);
            }
            
            if (isset($filters['person'])) {
                $filters['person_id'] = $filters['person'];
                unset($filters['person']);
            }

            $borrows = $this->borrowService->getPaginatedBorrows(Auth::id(), $filters);
            $wallets = $this->borrowService->getUserWallets(Auth::id());
            $people = $this->borrowService->getUserExpensePeople(Auth::id());

            return view('borrows.index', compact('borrows', 'wallets', 'people'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Show create form
    public function create()
    {
        $people = $this->borrowService->getUserExpensePeople(Auth::id());
        $wallets = $this->borrowService->getUserWallets(Auth::id());
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

        try {
            $this->borrowService->createBorrow(Auth::id(), $request->all());
            return redirect()->route('borrows.index')->with('success', 'Borrow/Lend added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Show details + history
    public function show(Borrow $borrow)
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            $data = $this->borrowService->getBorrowWithHistories($borrow, 10);
            $wallets = $this->borrowService->getUserWallets(Auth::id());
            
            return view('borrows.show', array_merge($data, compact('wallets')));
        } catch (\Exception $e) {
            abort($e->getCode() === 403 ? 403 : 404, $e->getMessage());
        }
    }

    // Edit form
    public function edit(Borrow $borrow)
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            $people = $this->borrowService->getUserExpensePeople(Auth::id());
            $wallets = $this->borrowService->getUserWallets(Auth::id());
            
            return view('borrows.edit', compact('borrow', 'people', 'wallets'));
        } catch (\Exception $e) {
            abort($e->getCode() === 403 ? 403 : 404, $e->getMessage());
        }
    }

    // Update borrow/lend
    public function update(Request $request, Borrow $borrow)
    {
        $request->validate([
            'person_id'   => 'required|exists:expense_people,id',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'borrow_type' => 'required|in:borrowed,lent',
            'wallet_id'   => 'required|exists:wallets,id',
            'note'        => 'nullable|string',
        ]);

        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            $this->borrowService->updateBorrow($borrow, $request->all());
            
            return redirect()->route('borrows.index')->with('success', 'Borrow/Lend updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Delete borrow and restore all related balances
    public function destroy(Borrow $borrow)
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            $this->borrowService->deleteBorrow($borrow);
            
            return redirect()->route('borrows.index')->with('success', 'Borrow/Lend and all related returns deleted and balances restored.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Repay: Record repayment & history
    public function repay(Request $request, Borrow $borrow)
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            
            $maxReturn = $borrow->amount - $borrow->returned_amount;
            $request->validate([
                'repay_amount' => "required|numeric|min:0.01|max:$maxReturn",
                'wallet_id'    => 'required|exists:wallets,id',
                'date'         => 'required|date',
            ]);

            $this->borrowService->processRepayment($borrow, $request->all());
            
            return redirect()->route('borrows.show', $borrow->id)->with('success', 'Repayment recorded.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Edit a return/repayment entry (used for popups, not a separate page)
    public function editReturn(Borrow $borrow, BorrowHistory $history)
    {
        try {
            $this->borrowService->validateHistoryOwnership($borrow, $history, Auth::id());
            $wallets = $this->borrowService->getUserWallets(Auth::id());
            
            return view('borrows.edit_return', compact('borrow', 'history', 'wallets'));
        } catch (\Exception $e) {
            abort($e->getCode() === 403 ? 403 : 404, $e->getMessage());
        }
    }

    // Update a return/repayment entry (can be used via popup/modal in show)
    public function updateReturn(Request $request, Borrow $borrow, BorrowHistory $history)
    {
        try {
            $this->borrowService->validateHistoryOwnership($borrow, $history, Auth::id());
            
            $otherTotal = $borrow->histories()->where('id', '!=', $history->id)->sum('amount');
            $maxAmount = $borrow->amount - $otherTotal;

            $request->validate([
                'amount' => "required|numeric|min:0.01|max:$maxAmount",
                'wallet_id' => 'required|exists:wallets,id',
                'date' => 'required|date',
            ]);

            $this->borrowService->updateRepayment($borrow, $history, $request->all());
            
            return redirect()->route('borrows.show', $borrow->id)->with('success', 'Return entry updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // Delete an individual return/repayment and restore wallet balance
    public function destroyReturn(Borrow $borrow, BorrowHistory $history)
    {
        try {
            $this->borrowService->validateHistoryOwnership($borrow, $history, Auth::id());
            $this->borrowService->deleteRepayment($borrow, $history);
            
            return redirect()->route('borrows.show', $borrow->id)->with('success', 'Return entry deleted and balance restored.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    protected function authorizeBorrow(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) abort(403, 'Unauthorized action.');
    }
}
