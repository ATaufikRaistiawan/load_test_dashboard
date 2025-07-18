<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return view('welcome');
});

// Actual dashboard page
Route::get('/loadTesting', [DashboardController::class, 'index']);

Route::get('/api/dashboard-data', [DashboardController::class, 'getData']);

Route::get('/history', [HistoryController::class, 'index'])->name('history');


// Navigation component

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/history', [HistoryController::class, 'index'])->name('history');

// Machine status

Route::get('/api/machine-status', [DashboardController::class, 'getStatus']);
