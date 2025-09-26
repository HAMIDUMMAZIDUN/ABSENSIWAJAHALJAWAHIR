<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FaceScanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');
    Route::get('/app/riwayat', [HistoryController::class, 'index'])->name('app.history');
    Route::get('/app/scan', [FaceScanController::class, 'index'])->name('app.scan');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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