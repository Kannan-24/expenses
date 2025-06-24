<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpensePersonController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTypeController;
use App\Http\Middleware\EnsureUserIsOnboarded;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');
});

Route::middleware(['auth', 'verified', EnsureUserIsOnboarded::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('password.confirm');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.update.photo');

    Route::get('/account-settings', [AccountSettingsController::class, 'index'])->name('account.settings');
    Route::patch('/account-settings/password', [AccountSettingsController::class, 'updatePassword'])->name('account.update.password');
    Route::delete('/account-settings/delete', [AccountSettingsController::class, 'destroy'])->name('account.destroy');

    Route::resource('transactions', TransactionController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('expense-people', ExpensePersonController::class);
    Route::resource('wallets', WalletController::class);

    Route::get('/reports/expenses', [ReportController::class, 'expenses'])->name('reports.expenses');
    Route::get('/reports/expenses/pdf', [ReportController::class, 'expensesPdf'])->name('reports.expenses_report');

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
