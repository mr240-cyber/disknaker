<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengesahanK3Controller;
use App\Http\Controllers\P2K3Controller;
use App\Http\Controllers\KKPAKController;
use App\Http\Controllers\PelaporanP2K3Controller;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Manual Migration Runner (Bypass Artisan Migrate)
Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    echo "<h1>Manual MIGRATION Runner</h1>";
    echo "Bypassing artisan migrate to run migrations directly via PHP.<br><hr>";

    try {
        // 1. Wipe Database
        echo "<b>1. Wiping Database...</b> ";
        \Illuminate\Support\Facades\Artisan::call('db:wipe --force');
        echo "DONE.<br>";

        // Force Reconnect
        \Illuminate\Support\Facades\DB::purge(config('database.default'));
        \Illuminate\Support\Facades\DB::reconnect(config('database.default'));

        // 2. Define Migrations List (Order matters!)
        $migrations = [
            '2014_10_12_000000_create_users_table.php',
            '2014_10_12_100000_create_password_reset_tokens_table.php',
            '2019_08_19_000000_create_failed_jobs_table.php',
            '2019_12_14_000001_create_personal_access_tokens_table.php',
            '2025_01_01_000000_create_pelayanan_tables.php',
            '2025_12_14_081247_add_file_balasan_to_submission_tables.php',
        ];

        // 3. Run Each Migration
        echo "<h3>2. Running Migrations...</h3>";
        $basePath = base_path('database/migrations/');

        foreach ($migrations as $file) {
            echo "Migrating: <b>$file</b> ... ";

            // Require the file. It returns the anonymous class instance!
            $migration = require_once $basePath . $file;

            // Run up()
            $migration->up();

            echo "DONE.<br>";
        }

        // 4. Run Seeder
        echo "<h3>3. Running Seeder...</h3>";
        $seeder = new \Database\Seeders\DatabaseSeeder();
        $seeder->run();
        echo "Seed DONE.<br>";

        echo "<hr><h1>FULL SUCCESS! 🎉</h1> Database siap digunakan.<br>Admin: syauqi032@gmail.com / 12345678";

    } catch (\Exception $e) {
        echo "<hr><h1>ERROR 😭</h1>";
        echo "<b>Message:</b> " . $e->getMessage() . "<br>";
        echo "<b>File:</b> " . $e->getFile() . ":" . $e->getLine() . "<br>";
        // echo "<pre>" . $e->getTraceAsString() . "</pre>";
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
