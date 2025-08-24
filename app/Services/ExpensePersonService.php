<?php

namespace App\Services;

use App\Models\ExpensePerson;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpensePersonService
{
    /**
     * Get paginated expense people for a user with optional search
     */
    public function getPaginatedExpensePeople(User $user, ?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = ExpensePerson::where('user_id', $user->id);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get all expense people for a user
     */
    public function getUserExpensePeople(User $user): Collection
    {
        return ExpensePerson::where('user_id', $user->id)->latest()->get();
    }

    /**
     * Create a new expense person
     */
    public function createExpensePerson(User $user, array $data): ExpensePerson
    {
        $data['user_id'] = $user->id;
        return ExpensePerson::create($data);
    }

    /**
     * Update an existing expense person
     */
    public function updateExpensePerson(ExpensePerson $expensePerson, array $data): ExpensePerson
    {
        $expensePerson->update($data);
        return $expensePerson->fresh();
    }

    /**
     * Delete an expense person
     */
    public function deleteExpensePerson(ExpensePerson $expensePerson): bool
    {
        return $expensePerson->delete();
    }

    /**
     * Check if expense person belongs to user
     */
    public function expensePersonBelongsToUser(ExpensePerson $expensePerson, User $user): bool
    {
        return $expensePerson->user_id === $user->id;
    }

    /**
     * Find expense person by ID for user
     */
    public function findExpensePersonForUser(int $expensePersonId, User $user): ?ExpensePerson
    {
        return ExpensePerson::where('id', $expensePersonId)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * Check if expense person name is unique for user
     */
    public function isExpensePersonNameUniqueForUser(string $name, User $user, ?int $excludeId = null): bool
    {
        $query = ExpensePerson::where('user_id', $user->id)
            ->where('name', $name);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    /**
     * Get expense person statistics for user
     */
    public function getExpensePersonStats(User $user): array
    {
        $totalExpensePeople = ExpensePerson::where('user_id', $user->id)->count();
        
        // You can extend this with more statistics as needed
        return [
            'total_expense_people' => $totalExpensePeople,
            'expense_people_with_transactions' => ExpensePerson::where('user_id', $user->id)
                ->whereHas('transactions')
                ->count(),
        ];
    }

    /**
     * Search expense people by name
     */
    public function searchExpensePeople(User $user, string $search, int $limit = 10): Collection
    {
        return ExpensePerson::where('user_id', $user->id)
            ->where('name', 'like', '%' . $search . '%')
            ->limit($limit)
            ->get();
    }

    /**
     * Get expense people with their transaction count
     */
    public function getExpensePeopleWithTransactionCount(User $user): Collection
    {
        return ExpensePerson::where('user_id', $user->id)
            ->withCount('transactions')
            ->latest()
            ->get();
    }
}
