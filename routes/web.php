<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\MonthlyDashboardController;

Route::get('/', function () { 
    return redirect('/laporan-manajemen'); 
});

// Route Dashboard
Route::get('/laporan-manajemen', [MonthlyDashboardController::class, 'index']);

// Route Input & Import Data
Route::get('/input-data', [MonthlyDashboardController::class, 'create']);
Route::post('/input-data', [MonthlyDashboardController::class, 'store']);
Route::post('/import-data', [MonthlyDashboardController::class, 'importExcel']);

// Route Download Template
Route::get('/download-template', [MonthlyDashboardController::class, 'downloadTemplate']);