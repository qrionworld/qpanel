<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login (GET = form, POST = proses login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});


// Logout (hanya untuk yang sudah login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin area (hanya bisa diakses setelah login)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Default redirect ke dashboard
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Content
    Route::resource('content', ContentController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});
