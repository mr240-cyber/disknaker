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
// Setup Database Route (Hanya untuk inisialisasi awal)
Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    echo "<h1>Manual Database Test</h1>";
    echo "This test bypasses the migration command to check raw capabilities.<br><hr>";

    try {
        // 1. Check Connection
        echo "<b>1. Checking Connection...</b> ";
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "OK.<br>";

        // 2. Drop Test Table if exists
        echo "<b>2. Dropping 'test_users' if exists...</b> ";
        \Illuminate\Support\Facades\Schema::dropIfExists('test_users');
        echo "OK.<br>";

        // 3. Create Test Table ( mimicking users table )
        echo "<b>3. Creating 'test_users' table...</b> ";
        \Illuminate\Support\Facades\Schema::create('test_users', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
        echo "SUCCESS! Table created.<br>";

        // 4. Verify Existence
        echo "<b>4. Verifying existence...</b> ";
        if (\Illuminate\Support\Facades\Schema::hasTable('test_users')) {
            echo "YES, table exists.<br>";
        } else {
            echo "NO, table missing (weird).<br>";
        }

        echo "<hr><h1>TEST COMPLETED SUCCESSFULLY</h1>";
        echo "This means the database works fine. The issue is in the Migration system.";

    } catch (\Exception $e) {
        echo "<hr><h1>TEST FAILED</h1>";
        echo "<b>Message:</b> " . $e->getMessage() . "<br>";
        echo "<b>Code:</b> " . $e->getCode() . "<br>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
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
