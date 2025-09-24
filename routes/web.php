<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FaceScanController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// === RUTE UNTUK ADMIN ===
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
});


// === RUTE UNTUK USER BIASA ===
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Riwayat Absensi
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history');
    
    // Halaman Scan Wajah
    Route::get('/scan', [FaceScanController::class, 'index'])->name('scan');

    // Pengaturan Profil Bawaan Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grup untuk Pengaturan Kustom
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/username', [SettingsController::class, 'showUsernameForm'])->name('username');
        Route::post('/username', [SettingsController::class, 'updateUsername'])->name('username.update');
        Route::get('/password', [SettingsController::class, 'showPasswordForm'])->name('password');
        
        // Catatan: Route untuk 'updatePassword' seharusnya menggunakan PUT/PATCH, tapi POST juga bisa berfungsi.
        // Jika Anda menggunakan form Laravel Breeze asli, route 'password.update' sudah ada di auth.php
        // Jadi, Anda mungkin bisa menghapus route di bawah ini jika sudah terdefinisi.
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        
        // == RUTE PHONE DIPINDAHKAN KE SINI ==
        Route::get('/phone', [SettingsController::class, 'showPhoneForm'])->name('phone');
        Route::post('/phone', [SettingsController::class, 'updatePhone'])->name('phone.update');
        // ===================================
        
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/theme', [SettingsController::class, 'updateTheme'])->name('theme.update');
    });
});

// Rute untuk phone yang salah posisi sudah dihapus dari sini.

// Rute Autentikasi
require __DIR__.'/auth.php';