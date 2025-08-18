<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetHistory;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\ExpensePerson;
use App\Models\User;
use App\Models\UserAnalytics;
use App\Models\Wallet;
use App\Models\WalletType;
use App\Services\AttachmentService;
use App\Services\StreakService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $attachmentService;

    /**
     * Create a new controller instance.
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->middleware('auth');
        $this->middleware('can:manage transactions');
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     * 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::where('user_id', Auth::id())->get();
        $people = ExpensePerson::where('user_id', Auth::id())->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();

        $query = Transaction::with(['category', 'person'])->where('user_id', Auth::id());

        // Search by person, category, or note
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('person', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        }

        // Date filters
        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '1month') {
            $query->where('date', '>=', now()->subMonth());
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Person filter
        if ($request->filled('person')) {
            $query->where('expense_person_id', $request->person);
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Wallet filter
        if ($request->filled('wallet')) {
            $query->where('wallet_id', $request->wallet);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(10);

        // Attach filter values to the pagination links
        $transactions->appends($request->except('page'));

        return view('transactions.index', compact('transactions', 'categories', 'people', 'wallets'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     *  @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();
        $currencies = Currency::get();

        return view('transactions.create', compact('categories', 'people', 'wallets', 'walletTypes', 'currencies'));
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

        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

        // Check wallet balance
        if ($request->type === 'expense' && $wallet->balance < $request->amount) {
            return redirect()->back()->withErrors(['wallet' => 'Insufficient balance in the selected wallet.']);
        }

        // Handle attachments
        $attachments = [];
        
        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $attachmentData = $this->attachmentService->uploadAttachment($file, Auth::id());
                    $attachments[] = $attachmentData;
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        // Handle single legacy camera image
        if ($request->filled('camera_image')) {
            try {
                $cameraImageData = $this->attachmentService->saveBase64Image($request->camera_image, Auth::id());
                $attachments[] = $cameraImageData;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['camera_image' => $e->getMessage()])->withInput();
            }
        }

        // Handle multiple camera images
        if ($request->filled('camera_images')) {
            foreach ($request->camera_images as $idx => $base64Image) {
                if (!$base64Image) { continue; }
                try {
                    $cameraImageData = $this->attachmentService->saveBase64Image($base64Image, Auth::id());
                    $attachments[] = $cameraImageData;
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors([
                        'camera_images.' . $idx => $e->getMessage()
                    ])->withInput();
                }
            }
        }

        // Adjust wallet balance based on transaction type
        $wallet->balance += ($request->type === 'income') ? $request->amount : -$request->amount;
        $wallet->save();

        if ($request->type == 'expense' && $request->category_id) {
            $this->updateBudgetHistory($request->category_id, $request->amount, $request->date);
        }

        $user = Auth::user();

        $transaction = Transaction::create([
            'user_id'           => $user->id,
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'         => $request->wallet_id,
            'attachments'       => $attachments,
        ]);

        $streakInfo = StreakService::updateUserStreak($user);

        // Track if came from email
        if ($request->hasAny(['utm_source', 'utm_medium', 'utm_campaign'])) {
            UserAnalytics::trackFromRequest(
            $request, 
                $user->id, 
                'transaction_created',
                [
                    'transaction_id' => $transaction->id,
                    'transaction_type' => $request->type,
                    'amount' => $request->amount,
                    'streak_info' => $streakInfo
                ]
            );
        }

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " added successfully. " . ucfirst($request->payment_method) . " balance updated."
        );
    }

    /**
     * Show the form for editing the specified resource.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $categories = Category::all();
        $people = ExpensePerson::where('user_id', Auth::id())->get();

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $walletTypes = WalletType::get();
        $currencies = Currency::get();

        return view('transactions.edit', compact('transaction', 'categories', 'people', 'wallets', 'walletTypes', 'currencies'));
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
        $this->authorizeTransaction($transaction);

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

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $request->wallet_id)
            ->first();

        // Rollback previous transaction amount from wallet
        $wallet->balance += ($transaction->type === 'income') ? -$transaction->amount : $transaction->amount;

        // Apply new transaction amount to wallet
        if ($request->type == 'expense' && $wallet->balance < $request->amount) {
            return redirect()->back()->withErrors(['wallet' => 'Insufficient balance in the selected wallet.'])->withInput();
        }

        $wallet->balance += ($request->type === 'income') ? $request->amount : -$request->amount;
        $wallet->save();

        if ($transaction->type === 'expense' && $transaction->category_id) {
            $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date);
        }

        if ($request->type == 'expense' && $request->category_id) {
            $this->updateBudgetHistory($request->category_id, $request->amount, $request->date);
        }

        // Handle attachments
        $currentAttachments = $transaction->attachments ?? [];
        
        // Remove deleted attachments
        if ($request->has('removed_attachments')) {
            foreach ($request->removed_attachments as $removedPath) {
                // Remove from current attachments array
                $currentAttachments = array_filter($currentAttachments, function($attachment) use ($removedPath) {
                    return $attachment['path'] !== $removedPath;
                });
                
                // Delete file from storage
                $this->attachmentService->deleteAttachment($removedPath);
            }
        }
        
        // Add new attachments (uploaded files)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $attachmentData = $this->attachmentService->uploadAttachment($file, Auth::id());
                    $currentAttachments[] = $attachmentData;
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        // Add new camera images (multiple)
        if ($request->filled('camera_images')) {
            foreach ($request->camera_images as $idx => $base64Image) {
                if (!$base64Image) { continue; }
                try {
                    $cameraImageData = $this->attachmentService->saveBase64Image($base64Image, Auth::id());
                    $currentAttachments[] = $cameraImageData;
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors([
                        'camera_images.' . $idx => $e->getMessage()
                    ])->withInput();
                }
            }
        }

        // Single legacy camera image
        if ($request->filled('camera_image')) {
            try {
                $cameraImageData = $this->attachmentService->saveBase64Image($request->camera_image, Auth::id());
                $currentAttachments[] = $cameraImageData;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['camera_image' => $e->getMessage()])->withInput();
            }
        }

        $transaction->update([
            'category_id'       => $request->category_id,
            'expense_person_id' => $request->expense_person_id,
            'amount'            => $request->amount,
            'date'              => $request->date,
            'note'              => $request->note,
            'type'              => $request->type,
            'wallet_id'         => $request->wallet_id,
            'attachments'       => array_values($currentAttachments), // Re-index array
        ]);

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($request->type) . " updated successfully. Wallet balance adjusted."
        );
    }

    /**
     * Display the specified resource.
     * 
     *   @param  \App\Models\Transaction  $transaction
     *   @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);
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
        $this->authorizeTransaction($transaction);

        $wallet = Wallet::where('user_id', Auth::id())
            ->where('id', $transaction->wallet_id)
            ->first();

        if ($transaction->type === 'income') {
            $wallet->balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $wallet->balance += $transaction->amount;

            if ($transaction->category_id) {
                $this->updateBudgetHistory($transaction->category_id, -$transaction->amount, $transaction->date);
            }
        }
        $wallet->save();
        $transaction->delete();

        return redirect()->route('transactions.index')->with(
            'success',
            ucfirst($transaction->type) . " deleted successfully. Balance restored."
        );
    }

    /**
     * Authorize the user has access to the transaction.
     * 
     *  @param  \App\Models\Transaction  $transaction
     *  @return void
     */
    protected function authorizeTransaction(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }


    /**
     * Update budget history based on the transaction.
     * 
     *  @param int $categoryId
     *  @param float $amount
     *  @param string $date
     *  @return void
     */
    protected function updateBudgetHistory($categoryId, $amount, $date)
    {
        $userId = Auth::id();

        $budget = Budget::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        if (!$budget) return;

        $budgetHistory = BudgetHistory::where('budget_id', $budget->id)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        if (!$budgetHistory) {
            // Calculate period aligned to budget's plan start_date
            $budgetStart = Carbon::parse($budget->start_date);
            $periodStart = match ($budget->frequency) {
                'daily' => Carbon::parse($date)->startOfDay(),
                'weekly' => Carbon::parse($budgetStart)->copy()->startOfWeek()->addWeeks(
                    Carbon::parse($budgetStart)->diffInWeeks($date)
                ),
                'monthly' => Carbon::parse($budgetStart)->copy()->startOfMonth()->addMonthsNoOverflow(
                    Carbon::parse($budgetStart)->diffInMonths($date)
                ),
                'yearly' => Carbon::parse($budgetStart)->copy()->startOfYear()->addYears(
                    Carbon::parse($budgetStart)->diffInYears($date)
                ),
            };

            $periodEnd = match ($budget->frequency) {
                'daily' => $periodStart->copy()->endOfDay(),
                'weekly' => $periodStart->copy()->endOfWeek(),
                'monthly' => $periodStart->copy()->endOfMonth(),
                'yearly' => $periodStart->copy()->endOfYear(),
            };

            // Fetch previous history (if exists)
            $previousHistory = BudgetHistory::where('budget_id', $budget->id)
                ->where('end_date', '<', $periodStart)
                ->latest('end_date')
                ->first();

            $rollOverAmount = 0;

            if ($previousHistory && $budget->roll_over) {
                $unspent = $previousHistory->allocated_amount + $previousHistory->roll_over_amount - $previousHistory->spent_amount;
                $rollOverAmount = max(0, $unspent);
            }

            BudgetHistory::create([
                'budget_id'        => $budget->id,
                'allocated_amount' => $budget->amount,
                'roll_over_amount' => $rollOverAmount,
                'spent_amount'     => $amount,
                'start_date'       => $periodStart,
                'end_date'         => $periodEnd,
                'status'           => 'active',
            ]);
        } else {
            $budgetHistory->spent_amount += $amount;
            $budgetHistory->save();
        }

        // Notify user if budget is exceeded above 100% or 90%
        if ($budgetHistory->allocated_amount <= 0) {
            return;
        }
        $exceededPercent =  ($budgetHistory->spent_amount / $budgetHistory->allocated_amount) * 100;
        $user = User::find($userId);
        if ($exceededPercent >= 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
        } elseif ($exceededPercent >= 90 && $exceededPercent < 100) {
            $user->notify(new \App\Notifications\BudgetLimit($budget, $exceededPercent));
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
            $attachmentData = $this->attachmentService->uploadAttachment($request->file('file'), Auth::id());
            
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
            $imageData = $this->attachmentService->saveBase64Image($request->image, Auth::id());
            
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
            $this->attachmentService->deleteAttachment($request->path);
            
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
        $this->authorizeTransaction($transaction);
        $attachments = $transaction->attachments ?? [];
        if (!isset($attachments[$index])) {
            abort(404);
        }
        $att = $attachments[$index];
        $path = $att['path'] ?? null;
        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404);
        }
        $mime = $att['mime_type'] ?? 'application/octet-stream';
        $filename = $att['original_name'] ?? basename($path);
        $stream = \Illuminate\Support\Facades\Storage::disk('public')->readStream($path);
        return response()->stream(function() use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => str_starts_with($mime, 'image/') ? 'inline; filename="'.$filename.'"' : 'attachment; filename="'.$filename.'"'
        ]);
    }
}
