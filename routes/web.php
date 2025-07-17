<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Actual dashboard page
Route::get('/loadTesting', [DashboardController::class, 'index']);

