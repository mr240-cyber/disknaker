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

// Setup Database Route (Hanya untuk inisialisasi awal)
Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    $conn = config('database.default');
    $host = config('database.connections.' . $conn . '.host');
    $db = config('database.connections.' . $conn . '.database');

    echo "<h1>Debug Info</h1>";
    echo "Connection: <b>$conn</b> (Harusnya 'pgsql')<br>";
    echo "Host: <b>$host</b><br>";
    echo "Database: <b>$db</b><br><hr>";

    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed --force');
        return 'SUCCESS! Database berhasil di-reset dan di-seed! Admin: syauqi032@gmail.com';
    } catch (\Exception $e) {
        return 'ERROR MIGRASI: ' . $e->getMessage();
    }
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
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userIndex'])->name('dashboard');

    Route::post('/submit-pengesahan', [PengesahanK3Controller::class, 'store']);
    Route::post('/submit-p2k3', [P2K3Controller::class, 'store']);
    Route::post('/submit-kkpak', [KKPAKController::class, 'store']);
    Route::post('/submit-pelaporan-p2k3', [PelaporanP2K3Controller::class, 'store']);
    // New Routes for Edit/Revision
    Route::get('/user/submission/{type}/{id}', [DashboardController::class, 'getUserSubmissionDetail']);
    Route::post('/update-pengesahan', [PengesahanK3Controller::class, 'update']);
});

// Protected routes - Admin dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::get('/submission/{type}/{id}', [DashboardController::class, 'getSubmissionDetail'])->name('admin.submission.detail');
    Route::post('/submission/update', [DashboardController::class, 'updateSubmissionStatus'])->name('admin.submission.update');
    Route::post('/submission/upload', [DashboardController::class, 'uploadSurat'])->name('admin.submission.upload');
});
