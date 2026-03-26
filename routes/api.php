<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute API untuk statistik Dashboard
Route::get('/dashboard-stats', [DashboardController::class, 'getStats']);

// Rute API untuk Manajemen Menu / Produk
Route::get('/products-data', [ProductController::class, 'index']);