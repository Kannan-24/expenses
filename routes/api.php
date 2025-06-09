<?php

use App\Http\Controllers\BusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/driver/login', [UserController::class, 'login']);
Route::post('/driver/update-location', [BusController::class, 'updateLocation']);
Route::post('/attendance', [BusController::class, 'attendance']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});
