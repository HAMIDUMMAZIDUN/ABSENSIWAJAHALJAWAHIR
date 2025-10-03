<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdminMiddleware;

// User Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FaceScanController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\AttendanceController; // PENAMBAHAN BARU
use App\Http\Controllers\Admin\FaceController;       // PENAMBAHAN BARU
use App\Http\Controllers\Admin\AnnouncementController; // PENAMBAHAN BARU


Route::get('/', function () {
    return view('welcome');
});

// ===================================================================
// LOGIKA PENGALIHAN ROLE PADA /dashboard
// ===================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('app.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// ===================================================================

// Routes untuk Admin (Dilindungi oleh IsAdminMiddleware)
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Rute Manajemen Pengguna (Sudah Ada)
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::post('/users/{user}/toggle-status', [DashboardAdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [DashboardAdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/edit', [DashboardAdminController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [DashboardAdminController::class, 'update'])->name('users.update');

    // --- PENAMBAHAN BARU: ROUTES UNTUK FITUR BARU ---
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/faces', [FaceController::class, 'index'])->name('faces.index');
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    // --- AKHIR PENAMBAHAN BARU ---
});

// Routes untuk User Biasa/Aplikasi (Dilindungi oleh middleware 'auth' dan 'verified')
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');
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