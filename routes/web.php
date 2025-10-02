<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FaceScanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// ===================================================================
// LOGIKA PENGALIHAN ROLE PADA /dashboard (DIPERBAIKI)
// ===================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Perbaikan: Cek kolom 'role' di database
    // Jika role adalah 'admin', arahkan ke admin.dashboard
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // Jika role adalah 'user' atau lainnya, arahkan ke app.dashboard
    return redirect()->route('app.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// ===================================================================

// Routes untuk Admin (Dilindungi oleh IsAdminMiddleware)
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard'); // admin.dashboard
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

// Routes untuk User Biasa/Aplikasi (Dilindungi oleh middleware 'auth' dan 'verified')
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app/dashboard', [DashboardController::class, 'index'])->name('app.dashboard'); // app.dashboard (DashboardController::index)
    Route::get('/app/riwayat', [HistoryController::class, 'index'])->name('app.history');
    Route::get('/app/scan', [FaceScanController::class, 'index'])->name('app.scan');
    Route::post('/app/scan/capture', [FaceScanController::class, 'capture'])->name('app.scan.capture');

    // Route untuk Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Unggah Foto Profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    
    // Routes Pengaturan
    Route::prefix('app/settings')->name('app.settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/username', [SettingsController::class, 'showUsernameForm'])->name('username');
        Route::post('/username', [SettingsController::class, 'updateUsername'])->name('username.update');
        Route::get('/password', [SettingsController::class, 'showPasswordForm'])->name('password');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        Route::get('/phone', [SettingsController::class, 'showPhoneForm'])->name('phone');
        Route::post('/phone', [SettingsController::class, 'updatePhone'])->name('phone.update');
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/theme', [SettingsController::class, 'updateTheme'])->name('theme.update');
    });
});

require __DIR__.'/auth.php';
