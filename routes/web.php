<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengesahanK3Controller;
use App\Http\Controllers\P2K3Controller;
use App\Http\Controllers\KKPAKController;
use App\Http\Controllers\PelaporanP2K3Controller;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('profile');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.resend');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::post('/submit-pengesahan', [PengesahanK3Controller::class, 'store']);
    Route::post('/submit-p2k3', [P2K3Controller::class, 'store']);
    Route::post('/submit-kkpak', [KKPAKController::class, 'store']);
    Route::post('/submit-pelaporan-p2k3', [PelaporanP2K3Controller::class, 'store']);
});

// Protected routes - Admin dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
