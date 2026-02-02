<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [OrderController::class, 'index'])->name('services.index');
Route::get('/services', [OrderController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Hanya untuk User yang Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- AREA KHUSUS CUSTOMER ---
    // Kita gunakan middleware 'customer_only' agar Admin tidak bisa memesan laundry
    Route::middleware('customer_only')->group(function () {
        
        // Halaman Dashboard Utama Customer
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Form dan Proses Transaksi
        Route::get('/transaction/{service}', [OrderController::class, 'create'])->name('transaction.create');
        Route::post('/transaction', [OrderController::class, 'store'])->name('transaction.store');
    });

    // --- AREA UMUM (Profil Bisa Diakses Admin & Customer) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load route otentikasi Breeze (login, register, logout)
require __DIR__.'/auth.php';