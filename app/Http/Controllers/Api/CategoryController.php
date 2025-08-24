<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of categories
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $search = $request->get('search');
            $perPage = $request->get('per_page', 10);

            // Validate per_page parameter
            if ($perPage > 100) {
                $perPage = 100; // Limit to prevent abuse
            }

            $categories = $this->categoryService->getPaginatedCategories($user, $search, $perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'categories' => $categories->items(),
                    'pagination' => [
                        'current_page' => $categories->currentPage(),
                        'per_page' => $categories->perPage(),
                        'total' => $categories->total(),
                        'last_page' => $categories->lastPage(),
                        'has_more_pages' => $categories->hasMorePages(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all categories (without pagination)
     */
    public function all(): JsonResponse
    {
        try {
            $user = Auth::user();
            $categories = $this->categoryService->getUserCategories($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'categories' => $categories
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if category name is unique for this user
            if (!$this->categoryService->isCategoryNameUniqueForUser($request->name, $user)) {
                throw ValidationException::withMessages([
                    'name' => ['A category with this name already exists.']
                ]);
            }

            $category = $this->categoryService->createCategory($user, $request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => [
                    'category' => $category
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified category
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $category = $this->categoryService->findCategoryForUser($id, $user);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => $category
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $category = $this->categoryService->findCategoryForUser($id, $user);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if category name is unique for this user (excluding current category)
            if (!$this->categoryService->isCategoryNameUniqueForUser($request->name, $user, $category->id)) {
                throw ValidationException::withMessages([
                    'name' => ['A category with this name already exists.']
                ]);
            }

            $updatedCategory = $this->categoryService->updateCategory($category, $request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => [
                    'category' => $updatedCategory
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified category
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $category = $this->categoryService->findCategoryForUser($id, $user);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Check if category has associated expenses
            if ($category->expenses()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category that has associated expenses'
                ], 409);
            }

            $this->categoryService->deleteCategory($category);

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get category statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $user = Auth::user();
            $stats = $this->categoryService->getCategoryStats($user);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
