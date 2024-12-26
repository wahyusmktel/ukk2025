<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKategoriBukuController;
use App\Http\Controllers\AdminBukuController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserBukuController;
use App\Http\Controllers\PeminjamanController;

// Rute untuk login
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

// Rute untuk logout
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Kategori Buku
    Route::get('/kategori-buku', [AdminKategoriBukuController::class, 'index'])->name('admin.kategori_buku.index');
    Route::post('/kategori-buku', [AdminKategoriBukuController::class, 'store'])->name('admin.kategori_buku.store');
    Route::put('/kategori-buku/{id}', [AdminKategoriBukuController::class, 'update'])->name('admin.kategori_buku.update');
    Route::delete('/kategori-buku/{id}', [AdminKategoriBukuController::class, 'destroy'])->name('admin.kategori_buku.destroy');

    //Buku
    Route::get('/buku', [AdminBukuController::class, 'index'])->name('admin.buku.index');
    Route::post('/buku', [AdminBukuController::class, 'store'])->name('admin.buku.store');
    Route::put('/buku/{id}', [AdminBukuController::class, 'update'])->name('admin.buku.update');
    Route::delete('/buku/{id}', [AdminBukuController::class, 'destroy'])->name('admin.buku.destroy');
});

// User
Route::prefix('user')->name('user.')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuthController::class, 'login'])->name('login.post');
    Route::middleware('auth:user')->group(function () {
        Route::get('dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');

        //Buku
        Route::get('/buku', [UserBukuController::class, 'index'])->name('buku.index');
        Route::get('/peminjaman/{buku}', [PeminjamanController::class, 'showPeminjaman'])->name('peminjaman.show');

        //Peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    });
});
