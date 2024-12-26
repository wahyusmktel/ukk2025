<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKategoriBukuController;

// Rute untuk login
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

// Rute untuk logout
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Kategori Buku
    Route::get('/kategori-buku', [AdminKategoriBukuController::class, 'index'])->name('admin.kategori_buku.index');
    Route::post('/kategori-buku', [AdminKategoriBukuController::class, 'store'])->name('admin.kategori_buku.store');
    Route::put('/kategori-buku/{id}', [AdminKategoriBukuController::class, 'update'])->name('admin.kategori_buku.update');
    Route::delete('/kategori-buku/{id}', [AdminKategoriBukuController::class, 'destroy'])->name('admin.kategori_buku.destroy');
});