<?php

use App\Http\Controllers\Api\AccountSettingsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BorrowController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmiLoanController;
use App\Http\Controllers\Api\ExpensePersonController;
use App\Http\Controllers\Api\SupportTicketController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::get('/tokens', [AuthController::class, 'tokens']);
        Route::post('/revoke-token', [AuthController::class, 'revokeToken']);
    });

    // Category routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/all', [CategoryController::class, 'all']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/stats', [CategoryController::class, 'stats']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    // Expense People routes
    Route::prefix('expense-people')->group(function () {
        Route::get('/', [ExpensePersonController::class, 'index']);
        Route::get('/all', [ExpensePersonController::class, 'all']);
        Route::post('/', [ExpensePersonController::class, 'store']);
        Route::get('/search', [ExpensePersonController::class, 'search']);
        Route::get('/stats', [ExpensePersonController::class, 'stats']);
        Route::get('/with-transaction-counts', [ExpensePersonController::class, 'withTransactionCounts']);
        Route::get('/{id}', [ExpensePersonController::class, 'show']);
        Route::put('/{id}', [ExpensePersonController::class, 'update']);
        Route::delete('/{id}', [ExpensePersonController::class, 'destroy']);
    });

    // Wallet routes
    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::get('/all', [WalletController::class, 'all']);
        Route::post('/', [WalletController::class, 'store']);
        Route::get('/stats', [WalletController::class, 'stats']);
        Route::get('/balance-summary', [WalletController::class, 'balanceSummary']);
        Route::get('/wallet-types', [WalletController::class, 'walletTypes']);
        Route::get('/currencies', [WalletController::class, 'currencies']);
        Route::get('/by-currency/{currencyId}', [WalletController::class, 'byCurrency']);
        Route::post('/transfer', [WalletController::class, 'transfer']);
        Route::get('/{id}', [WalletController::class, 'show']);
        Route::put('/{id}', [WalletController::class, 'update']);
        Route::delete('/{id}', [WalletController::class, 'destroy']);
    });

    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/all', [TransactionController::class, 'all']);
        Route::post('/', [TransactionController::class, 'store']);
        Route::get('/stats', [TransactionController::class, 'stats']);
        Route::get('/by-category', [TransactionController::class, 'byCategory']);
        Route::get('/monthly-summary', [TransactionController::class, 'monthlySummary']);
        Route::get('/form-data', [TransactionController::class, 'formData']);
        Route::post('/upload-attachment', [TransactionController::class, 'uploadAttachment']);
        Route::post('/save-camera-image', [TransactionController::class, 'saveCameraImage']);
        Route::delete('/delete-attachment', [TransactionController::class, 'deleteAttachment']);
        Route::get('/{id}', [TransactionController::class, 'show']);
        Route::put('/{id}', [TransactionController::class, 'update']);
        Route::delete('/{id}', [TransactionController::class, 'destroy']);
        Route::post('/{id}/add-attachment', [TransactionController::class, 'addAttachment']);
        Route::post('/{id}/add-camera-image', [TransactionController::class, 'addCameraImage']);
        Route::delete('/{id}/remove-attachment', [TransactionController::class, 'removeAttachment']);
        Route::get('/{id}/attachment/{index}', [TransactionController::class, 'attachment']);
    });

    // Budget routes
    Route::prefix('budgets')->group(function () {
        Route::get('/', [BudgetController::class, 'index']);
        Route::post('/', [BudgetController::class, 'store']);
        Route::get('/categories', [BudgetController::class, 'getCategories']);
        Route::get('/stats', [BudgetController::class, 'getStats']);
        Route::get('/performance-by-category', [BudgetController::class, 'getPerformanceByCategory']);
        Route::get('/trends', [BudgetController::class, 'getTrends']);
        Route::get('/active', [BudgetController::class, 'getActiveBudgets']);
        Route::post('/check-overlaps', [BudgetController::class, 'checkOverlaps']);
        Route::post('/bulk-delete', [BudgetController::class, 'bulkDelete']);
        Route::get('/{budget}', [BudgetController::class, 'show']);
        Route::put('/{budget}', [BudgetController::class, 'update']);
        Route::delete('/{budget}', [BudgetController::class, 'destroy']);
    });

    // Borrow routes
    Route::prefix('borrows')->group(function () {
        Route::get('/', [BorrowController::class, 'index']);
        Route::post('/', [BorrowController::class, 'store']);
        Route::get('/expense-people', [BorrowController::class, 'getExpensePeople']);
        Route::get('/wallets', [BorrowController::class, 'getWallets']);
        Route::get('/stats', [BorrowController::class, 'getStats']);
        Route::get('/by-status', [BorrowController::class, 'getBorrowsByStatus']);
        Route::post('/bulk-delete', [BorrowController::class, 'bulkDelete']);
        Route::get('/{borrow}', [BorrowController::class, 'show']);
        Route::put('/{borrow}', [BorrowController::class, 'update']);
        Route::delete('/{borrow}', [BorrowController::class, 'destroy']);
        Route::post('/{borrow}/repay', [BorrowController::class, 'repay']);
        Route::put('/{borrow}/repayments/{history}', [BorrowController::class, 'updateRepayment']);
        Route::delete('/{borrow}/repayments/{history}', [BorrowController::class, 'deleteRepayment']);
    });

    // EMI Loan routes
    Route::prefix('emi-loans')->group(function () {
        Route::get('/', [EmiLoanController::class, 'index']);
        Route::post('/', [EmiLoanController::class, 'store']);
        Route::get('/categories', [EmiLoanController::class, 'getCategories']);
        Route::get('/wallets', [EmiLoanController::class, 'getWallets']);
        Route::get('/stats', [EmiLoanController::class, 'getStats']);
        Route::get('/upcoming-schedules', [EmiLoanController::class, 'getUpcomingSchedules']);
        Route::post('/bulk-delete', [EmiLoanController::class, 'bulkDelete']);
        Route::get('/{emiLoan}', [EmiLoanController::class, 'show']);
        Route::put('/{emiLoan}', [EmiLoanController::class, 'update']);
        Route::delete('/{emiLoan}', [EmiLoanController::class, 'destroy']);
        Route::post('/{emiLoan}/schedules/{emiSchedule}/mark-paid', [EmiLoanController::class, 'markSchedulePaid']);
        Route::put('/{emiLoan}/schedules/{emiSchedule}/update-payment', [EmiLoanController::class, 'updateSchedulePayment']);
        Route::post('/{emiLoan}/schedules/{emiSchedule}/mark-unpaid', [EmiLoanController::class, 'markScheduleUnpaid']);
    });

    // Support Ticket routes
    Route::prefix('support-tickets')->group(function () {
        Route::get('/', [SupportTicketController::class, 'index']);
        Route::post('/', [SupportTicketController::class, 'store']);
        Route::get('/users', [SupportTicketController::class, 'getUsers']);
        Route::get('/stats', [SupportTicketController::class, 'getStats']);
        Route::get('/by-status', [SupportTicketController::class, 'getTicketsByStatus']);
        Route::post('/bulk-update', [SupportTicketController::class, 'bulkUpdate']);
        Route::get('/{supportTicket}', [SupportTicketController::class, 'show']);
        Route::delete('/{supportTicket}', [SupportTicketController::class, 'destroy']);
        Route::post('/{supportTicket}/reply', [SupportTicketController::class, 'reply']);
        Route::post('/{supportTicket}/close', [SupportTicketController::class, 'markAsClosed']);
        Route::post('/{supportTicket}/reopen', [SupportTicketController::class, 'markAsReopened']);
        Route::post('/{supportTicket}/recover', [SupportTicketController::class, 'recover']);
    });

    // Account Settings routes
    Route::prefix('account')->group(function () {
        Route::get('/settings', [AccountSettingsController::class, 'getAllSettings']);
        Route::get('/profile', [AccountSettingsController::class, 'getProfile']);
        Route::put('/profile', [AccountSettingsController::class, 'updateProfile']);
        Route::put('/password', [AccountSettingsController::class, 'updatePassword']);
        Route::get('/notifications', [AccountSettingsController::class, 'getNotificationPreferences']);
        Route::put('/notifications', [AccountSettingsController::class, 'updateNotificationPreferences']);
        Route::get('/security', [AccountSettingsController::class, 'getAccountSecurity']);
        Route::get('/activity', [AccountSettingsController::class, 'getAccountActivity']);
        Route::get('/config-options', [AccountSettingsController::class, 'getConfigOptions']);
        Route::delete('/delete', [AccountSettingsController::class, 'deleteAccount']);
    });

    // Legacy user route for backward compatibility
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
