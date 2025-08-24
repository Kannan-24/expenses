<?php

namespace App\Services;

use App\Models\Borrow;
use App\Models\BorrowHistory;
use App\Models\ExpensePerson;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BorrowService
{
    /**
     * Get paginated borrows with filtering and searching
     */
    public function getPaginatedBorrows(int $userId, array $filters = []): LengthAwarePaginator
    {
        $query = Borrow::with(['person', 'wallet.currency'])
            ->where('user_id', $userId);

        $this->applyFilters($query, $filters);

        $sortBy = $filters['sort_by'] ?? 'date';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $perPage = $filters['per_page'] ?? 15;

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    /**
     * Apply filters to the borrow query
     */
    private function applyFilters($query, array $filters): void
    {
        // Search functionality
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('person', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('wallet', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%");
            });
        }

        // Filter by type (borrowed/lent)
        if (!empty($filters['type'])) {
            $query->where('borrow_type', $filters['type']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by wallet
        if (!empty($filters['wallet_id'])) {
            $query->where('wallet_id', $filters['wallet_id']);
        }

        // Filter by person
        if (!empty($filters['person_id'])) {
            $query->where('person_id', $filters['person_id']);
        }

        // Filter by date range
        if (!empty($filters['start_date'])) {
            $query->whereDate('date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('date', '<=', $filters['end_date']);
        }

        // Filter by amount range
        if (!empty($filters['min_amount'])) {
            $query->where('amount', '>=', $filters['min_amount']);
        }

        if (!empty($filters['max_amount'])) {
            $query->where('amount', '<=', $filters['max_amount']);
        }
    }

    /**
     * Get user's expense people
     */
    public function getUserExpensePeople(int $userId): Collection
    {
        return ExpensePerson::where('user_id', $userId)->orderBy('name')->get();
    }

    /**
     * Get user's wallets
     */
    public function getUserWallets(int $userId): Collection
    {
        return Wallet::where('user_id', $userId)->orderBy('name')->get();
    }

    /**
     * Create a new borrow/lend record
     */
    public function createBorrow(int $userId, array $data): Borrow
    {
        return DB::transaction(function () use ($userId, $data) {
            // Validate that person belongs to user
            $person = ExpensePerson::where('user_id', $userId)
                ->where('id', $data['person_id'])
                ->first();

            if (!$person) {
                throw new \Exception('Person not found or access denied.');
            }

            // Validate that wallet belongs to user
            $wallet = Wallet::where('user_id', $userId)
                ->where('id', $data['wallet_id'])
                ->first();

            if (!$wallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // Check wallet balance for lending
            if ($data['borrow_type'] === 'lent' && $wallet->balance < $data['amount']) {
                throw new \Exception('Insufficient balance in wallet.');
            }

            // Update wallet balance
            if ($data['borrow_type'] === 'lent') {
                $wallet->balance -= $data['amount'];
            } else {
                $wallet->balance += $data['amount'];
            }
            $wallet->save();

            // Create borrow record
            return Borrow::create([
                'user_id' => $userId,
                'person_id' => $data['person_id'],
                'amount' => $data['amount'],
                'returned_amount' => 0,
                'status' => 'pending',
                'borrow_type' => $data['borrow_type'],
                'wallet_id' => $data['wallet_id'],
                'date' => $data['date'],
                'note' => $data['note'] ?? null,
            ]);
        });
    }

    /**
     * Get borrow with histories
     */
    public function getBorrowWithHistories(Borrow $borrow, int $perPage = 10): array
    {
        $borrow->load(['person', 'wallet.currency']);
        
        $histories = $borrow->histories()
            ->with(['wallet.currency'])
            ->orderBy('date', 'desc')
            ->paginate($perPage);

        return [
            'borrow' => $borrow,
            'histories' => $histories
        ];
    }

    /**
     * Update a borrow record
     */
    public function updateBorrow(Borrow $borrow, array $data): Borrow
    {
        return DB::transaction(function () use ($borrow, $data) {
            // Validate that the new person belongs to the user
            $person = ExpensePerson::where('user_id', $borrow->user_id)
                ->where('id', $data['person_id'])
                ->first();

            if (!$person) {
                throw new \Exception('Person not found or access denied.');
            }

            // Validate that the new wallet belongs to the user
            $newWallet = Wallet::where('user_id', $borrow->user_id)
                ->where('id', $data['wallet_id'])
                ->first();

            if (!$newWallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // Check if returned amount exceeds new borrow amount
            if ($borrow->returned_amount > $data['amount']) {
                throw new \Exception('Returned amount exceeds new borrow amount.');
            }

            // Update wallet balances if necessary
            if (
                $borrow->wallet_id != $data['wallet_id'] ||
                $borrow->amount != $data['amount'] ||
                $borrow->borrow_type != $data['borrow_type']
            ) {
                $this->updateWalletBalancesForBorrowUpdate($borrow, $data, $newWallet);
            }

            // Calculate status based on returned amount vs new amount
            $status = $this->calculateBorrowStatus($borrow->returned_amount, $data['amount']);

            // Update the borrow record
            $borrow->update([
                'person_id' => $data['person_id'],
                'amount' => $data['amount'],
                'borrow_type' => $data['borrow_type'],
                'wallet_id' => $data['wallet_id'],
                'date' => $data['date'],
                'note' => $data['note'] ?? null,
                'status' => $status,
            ]);

            return $borrow->fresh();
        });
    }

    /**
     * Update wallet balances when borrow is updated
     */
    private function updateWalletBalancesForBorrowUpdate(Borrow $borrow, array $data, Wallet $newWallet): void
    {
        // Get old wallet
        $oldWallet = Wallet::where('user_id', $borrow->user_id)
            ->where('id', $borrow->wallet_id)
            ->first();

        if (!$oldWallet) {
            throw new \Exception('Original wallet not found.');
        }

        // Calculate the net effect of the old transaction
        $oldNetEffect = ($borrow->borrow_type === 'lent') ? -$borrow->amount : $borrow->amount;

        // Calculate the net effect of the new transaction
        $newNetEffect = ($data['borrow_type'] === 'lent') ? -$data['amount'] : $data['amount'];

        // If wallet changed, reverse the old transaction and apply new one
        if ($borrow->wallet_id != $data['wallet_id']) {
            // Reverse old transaction
            $oldWallet->balance -= $oldNetEffect;
            $oldWallet->save();

            // Check if new wallet has sufficient balance for lending
            if ($data['borrow_type'] === 'lent' && $newWallet->balance < $data['amount']) {
                throw new \Exception('Insufficient balance in wallet.');
            }

            // Apply new transaction
            $newWallet->balance += $newNetEffect;
            $newWallet->save();
        } else {
            // Same wallet, just adjust the difference
            $balanceDifference = $newNetEffect - $oldNetEffect;

            // Check if wallet has sufficient balance for the change
            if ($balanceDifference < 0 && $newWallet->balance < abs($balanceDifference)) {
                throw new \Exception('Insufficient balance in wallet for this change.');
            }

            $newWallet->balance += $balanceDifference;
            $newWallet->save();
        }
    }

    /**
     * Calculate borrow status based on returned amount
     */
    private function calculateBorrowStatus(float $returnedAmount, float $totalAmount): string
    {
        if ($returnedAmount >= $totalAmount) {
            return 'returned';
        } elseif ($returnedAmount > 0) {
            return 'partial';
        }
        return 'pending';
    }

    /**
     * Delete a borrow and restore all related balances
     */
    public function deleteBorrow(Borrow $borrow): void
    {
        DB::transaction(function () use ($borrow) {
            // Roll back all repayment histories first
            foreach ($borrow->histories as $history) {
                $wallet = Wallet::where('user_id', $borrow->user_id)
                    ->where('id', $history->wallet_id)
                    ->first();

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
            $wallet = Wallet::where('user_id', $borrow->user_id)
                ->where('id', $borrow->wallet_id)
                ->first();

            if ($wallet) {
                if ($borrow->borrow_type === 'lent') {
                    $wallet->balance += $borrow->amount;
                } else {
                    $wallet->balance -= $borrow->amount;
                }
                $wallet->save();
            }

            // Delete all histories
            $borrow->histories()->delete();

            // Delete the borrow
            $borrow->delete();
        });
    }

    /**
     * Process a repayment
     */
    public function processRepayment(Borrow $borrow, array $data): BorrowHistory
    {
        return DB::transaction(function () use ($borrow, $data) {
            $maxReturn = $borrow->amount - $borrow->returned_amount;

            if ($data['repay_amount'] > $maxReturn) {
                throw new \Exception("Repayment amount cannot exceed {$maxReturn}");
            }

            // Validate wallet ownership
            $wallet = Wallet::where('user_id', $borrow->user_id)
                ->where('id', $data['wallet_id'])
                ->first();

            if (!$wallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // Update wallet balance
            if ($borrow->borrow_type === 'lent') {
                $wallet->balance += $data['repay_amount'];
            } else {
                if ($wallet->balance < $data['repay_amount']) {
                    throw new \Exception('Insufficient balance in wallet.');
                }
                $wallet->balance -= $data['repay_amount'];
            }
            $wallet->save();

            // Create repayment history
            $history = BorrowHistory::create([
                'borrow_id' => $borrow->id,
                'wallet_id' => $data['wallet_id'],
                'amount' => $data['repay_amount'],
                'date' => $data['date'],
            ]);

            // Update borrow
            $borrow->returned_amount += $data['repay_amount'];
            $borrow->status = $this->calculateBorrowStatus($borrow->returned_amount, $borrow->amount);
            $borrow->save();

            return $history;
        });
    }

    /**
     * Update a repayment history
     */
    public function updateRepayment(Borrow $borrow, BorrowHistory $history, array $data): BorrowHistory
    {
        return DB::transaction(function () use ($borrow, $history, $data) {
            // Calculate maximum allowed amount
            $otherTotal = $borrow->histories()->where('id', '!=', $history->id)->sum('amount');
            $maxAmount = $borrow->amount - $otherTotal;

            if ($data['amount'] > $maxAmount) {
                throw new \Exception("Amount cannot exceed {$maxAmount}");
            }

            // Validate wallet ownership
            $wallet = Wallet::where('user_id', $borrow->user_id)
                ->where('id', $data['wallet_id'])
                ->first();

            if (!$wallet) {
                throw new \Exception('Wallet not found or access denied.');
            }

            // Update history
            $history->update([
                'amount' => $data['amount'],
                'wallet_id' => $data['wallet_id'],
                'date' => $data['date'],
            ]);

            // Update borrow returned_amount and status
            $borrow->returned_amount = $borrow->histories()->sum('amount');
            $borrow->status = $this->calculateBorrowStatus($borrow->returned_amount, $borrow->amount);
            $borrow->save();

            return $history->fresh();
        });
    }

    /**
     * Delete a repayment and restore wallet balance
     */
    public function deleteRepayment(Borrow $borrow, BorrowHistory $history): void
    {
        DB::transaction(function () use ($borrow, $history) {
            $wallet = Wallet::where('user_id', $borrow->user_id)
                ->where('id', $history->wallet_id)
                ->first();

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
            $borrow->status = $this->calculateBorrowStatus($borrow->returned_amount, $borrow->amount);
            $borrow->save();
        });
    }

    /**
     * Validate borrow ownership
     */
    public function validateOwnership(Borrow $borrow, int $userId): void
    {
        if ($borrow->user_id !== $userId) {
            throw new \Exception('Unauthorized access to this borrow record.', 403);
        }
    }

    /**
     * Validate borrow history ownership
     */
    public function validateHistoryOwnership(Borrow $borrow, BorrowHistory $history, int $userId): void
    {
        $this->validateOwnership($borrow, $userId);
        
        if ($history->borrow_id !== $borrow->id) {
            throw new \Exception('History does not belong to this borrow record.', 404);
        }
    }

    /**
     * Get borrow statistics
     */
    public function getBorrowStats(int $userId, array $params = []): array
    {
        $query = Borrow::where('user_id', $userId);

        // Apply date filters if provided
        if (!empty($params['start_date'])) {
            $query->whereDate('date', '>=', $params['start_date']);
        }

        if (!empty($params['end_date'])) {
            $query->whereDate('date', '<=', $params['end_date']);
        }

        $borrows = $query->get();

        $stats = [
            'total_borrows' => $borrows->count(),
            'total_borrowed_amount' => $borrows->where('borrow_type', 'borrowed')->sum('amount'),
            'total_lent_amount' => $borrows->where('borrow_type', 'lent')->sum('amount'),
            'total_returned_borrowed' => $borrows->where('borrow_type', 'borrowed')->sum('returned_amount'),
            'total_returned_lent' => $borrows->where('borrow_type', 'lent')->sum('returned_amount'),
            'pending_count' => $borrows->where('status', 'pending')->count(),
            'partial_count' => $borrows->where('status', 'partial')->count(),
            'returned_count' => $borrows->where('status', 'returned')->count(),
        ];

        // Calculate net amounts
        $stats['net_borrowed_outstanding'] = $stats['total_borrowed_amount'] - $stats['total_returned_borrowed'];
        $stats['net_lent_outstanding'] = $stats['total_lent_amount'] - $stats['total_returned_lent'];
        $stats['net_position'] = $stats['net_lent_outstanding'] - $stats['net_borrowed_outstanding'];

        return $stats;
    }

    /**
     * Get borrows by status
     */
    public function getBorrowsByStatus(int $userId): array
    {
        $borrows = Borrow::where('user_id', $userId)
            ->with(['person', 'wallet.currency'])
            ->get()
            ->groupBy('status');

        return [
            'pending' => $borrows->get('pending', collect()),
            'partial' => $borrows->get('partial', collect()),
            'returned' => $borrows->get('returned', collect()),
        ];
    }

    /**
     * Bulk delete borrows
     */
    public function bulkDeleteBorrows(int $userId, array $borrowIds): int
    {
        return DB::transaction(function () use ($userId, $borrowIds) {
            $borrows = Borrow::where('user_id', $userId)
                ->whereIn('id', $borrowIds)
                ->get();

            $deletedCount = 0;
            foreach ($borrows as $borrow) {
                $this->deleteBorrow($borrow);
                $deletedCount++;
            }

            return $deletedCount;
        });
    }
}
