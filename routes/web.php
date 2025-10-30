<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashExpenseController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('cash-expenses.index');
    });

    Route::get('cash-expenses/download-format', [CashExpenseController::class, 'downloadFormat'])
        ->name('cash-expenses.download-format');

    Route::resource('cash-expenses', CashExpenseController::class);

    Route::post('cash-expenses/{cashExpense}/approval/{role}/{status}', [CashExpenseController::class, 'updateApproval'])
        ->name('cash-expenses.approval');
});
