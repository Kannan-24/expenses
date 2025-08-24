<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\BorrowHistory;
use App\Services\BorrowService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->middleware('auth:sanctum');
        $this->borrowService = $borrowService;
    }

    /**
     * Display a listing of borrows/lends
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'search', 'type', 'status', 'wallet_id', 'person_id', 
                'start_date', 'end_date', 'min_amount', 'max_amount',
                'sort_by', 'sort_order', 'per_page'
            ]);
            
            $borrows = $this->borrowService->getPaginatedBorrows(Auth::id(), $filters);
            
            return response()->json([
                'success' => true,
                'data' => $borrows,
                'message' => 'Borrows retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve borrows: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve borrows',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's expense people for borrow creation
     * 
     * @return JsonResponse
     */
    public function getExpensePeople(): JsonResponse
    {
        try {
            $people = $this->borrowService->getUserExpensePeople(Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $people,
                'message' => 'Expense people retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve expense people: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve expense people',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's wallets for borrow creation
     * 
     * @return JsonResponse
     */
    public function getWallets(): JsonResponse
    {
        try {
            $wallets = $this->borrowService->getUserWallets(Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $wallets,
                'message' => 'Wallets retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve wallets: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created borrow/lend
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'person_id'  => 'required|exists:expense_people,id',
            'amount'     => 'required|numeric|min:0.01',
            'date'       => 'required|date',
            'borrow_type' => 'required|in:borrowed,lent',
            'wallet_id'  => 'required|exists:wallets,id',
            'note'       => 'nullable|string',
        ]);

        try {
            $borrow = $this->borrowService->createBorrow(Auth::id(), $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $borrow->load(['person', 'wallet.currency']),
                'message' => 'Borrow/Lend created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create borrow: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create borrow/lend',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified borrow with histories
     * 
     * @param Borrow $borrow
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Borrow $borrow, Request $request): JsonResponse
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            
            $perPage = $request->get('per_page', 10);
            $data = $this->borrowService->getBorrowWithHistories($borrow, $perPage);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Borrow retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve borrow: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve borrow',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Update the specified borrow
     * 
     * @param Request $request
     * @param Borrow $borrow
     * @return JsonResponse
     */
    public function update(Request $request, Borrow $borrow): JsonResponse
    {
        $request->validate([
            'person_id'   => 'required|exists:expense_people,id',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'borrow_type' => 'required|in:borrowed,lent',
            'wallet_id'   => 'required|exists:wallets,id',
            'note'        => 'nullable|string',
        ]);

        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            
            $updatedBorrow = $this->borrowService->updateBorrow($borrow, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $updatedBorrow->load(['person', 'wallet.currency']),
                'message' => 'Borrow/Lend updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update borrow: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update borrow/lend',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Remove the specified borrow
     * 
     * @param Borrow $borrow
     * @return JsonResponse
     */
    public function destroy(Borrow $borrow): JsonResponse
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            
            $this->borrowService->deleteBorrow($borrow);
            
            return response()->json([
                'success' => true,
                'message' => 'Borrow/Lend deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete borrow: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete borrow/lend',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Process a repayment for a borrow
     * 
     * @param Request $request
     * @param Borrow $borrow
     * @return JsonResponse
     */
    public function repay(Request $request, Borrow $borrow): JsonResponse
    {
        try {
            $this->borrowService->validateOwnership($borrow, Auth::id());
            
            $maxReturn = $borrow->amount - $borrow->returned_amount;
            $request->validate([
                'repay_amount' => "required|numeric|min:0.01|max:$maxReturn",
                'wallet_id'    => 'required|exists:wallets,id',
                'date'         => 'required|date',
            ]);

            $history = $this->borrowService->processRepayment($borrow, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => [
                    'history' => $history->load(['wallet.currency']),
                    'borrow' => $borrow->fresh(['person', 'wallet.currency'])
                ],
                'message' => 'Repayment recorded successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to process repayment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process repayment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Update a repayment history
     * 
     * @param Request $request
     * @param Borrow $borrow
     * @param BorrowHistory $history
     * @return JsonResponse
     */
    public function updateRepayment(Request $request, Borrow $borrow, BorrowHistory $history): JsonResponse
    {
        try {
            $this->borrowService->validateHistoryOwnership($borrow, $history, Auth::id());
            
            $otherTotal = $borrow->histories()->where('id', '!=', $history->id)->sum('amount');
            $maxAmount = $borrow->amount - $otherTotal;

            $request->validate([
                'amount' => "required|numeric|min:0.01|max:$maxAmount",
                'wallet_id' => 'required|exists:wallets,id',
                'date' => 'required|date',
            ]);

            $updatedHistory = $this->borrowService->updateRepayment($borrow, $history, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => [
                    'history' => $updatedHistory->load(['wallet.currency']),
                    'borrow' => $borrow->fresh(['person', 'wallet.currency'])
                ],
                'message' => 'Repayment updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update repayment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update repayment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Delete a repayment history
     * 
     * @param Borrow $borrow
     * @param BorrowHistory $history
     * @return JsonResponse
     */
    public function deleteRepayment(Borrow $borrow, BorrowHistory $history): JsonResponse
    {
        try {
            $this->borrowService->validateHistoryOwnership($borrow, $history, Auth::id());
            
            $this->borrowService->deleteRepayment($borrow, $history);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'borrow' => $borrow->fresh(['person', 'wallet.currency'])
                ],
                'message' => 'Repayment deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete repayment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete repayment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Get borrow statistics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            $params = $request->only(['start_date', 'end_date']);
            $stats = $this->borrowService->getBorrowStats(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Borrow statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve borrow statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve borrow statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get borrows grouped by status
     * 
     * @return JsonResponse
     */
    public function getBorrowsByStatus(): JsonResponse
    {
        try {
            $borrowsByStatus = $this->borrowService->getBorrowsByStatus(Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $borrowsByStatus,
                'message' => 'Borrows by status retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve borrows by status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve borrows by status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete borrows
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'borrow_ids' => 'required|array|min:1',
            'borrow_ids.*' => 'exists:borrows,id'
        ]);

        try {
            $deletedCount = $this->borrowService->bulkDeleteBorrows(Auth::id(), $request->borrow_ids);
            
            return response()->json([
                'success' => true,
                'data' => ['deleted_count' => $deletedCount],
                'message' => "Successfully deleted {$deletedCount} borrow(s)"
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete borrows: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete borrows',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
