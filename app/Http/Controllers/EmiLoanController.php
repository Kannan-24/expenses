<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EmiLoan;
use App\Models\EmiSchedule;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmiLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emiLoans = EmiLoan::with(['user', 'category', 'emiSchedules'])->get();
        return view('emi_loans.index', compact('emiLoans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $wallets = Wallet::where('user_id', Auth::id())->where('is_active', true)->get();
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

        DB::beginTransaction();

        try {
            $emiLoan = EmiLoan::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'name' => $request->name,
                'total_amount' => $request->total_amount,
                'interest_rate' => $request->interest_rate,
                'start_date' => $request->start_date,
                'tenure_months' => $request->tenure_months,
                'monthly_emi' => $request->monthly_emi, // You may calculate below if null
                'is_auto_deduct' => $request->is_auto_deduct ?? false,
                'loan_type' => $request->loan_type ?? 'fixed',
                'status' => $request->status ?? 'active'
            ]);

            $emiSchedules = [];
            $dueDate = \Carbon\Carbon::parse($emiLoan->start_date);

            $principalPerMonth = round($emiLoan->total_amount / $emiLoan->tenure_months, 2);
            $totalInterest = ($emiLoan->total_amount * $emiLoan->interest_rate / 100);
            $interestPerMonth = round($totalInterest / $emiLoan->tenure_months, 2);

            for ($i = 0; $i < $emiLoan->tenure_months; $i++) {
                $principal = $principalPerMonth;
                $interest = $interestPerMonth;

                // If reducing balance, recalculate interest each month
                if ($emiLoan->loan_type === 'reducing_balance') {
                    $remainingPrincipal = $emiLoan->total_amount - ($principalPerMonth * $i);
                    $interest = round(($remainingPrincipal * $emiLoan->interest_rate / 100) / 12, 2);
                }

                $emiAmount = $principal + $interest;

                $emiSchedules[] = [
                    'user_id' => Auth::id(),
                    'emi_loan_id' => $emiLoan->id,
                    'due_date' => $dueDate->copy(),
                    'principal_amount' => $principal,
                    'interest_amount' => $interest,
                    'total_amount' => $emiAmount,
                    'wallet_id' => $request->default_wallet_id,
                    'status' => 'upcoming',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $dueDate->addMonth();
            }

            EmiSchedule::insert($emiSchedules);

            DB::commit();

            return redirect()->route('emi-loans.index')->with('success', 'EMI Loan created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create EMI loan: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(EmiLoan $emiLoan)
    {
        $emiSchedules = $emiLoan->emiSchedules()->with('wallet')->get();
        $wallets = Wallet::where('user_id', Auth::id())->where('is_active', true)->get();
        return view('emi_loans.show', compact('emiLoan', 'emiSchedules', 'wallets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmiLoan $emiLoan)
    {
        $categories = Category::all();
        $wallets = Wallet::where('user_id', Auth::id())->where('is_active', true)->get();
        return view('emi_loans.edit', compact('emiLoan', 'categories', 'wallets'));
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

        DB::beginTransaction();

        try {
            $emiLoan->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'total_amount' => $request->total_amount,
                'interest_rate' => $request->interest_rate,
                'start_date' => $request->start_date,
                'tenure_months' => $request->tenure_months,
                'monthly_emi' => $request->monthly_emi,
                'is_auto_deduct' => $request->is_auto_deduct ?? false,
                'loan_type' => $request->loan_type ?? 'fixed',
                'status' => $request->status ?? 'active',
                'default_wallet_id' => $request->default_wallet_id
            ]);

            // Delete previous schedules (optional: only if schedule-affecting fields changed)
            EmiSchedule::where('emi_loan_id', $emiLoan->id)->delete();

            $emiSchedules = [];
            $dueDate = \Carbon\Carbon::parse($emiLoan->start_date);

            $principalPerMonth = round($emiLoan->total_amount / $emiLoan->tenure_months, 2);
            $totalInterest = ($emiLoan->total_amount * $emiLoan->interest_rate / 100);
            $interestPerMonth = round($totalInterest / $emiLoan->tenure_months, 2);

            for ($i = 0; $i < $emiLoan->tenure_months; $i++) {
                $principal = $principalPerMonth;
                $interest = $interestPerMonth;

                if ($emiLoan->loan_type === 'reducing_balance') {
                    $remainingPrincipal = $emiLoan->total_amount - ($principalPerMonth * $i);
                    $interest = round(($remainingPrincipal * $emiLoan->interest_rate / 100) / 12, 2);
                }

                $emiAmount = $principal + $interest;

                $emiSchedules[] = [
                    'user_id' => Auth::id(),
                    'emi_loan_id' => $emiLoan->id,
                    'due_date' => $dueDate->copy(),
                    'principal_amount' => $principal,
                    'interest_amount' => $interest,
                    'total_amount' => $emiAmount,
                    'wallet_id' => $request->default_wallet_id,
                    'status' => 'upcoming',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $dueDate->addMonth();
            }

            EmiSchedule::insert($emiSchedules);

            DB::commit();

            return redirect()->route('emi_loans.index')->with('success', 'EMI Loan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update EMI loan: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmiLoan $emiLoan)
    {
        DB::beginTransaction();

        try {
            // Delete associated schedules
            EmiSchedule::where('emi_loan_id', $emiLoan->id)->delete();

            // Delete the EMI loan
            $emiLoan->delete();

            DB::commit();

            return redirect()->route('emi_loans.index')->with('success', 'EMI Loan deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete EMI loan: ' . $e->getMessage()]);
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

        DB::beginTransaction();

        try {
            // Check if wallet belongs to the user
            $wallet = Wallet::where('id', $request->wallet_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Check if wallet has sufficient balance
            if ($wallet->balance < $request->paid_amount) {
                return back()->withErrors(['error' => 'Insufficient wallet balance.']);
            }

            // Update EMI schedule
            $emiSchedule->update([
                'status' => 'paid',
                'paid_date' => $request->paid_date,
                'paid_amount' => $request->paid_amount,
                'wallet_id' => $request->wallet_id,
                'notes' => $request->notes
            ]);

            // Deduct amount from wallet
            $wallet->decrement('balance', $request->paid_amount);

            // Create transaction record (optional - if you have transaction system)
            // Transaction::create([...]);

            DB::commit();

            return back()->with('success', 'EMI payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to record payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Get upcoming EMI schedules for notifications
     */
    public function getUpcomingSchedules()
    {
        $notificationDays = env('EMI_NOTIFICATION_DAYS', 3);
        $notificationDate = now()->addDays($notificationDays);

        $upcomingSchedules = EmiSchedule::with(['emiLoan', 'user'])
            ->where('status', 'upcoming')
            ->where('due_date', '<=', $notificationDate)
            ->where('due_date', '>=', now())
            ->get();

        return $upcomingSchedules;
    }
}
