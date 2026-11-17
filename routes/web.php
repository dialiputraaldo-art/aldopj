<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root "/" langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Semua route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard (bawaan Breeze)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Kategori Buku
    Route::resource('kategori', KategoriBukuController::class);

    // CRUD Buku
    Route::resource('buku', BukuController::class);

    // Peminjaman (hanya index, create, store)
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});

// Route autentikasi bawaan Breeze (login, logout, dll)
require __DIR__.'/auth.php';