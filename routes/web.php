<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengesahanK3Controller;
use App\Http\Controllers\P2K3Controller;
use App\Http\Controllers\KKPAKController;
use App\Http\Controllers\PelaporanP2K3Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrackingController;

// Temporary route to create all users - DELETE AFTER USE
// Access: https://disknaker.vercel.app/setup-users
Route::get('/setup-users', function () {
    $results = [];

    // Create Admin 1
    $admin1 = \App\Models\User::firstOrCreate(
        ['email' => 'admin@pelayanan-k3.com'],
        [
            'nama_lengkap' => 'Administrator',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]
    );
    $results[] = [
        'email' => 'admin@pelayanan-k3.com',
        'password' => 'admin123',
        'role' => 'admin',
        'created' => $admin1->wasRecentlyCreated
    ];

    // Create Admin 2 (Dina)
    $admin2 = \App\Models\User::firstOrCreate(
        ['email' => 'dina26@gmail.com'],
        [
            'nama_lengkap' => 'Dina Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
            'role' => 'admin',
        ]
    );
    $results[] = [
        'email' => 'dina26@gmail.com',
        'password' => '123456789',
        'role' => 'admin',
        'created' => $admin2->wasRecentlyCreated
    ];

    // Create User (Dina Mawaddah)
    $user1 = \App\Models\User::firstOrCreate(
        ['email' => 'dinamawaddah2004@gmail.com'],
        [
            'nama_lengkap' => 'Dina Mawaddah',
            'password' => \Illuminate\Support\Facades\Hash::make('Banjarmasin'),
            'role' => 'pengguna',
        ]
    );
    $results[] = [
        'email' => 'dinamawaddah2004@gmail.com',
        'password' => 'Banjarmasin',
        'role' => 'pengguna',
        'created' => $user1->wasRecentlyCreated
    ];

    // Create User (Aditia)
    $user2 = \App\Models\User::firstOrCreate(
        ['email' => 'aditia0200@gmail.com'],
        [
            'nama_lengkap' => 'Aditia',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'pengguna',
        ]
    );
    $results[] = [
        'email' => 'aditia0200@gmail.com',
        'password' => '12345678',
        'role' => 'pengguna',
        'created' => $user2->wasRecentlyCreated
    ];

    return response()->json([
        'status' => 'success',
        'message' => 'All accounts created/verified!',
        'accounts' => $results,
        'note' => 'DELETE THIS ROUTE AFTER USE for security!'
    ]);
});

// Debug route to check all submissions - DELETE AFTER USE
Route::get('/check-submissions', function () {
    $pelkes = \DB::table('pelayanan_kesekerja')->select('id', 'user_id', 'nama_perusahaan', 'status_pengajuan', 'created_at')->get();
    $p2k3 = \DB::table('sk_p2k3')->select('id', 'user_id', 'nama_perusahaan', 'status_pengajuan', 'created_at')->get();
    $kkpak = \DB::table('pelaporan_kk_pak')->select('id', 'user_id', 'nama_perusahaan', 'status_pengajuan', 'created_at')->get();
    $laporP2k3 = \DB::table('pelaporan_p2k3')->select('id', 'user_id', 'nama_perusahaan', 'status_pengajuan', 'created_at')->get();

    $users = \DB::table('users')->select('id', 'nama_lengkap', 'email', 'role')->get();

    return response()->json([
        'users' => $users,
        'pelayanan_kesekerja' => $pelkes,
        'sk_p2k3' => $p2k3,
        'pelaporan_kk_pak' => $kkpak,
        'pelaporan_p2k3' => $laporP2k3,
        'totals' => [
            'users' => count($users),
            'pelkes' => count($pelkes),
            'p2k3' => count($p2k3),
            'kkpak' => count($kkpak),
            'lapor_p2k3' => count($laporP2k3),
        ]
    ]);
});

// Debug route removed (Cloudinary no longer used)

// Temp route to reset syauqi password
Route::get('/reset-syauqi', function () {
    $user = \App\Models\User::where('email', 'syauqi0200@gmail.com')->first();
    if ($user) {
        $user->password = \Illuminate\Support\Facades\Hash::make('12345678');
        $user->save();
        return 'Password untuk syauqi0200@gmail.com berhasil direset menjadi: 12345678';
    }
    return 'User tidak ditemukan.';
});

