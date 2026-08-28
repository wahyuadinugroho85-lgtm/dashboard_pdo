<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Report\MonthlyDashboardController;
use App\Http\Controllers\UserController; 

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

    // Route Input, Import, & Export Data
    Route::get('/input-data', [MonthlyDashboardController::class, 'create']);
    Route::post('/input-data', [MonthlyDashboardController::class, 'store']);
    Route::post('/import-data', [MonthlyDashboardController::class, 'importExcel']);
    Route::get('/export-data', [MonthlyDashboardController::class, 'exportData'])->name('export.data'); 
    Route::get('/download-template', [MonthlyDashboardController::class, 'downloadTemplate']);
    
    // Route Kelola User
    Route::get('/kelola-user', [UserController::class, 'index'])->name('kelola.user');
    Route::post('/kelola-user', [UserController::class, 'store'])->name('kelola.user.store');
    Route::put('/kelola-user/{id}', [UserController::class, 'update'])->name('kelola.user.update');
    Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('kelola.user.destroy');
    
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
