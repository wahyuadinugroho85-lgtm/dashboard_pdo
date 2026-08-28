<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Report\MonthlyDashboardController;
use App\Http\Controllers\UserController; 

// Auth Routes bawaan Laravel
Auth::routes();

// --- PERUBAHAN DI SINI ---

// 1. Route Root (/) sekarang menampilkan halaman portal depan, wajib login
Route::get('/', function () {
    return view('tampilan_depan'); // Menampilkan file view baru tadi
})->middleware('auth');

// 2. Route /home (bawaan login success) dilempar juga ke root (/)
Route::get('/home', function() {
    return redirect('/');
});

// --- BATAS PERUBAHAN ---


// KUMPULAN RUTE YANG DIKUNCI (Wajib Login)
Route::middleware(['auth'])->group(function () {
    
    // Sub-menu 1: Dashboard
    Route::get('/laporan-manajemen', [MonthlyDashboardController::class, 'index']);

    // Sub-menu 2: Input Data
    Route::get('/input-data', [MonthlyDashboardController::class, 'create']);
    Route::post('/input-data', [MonthlyDashboardController::class, 'store']);
    Route::post('/import-data', [MonthlyDashboardController::class, 'importExcel']);
    Route::get('/export-data', [MonthlyDashboardController::class, 'exportData'])->name('export.data'); 
    Route::get('/download-template', [MonthlyDashboardController::class, 'downloadTemplate']);
    
    // Sub-menu 3: Kelola User (Sudah aman karena diproteksi di Controller)
    Route::get('/kelola-user', [UserController::class, 'index'])->name('kelola.user');
    Route::post('/kelola-user', [UserController::class, 'store'])->name('kelola.user.store');
    Route::put('/kelola-user/{id}', [UserController::class, 'update'])->name('kelola.user.update');
    Route::delete('/kelola-user/{id}', [UserController::class, 'destroy'])->name('kelola.user.destroy');
    
});
