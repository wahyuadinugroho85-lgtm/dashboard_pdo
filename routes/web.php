<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Report\MonthlyDashboardController;

// Ini adalah baris ajaib yang baru saja dibuat oleh Laravel untuk mengatur Login/Register/Logout
Auth::routes();

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
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
