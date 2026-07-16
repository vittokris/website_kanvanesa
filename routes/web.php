<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\AhpController as AdminAhpController;
use App\Http\Controllers\Admin\SawController as AdminSawController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\User\RankingController as UserRankingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PenilaianController as UserPenilaianController;
use Illuminate\Support\Facades\Storage;

// Root redirect → halaman ranking publik
Route::get('/', function () {
    return redirect()->route('ranking');
});

Route::get('/menu-images/{filename}', function (string $filename) {
    $path = 'menus/' . basename($filename);

    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->response($path);
})->where('filename', '[A-Za-z0-9._-]+')->name('menu.image');

// ============================================================
// PUBLIC USER ROUTES — tidak perlu login
// ============================================================
Route::get('/ranking', [UserRankingController::class, 'index'])->name('ranking');

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only admin auth routes
    Route::middleware('guest:web')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Menu CRUD
        Route::get('/menus', [AdminMenuController::class, 'index'])->name('menus.index');
        Route::post('/menus', [AdminMenuController::class, 'store'])->name('menus.store');
        Route::get('/menus/{menu}/edit', [AdminMenuController::class, 'edit'])->name('menus.edit');
        Route::put('/menus/{menu}', [AdminMenuController::class, 'update'])->name('menus.update');
        Route::delete('/menus/{menu}', [AdminMenuController::class, 'destroy'])->name('menus.destroy');

        // AHP (static)
        Route::get('/ahp', [AdminAhpController::class, 'index'])->name('ahp');

        // SAW — read-only, calculation triggered automatically on each user rating
        Route::get('/saw', [AdminSawController::class, 'index'])->name('saw');
    });
});

// ============================================================
// USER AUTH ROUTES
// ============================================================

// Guest-only user auth routes
Route::middleware('guest:user')->group(function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.post');
    Route::get('/register', [UserRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

// ============================================================
// PROTECTED USER ROUTES — perlu login
// ============================================================
Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/penilaian', [UserPenilaianController::class, 'index'])->name('user.penilaian');
    Route::post('/penilaian', [UserPenilaianController::class, 'store'])->name('user.penilaian.store');
});
