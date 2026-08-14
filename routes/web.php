<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\MonthlyDashboardController;

// Rute awal (otomatis dilempar ke laporan manajemen)
Route::get('/', function () { 
    return redirect('/laporan-manajemen'); 
});

// KUMPULAN RUTE YANG DIKUNCI (Wajib Login)
Route::middleware(['auth'])->group(function () {
    
    // Route Dashboard
    Route::get('/laporan-manajemen', [MonthlyDashboardController::class, 'index']);

    // Route Input & Import Data
    Route::get('/input-data', [MonthlyDashboardController::class, 'create']);
    Route::post('/input-data', [MonthlyDashboardController::class, 'store']);
    Route::post('/import-data', [MonthlyDashboardController::class, 'importExcel']);

    // Route Download Template
    Route::get('/download-template', [MonthlyDashboardController::class, 'downloadTemplate']);
    
});

// Catatan: Rute login bawaan Laravel biasanya ada di bawah ini.
// Biarkan saja jika ada kode tambahan seperti `require __DIR__.'/auth.php';` atau `Auth::routes();`
