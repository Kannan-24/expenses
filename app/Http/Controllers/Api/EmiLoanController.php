<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmiLoan;
use App\Models\EmiSchedule;
use App\Services\EmiLoanService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmiLoanController extends Controller
{
    protected $emiLoanService;

    public function __construct(EmiLoanService $emiLoanService)
    {
        $this->middleware('auth:sanctum');
        $this->emiLoanService = $emiLoanService;
    }

    /**
     * Display a listing of EMI loans
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'search', 'category_id', 'status', 'loan_type', 
                'start_date', 'end_date', 'min_amount', 'max_amount',
                'is_auto_deduct', 'sort_by', 'sort_order', 'per_page'
            ]);
            
            $emiLoans = $this->emiLoanService->getPaginatedEmiLoans(Auth::id(), $filters);
            
            return response()->json([
                'success' => true,
                'data' => $emiLoans,
                'message' => 'EMI loans retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve EMI loans: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve EMI loans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's categories for EMI loan creation
     * 
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = $this->emiLoanService->getUserCategories(Auth::id());
            
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
     * Get user's active wallets for EMI loan creation
     * 
     * @return JsonResponse
     */
    public function getWallets(): JsonResponse
    {
        try {
            $wallets = $this->emiLoanService->getUserWallets(Auth::id());
            
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
     * Store a newly created EMI loan
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'tenure_months' => 'required|integer|min:1',
            'monthly_emi' => 'nullable|numeric|min:0',
            'is_auto_deduct' => 'boolean',
            'loan_type' => 'in:fixed,reducing_balance',
            'status' => 'in:active,closed,cancelled',
            'default_wallet_id' => 'nullable|exists:wallets,id'
        ]);

        try {
            $emiLoan = $this->emiLoanService->createEmiLoan(Auth::id(), $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $emiLoan,
                'message' => 'EMI loan created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create EMI loan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create EMI loan',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified EMI loan with schedules
     * 
     * @param EmiLoan $emiLoan
     * @param Request $request
     * @return JsonResponse
     */
    public function show(EmiLoan $emiLoan, Request $request): JsonResponse
    {
        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            
            $perPage = $request->get('per_page', 10);
            $data = $this->emiLoanService->getEmiLoanWithSchedules($emiLoan, $perPage);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'EMI loan retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve EMI loan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve EMI loan',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Update the specified EMI loan
     * 
     * @param Request $request
     * @param EmiLoan $emiLoan
     * @return JsonResponse
     */
    public function update(Request $request, EmiLoan $emiLoan): JsonResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'tenure_months' => 'required|integer|min:1',
            'monthly_emi' => 'nullable|numeric|min:0',
            'is_auto_deduct' => 'boolean',
            'loan_type' => 'in:fixed,reducing_balance',
            'status' => 'in:active,closed,cancelled',
            'default_wallet_id' => 'nullable|exists:wallets,id'
        ]);

        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            
            $updatedEmiLoan = $this->emiLoanService->updateEmiLoan($emiLoan, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $updatedEmiLoan,
                'message' => 'EMI loan updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update EMI loan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update EMI loan',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Remove the specified EMI loan
     * 
     * @param EmiLoan $emiLoan
     * @return JsonResponse
     */
    public function destroy(EmiLoan $emiLoan): JsonResponse
    {
        try {
            $this->emiLoanService->validateOwnership($emiLoan, Auth::id());
            
            $this->emiLoanService->deleteEmiLoan($emiLoan);
            
            return response()->json([
                'success' => true,
                'message' => 'EMI loan deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete EMI loan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete EMI loan',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 500);
        }
    }

    /**
     * Mark EMI schedule as paid
     * 
     * @param Request $request
     * @param EmiLoan $emiLoan
     * @param EmiSchedule $emiSchedule
     * @return JsonResponse
     */
    public function markSchedulePaid(Request $request, EmiLoan $emiLoan, EmiSchedule $emiSchedule): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'paid_amount' => 'required|numeric|min:0',
            'paid_date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $this->emiLoanService->validateScheduleOwnership($emiLoan, $emiSchedule, Auth::id());
            
            $updatedSchedule = $this->emiLoanService->markSchedulePaid($emiLoan, $emiSchedule, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => [
                    'schedule' => $updatedSchedule,
                    'emi_loan' => $emiLoan->fresh(['category'])
                ],
                'message' => 'EMI payment recorded successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to record EMI payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to record EMI payment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Update EMI schedule payment
     * 
     * @param Request $request
     * @param EmiLoan $emiLoan
     * @param EmiSchedule $emiSchedule
     * @return JsonResponse
     */
    public function updateSchedulePayment(Request $request, EmiLoan $emiLoan, EmiSchedule $emiSchedule): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'paid_amount' => 'required|numeric|min:0',
            'paid_date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $this->emiLoanService->validateScheduleOwnership($emiLoan, $emiSchedule, Auth::id());
            
            if ($emiSchedule->status !== 'paid') {
                throw new \Exception('Schedule must be marked as paid before updating payment details.');
            }
            
            $updatedSchedule = $this->emiLoanService->updateSchedulePayment($emiLoan, $emiSchedule, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => [
                    'schedule' => $updatedSchedule,
                    'emi_loan' => $emiLoan->fresh(['category'])
                ],
                'message' => 'EMI payment updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update EMI payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update EMI payment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Mark EMI schedule as unpaid
     * 
     * @param EmiLoan $emiLoan
     * @param EmiSchedule $emiSchedule
     * @return JsonResponse
     */
    public function markScheduleUnpaid(EmiLoan $emiLoan, EmiSchedule $emiSchedule): JsonResponse
    {
        try {
            $this->emiLoanService->validateScheduleOwnership($emiLoan, $emiSchedule, Auth::id());
            
            if ($emiSchedule->status !== 'paid') {
                throw new \Exception('Schedule is not marked as paid.');
            }
            
            $updatedSchedule = $this->emiLoanService->markScheduleUnpaid($emiLoan, $emiSchedule);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'schedule' => $updatedSchedule,
                    'emi_loan' => $emiLoan->fresh(['category'])
                ],
                'message' => 'EMI payment reversed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to reverse EMI payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reverse EMI payment',
                'error' => $e->getMessage()
            ], $e->getCode() === 403 ? 403 : 422);
        }
    }

    /**
     * Get upcoming EMI schedules
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getUpcomingSchedules(Request $request): JsonResponse
    {
        try {
            $notificationDays = $request->get('notification_days', 3);
            $upcomingSchedules = $this->emiLoanService->getUpcomingSchedules(Auth::id(), $notificationDays);
            
            return response()->json([
                'success' => true,
                'data' => $upcomingSchedules,
                'message' => 'Upcoming schedules retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve upcoming schedules: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve upcoming schedules',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get EMI loan statistics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            $params = $request->only(['start_date', 'end_date']);
            $stats = $this->emiLoanService->getEmiLoanStats(Auth::id(), $params);
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'EMI loan statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve EMI loan statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve EMI loan statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete EMI loans
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'loan_ids' => 'required|array|min:1',
            'loan_ids.*' => 'exists:emi_loans,id'
        ]);

        try {
            $deletedCount = $this->emiLoanService->bulkDeleteEmiLoans(Auth::id(), $request->loan_ids);
            
            return response()->json([
                'success' => true,
                'data' => ['deleted_count' => $deletedCount],
                'message' => "Successfully deleted {$deletedCount} EMI loan(s)"
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete EMI loans: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete EMI loans',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
