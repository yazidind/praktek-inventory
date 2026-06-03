<?php

use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::get('/pencatatan', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/pencatatan/sepatu', [InventoryController::class, 'store'])->name('inventory.store');
Route::post('/pencatatan/sepatu/{shoe}/mutasi', [InventoryController::class, 'movement'])->name('inventory.movement');

Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');

Route::get('/komunikasi', [CommunicationController::class, 'index'])->name('communications.index');
Route::post('/komunikasi', [CommunicationController::class, 'store'])->name('communications.store');
Route::post('/komunikasi/stok-minimum', [CommunicationController::class, 'lowStock'])->name('communications.low-stock');
Route::post('/komunikasi/{notification}/sent', [CommunicationController::class, 'sent'])->name('communications.sent');