// Temp migration route
Route::get('/run-migration-resi', function () {
    $migration = require_once base_path('database/migrations/2026_07_18_093200_add_resi_and_rating_to_submissions.php');
    $migration->up();
    return 'Migration success! Added resi_pengajuan and rating_ikm to tables.';
});

// Migration Route: Cloudinary to Vercel Blob (Admin only, run once)
Route::get('/migrate-to-blob', function () {
    // Simple auth check - you should protect this better in production
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $tables = [
        'pelayanan_kesekerja' => ['file_balasan'],
        'sk_p2k3' => ['file_balasan'],
        'pelaporan_kk_pak' => ['file_balasan', 'file_bukti'],
        'pelaporan_p2k3' => ['file_balasan', 'file_laporan'],
    ];

    $results = ['migrated' => 0, 'failed' => 0, 'details' => []];
    $token = env('BLOB_READ_WRITE_TOKEN');

    if (!$token) {
        return response()->json(['error' => 'BLOB_READ_WRITE_TOKEN not set'], 500);
    }

    $client = new \VercelBlobPhp\Client($token);

    foreach ($tables as $table => $columns) {
        foreach ($columns as $column) {
            if (!\Schema::hasColumn($table, $column))
                continue;

            $records = \DB::table($table)
                ->whereNotNull($column)
                ->where($column, 'LIKE', '%cloudinary.com%')
                ->select('id', $column)
                ->get();

            foreach ($records as $record) {
                $oldUrl = $record->$column;

                try {
                    // Download from Cloudinary
                    $content = @file_get_contents($oldUrl);
                    if ($content === false) {
                        $results['failed']++;
                        $results['details'][] = "Failed to download: {$oldUrl}";
                        continue;
                    }

                    // Get filename
                    $pathInfo = pathinfo(parse_url($oldUrl, PHP_URL_PATH));
                    $filename = $pathInfo['basename'] ?? 'file_' . uniqid();
                    $pathname = 'migrated/' . uniqid() . '_' . $filename;

                    // Upload to Vercel Blob
                    $response = $client->put($pathname, $content);

                    $newUrl = $response->url ?? null;

                    if ($newUrl) {
                        \DB::table($table)->where('id', $record->id)->update([$column => $newUrl]);
                        $results['migrated']++;
                        $results['details'][] = "OK: {$filename}";
                    } else {
                        $results['failed']++;
                    }
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['details'][] = "Error: " . $e->getMessage();
                }
            }
        }
    }

    return response()->json($results);
})->middleware('auth');

// Public routes
Route::get('/', function () {
    return view('landing');
});

// Tracking Routes
Route::get('/lacak', [TrackingController::class, 'index']);
Route::post('/lacak/cek', [TrackingController::class, 'track']);
Route::post('/lacak/rating', [TrackingController::class, 'rate']);

if (app()->isLocal()) {
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

            // SAFETY: Reconnect again before Seeding to prevent "cached plan" errors after DDL changes
            echo "<b>Refreshing Connection before Seeding...</b><br>";
            \Illuminate\Support\Facades\DB::purge(config('database.default'));
            \Illuminate\Support\Facades\DB::reconnect(config('database.default'));

            // EXTRA SAFETY for Postgres: Clear prepared statements
            try {
                \Illuminate\Support\Facades\DB::connection()->getPdo()->exec("DEALLOCATE ALL");
                echo "Prepared statements deallocated.<br>";
            } catch (\Exception $e) {
                echo "Warning: Could not deallocate: " . $e->getMessage() . "<br>";
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

    // Debug Route: Check Users
    Route::get('/check-users', function () {
        $users = \App\Models\User::all(['id', 'nama_lengkap', 'email', 'role']);

        echo "<h1>Users in Database</h1>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th></tr>";

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user->id}</td>";
            echo "<td>{$user->nama_lengkap}</td>";
            echo "<td>{$user->email}</td>";
            echo "<td>{$user->role}</td>";
            echo "</tr>";
        }

        echo "</table>";

        if ($users->isEmpty()) {
            echo "<p style='color: red;'><b>WARNING: No users found! Please run /migrate first.</b></p>";
        }
    });
}

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return redirect('/dashboard#profil');
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
