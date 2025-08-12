<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/driver/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});

// WhatsApp Integration API Routes (no auth middleware - using WhatsApp session identification)
Route::prefix('whatsapp')->name('api.whatsapp.')->group(function () {
    Route::post('/parse-expense', [WhatsAppController::class, 'parseExpense'])->name('parse.expense');
    Route::post('/create-transaction', [WhatsAppController::class, 'createTransaction'])->name('create.transaction');
    Route::post('/parse-and-create', [WhatsAppController::class, 'parseAndCreate'])->name('parse.and.create');
    Route::get('/recent-transactions', [WhatsAppController::class, 'getRecentTransactions'])->name('recent.transactions');
    
    // Test endpoint for WhatsApp session authentication
    Route::post('/test-auth', [WhatsAppController::class, 'testWhatsAppAuth'])->name('test.auth');
    
    // Public WhatsApp webhook (no authentication required)
    Route::get('/webhook', [WhatsAppController::class, 'webhookVerify'])->name('webhook.verify');
    Route::post('/webhook', [WhatsAppController::class, 'webhookReceive'])->name('webhook');
});
