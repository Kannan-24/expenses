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
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Route::resource('categories', CategoryController::class);
    Route::resource('expense-people', ExpensePersonController::class);
    Route::resource('budgets', BudgetController::class);

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
