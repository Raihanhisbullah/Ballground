<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login-process', [LoginController::class, 'login'])->name('login.process'); // Changed this line
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/lapangan/map-data', [LapanganController::class, 'getMapData'])->name('lapangan.map-data');
    Route::resource('lapangan', LapanganController::class);
    Route::resource('user', UserController::class);
});
