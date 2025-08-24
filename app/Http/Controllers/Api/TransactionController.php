<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->middleware('auth:sanctum');
        $this->transactionService = $transactionService;
    }

    /**
     * Get paginated transactions with filters
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
                'search' => 'nullable|string|max:255',
                'filter' => 'nullable|in:7days,15days,1month',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'category' => 'nullable|integer|exists:categories,id',
                'person' => 'nullable|integer|exists:expense_people,id',
                'type' => 'nullable|in:income,expense',
                'wallet' => 'nullable|integer|exists:wallets,id',
            ]);

            $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'category', 'person', 'type', 'wallet']);
            $perPage = $request->get('per_page', 15);

            $transactions = $this->transactionService->getPaginatedTransactions(Auth::id(), $filters, $perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'transactions' => $transactions->items(),
                    'pagination' => [
                        'current_page' => $transactions->currentPage(),
                        'last_page' => $transactions->lastPage(),
                        'per_page' => $transactions->perPage(),
                        'total' => $transactions->total(),
                        'from' => $transactions->firstItem(),
                        'to' => $transactions->lastItem(),
                    ]
                ],
                'message' => 'Transactions retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all transactions without pagination
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'filter' => 'nullable|in:7days,15days,1month',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'category' => 'nullable|integer|exists:categories,id',
                'person' => 'nullable|integer|exists:expense_people,id',
                'type' => 'nullable|in:income,expense',
                'wallet' => 'nullable|integer|exists:wallets,id',
            ]);

            $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'category', 'person', 'type', 'wallet']);
            $transactions = $this->transactionService->getAllTransactions(Auth::id(), $filters);

            return response()->json([
                'success' => true,
                'data' => $transactions,
                'message' => 'All transactions retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new transaction
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'expense_person_id' => 'nullable|exists:expense_people,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'note' => 'nullable|string|max:1000',
                'type' => 'required|in:income,expense',
                'wallet_id' => 'required|exists:wallets,id',
                'attachments.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
                'camera_image' => 'nullable|string',
                'camera_images' => 'nullable|array',
                'camera_images.*' => 'nullable|string',
            ]);

            $data = $request->all();

            // Process uploaded files
            if ($request->hasFile('attachments')) {
                $data['uploaded_files'] = $request->file('attachments');
            }

            $transaction = $this->transactionService->createTransaction(Auth::id(), $data);

            return response()->json([
                'success' => true,
                'data' => $transaction->load(['category', 'person', 'wallet']),
                'message' => ucfirst($request->type) . ' created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get a specific transaction
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $transaction = Transaction::with(['category', 'person', 'wallet'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $transaction,
                'message' => 'Transaction retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update a transaction
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'expense_person_id' => 'nullable|exists:expense_people,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'note' => 'nullable|string|max:1000',
                'type' => 'required|in:income,expense',
                'wallet_id' => 'required|exists:wallets,id',
                'attachments.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
                'removed_attachments' => 'nullable|array',
                'removed_attachments.*' => 'nullable|string',
                'camera_images' => 'nullable|array',
                'camera_images.*' => 'nullable|string',
                'camera_image' => 'nullable|string'
            ]);

            $data = $request->all();

            // Process uploaded files
            if ($request->hasFile('attachments')) {
                $data['uploaded_files'] = $request->file('attachments');
            }

            $updatedTransaction = $this->transactionService->updateTransaction($transaction, $data);

            return response()->json([
                'success' => true,
                'data' => $updatedTransaction->load(['category', 'person', 'wallet']),
                'message' => ucfirst($request->type) . ' updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete a transaction
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            $type = $transaction->type;
            
            $this->transactionService->deleteTransaction($transaction);

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get transaction statistics
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function stats(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'filter' => 'nullable|in:7days,15days,1month',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'category' => 'nullable|integer|exists:categories,id',
                'person' => 'nullable|integer|exists:expense_people,id',
                'type' => 'nullable|in:income,expense',
                'wallet' => 'nullable|integer|exists:wallets,id',
            ]);

            $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'category', 'person', 'type', 'wallet']);
            $stats = $this->transactionService->getTransactionStats(Auth::id(), $filters);

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Transaction statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transaction statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get transactions by category
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function byCategory(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'filter' => 'nullable|in:7days,15days,1month',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'type' => 'nullable|in:income,expense',
            ]);

            $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'type']);
            $transactions = $this->transactionService->getTransactionsByCategory(Auth::id(), $filters);

            return response()->json([
                'success' => true,
                'data' => $transactions,
                'message' => 'Transactions by category retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions by category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get monthly transaction summary
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function monthlySummary(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'year' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            ]);

            $year = $request->get('year');
            $summary = $this->transactionService->getMonthlyTransactionSummary(Auth::id(), $year);

            return response()->json([
                'success' => true,
                'data' => $summary,
                'message' => 'Monthly transaction summary retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve monthly summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload attachment via AJAX
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAttachment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
                'transaction_id' => 'nullable|integer|exists:transactions,id',
            ]);

            // Validate transaction ownership if transaction_id is provided
            if ($request->filled('transaction_id')) {
                $transaction = Transaction::where('user_id', Auth::id())
                    ->where('id', $request->transaction_id)
                    ->first();
                
                if (!$transaction) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Transaction not found or access denied'
                    ], 404);
                }
            }

            $attachmentData = $this->transactionService->uploadAttachment($request->file('file'), Auth::id());
            
            // Add transaction_id to the response data if provided
            if ($request->filled('transaction_id')) {
                $attachmentData['transaction_id'] = $request->transaction_id;
            }

            return response()->json([
                'success' => true,
                'data' => $attachmentData,
                'message' => 'File uploaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Save camera image via AJAX
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function saveCameraImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'transaction_id' => 'nullable|integer|exists:transactions,id',
            ]);

            // Validate transaction ownership if transaction_id is provided
            if ($request->filled('transaction_id')) {
                $transaction = Transaction::where('user_id', Auth::id())
                    ->where('id', $request->transaction_id)
                    ->first();
                
                if (!$transaction) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Transaction not found or access denied'
                    ], 404);
                }
            }

            $imageData = $this->transactionService->saveCameraImage($request->image, Auth::id());
            
            // Add transaction_id to the response data if provided
            if ($request->filled('transaction_id')) {
                $imageData['transaction_id'] = $request->transaction_id;
            }

            return response()->json([
                'success' => true,
                'data' => $imageData,
                'message' => 'Photo saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save photo',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete attachment
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAttachment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'path' => 'required|string',
            ]);

            $this->transactionService->deleteAttachmentFile($request->path);

            return response()->json([
                'success' => true,
                'message' => 'Attachment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attachment',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Stream or download an attachment
     * 
     * @param int $id
     * @param int $index
     * @return mixed
     */
    public function attachment(int $id, int $index)
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            return $this->transactionService->streamAttachment($transaction, $index);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Attachment not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get form data for transactions
     * 
     * @return JsonResponse
     */
    public function formData(): JsonResponse
    {
        try {
            $formData = $this->transactionService->getFormData(Auth::id());

            return response()->json([
                'success' => true,
                'data' => $formData,
                'message' => 'Form data retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve form data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add attachment to existing transaction
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function addAttachment(Request $request, int $id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            
            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            ]);

            // Upload the file
            $attachmentData = $this->transactionService->uploadAttachment($request->file('file'), Auth::id());
            
            // Add attachment to existing transaction
            $currentAttachments = $transaction->attachments ?? [];
            $currentAttachments[] = $attachmentData;
            
            $transaction->update([
                'attachments' => $currentAttachments
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'attachment' => $attachmentData,
                    'transaction' => $transaction->load(['category', 'person', 'wallet'])
                ],
                'message' => 'Attachment added to transaction successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add attachment to transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Add camera image to existing transaction
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function addCameraImage(Request $request, int $id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            
            $request->validate([
                'image' => 'required|string',
            ]);

            // Save the camera image
            $imageData = $this->transactionService->saveCameraImage($request->image, Auth::id());
            
            // Add image to existing transaction
            $currentAttachments = $transaction->attachments ?? [];
            $currentAttachments[] = $imageData;
            
            $transaction->update([
                'attachments' => $currentAttachments
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'attachment' => $imageData,
                    'transaction' => $transaction->load(['category', 'person', 'wallet'])
                ],
                'message' => 'Camera image added to transaction successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add camera image to transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove attachment from existing transaction
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function removeAttachment(Request $request, int $id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            
            $request->validate([
                'attachment_path' => 'required|string',
            ]);

            $attachmentPath = $request->attachment_path;
            $currentAttachments = $transaction->attachments ?? [];
            
            // Find and remove the attachment
            $updatedAttachments = array_filter($currentAttachments, function($attachment) use ($attachmentPath) {
                return $attachment['path'] !== $attachmentPath;
            });
            
            // Delete the file from storage
            $this->transactionService->deleteAttachmentFile($attachmentPath);
            
            // Update transaction
            $transaction->update([
                'attachments' => array_values($updatedAttachments)
            ]);

            return response()->json([
                'success' => true,
                'data' => $transaction->load(['category', 'person', 'wallet']),
                'message' => 'Attachment removed from transaction successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove attachment from transaction',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
