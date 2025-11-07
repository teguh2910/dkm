<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\CashExpenseController;
use App\Http\Controllers\MasterCodeController;
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
    Route::get('cash-expenses/export', [CashExpenseController::class, 'export'])
        ->name('cash-expenses.export');

    // AJAX Routes for filtering
    Route::get('api/master-codes/year/{year}', [CashExpenseController::class, 'getMasterCodesByYear'])
        ->name('api.master-codes.by-year');
    Route::get('api/barcodes/master-code/{masterCode}/year/{year}', [CashExpenseController::class, 'getBarcodesByMasterCode'])
        ->name('api.barcodes.by-master-code');

    Route::resource('cash-expenses', CashExpenseController::class);

    Route::post('cash-expenses/{cashExpense}/approval/{role}/{status}', [CashExpenseController::class, 'updateApproval'])
        ->name('cash-expenses.approval');

    // Master Code Routes
    Route::get('master-codes/upload', [MasterCodeController::class, 'showUploadForm'])->name('master-codes.upload');
    Route::post('master-codes/upload', [MasterCodeController::class, 'upload'])->name('master-codes.upload.store');
    Route::get('master-codes/template', [MasterCodeController::class, 'downloadTemplate'])->name('master-codes.template');
    Route::resource('master-codes', MasterCodeController::class);

    // Barcode Routes
    Route::get('barcodes/upload', [BarcodeController::class, 'showUpload'])->name('barcodes.upload');
    Route::post('barcodes/upload', [BarcodeController::class, 'upload'])->name('barcodes.upload.store');
    Route::get('barcodes/template', [BarcodeController::class, 'downloadTemplate'])->name('barcodes.template');
    Route::resource('barcodes', BarcodeController::class);
});
