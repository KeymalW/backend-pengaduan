<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\AspirasiController;
use App\Http\Controllers\Api\SiswaController;



// Authentication
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);
Route::post('/login/siswa', [AuthController::class, 'loginSiswa']);

// Dashboard Stats
Route::middleware('auth:sanctum')->group(function () {
    // Siswa Routes
    Route::get('/siswa/dashboard/stats', [\App\Http\Controllers\Api\Siswa\DashboardController::class, 'stats']);
    
    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard/stats', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'stats']);
        
        // Other Admin Restricted Routes
        Route::apiResource('/kategori', KategoriController::class)->except(['index']);
        Route::apiResource('/siswa', SiswaController::class);
        Route::put('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus']);
    });

    // Common/Shared Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/aspirasi', [AspirasiController::class, 'index']);
    Route::post('/aspirasi', [AspirasiController::class, 'store']); // Create by Siswa
});