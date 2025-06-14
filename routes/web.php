<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpensePersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.update.photo');

    // Account Settings Routes
    Route::get('/account-settings', [AccountSettingsController::class, 'index'])->name('account.settings');
    Route::patch('/account-settings/password', [AccountSettingsController::class, 'updatePassword'])->name('account.update.password');
    Route::delete('/account-settings/delete', [AccountSettingsController::class, 'destroy'])->name('account.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('expenses', ExpenseController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('expense-people', ExpensePersonController::class);
    Route::get('/balance/edit', [BalanceController::class, 'edit'])->name('balance.edit');
    Route::put('/balance/update', [BalanceController::class, 'update'])->name('balance.update');
    Route::get('/balance/history', [BalanceController::class, 'history'])->name('balance.history');
    Route::get('/reports/expenses', [ReportController::class, 'expenses'])->name('reports.expenses');
    Route::get('/reports/expenses/pdf', [ReportController::class, 'expensesPdf'])->name('reports.expenses_report');
});

require __DIR__ . '/auth.php';
