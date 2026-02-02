<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\AspirasiController;
use App\Http\Controllers\Api\DashboardController;



// Authentication
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);
Route::post('/login/siswa', [AuthController::class, 'loginSiswa']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Dashboard Stats
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index']);
    
    // Aspirasi
    Route::get('/aspirasi', [AspirasiController::class, 'index']);
    Route::post('/aspirasi', [AspirasiController::class, 'store']); // Create by Siswa
    
    // Restricted to Admin (you might want to add a middleware for this, or check in controller)
    Route::post('/kategori', [KategoriController::class, 'store']);
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
    Route::put('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus']);
});