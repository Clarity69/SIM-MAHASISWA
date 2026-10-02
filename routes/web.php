<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Group Route yang Membutuhkan Autentikasi (Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Export PDF Mahasiswa (Wajib diletakkan SEBELUM resource route)
    Route::get('/mahasiswa/pdf', [MahasiswaController::class, 'pdf'])->name('mahasiswa.pdf');

    // Resource CRUD Mahasiswa & Prodi
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('prodi', ProdiController::class);

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Route Autentikasi dari Laravel Breeze (Login, Register, Logout, Reset Password)
require __DIR__ . '/auth.php';