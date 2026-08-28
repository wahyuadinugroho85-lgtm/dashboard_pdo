<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Report\MonthlyDashboardController;
use App\Http\Controllers\UserController; 

// Rute Bawaan Auth Laravel
Auth::routes();

// Rute awal (otomatis dilempar ke laporan manajemen)
Route::get('/', function () { 
    return redirect('/laporan-manajemen'); 
});

// KUMPULAN RUTE UMUM (Semua User Login Bisa Akses)
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan-manajemen', [MonthlyDashboardController::class, 'index']);
    Route::get('/input-data', [MonthlyDashboardController::class, 'create']);
    Route::post('/input-data', [MonthlyDashboardController::class, 'store']);
    Route::post('/import-data', [MonthlyDashboardController::class, 'importExcel']);
    Route::get('/export-data', [MonthlyDashboardController::class, 'exportData'])->name('export.data');
    Route::get('/download-template', [MonthlyDashboardController::class, 'downloadTemplate']);
});

// KUMPULAN RUTE TERKUNCI (HANYA ADMIN)
Route::middleware(['auth', function ($request, $next) {
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Akses Ditolak! Hanya Admin yang dapat mengelola user.');
    }
    return $next($request);
}])->group(function () {
    Route::get('/kelola-user', [UserController::class, 'index'])->name('kelola.user');
    Route::post('/kelola-user', [UserController::class, 'store'])->name('kelola.user.store');
    Route::put('/kelola-user/{id}', [UserController::class, 'update'])->name('kelola.user.update');
    Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('kelola.user.destroy');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
