<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\BudgetHistory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    /**
     * Get paginated budgets with filters
     */
    public function getPaginatedBudgets(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Budget::where('user_id', $userId)->with(['category', 'histories']);

        $this->applyFilters($query, $filters);

        return $query->orderBy('start_date', 'desc')->paginate($perPage);
    }

    /**
     * Get all budgets for a user (without pagination)
     */
    public function getAllBudgets(int $userId, array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Budget::where('user_id', $userId)->with(['category', 'histories']);

        $this->applyFilters($query, $filters);

        return $query->orderBy('start_date', 'desc')->get();
    }

    /**
     * Apply filters to budget query
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        // Search by keyword (searches category name and amount)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('category', function ($cat) use ($search) {
                    $cat->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }

        // Quick filter: active or expired
        if (!empty($filters['filter'])) {
            if ($filters['filter'] === 'active') {
                $query->where('end_date', '>=', now());
            } elseif ($filters['filter'] === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        // Start date filter
        if (!empty($filters['start_date'])) {
            $query->where('start_date', '>=', $filters['start_date']);
        }

        // End date filter
        if (!empty($filters['end_date'])) {
            $query->where('end_date', '<=', $filters['end_date']);
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Frequency filter
        if (!empty($filters['frequency'])) {
            $query->where('frequency', $filters['frequency']);
        }

        // Roll over filter
        if (isset($filters['roll_over']) && $filters['roll_over'] !== '') {
            $query->where('roll_over', $filters['roll_over']);
        }
    }

    /**
     * Create a new budget
     */
    public function createBudget(int $userId, array $data): Budget
    {
        return DB::transaction(function () use ($userId, $data) {
            // Validate category ownership
            $category = Category::where('user_id', $userId)
                ->where('id', $data['category_id'])
                ->first();

            if (!$category) {
                throw new \Exception('Category not found or access denied.');
            }

            // Check for overlapping budgets for the same category
            $overlapping = Budget::where('user_id', $userId)
                ->where('category_id', $data['category_id'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                        ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_date', '<=', $data['start_date'])
                              ->where('end_date', '>=', $data['end_date']);
                        });
                })
                ->exists();

            if ($overlapping) {
                throw new \Exception('A budget for this category already exists in the specified date range.');
            }

            return Budget::create([
                'user_id' => $userId,
                'category_id' => $data['category_id'],
                'amount' => $data['amount'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'roll_over' => $data['roll_over'] ?? false,
                'frequency' => $data['frequency'],
            ]);
        });
    }

    /**
     * Update an existing budget
     */
    public function updateBudget(Budget $budget, array $data): Budget
    {
        return DB::transaction(function () use ($budget, $data) {
            // Validate category ownership if category is being changed
            if ($budget->category_id != $data['category_id']) {
                $category = Category::where('user_id', $budget->user_id)
                    ->where('id', $data['category_id'])
                    ->first();

                if (!$category) {
                    throw new \Exception('Category not found or access denied.');
                }
            }

            // Check for overlapping budgets for the same category (excluding current budget)
            $overlapping = Budget::where('user_id', $budget->user_id)
                ->where('category_id', $data['category_id'])
                ->where('id', '!=', $budget->id)
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                        ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_date', '<=', $data['start_date'])
                              ->where('end_date', '>=', $data['end_date']);
                        });
                })
                ->exists();

            if ($overlapping) {
                throw new \Exception('A budget for this category already exists in the specified date range.');
            }

            $budget->update([
                'category_id' => $data['category_id'],
                'amount' => $data['amount'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'roll_over' => $data['roll_over'] ?? false,
                'frequency' => $data['frequency'],
            ]);

            return $budget->fresh();
        });
    }

    /**
     * Delete a budget
     */
    public function deleteBudget(Budget $budget): bool
    {
        return DB::transaction(function () use ($budget) {
            // Delete associated budget histories
            if ($budget->histories()->count() > 0) {
                $budget->histories()->delete();
            }

            return $budget->delete();
        });
    }

    /**
     * Get budget with its histories
     */
    public function getBudgetWithHistories(Budget $budget, int $perPage = 10): array
    {
        $histories = $budget->histories()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return [
            'budget' => $budget->load('category'),
            'histories' => $histories
        ];
    }

    /**
     * Get user's categories for dropdowns
     */
    public function getUserCategories(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Category::where('user_id', $userId)->get();
    }

    /**
     * Get budget statistics
     */
    public function getBudgetStats(int $userId, array $filters = []): array
    {
        $query = Budget::where('user_id', $userId);
        $this->applyFilters($query, $filters);

        $totalBudgets = $query->count();
        $activeBudgets = (clone $query)->where('end_date', '>=', now())->count();
        $expiredBudgets = (clone $query)->where('end_date', '<', now())->count();
        $totalAmount = (clone $query)->sum('amount');
        $averageAmount = $totalBudgets > 0 ? $totalAmount / $totalBudgets : 0;

        // Get budget utilization
        $budgetsWithSpending = $query->with(['histories' => function ($q) {
            $q->selectRaw('budget_id, SUM(spent_amount) as total_spent')
              ->groupBy('budget_id');
        }])->get();

        $totalSpent = 0;
        $budgetsOverSpent = 0;
        $budgetsUnderSpent = 0;

        foreach ($budgetsWithSpending as $budget) {
            $spent = $budget->histories->sum('spent_amount');
            $totalSpent += $spent;

            if ($spent > $budget->amount) {
                $budgetsOverSpent++;
            } elseif ($spent < $budget->amount) {
                $budgetsUnderSpent++;
            }
        }

        return [
            'total_budgets' => $totalBudgets,
            'active_budgets' => $activeBudgets,
            'expired_budgets' => $expiredBudgets,
            'total_amount' => $totalAmount,
            'average_amount' => round($averageAmount, 2),
            'total_spent' => $totalSpent,
            'budgets_over_spent' => $budgetsOverSpent,
            'budgets_under_spent' => $budgetsUnderSpent,
            'utilization_rate' => $totalAmount > 0 ? round(($totalSpent / $totalAmount) * 100, 2) : 0,
        ];
    }

    /**
     * Get budget performance by category
     */
    public function getBudgetPerformanceByCategory(int $userId, array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Budget::where('user_id', $userId)
            ->with(['category', 'histories']);

        $this->applyFilters($query, $filters);

        return $query->get()->map(function ($budget) {
            $totalSpent = $budget->histories->sum('spent_amount');
            $remainingAmount = $budget->amount - $totalSpent;
            $utilizationPercent = $budget->amount > 0 ? ($totalSpent / $budget->amount) * 100 : 0;

            return [
                'budget_id' => $budget->id,
                'category' => $budget->category,
                'amount' => $budget->amount,
                'spent' => $totalSpent,
                'remaining' => $remainingAmount,
                'utilization_percent' => round($utilizationPercent, 2),
                'is_over_budget' => $totalSpent > $budget->amount,
                'frequency' => $budget->frequency,
                'start_date' => $budget->start_date,
                'end_date' => $budget->end_date,
                'roll_over' => $budget->roll_over,
            ];
        });
    }

    /**
     * Get active budgets summary
     */
    public function getActiveBudgetsSummary(int $userId): array
    {
        $activeBudgets = Budget::where('user_id', $userId)
            ->where('end_date', '>=', now())
            ->with(['category', 'histories'])
            ->get();

        $summary = [
            'total_active_budgets' => $activeBudgets->count(),
            'total_budgeted_amount' => $activeBudgets->sum('amount'),
            'total_spent' => 0,
            'budgets_at_risk' => 0, // Over 80% utilization
            'budgets_exceeded' => 0,
        ];

        foreach ($activeBudgets as $budget) {
            $spent = $budget->histories->sum('spent_amount');
            $summary['total_spent'] += $spent;

            $utilizationPercent = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;

            if ($utilizationPercent > 100) {
                $summary['budgets_exceeded']++;
            } elseif ($utilizationPercent > 80) {
                $summary['budgets_at_risk']++;
            }
        }

        $summary['total_remaining'] = $summary['total_budgeted_amount'] - $summary['total_spent'];
        $summary['overall_utilization'] = $summary['total_budgeted_amount'] > 0 
            ? round(($summary['total_spent'] / $summary['total_budgeted_amount']) * 100, 2) 
            : 0;

        return $summary;
    }

    /**
     * Validate budget ownership
     */
    public function validateOwnership(Budget $budget, int $userId): void
    {
        if ($budget->user_id !== $userId) {
            throw new \Exception('Unauthorized access to budget.');
        }
    }

    /**
     * Get budget by ID with ownership validation
     */
    public function getBudgetById(int $budgetId, int $userId): Budget
    {
        $budget = Budget::with(['category', 'histories'])->findOrFail($budgetId);
        $this->validateOwnership($budget, $userId);
        return $budget;
    }

    /**
     * Check if budget period overlaps with existing budgets
     */
    public function checkBudgetOverlap(int $userId, int $categoryId, string $startDate, string $endDate, ?int $excludeBudgetId = null): bool
    {
        $query = Budget::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            });

        if ($excludeBudgetId) {
            $query->where('id', '!=', $excludeBudgetId);
        }

        return $query->exists();
    }

    /**
     * Get monthly budget summary
     */
    public function getMonthlyBudgetSummary(int $userId, int $year): \Illuminate\Database\Eloquent\Collection
    {
        return Budget::where('user_id', $userId)
            ->whereYear('start_date', '<=', $year)
            ->whereYear('end_date', '>=', $year)
            ->with(['category', 'histories'])
            ->selectRaw('MONTH(start_date) as month, category_id, SUM(amount) as total_amount, COUNT(*) as budget_count')
            ->groupBy('month', 'category_id')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get budget trends over time
     */
    public function getBudgetTrends(int $userId, array $params = []): array
    {
        $period = $params['period'] ?? 'monthly'; // monthly, yearly
        $categoryId = $params['category_id'] ?? null;

        $query = Budget::where('user_id', $userId)
            ->with(['category', 'histories']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $budgets = $query->get();
        $trends = [];

        foreach ($budgets as $budget) {
            $periodKey = $period === 'yearly' 
                ? date('Y', strtotime($budget->start_date))
                : date('Y-m', strtotime($budget->start_date));

            if (!isset($trends[$periodKey])) {
                $trends[$periodKey] = [
                    'period' => $periodKey,
                    'total_budgeted' => 0,
                    'total_spent' => 0,
                    'budget_count' => 0,
                    'categories' => []
                ];
            }

            $spent = $budget->histories()
                ->where('type', 'debit')
                ->sum('amount');

            $trends[$periodKey]['total_budgeted'] += $budget->amount;
            $trends[$periodKey]['total_spent'] += $spent;
            $trends[$periodKey]['budget_count']++;
            
            $trends[$periodKey]['categories'][$budget->category->name] = [
                'budgeted' => ($trends[$periodKey]['categories'][$budget->category->name]['budgeted'] ?? 0) + $budget->amount,
                'spent' => ($trends[$periodKey]['categories'][$budget->category->name]['spent'] ?? 0) + $spent
            ];
        }

        return array_values($trends);
    }

    /**
     * Get active budgets for a user
     */
    public function getActiveBudgets(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        $today = now()->format('Y-m-d');
        
        return Budget::where('user_id', $userId)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->with(['category'])
            ->orderBy('category_id')
            ->get();
    }

    /**
     * Bulk delete budgets
     */
    public function bulkDeleteBudgets(int $userId, array $budgetIds): int
    {
        return DB::transaction(function () use ($userId, $budgetIds) {
            // Get budgets that belong to the user
            $budgets = Budget::where('user_id', $userId)
                ->whereIn('id', $budgetIds)
                ->get();

            $deletedCount = 0;
            foreach ($budgets as $budget) {
                $this->deleteBudget($budget);
                $deletedCount++;
            }

            return $deletedCount;
        });
    }
}
