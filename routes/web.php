<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpensePersonController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTypeController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\EmiLoanController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\LandingController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/terms-of-service', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');

Route::middleware(['auth'])->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');
});

Route::middleware(['auth', 'verified', EnsureUserIsOnboarded::class])->group(function () {
    Route::post('/store-token', [FCMController::class, 'storeToken'])->name('store.token');
    Route::post('/send-notification', [FCMController::class, 'sendNotification'])->name('send.notification');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chart-data', [DashboardController::class, 'getChartData'])->name('chart.data');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('password.confirm');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.update.photo');

    Route::get('/account-settings', [AccountSettingsController::class, 'index'])->name('account.settings');
    Route::patch('/account-settings/password', [AccountSettingsController::class, 'updatePassword'])->name('account.update.password');
    Route::delete('/account-settings/delete', [AccountSettingsController::class, 'destroy'])->name('account.destroy');

    Route::get('/account/activity', [ActivityController::class, 'index'])->name('account.activity');

    Route::post('/notifications/{id}/read', function ($id) {
        Auth::user()->notifications()->where('id', $id)->first()?->markAsRead();
        return back();
    })->name('notifications.read');
    Route::post('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllAsRead');

    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{transaction}/attachment/{index}', [TransactionController::class, 'attachment'])->name('transactions.attachment');

    // Transaction attachment routes
    Route::post('transactions/upload-attachment', [TransactionController::class, 'uploadAttachment'])->name('transactions.upload-attachment');
    Route::post('transactions/save-camera-image', [TransactionController::class, 'saveCameraImage'])->name('transactions.save-camera-image');
    Route::delete('transactions/delete-attachment', [TransactionController::class, 'deleteAttachment'])->name('transactions.delete-attachment');

    Route::resource('categories', CategoryController::class);
    Route::resource('expense-people', ExpensePersonController::class);
    Route::resource('budgets', BudgetController::class);

    // Edit and update a return history (repayment) for a borrow
    Route::get('borrows/{borrow}/return/{history}/edit', [BorrowController::class, 'editReturn'])->name('borrows.return.edit');
    Route::put('borrows/{borrow}/return/{history}', [BorrowController::class, 'updateReturn'])->name('borrows.return.update');
    Route::post('/borrows/{borrow}/repay', [BorrowController::class, 'repay'])->name('borrows.repay');
    Route::delete('borrows/{borrow}/return/{history}', [BorrowController::class, 'destroyReturn'])->name('borrows.return.destroy');
    Route::resource('borrows', BorrowController::class);

    Route::resource('emi-loans', EmiLoanController::class);
    Route::post('emi-loans/{emiLoan}/schedules/{emiSchedule}/mark-paid', [EmiLoanController::class, 'markSchedulePaid'])->name('emi-loans.schedules.mark-paid');

    Route::get('/wallets/transfer', [WalletController::class, 'showTransferForm'])->name('wallets.transfer.form');
    Route::post('/wallets/transfer', [WalletController::class, 'transfer'])->name('wallets.transfer');
    Route::resource('wallets', WalletController::class);

    Route::get('/support-tickets', [SupportTicketController::class, 'index'])->name('support_tickets.index');
    Route::get('/support-tickets/create', [SupportTicketController::class, 'create'])->name('support_tickets.create');
    Route::post('/support-tickets', [SupportTicketController::class, 'store'])->name('support_tickets.store');
    Route::get('/support-tickets/{supportTicket}', [SupportTicketController::class, 'show'])->withTrashed()->name('support_tickets.show');
    Route::post('/support-tickets/{supportTicket}/reply', [SupportTicketController::class, 'reply'])->name('support_tickets.reply');
    Route::delete('/support-tickets/{supportTicket}', [SupportTicketController::class, 'destroy'])->name('support_tickets.destroy');
    Route::post('/support-tickets/{supportTicket}/recover', [SupportTicketController::class, 'recover'])->withTrashed()->name('support_tickets.recover');
    Route::post('/support-tickets/{supportTicket}/close', [SupportTicketController::class, 'markAsClosed'])->name('support_tickets.close');
    Route::post('/support-tickets/{supportTicket}/reopen', [SupportTicketController::class, 'markAsReopened'])->name('support_tickets.reopen');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::post('/reports/regenerate', [ReportController::class, 'regenerate'])->name('reports.regenerate');
    Route::delete('/reports/history/{id}', [ReportController::class, 'deleteReport'])->name('reports.history.delete');

    // Admin Routes
    Route::resources([
        'user' => UserController::class,
        'roles' => RoleController::class,
        'wallet-types' => WalletTypeController::class,
        'currencies' => CurrencyController::class,
    ], [
        'except' => [
            'wallet-types.show',
            'currencies.show',
        ],
    ]);
});

require __DIR__ . '/auth.php';
