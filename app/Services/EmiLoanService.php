<?php

namespace App\Services;

use App\Models\Category;
use App\Models\EmiLoan;
use App\Models\EmiSchedule;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EmiLoanService
{
    /**
     * Get paginated EMI loans with filtering
     */
    public function getPaginatedEmiLoans(int $userId, array $filters = []): LengthAwarePaginator
    {
        $query = EmiLoan::with(['category', 'emiSchedules'])
            ->where('user_id', $userId);

        $this->applyFilters($query, $filters);

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $perPage = $filters['per_page'] ?? 15;

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    /**
     * Apply filters to the EMI loan query
     */
    private function applyFilters($query, array $filters): void
    {
        // Search functionality
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by loan type
        if (!empty($filters['loan_type'])) {
            $query->where('loan_type', $filters['loan_type']);
        }

        // Filter by start date range
        if (!empty($filters['start_date'])) {
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('start_date', '<=', $filters['end_date']);
        }

        // Filter by amount range
        if (!empty($filters['min_amount'])) {
            $query->where('total_amount', '>=', $filters['min_amount']);
        }

        if (!empty($filters['max_amount'])) {
            $query->where('total_amount', '<=', $filters['max_amount']);
        }

        // Filter by auto deduct
        if (isset($filters['is_auto_deduct']) && $filters['is_auto_deduct'] !== '') {
            $query->where('is_auto_deduct', $filters['is_auto_deduct']);
        }
    }

    /**
     * Get user's categories
     */
    public function getUserCategories(int $userId): Collection
    {
        return Category::where('user_id', $userId)->orderBy('name')->get();
    }

    /**
     * Get user's active wallets
     */
    public function getUserWallets(int $userId): Collection
    {
        return Wallet::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Create a new EMI loan with schedules
     */
    public function createEmiLoan(int $userId, array $data): EmiLoan
    {
        return DB::transaction(function () use ($userId, $data) {
            // Validate category ownership if provided
            if (!empty($data['category_id'])) {
                $category = Category::where('user_id', $userId)
                    ->where('id', $data['category_id'])
                    ->first();

                if (!$category) {
                    throw new \Exception('Category not found or access denied.');
                }
            }

            // Validate wallet ownership if provided
            if (!empty($data['default_wallet_id'])) {
                $wallet = Wallet::where('user_id', $userId)
                    ->where('id', $data['default_wallet_id'])
                    ->where('is_active', true)
                    ->first();

                if (!$wallet) {
                    throw new \Exception('Wallet not found or access denied.');
                }
            }

            // Calculate monthly EMI if not provided
            $monthlyEmi = $data['monthly_emi'] ?? $this->calculateMonthlyEmi(
                $data['total_amount'],
                $data['interest_rate'],
                $data['tenure_months'],
                $data['loan_type'] ?? 'fixed'
            );

            // Create EMI loan
            $emiLoan = EmiLoan::create([
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? null,
                'name' => $data['name'],
                'total_amount' => $data['total_amount'],
                'interest_rate' => $data['interest_rate'],
                'start_date' => $data['start_date'],
                'tenure_months' => $data['tenure_months'],
                'monthly_emi' => $monthlyEmi,
                'is_auto_deduct' => $data['is_auto_deduct'] ?? false,
                'loan_type' => $data['loan_type'] ?? 'fixed',
                'status' => $data['status'] ?? 'active',
                'default_wallet_id' => $data['default_wallet_id'] ?? null,
            ]);

            // Generate EMI schedules
            $this->generateEmiSchedules($emiLoan, $userId, $data['default_wallet_id'] ?? null);

            return $emiLoan->fresh(['category', 'emiSchedules']);
        });
    }

    /**
     * Update an existing EMI loan
     */
    public function updateEmiLoan(EmiLoan $emiLoan, array $data): EmiLoan
    {
        return DB::transaction(function () use ($emiLoan, $data) {
            // Validate category ownership if provided
            if (!empty($data['category_id'])) {
                $category = Category::where('user_id', $emiLoan->user_id)
                    ->where('id', $data['category_id'])
                    ->first();

                if (!$category) {
                    throw new \Exception('Category not found or access denied.');
                }
            }

            // Validate wallet ownership if provided
            if (!empty($data['default_wallet_id'])) {
                $wallet = Wallet::where('user_id', $emiLoan->user_id)
                    ->where('id', $data['default_wallet_id'])
                    ->where('is_active', true)
                    ->first();

                if (!$wallet) {
                    throw new \Exception('Wallet not found or access denied.');
                }
            }

            // Calculate monthly EMI if not provided
            $monthlyEmi = $data['monthly_emi'] ?? $this->calculateMonthlyEmi(
                $data['total_amount'],
                $data['interest_rate'],
                $data['tenure_months'],
                $data['loan_type'] ?? 'fixed'
            );

            // Update EMI loan
            $emiLoan->update([
                'category_id' => $data['category_id'] ?? null,
                'name' => $data['name'],
                'total_amount' => $data['total_amount'],
                'interest_rate' => $data['interest_rate'],
                'start_date' => $data['start_date'],
                'tenure_months' => $data['tenure_months'],
                'monthly_emi' => $monthlyEmi,
                'is_auto_deduct' => $data['is_auto_deduct'] ?? false,
                'loan_type' => $data['loan_type'] ?? 'fixed',
                'status' => $data['status'] ?? 'active',
                'default_wallet_id' => $data['default_wallet_id'] ?? null,
            ]);

            // Regenerate schedules (delete and create new ones)
            EmiSchedule::where('emi_loan_id', $emiLoan->id)->delete();
            $this->generateEmiSchedules($emiLoan, $emiLoan->user_id, $data['default_wallet_id'] ?? null);

            return $emiLoan->fresh(['category', 'emiSchedules']);
        });
    }

    /**
     * Delete an EMI loan and its schedules
     */
    public function deleteEmiLoan(EmiLoan $emiLoan): void
    {
        DB::transaction(function () use ($emiLoan) {
            // Delete associated schedules
            EmiSchedule::where('emi_loan_id', $emiLoan->id)->delete();

            // Delete the EMI loan
            $emiLoan->delete();
        });
    }

    /**
     * Get EMI loan with paginated schedules
     */
    public function getEmiLoanWithSchedules(EmiLoan $emiLoan, int $perPage = 10): array
    {
        $emiLoan->load(['category']);
        
        $schedules = $emiLoan->emiSchedules()
            ->with(['wallet.currency'])
            ->orderBy('due_date')
            ->paginate($perPage);

        return [
            'emi_loan' => $emiLoan,
            'schedules' => $schedules
        ];
    }

    /**
     * Mark EMI schedule as paid
     */
    public function markSchedulePaid(EmiLoan $emiLoan, EmiSchedule $emiSchedule, array $data): EmiSchedule
    {
        return DB::transaction(function () use ($emiLoan, $emiSchedule, $data) {
            // Validate wallet ownership
            $wallet = Wallet::where('id', $data['wallet_id'])
                ->where('user_id', $emiLoan->user_id)
                ->where('is_active', true)
                ->first();

            if (!$wallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // Check if wallet has sufficient balance
            if ($wallet->balance < $data['paid_amount']) {
                throw new \Exception('Insufficient wallet balance.');
            }

            // Update EMI schedule
            $emiSchedule->update([
                'status' => 'paid',
                'paid_date' => $data['paid_date'],
                'paid_amount' => $data['paid_amount'],
                'wallet_id' => $data['wallet_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Deduct amount from wallet
            $wallet->decrement('balance', $data['paid_amount']);

            return $emiSchedule->fresh(['wallet.currency']);
        });
    }

    /**
     * Update a paid EMI schedule
     */
    public function updateSchedulePayment(EmiLoan $emiLoan, EmiSchedule $emiSchedule, array $data): EmiSchedule
    {
        return DB::transaction(function () use ($emiLoan, $emiSchedule, $data) {
            // Validate wallet ownership
            $newWallet = Wallet::where('id', $data['wallet_id'])
                ->where('user_id', $emiLoan->user_id)
                ->where('is_active', true)
                ->first();

            if (!$newWallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // If wallet or amount changed, adjust balances
            if ($emiSchedule->wallet_id != $data['wallet_id'] || $emiSchedule->paid_amount != $data['paid_amount']) {
                // Restore old wallet balance if exists
                if ($emiSchedule->wallet_id) {
                    $oldWallet = Wallet::where('id', $emiSchedule->wallet_id)
                        ->where('user_id', $emiLoan->user_id)
                        ->first();

                    if ($oldWallet) {
                        $oldWallet->increment('balance', $emiSchedule->paid_amount);
                    }
                }

                // Check new wallet balance
                if ($newWallet->balance < $data['paid_amount']) {
                    throw new \Exception('Insufficient balance in the selected wallet.');
                }

                // Deduct from new wallet
                $newWallet->decrement('balance', $data['paid_amount']);
            }

            // Update schedule
            $emiSchedule->update([
                'paid_date' => $data['paid_date'],
                'paid_amount' => $data['paid_amount'],
                'wallet_id' => $data['wallet_id'],
                'notes' => $data['notes'] ?? null,
            ]);

            return $emiSchedule->fresh(['wallet.currency']);
        });
    }

    /**
     * Mark schedule as unpaid and restore wallet balance
     */
    public function markScheduleUnpaid(EmiLoan $emiLoan, EmiSchedule $emiSchedule): EmiSchedule
    {
        return DB::transaction(function () use ($emiLoan, $emiSchedule) {
            // Restore wallet balance if payment was made
            if ($emiSchedule->wallet_id && $emiSchedule->paid_amount > 0) {
                $wallet = Wallet::where('id', $emiSchedule->wallet_id)
                    ->where('user_id', $emiLoan->user_id)
                    ->first();

                if ($wallet) {
                    $wallet->increment('balance', $emiSchedule->paid_amount);
                }
            }

            // Reset schedule to unpaid
            $emiSchedule->update([
                'status' => 'upcoming',
                'paid_date' => null,
                'paid_amount' => null,
                'wallet_id' => null,
                'notes' => null,
            ]);

            return $emiSchedule->fresh();
        });
    }

    /**
     * Get upcoming EMI schedules for notifications
     */
    public function getUpcomingSchedules(int $userId, int $notificationDays = 3): Collection
    {
        $notificationDate = now()->addDays($notificationDays);

        return EmiSchedule::with(['emiLoan', 'wallet.currency'])
            ->where('user_id', $userId)
            ->where('status', 'upcoming')
            ->where('due_date', '<=', $notificationDate)
            ->where('due_date', '>=', now())
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Get EMI loan statistics
     */
    public function getEmiLoanStats(int $userId, array $params = []): array
    {
        $query = EmiLoan::where('user_id', $userId);

        // Apply date filters if provided
        if (!empty($params['start_date'])) {
            $query->whereDate('start_date', '>=', $params['start_date']);
        }

        if (!empty($params['end_date'])) {
            $query->whereDate('start_date', '<=', $params['end_date']);
        }

        $loans = $query->with(['emiSchedules'])->get();

        $stats = [
            'total_loans' => $loans->count(),
            'active_loans' => $loans->where('status', 'active')->count(),
            'closed_loans' => $loans->where('status', 'closed')->count(),
            'cancelled_loans' => $loans->where('status', 'cancelled')->count(),
            'total_loan_amount' => $loans->sum('total_amount'),
            'total_monthly_emi' => $loans->where('status', 'active')->sum('monthly_emi'),
        ];

        // Calculate payment statistics
        $allSchedules = $loans->flatMap->emiSchedules;
        $paidSchedules = $allSchedules->where('status', 'paid');
        $upcomingSchedules = $allSchedules->where('status', 'upcoming');

        $stats['total_paid_amount'] = $paidSchedules->sum('paid_amount');
        $stats['total_pending_amount'] = $upcomingSchedules->sum('total_amount');
        $stats['total_schedules'] = $allSchedules->count();
        $stats['paid_schedules'] = $paidSchedules->count();
        $stats['upcoming_schedules'] = $upcomingSchedules->count();

        return $stats;
    }

    /**
     * Validate EMI loan ownership
     */
    public function validateOwnership(EmiLoan $emiLoan, int $userId): void
    {
        if ($emiLoan->user_id !== $userId) {
            throw new \Exception('Unauthorized access to this EMI loan.', 403);
        }
    }

    /**
     * Validate EMI schedule ownership
     */
    public function validateScheduleOwnership(EmiLoan $emiLoan, EmiSchedule $emiSchedule, int $userId): void
    {
        $this->validateOwnership($emiLoan, $userId);
        
        if ($emiSchedule->emi_loan_id !== $emiLoan->id) {
            throw new \Exception('Schedule does not belong to this EMI loan.', 404);
        }
    }

    /**
     * Calculate monthly EMI amount
     */
    private function calculateMonthlyEmi(float $totalAmount, float $interestRate, int $tenureMonths, string $loanType): float
    {
        if ($loanType === 'reducing_balance' && $interestRate > 0) {
            // EMI calculation for reducing balance
            $monthlyRate = $interestRate / (12 * 100);
            $emi = ($totalAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths)) 
                   / (pow(1 + $monthlyRate, $tenureMonths) - 1);
            return round($emi, 2);
        } else {
            // Simple EMI calculation for fixed loan type
            $principalPerMonth = $totalAmount / $tenureMonths;
            $totalInterest = ($totalAmount * $interestRate / 100);
            $interestPerMonth = $totalInterest / $tenureMonths;
            return round($principalPerMonth + $interestPerMonth, 2);
        }
    }

    /**
     * Generate EMI schedules for a loan
     */
    private function generateEmiSchedules(EmiLoan $emiLoan, int $userId, ?int $defaultWalletId): void
    {
        $schedules = [];
        $dueDate = Carbon::parse($emiLoan->start_date);
        
        $principalPerMonth = round($emiLoan->total_amount / $emiLoan->tenure_months, 2);
        $totalInterest = ($emiLoan->total_amount * $emiLoan->interest_rate / 100);
        $interestPerMonth = round($totalInterest / $emiLoan->tenure_months, 2);

        for ($i = 0; $i < $emiLoan->tenure_months; $i++) {
            $principal = $principalPerMonth;
            $interest = $interestPerMonth;

            // For reducing balance, recalculate interest each month
            if ($emiLoan->loan_type === 'reducing_balance') {
                $remainingPrincipal = $emiLoan->total_amount - ($principalPerMonth * $i);
                $interest = round(($remainingPrincipal * $emiLoan->interest_rate / 100) / 12, 2);
            }

            $emiAmount = $principal + $interest;

            $schedules[] = [
                'user_id' => $userId,
                'emi_loan_id' => $emiLoan->id,
                'due_date' => $dueDate->copy()->format('Y-m-d'),
                'principal_amount' => $principal,
                'interest_amount' => $interest,
                'total_amount' => $emiAmount,
                'wallet_id' => $defaultWalletId,
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $dueDate->addMonth();
        }

        EmiSchedule::insert($schedules);
    }

    /**
     * Bulk delete EMI loans
     */
    public function bulkDeleteEmiLoans(int $userId, array $loanIds): int
    {
        return DB::transaction(function () use ($userId, $loanIds) {
            $loans = EmiLoan::where('user_id', $userId)
                ->whereIn('id', $loanIds)
                ->get();

            $deletedCount = 0;
            foreach ($loans as $loan) {
                $this->deleteEmiLoan($loan);
                $deletedCount++;
            }

            return $deletedCount;
        });
    }
}
