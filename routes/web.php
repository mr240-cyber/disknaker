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
    // 1. Bersihkan Cache (Opsional, tapi bagus)
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    // Debug Output
    $conn = config('database.default');
    $host = config('database.connections.' . $conn . '.host');
    $db = config('database.connections.' . $conn . '.database');
    echo "<h1>Debug Info</h1>";
    echo "Connection: <b>$conn</b> | Host: <b>$host</b> | DB: <b>$db</b><br><hr>";

    try {
        echo "<h3>1. Initial Table Check:</h3>";
        $tables = \Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema'");
        if (empty($tables)) {
            echo "Database is empty.<br>";
        } else {
            echo "<ul>";
            foreach ($tables as $t) {
                echo "<li>" . $t->tablename . "</li>";
            }
            echo "</ul>";
        }

        // 2. Hapus semua tabel dulu (Reset total)
        echo "<h3>2. Trying db:wipe...</h3>";
        $exitCode = \Illuminate\Support\Facades\Artisan::call('db:wipe --force');
        echo "Exit Code: $exitCode <br>";
        echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";

        echo "<h3>3. Post-Wipe Table Check:</h3>";
        $tablesAfter = \Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema'");
        if (empty($tablesAfter)) {
            echo "<b>SUCCESS: Database is clean.</b><br>";
        } else {
            echo "<b>WARNING: Tables still exist!</b><ul>";
            foreach ($tablesAfter as $t) {
                echo "<li>" . $t->tablename . "</li>";
            }
            echo "</ul>";
        }

        // 3. Jalankan Migrasi
        echo "<h3>4. Trying migrate...</h3>";
        \Illuminate\Support\Facades\Artisan::call('migrate --force');
        echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
        echo "DONE.<br>";

        // 4. Jalankan Seeder
        echo "<h3>5. Trying seed...</h3>";
        \Illuminate\Support\Facades\Artisan::call('db:seed --force');
        echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
        echo "DONE.<br>";

        return '<hr><h1>SUCCESS! 🎉</h1> Database berhasil di-reset dan di-seed! <br>Admin: syauqi032@gmail.com / 12345678';

    } catch (\Exception $e) {
        return '<hr><h1>ERROR 😭</h1>' . $e->getMessage() . '<br><pre>' . $e->getTraceAsString() . '</pre>';
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
