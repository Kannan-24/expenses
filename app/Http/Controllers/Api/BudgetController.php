<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Services\BudgetService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    protected $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->middleware('auth:sanctum');
        $this->budgetService = $budgetService;
    }

    /**
     * Display a listing of budgets
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $request->only([
                'search', 'category_id', 'start_date', 'end_date', 
                'frequency', 'status', 'sort_by', 'sort_order', 'per_page'
            ]);
            
            $budgets = $this->budgetService->getPaginatedBudgets(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $budgets,
                'message' => 'Budgets retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve budgets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve budgets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user categories for budget creation
     * 
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = $this->budgetService->getUserCategories(Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categories retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve categories: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created budget
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'roll_over' => 'boolean',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
        ]);

        try {
            $budgetData = $request->all();
            $userId = Auth::id();
            
            $budget = $this->budgetService->createBudget($userId, $budgetData);
            
            return response()->json([
                'success' => true,
                'data' => $budget,
                'message' => 'Budget created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create budget: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create budget',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified budget with histories
     * 
     * @param Budget $budget
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Budget $budget, Request $request): JsonResponse
    {
        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            
            $perPage = $request->get('per_page', 10);
            $data = $this->budgetService->getBudgetWithHistories($budget, $perPage);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Budget retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve budget: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve budget',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Update the specified budget
     * 
     * @param Request $request
     * @param Budget $budget
     * @return JsonResponse
     */
    public function update(Request $request, Budget $budget): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'roll_over' => 'boolean',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
        ]);

        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            
            $updatedBudget = $this->budgetService->updateBudget($budget, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $updatedBudget,
                'message' => 'Budget updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update budget: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update budget',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Remove the specified budget
     * 
     * @param Budget $budget
     * @return JsonResponse
     */
    public function destroy(Budget $budget): JsonResponse
    {
        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            
            $this->budgetService->deleteBudget($budget);
            
            return response()->json([
                'success' => true,
                'message' => 'Budget deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete budget: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete budget',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Get budget statistics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            $params = $request->only(['start_date', 'end_date', 'category_id']);
            $stats = $this->budgetService->getBudgetStats(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Budget statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve budget statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve budget statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get budget performance by category
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getPerformanceByCategory(Request $request): JsonResponse
    {
        try {
            $params = $request->only(['start_date', 'end_date']);
            $performance = $this->budgetService->getBudgetPerformanceByCategory(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $performance,
                'message' => 'Budget performance retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve budget performance: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve budget performance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get budget trends
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getTrends(Request $request): JsonResponse
    {
        try {
            $params = $request->only(['period', 'category_id']);
            $trends = $this->budgetService->getBudgetTrends(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $trends,
                'message' => 'Budget trends retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve budget trends: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve budget trends',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active budgets for the current user
     * 
     * @return JsonResponse
     */
    public function getActiveBudgets(): JsonResponse
    {
        try {
            $activeBudgets = $this->budgetService->getActiveBudgets(Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $activeBudgets,
                'message' => 'Active budgets retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve active budgets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve active budgets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check for budget overlaps
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function checkOverlaps(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget_id' => 'nullable|exists:budgets,id'
        ]);

        try {
            $overlaps = $this->budgetService->checkBudgetOverlap(
                Auth::id(),
                $request->category_id,
                $request->start_date,
                $request->end_date,
                $request->budget_id
            );
            
            return response()->json([
                'success' => true,
                'data' => [
                    'has_overlaps' => !empty($overlaps),
                    'overlapping_budgets' => $overlaps
                ],
                'message' => 'Budget overlap check completed'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to check budget overlaps: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to check budget overlaps',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete budgets
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'budget_ids' => 'required|array|min:1',
            'budget_ids.*' => 'exists:budgets,id'
        ]);

        try {
            $deletedCount = $this->budgetService->bulkDeleteBudgets(Auth::id(), $request->budget_ids);
            
            return response()->json([
                'success' => true,
                'data' => ['deleted_count' => $deletedCount],
                'message' => "Successfully deleted {$deletedCount} budget(s)"
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete budgets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete budgets',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
