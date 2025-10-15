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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\FaceController;
use App\Http\Controllers\Admin\AnnouncementController;
// [TAMBAHAN] Mengimpor SettingsController dari folder Admin dengan alias
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;


Route::get('/', function () {
    return view('welcome');
});

// Logika Pengalihan Role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // [PERUBAHAN 1] Mengarahkan ke route 'home' yang baru untuk user
    return redirect()->route('home'); 
    
})->middleware(['auth', 'verified'])->name('dashboard');


// Routes untuk Admin
Route::middleware(['auth', IsAdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleUserStatus'])->name('toggle-status');
        Route::post('/bulk-status-update', [UserController::class, 'bulkStatusUpdate'])->name('bulk-status-update');
    });
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/faces', [FaceController::class, 'index'])->name('faces.index');
    Route::resource('announcements', AnnouncementController::class);

    // [TAMBAHAN] Route untuk update tema di panel admin
    Route::post('/settings/theme', [AdminSettingsController::class, 'updateTheme'])->name('settings.theme.update');
});


// [PERUBAHAN 2] ->name('app.') DIHAPUS dari grup ini untuk menyederhanakan nama route
Route::middleware(['auth', 'verified'])->prefix('app')->group(function () { 

    // [PERUBAHAN 3] Nama route diubah menjadi 'home' untuk menghindari konflik
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history');
    Route::get('/scan', [FaceScanController::class, 'index'])->name('scan');
    Route::post('/scan/capture', [FaceScanController::class, 'capture'])->name('scan.capture');

    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
    });
    
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/username', [SettingsController::class, 'showUsernameForm'])->name('username');
        Route::post('/username', [SettingsController::class, 'updateUsername'])->name('username.update');
        Route::get('/password', [SettingsController::class, 'showPasswordForm'])->name('password');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        Route::get('/phone', [SettingsController::class, 'showPhoneForm'])->name('phone');
        Route::post('/phone', [SettingsController::class, 'updatePhone'])->name('phone.update');
        Route::get('/face', [SettingsController::class, 'showFaceForm'])->name('face.create');
        Route::post('/face', [SettingsController::class, 'storeFace'])->name('face.store');
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/theme', [SettingsController::class, 'updateTheme'])->name('theme.update');
    });
});

require __DIR__.'/auth.php';
