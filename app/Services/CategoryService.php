<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    /**
     * Get paginated categories for a user with optional search
     */
    public function getPaginatedCategories(User $user, ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Category::where('user_id', $user->id);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get all categories for a user
     */
    public function getUserCategories(User $user): Collection
    {
        return Category::where('user_id', $user->id)->latest()->get();
    }

    /**
     * Create a new category
     */
    public function createCategory(User $user, array $data): Category
    {
        $data['user_id'] = $user->id;
        return Category::create($data);
    }

    /**
     * Update an existing category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }

    /**
     * Check if category belongs to user
     */
    public function categoryBelongsToUser(Category $category, User $user): bool
    {
        return $category->user_id === $user->id;
    }

    /**
     * Find category by ID for user
     */
    public function findCategoryForUser(int $categoryId, User $user): ?Category
    {
        return Category::where('id', $categoryId)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * Check if category name is unique for user
     */
    public function isCategoryNameUniqueForUser(string $name, User $user, ?int $excludeId = null): bool
    {
        $query = Category::where('user_id', $user->id)
            ->where('name', $name);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    /**
     * Get category statistics for user
     */
    public function getCategoryStats(User $user): array
    {
        $totalCategories = Category::where('user_id', $user->id)->count();
        
        // You can extend this with more statistics as needed
        return [
            'total_categories' => $totalCategories,
            'categories_with_expenses' => Category::where('user_id', $user->id)
                ->whereHas('expenses')
                ->count(),
        ];
    }
}
