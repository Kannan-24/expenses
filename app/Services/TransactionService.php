<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\BudgetHistory;
use App\Models\Category;
use App\Models\Currency;
use App\Models\ExpensePerson;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAnalytics;
use App\Models\Wallet;
use App\Models\WalletType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionService
{
    protected $attachmentService;
    protected $streakService;

    public function __construct(AttachmentService $attachmentService, StreakService $streakService)
    {
        $this->attachmentService = $attachmentService;
        $this->streakService = $streakService;
    }

    /**
     * Get paginated transactions with filters
     */
    public function getPaginatedTransactions(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Transaction::with(['category', 'person', 'wallet'])
            ->where('user_id', $userId);

        $this->applyFilters($query, $filters);

        return $query->orderBy('date', 'desc')->paginate($perPage);
    }

    /**
     * Get all transactions for a user (without pagination)
     */
    public function getAllTransactions(int $userId, array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Transaction::with(['category', 'person', 'wallet'])
            ->where('user_id', $userId);

        $this->applyFilters($query, $filters);

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Apply filters to transaction query
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        // Search by person, category, or note
        if (!empty($filters['search'])) {
            $search = $filters['search'];
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
        if (!empty($filters['filter'])) {
            switch ($filters['filter']) {
                case '7days':
                    $query->where('date', '>=', now()->subDays(7));
                    break;
                case '15days':
                    $query->where('date', '>=', now()->subDays(15));
                    break;
                case '1month':
                    $query->where('date', '>=', now()->subMonth());
                    break;
            }
        }

        // Custom date range
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('date', [$filters['start_date'], $filters['end_date']]);
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Person filter
        if (!empty($filters['person'])) {
            $query->where('expense_person_id', $filters['person']);
        }

        // Type filter
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Wallet filter
        if (!empty($filters['wallet'])) {
            $query->where('wallet_id', $filters['wallet']);
        }
    }

    /**
     * Get form data for creating/editing transactions
     */
    public function getFormData(int $userId): array
    {
        return [
            'categories' => Category::where('user_id', $userId)->get(),
            'people' => ExpensePerson::where('user_id', $userId)->get(),
            'wallets' => Wallet::where('user_id', $userId)->get(),
            'walletTypes' => WalletType::all(),
            'currencies' => Currency::all(),
        ];
    }

    /**
     * Create a new transaction
     */
    public function createTransaction(int $userId, array $data): Transaction
    {
        return DB::transaction(function () use ($userId, $data) {
            // Get and validate wallet
            $wallet = Wallet::where('user_id', $userId)->findOrFail($data['wallet_id']);

            // Check wallet balance for expenses
            if ($data['type'] === 'expense' && $wallet->balance < $data['amount']) {
                throw new \Exception('Insufficient balance in the selected wallet.');
            }

            // Handle attachments
            $attachments = $this->processAttachments($data, $userId);

            // Update wallet balance
            $this->updateWalletBalance($wallet, $data['amount'], $data['type']);

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? null,
                'expense_person_id' => $data['expense_person_id'] ?? null,
                'amount' => $data['amount'],
                'date' => $data['date'],
                'note' => $data['note'] ?? null,
                'type' => $data['type'],
                'wallet_id' => $data['wallet_id'],
                'attachments' => $attachments,
            ]);

            // Update budget history for expenses
            if ($data['type'] === 'expense' && !empty($data['category_id'])) {
                $this->updateBudgetHistory($data['category_id'], $data['amount'], $data['date'], $userId);
            }

            // Update user streak
            $user = User::find($userId);
            $streakInfo = $this->streakService::updateUserStreak($user);

            // Track analytics if from email
            if (!empty($data['utm_tracking'])) {
                UserAnalytics::create([
                    'user_id' => $userId,
                    'action' => 'transaction_created',
                    'data' => [
                        'transaction_id' => $transaction->id,
                        'transaction_type' => $data['type'],
                        'amount' => $data['amount'],
                        'streak_info' => $streakInfo,
                        'utm_data' => $data['utm_tracking']
                    ]
                ]);
            }

            return $transaction;
        });
    }

    /**
     * Update an existing transaction
     */
    public function updateTransaction(Transaction $transaction, array $data): Transaction
    {
        return DB::transaction(function () use ($transaction, $data) {
            // Get wallet and validate ownership
            $wallet = Wallet::where('user_id', $transaction->user_id)
                ->findOrFail($data['wallet_id']);

            // Rollback previous transaction amount from wallet
            $this->revertWalletBalance($wallet, $transaction->amount, $transaction->type);

            // Check wallet balance for new expense amount
            if ($data['type'] === 'expense' && $wallet->balance < $data['amount']) {
                throw new \Exception('Insufficient balance in the selected wallet.');
            }

            // Apply new transaction amount to wallet
            $this->updateWalletBalance($wallet, $data['amount'], $data['type']);

            // Revert previous budget history
            if ($transaction->type === 'expense' && $transaction->category_id) {
                $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date, $transaction->user_id);
            }

            // Apply new budget history
            if ($data['type'] === 'expense' && !empty($data['category_id'])) {
                $this->updateBudgetHistory($data['category_id'], $data['amount'], $data['date'], $transaction->user_id);
            }

            // Handle attachments
            $attachments = $this->updateAttachments($transaction, $data);

            // Update transaction
            $transaction->update([
                'category_id' => $data['category_id'] ?? null,
                'expense_person_id' => $data['expense_person_id'] ?? null,
                'amount' => $data['amount'],
                'date' => $data['date'],
                'note' => $data['note'] ?? null,
                'type' => $data['type'],
                'wallet_id' => $data['wallet_id'],
                'attachments' => array_values($attachments),
            ]);

            return $transaction->fresh();
        });
    }

    /**
     * Delete a transaction
     */
    public function deleteTransaction(Transaction $transaction): bool
    {
        return DB::transaction(function () use ($transaction) {
            // Get wallet
            $wallet = Wallet::where('user_id', $transaction->user_id)
                ->findOrFail($transaction->wallet_id);

            // Revert wallet balance
            $this->revertWalletBalance($wallet, $transaction->amount, $transaction->type);

            // Revert budget history for expenses
            if ($transaction->type === 'expense' && $transaction->category_id) {
                $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date, $transaction->user_id);
            }

            // Delete attachments from storage
            if (!empty($transaction->attachments)) {
                foreach ($transaction->attachments as $attachment) {
                    $this->attachmentService->deleteAttachment($attachment['path']);
                }
            }

            return $transaction->delete();
        });
    }

    /**
     * Process attachments from request data
     */
    protected function processAttachments(array $data, int $userId): array
    {
        $attachments = [];

        // Handle file uploads
        if (!empty($data['uploaded_files'])) {
            foreach ($data['uploaded_files'] as $file) {
                $attachmentData = $this->attachmentService->uploadAttachment($file, $userId);
                $attachments[] = $attachmentData;
            }
        }

        // Handle single legacy camera image
        if (!empty($data['camera_image'])) {
            $cameraImageData = $this->attachmentService->saveBase64Image($data['camera_image'], $userId);
            $attachments[] = $cameraImageData;
        }

        // Handle multiple camera images
        if (!empty($data['camera_images'])) {
            foreach ($data['camera_images'] as $base64Image) {
                if ($base64Image) {
                    $cameraImageData = $this->attachmentService->saveBase64Image($base64Image, $userId);
                    $attachments[] = $cameraImageData;
                }
            }
        }

        return $attachments;
    }

    /**
     * Update attachments for existing transaction
     */
    protected function updateAttachments(Transaction $transaction, array $data): array
    {
        $currentAttachments = $transaction->attachments ?? [];

        // Remove deleted attachments
        if (!empty($data['removed_attachments'])) {
            foreach ($data['removed_attachments'] as $removedPath) {
                // Remove from current attachments array
                $currentAttachments = array_filter($currentAttachments, function($attachment) use ($removedPath) {
                    return $attachment['path'] !== $removedPath;
                });
                
                // Delete file from storage
                $this->attachmentService->deleteAttachment($removedPath);
            }
        }

        // Add new attachments
        $newAttachments = $this->processAttachments($data, $transaction->user_id);
        
        return array_merge($currentAttachments, $newAttachments);
    }

    /**
     * Update wallet balance
     */
    protected function updateWalletBalance(Wallet $wallet, float $amount, string $type): void
    {
        $wallet->balance += ($type === 'income') ? $amount : -$amount;
        $wallet->save();
    }

    /**
     * Revert wallet balance
     */
    protected function revertWalletBalance(Wallet $wallet, float $amount, string $type): void
    {
        $wallet->balance += ($type === 'income') ? -$amount : $amount;
        $wallet->save();
    }

    /**
     * Update budget history based on the transaction
     */
    protected function updateBudgetHistory(int $categoryId, float $amount, string $date, int $userId): void
    {
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
            $this->createBudgetHistory($budget, $amount, $date);
        } else {
            $budgetHistory->spent_amount += $amount;
            $budgetHistory->save();
        }

        // Notify user if budget is exceeded
        $this->checkBudgetExceeded($budgetHistory ?? BudgetHistory::where('budget_id', $budget->id)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first(), $budget, $userId);
    }

    /**
     * Create new budget history
     */
    protected function createBudgetHistory(Budget $budget, float $amount, string $date): void
    {
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
            'budget_id' => $budget->id,
            'allocated_amount' => $budget->amount,
            'roll_over_amount' => $rollOverAmount,
            'spent_amount' => $amount,
            'start_date' => $periodStart,
            'end_date' => $periodEnd,
            'status' => 'active',
        ]);
    }

    /**
     * Check if budget is exceeded and notify user
     */
    protected function checkBudgetExceeded(BudgetHistory $budgetHistory, Budget $budget, int $userId): void
    {
        if ($budgetHistory->allocated_amount <= 0) {
            return;
        }

        $exceededPercent = ($budgetHistory->spent_amount / $budgetHistory->allocated_amount) * 100;
        $user = User::find($userId);

        if ($exceededPercent >= 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
        } elseif ($exceededPercent >= 90 && $exceededPercent < 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
        }
    }

    /**
     * Get transaction statistics
     */
    public function getTransactionStats(int $userId, array $filters = []): array
    {
        $query = Transaction::where('user_id', $userId);
        $this->applyFilters($query, $filters);

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $transactionCount = $query->count();
        $balance = $totalIncome - $totalExpense;

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
            'transaction_count' => $transactionCount,
        ];
    }

    /**
     * Get transactions by category
     */
    public function getTransactionsByCategory(int $userId, array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Transaction::with('category')
            ->where('user_id', $userId)
            ->whereNotNull('category_id');

        $this->applyFilters($query, $filters);

        return $query->selectRaw('category_id, type, SUM(amount) as total_amount, COUNT(*) as transaction_count')
            ->groupBy('category_id', 'type')
            ->get();
    }

    /**
     * Get monthly transaction summary
     */
    public function getMonthlyTransactionSummary(int $userId, int $year): \Illuminate\Database\Eloquent\Collection
    {
        return Transaction::where('user_id', $userId)
            ->whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, type, SUM(amount) as total_amount, COUNT(*) as transaction_count')
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();
    }

    /**
     * Validate transaction ownership
     */
    public function validateOwnership(Transaction $transaction, int $userId): void
    {
        if ($transaction->user_id !== $userId) {
            throw new \Exception('Unauthorized access to transaction.');
        }
    }

    /**
     * Handle attachment upload via AJAX
     */
    public function uploadAttachment($file, int $userId): array
    {
        return $this->attachmentService->uploadAttachment($file, $userId);
    }

    /**
     * Handle camera image save via AJAX
     */
    public function saveCameraImage(string $base64Image, int $userId): array
    {
        return $this->attachmentService->saveBase64Image($base64Image, $userId);
    }

    /**
     * Delete attachment
     */
    public function deleteAttachmentFile(string $path): void
    {
        $this->attachmentService->deleteAttachment($path);
    }

    /**
     * Stream attachment file
     */
    public function streamAttachment(Transaction $transaction, int $index): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $attachments = $transaction->attachments ?? [];
        
        if (!isset($attachments[$index])) {
            throw new \Exception('Attachment not found.');
        }

        $attachment = $attachments[$index];
        $path = $attachment['path'] ?? null;
        
        if (!$path || !Storage::disk('public')->exists($path)) {
            throw new \Exception('Attachment file not found.');
        }

        $mime = $attachment['mime_type'] ?? 'application/octet-stream';
        $filename = $attachment['original_name'] ?? basename($path);
        $stream = Storage::disk('public')->readStream($path);

        return response()->stream(function() use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => str_starts_with($mime, 'image/') 
                ? 'inline; filename="'.$filename.'"' 
                : 'attachment; filename="'.$filename.'"'
        ]);
    }
}
