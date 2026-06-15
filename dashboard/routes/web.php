<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
Route::get('/sales', [DashboardController::class, 'sales'])->name('sales');
Route::get('/explorer', [DashboardController::class, 'explorer'])->name('explorer');

Route::get('/api/chart-data', [DashboardController::class, 'chartData']);
Route::get('/api/sales-data', [DashboardController::class, 'salesData']);
Route::get('/api/customer-data', [DashboardController::class, 'customerData']);
Route::get('/api/explorer-data', [DashboardController::class, 'explorerData']);
