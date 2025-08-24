<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpensePerson;
use App\Services\ExpensePersonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ExpensePersonController extends Controller
{
    protected ExpensePersonService $expensePersonService;

    public function __construct(ExpensePersonService $expensePersonService)
    {
        $this->expensePersonService = $expensePersonService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of expense people
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $search = $request->get('search');
            $perPage = $request->get('per_page', 12);

            // Validate per_page parameter
            if ($perPage > 100) {
                $perPage = 100; // Limit to prevent abuse
            }

            $expensePeople = $this->expensePersonService->getPaginatedExpensePeople($user, $search, $perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'expense_people' => $expensePeople->items(),
                    'pagination' => [
                        'current_page' => $expensePeople->currentPage(),
                        'per_page' => $expensePeople->perPage(),
                        'total' => $expensePeople->total(),
                        'last_page' => $expensePeople->lastPage(),
                        'has_more_pages' => $expensePeople->hasMorePages(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense people',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all expense people (without pagination)
     */
    public function all(): JsonResponse
    {
        try {
            $user = Auth::user();
            $expensePeople = $this->expensePersonService->getUserExpensePeople($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'expense_people' => $expensePeople
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense people',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created expense person
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if expense person name is unique for this user
            if (!$this->expensePersonService->isExpensePersonNameUniqueForUser($request->name, $user)) {
                throw ValidationException::withMessages([
                    'name' => ['A person with this name already exists.']
                ]);
            }

            $expensePerson = $this->expensePersonService->createExpensePerson($user, $request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Expense person created successfully',
                'data' => [
                    'expense_person' => $expensePerson
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
                'message' => 'Failed to create expense person',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified expense person
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $expensePerson = $this->expensePersonService->findExpensePersonForUser($id, $user);

            if (!$expensePerson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Expense person not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'expense_person' => $expensePerson
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense person',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified expense person
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $expensePerson = $this->expensePersonService->findExpensePersonForUser($id, $user);

            if (!$expensePerson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Expense person not found'
                ], 404);
            }

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if expense person name is unique for this user (excluding current expense person)
            if (!$this->expensePersonService->isExpensePersonNameUniqueForUser($request->name, $user, $expensePerson->id)) {
                throw ValidationException::withMessages([
                    'name' => ['A person with this name already exists.']
                ]);
            }

            $updatedExpensePerson = $this->expensePersonService->updateExpensePerson($expensePerson, $request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Expense person updated successfully',
                'data' => [
                    'expense_person' => $updatedExpensePerson
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
                'message' => 'Failed to update expense person',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified expense person
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $expensePerson = $this->expensePersonService->findExpensePersonForUser($id, $user);

            if (!$expensePerson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Expense person not found'
                ], 404);
            }

            // Check if expense person has associated transactions
            if ($expensePerson->transactions()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete expense person that has associated transactions'
                ], 409);
            }

            $this->expensePersonService->deleteExpensePerson($expensePerson);

            return response()->json([
                'success' => true,
                'message' => 'Expense person deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete expense person',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search expense people
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'query' => 'required|string|max:255',
                'limit' => 'integer|min:1|max:50'
            ]);

            $query = $request->get('query');
            $limit = $request->get('limit', 10);

            $expensePeople = $this->expensePersonService->searchExpensePeople($user, $query, $limit);

            return response()->json([
                'success' => true,
                'data' => [
                    'expense_people' => $expensePeople
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
                'message' => 'Failed to search expense people',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get expense person statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $user = Auth::user();
            $stats = $this->expensePersonService->getExpensePersonStats($user);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense person statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get expense people with transaction counts
     */
    public function withTransactionCounts(): JsonResponse
    {
        try {
            $user = Auth::user();
            $expensePeople = $this->expensePersonService->getExpensePeopleWithTransactionCount($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'expense_people' => $expensePeople
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense people with transaction counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
