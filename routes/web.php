<?php

use App\Http\Controllers\CashExpenseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cash-expenses.index');
});

Route::resource('cash-expenses', CashExpenseController::class);

Route::post('cash-expenses/{cashExpense}/approval/{role}/{status}', [CashExpenseController::class, 'updateApproval'])
    ->name('cash-expenses.approval');
