<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Get paginated wallets for a user with filters
     */
    public function getPaginatedWallets(
        User $user,
        ?string $search = null,
        ?string $filter = null,
        ?int $walletTypeId = null,
        ?int $currencyId = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = Wallet::with('walletType', 'currency')->where('user_id', $user->id);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('walletType', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('currency', function ($q3) use ($search) {
                        $q3->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        // Active/inactive filter
        if ($filter === 'active') {
            $query->where('is_active', true);
        } elseif ($filter === 'inactive') {
            $query->where('is_active', false);
        }

        // Wallet type filter
        if ($walletTypeId) {
            $query->where('wallet_type_id', $walletTypeId);
        }

        // Currency filter
        if ($currencyId) {
            $query->where('currency_id', $currencyId);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get all wallets for a user
     */
    public function getUserWallets(User $user, bool $activeOnly = false): Collection
    {
        $query = Wallet::with('walletType', 'currency')->where('user_id', $user->id);

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->latest()->get();
    }

    /**
     * Create a new wallet
     */
    public function createWallet(User $user, array $data): Wallet
    {
        $data['user_id'] = $user->id;
        return Wallet::create($data);
    }

    /**
     * Update an existing wallet
     */
    public function updateWallet(Wallet $wallet, array $data): Wallet
    {
        $wallet->update($data);
        return $wallet->fresh(['walletType', 'currency']);
    }

    /**
     * Delete a wallet
     */
    public function deleteWallet(Wallet $wallet): bool
    {
        return $wallet->delete();
    }

    /**
     * Check if wallet belongs to user
     */
    public function walletBelongsToUser(Wallet $wallet, User $user): bool
    {
        return $wallet->user_id === $user->id;
    }

    /**
     * Find wallet by ID for user
     */
    public function findWalletForUser(int $walletId, User $user): ?Wallet
    {
        return Wallet::with('walletType', 'currency')
            ->where('id', $walletId)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * Check if wallet has transactions
     */
    public function walletHasTransactions(Wallet $wallet): bool
    {
        return Transaction::where('wallet_id', $wallet->id)->exists();
    }

    /**
     * Check if wallet name is unique for user and wallet type
     */
    public function isWalletNameUniqueForUserAndType(
        string $name,
        User $user,
        int $walletTypeId,
        ?int $excludeId = null
    ): bool {
        $query = Wallet::where('user_id', $user->id)
            ->where('wallet_type_id', $walletTypeId)
            ->where('name', $name);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    /**
     * Get wallet with transactions
     */
    public function getWalletWithTransactions(Wallet $wallet, int $transactionsPerPage = 10): array
    {
        $wallet->load('walletType', 'currency');
        $transactions = $wallet->transactions()->latest()->paginate($transactionsPerPage);
        $borrows = $wallet->borrows()->latest()->paginate($transactionsPerPage);

        return [
            'wallet' => $wallet,
            'transactions' => $transactions,
            'borrows' => $borrows
        ];
    }

    /**
     * Transfer funds between wallets
     */
    public function transferFunds(Wallet $fromWallet, Wallet $toWallet, float $amount): bool
    {
        if ($fromWallet->balance < $amount) {
            throw new \Exception('Insufficient balance in source wallet.');
        }

        return DB::transaction(function () use ($fromWallet, $toWallet, $amount) {
            $fromWallet->decrement('balance', $amount);
            $toWallet->increment('balance', $amount);

            // Log transactions for both wallets
            Transaction::create([
                'wallet_id' => $fromWallet->id,
                'user_id' => $fromWallet->user_id,
                'amount' => -$amount,
                'type' => 'transfer_out',
                'description' => 'Transfer to wallet: ' . $toWallet->name,
            ]);

            Transaction::create([
                'wallet_id' => $toWallet->id,
                'user_id' => $toWallet->user_id,
                'amount' => $amount,
                'type' => 'transfer_in',
                'description' => 'Transfer from wallet: ' . $fromWallet->name,
            ]);

            return true;
        });
    }

    /**
     * Get wallet statistics for user
     */
    public function getWalletStats(User $user): array
    {
        $wallets = Wallet::where('user_id', $user->id);
        
        return [
            'total_wallets' => $wallets->count(),
            'active_wallets' => $wallets->where('is_active', true)->count(),
            'inactive_wallets' => $wallets->where('is_active', false)->count(),
            'total_balance' => $wallets->sum('balance'),
            'wallets_with_transactions' => Wallet::where('user_id', $user->id)
                ->whereHas('transactions')
                ->count(),
        ];
    }

    /**
     * Get active wallet types
     */
    public function getActiveWalletTypes(): Collection
    {
        return WalletType::where('is_active', true)->get();
    }

    /**
     * Get all currencies
     */
    public function getAllCurrencies(): Collection
    {
        return Currency::all();
    }

    /**
     * Get wallets by currency for user
     */
    public function getWalletsByCurrency(User $user, int $currencyId): Collection
    {
        return Wallet::with('walletType')
            ->where('user_id', $user->id)
            ->where('currency_id', $currencyId)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Get wallet balance summary by currency
     */
    public function getBalanceSummaryByCurrency(User $user): Collection
    {
        return Wallet::with('currency')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->get()
            ->groupBy('currency_id')
            ->map(function ($wallets) {
                return [
                    'currency' => $wallets->first()->currency,
                    'total_balance' => $wallets->sum('balance'),
                    'wallet_count' => $wallets->count()
                ];
            })
            ->values();
    }

    /**
     * Validate transfer request
     */
    public function validateTransfer(User $user, int $fromWalletId, int $toWalletId): array
    {
        $fromWallet = $this->findWalletForUser($fromWalletId, $user);
        $toWallet = $this->findWalletForUser($toWalletId, $user);

        if (!$fromWallet) {
            throw new \Exception('Source wallet not found.');
        }

        if (!$toWallet) {
            throw new \Exception('Destination wallet not found.');
        }

        if ($fromWalletId === $toWalletId) {
            throw new \Exception('Source and destination wallets cannot be the same.');
        }

        if (!$fromWallet->is_active) {
            throw new \Exception('Source wallet is inactive.');
        }

        if (!$toWallet->is_active) {
            throw new \Exception('Destination wallet is inactive.');
        }

        return [$fromWallet, $toWallet];
    }
}
