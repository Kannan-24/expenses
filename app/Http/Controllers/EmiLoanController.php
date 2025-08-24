<?php

namespace App\Http\Controllers;

use App\Models\EmiLoan;
use App\Models\EmiSchedule;
use App\Services\EmiLoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmiLoanController extends Controller
{
    protected $emiLoanService;

    public function __construct(EmiLoanService $emiLoanService)
    {
        $this->middleware(['auth', 'verified', 'can:manage emi loans']);
        $this->emiLoanService = $emiLoanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $filters = request()->only(['search', 'category_id', 'status', 'loan_type', 'per_page']);
            $emiLoans = $this->emiLoanService->getPaginatedEmiLoans(Auth::id(), $filters);
            
            return view('emi_loans.index', compact('emiLoans'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->emiLoanService->getUserCategories(Auth::id());
        $wallets = $this->emiLoanService->getUserWallets(Auth::id());
        return view('emi_loans.create', compact('categories', 'wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'tenure_months' => 'required|integer|min:1',
            'monthly_emi' => 'nullable|numeric|min:0',
            'is_auto_deduct' => 'boolean',
            'loan_type' => 'in:fixed,reducing_balance',
            'status' => 'in:active,closed,cancelled',
            'default_wallet_id' => 'nullable|exists:wallets,id'
        ]);

        try {
            $this->emiLoanService->createEmiLoan(Auth::id(), $request->all());
            return redirect()->route('emi-loans.index')->with('success', 'EMI Loan created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(EmiLoan $emiLoan)
    {
        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            $data = $this->emiLoanService->getEmiLoanWithSchedules($emiLoan, 10);
            $wallets = $this->emiLoanService->getUserWallets(Auth::id());
            
            return view('emi_loans.show', array_merge($data, compact('wallets')));
        } catch (\Exception $e) {
            abort($e->getCode() === 403 ? 403 : 404, $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmiLoan $emiLoan)
    {
        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            $categories = $this->emiLoanService->getUserCategories(Auth::id());
            $wallets = $this->emiLoanService->getUserWallets(Auth::id());
            
            return view('emi_loans.edit', compact('emiLoan', 'categories', 'wallets'));
        } catch (\Exception $e) {
            abort($e->getCode() === 403 ? 403 : 404, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmiLoan $emiLoan)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'tenure_months' => 'required|integer|min:1',
            'monthly_emi' => 'nullable|numeric|min:0',
            'is_auto_deduct' => 'boolean',
            'loan_type' => 'in:fixed,reducing_balance',
            'status' => 'in:active,closed,cancelled',
            'default_wallet_id' => 'nullable|exists:wallets,id'
        ]);

        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            $this->emiLoanService->updateEmiLoan($emiLoan, $request->all());
            
            return redirect()->route('emi-loans.index')->with('success', 'EMI Loan updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmiLoan $emiLoan)
    {
        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            $this->emiLoanService->deleteEmiLoan($emiLoan);
            
            return redirect()->route('emi-loans.index')->with('success', 'EMI Loan deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Mark EMI schedule as paid
     */
    public function markSchedulePaid(Request $request, EmiLoan $emiLoan, EmiSchedule $emiSchedule)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'paid_amount' => 'required|numeric|min:0',
            'paid_date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $this->emiLoanService->validateScheduleOwnership($emiLoan, $emiSchedule, Auth::id());
            $this->emiLoanService->markSchedulePaid($emiLoan, $emiSchedule, $request->all());
            
            return redirect()->back()->with('success', 'EMI payment recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Get upcoming EMI schedules for notifications
     */
    public function getUpcomingSchedules()
    {
        try {
            $notificationDays = env('EMI_NOTIFICATION_DAYS', 3);
            $upcomingSchedules = $this->emiLoanService->getUpcomingSchedules(Auth::id(), $notificationDays);
            
            return $upcomingSchedules;
        } catch (\Exception $e) {
            return collect();
        }
    }
}
