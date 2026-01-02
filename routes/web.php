<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Jalur Khusus Siswa Upload
    Route::post('/pemasukan/transfer', [PemasukanController::class, 'storeTransfer']);

    // --- AREA KHUSUS ADMIN ---
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/siswa', [SiswaController::class, 'index']);
        
        // Pemasukan
        Route::get('/pemasukan', [PemasukanController::class, 'index']);
        Route::post('/pemasukan', [PemasukanController::class, 'store']);
        Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy']);
        
        // 👇 INI BARIS BARU BUAT ACC TRANSFER 👇
        Route::patch('/pemasukan/{id}/approve', [PemasukanController::class, 'approve']);

        // Pengeluaran
        Route::get('/pengeluaran', [PengeluaranController::class, 'index']);
        Route::post('/pengeluaran', [PengeluaranController::class, 'store']);
        Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy']);
    });
});