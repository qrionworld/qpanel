<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;

// Root redirect ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', fn() => redirect()->route('admin.dashboard'));
=======

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
    
>>>>>>> f33df973db1ec27cd815fb27c6f765ca5a0ff52b

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

<<<<<<< HEAD
    // Content CRUD + AJAX
    Route::resource('content', ContentController::class);
    Route::get('content/ajax', [ContentController::class, 'ajaxSearch'])->name('content.ajax');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

    // Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

    // Activity Logs
    Route::get('activity', [ActivityLogController::class, 'index'])->name('activity.index');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
=======
    // CRUD Content
    Route::resource('content', ContentController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
>>>>>>> f33df973db1ec27cd815fb27c6f765ca5a0ff52b
});
