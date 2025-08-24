<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $transactionService;

    /**
     * Create a new controller instance.
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->middleware('auth');
        $this->middleware('can:manage transactions');
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'category', 'person', 'type', 'wallet']);
        
        $transactions = $this->transactionService->getPaginatedTransactions(Auth::id(), $filters, 10);
        $formData = $this->transactionService->getFormData(Auth::id());

        // Attach filter values to the pagination links
        $transactions->appends($request->except('page'));

        return view('transactions.index', array_merge(compact('transactions'), $formData));
    }

    /**
     * Show the form for creating a new resource.
     * 
     *  @return \Illuminate\View\View
     */
    public function create()
    {
        $formData = $this->transactionService->getFormData(Auth::id());
        return view('transactions.create', $formData);
    }

    /**
     * Store a newly created resource in storage.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'        => 'nullable|exists:categories,id',
            'expense_person_id'  => 'nullable|exists:expense_people,id',
            'amount'             => 'required|numeric|min:0',
            'date'               => 'required|date',
            'note'               => 'nullable|string',
            'type'               => 'required|in:income,expense',
            'wallet_id'          => 'required|exists:wallets,id',
            'attachments.*'      => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120', // 5MB max
            'camera_image'       => 'nullable|string', // legacy single camera image (kept for backwards compat)
            'camera_images'      => 'nullable|array',
            'camera_images.*'    => 'nullable|string', // multiple base64 camera images
        ]);

        try {
            $data = $request->all();
            
            // Process uploaded files
            if ($request->hasFile('attachments')) {
                $data['uploaded_files'] = $request->file('attachments');
            }

            // Add UTM tracking if present
            if ($request->hasAny(['utm_source', 'utm_medium', 'utm_campaign'])) {
                $data['utm_tracking'] = $request->only(['utm_source', 'utm_medium', 'utm_campaign']);
            }

            $transaction = $this->transactionService->createTransaction(Auth::id(), $data);

            return redirect()->route('transactions.index')->with(
                'success',
                ucfirst($request->type) . " added successfully. Wallet balance updated."
            );
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $this->transactionService->validateOwnership($transaction, Auth::id());
        $formData = $this->transactionService->getFormData(Auth::id());
        return view('transactions.edit', array_merge(compact('transaction'), $formData));
    }

    /**
     * Update the specified resource in storage.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *   @param  \App\Models\Transaction  $transaction
     *   @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'category_id'        => 'nullable|exists:categories,id',
            'expense_person_id'  => 'nullable|exists:expense_people,id',
            'amount'             => 'required|numeric|min:0',
            'date'               => 'required|date',
            'note'               => 'nullable|string',
            'type'               => 'required|in:income,expense',
            'wallet_id'          => 'required|exists:wallets,id',
            'attachments.*'      => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120', // 5MB max
            'removed_attachments.*' => 'nullable|string', // paths of removed attachments
            'camera_images'      => 'nullable|array',
            'camera_images.*'    => 'nullable|string',
            'camera_image'       => 'nullable|string'
        ]);

        try {
            $this->transactionService->validateOwnership($transaction, Auth::id());
            
            $data = $request->all();
            
            // Process uploaded files
            if ($request->hasFile('attachments')) {
                $data['uploaded_files'] = $request->file('attachments');
            }

            $updatedTransaction = $this->transactionService->updateTransaction($transaction, $data);

            return redirect()->route('transactions.index')->with(
                'success',
                ucfirst($request->type) . " updated successfully. Wallet balance adjusted."
            );
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     * 
     *   @param  \App\Models\Transaction  $transaction
     *   @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        $this->transactionService->validateOwnership($transaction, Auth::id());
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        try {
            $this->transactionService->validateOwnership($transaction, Auth::id());
            $type = $transaction->type;
            $this->transactionService->deleteTransaction($transaction);

            return redirect()->route('transactions.index')->with(
                'success',
                ucfirst($type) . " deleted successfully. Balance restored."
            );
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Upload attachment files via AJAX
     */
    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
        ]);

        try {
            $attachmentData = $this->transactionService->uploadAttachment($request->file('file'), Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $attachmentData,
                'message' => 'File uploaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Save camera image via AJAX
     */
    public function saveCameraImage(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        try {
            $imageData = $this->transactionService->saveCameraImage($request->image, Auth::id());
            
            return response()->json([
                'success' => true,
                'data' => $imageData,
                'message' => 'Photo saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        try {
            $this->transactionService->deleteAttachmentFile($request->path);
            
            return response()->json([
                'success' => true,
                'message' => 'Attachment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Stream or download an attachment ensuring ownership.
     */
    public function attachment(Transaction $transaction, $index)
    {
        try {
            $this->transactionService->validateOwnership($transaction, Auth::id());
            return $this->transactionService->streamAttachment($transaction, $index);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
