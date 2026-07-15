<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DATABASE DEBUG ===\n";

// 1. Check Users
echo "\n--- USERS ---\n";
$users = User::all();
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->nama_lengkap}, Role: {$u->role}\n";
}

// 2. Check Tables & Columns
$tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];
echo "\n--- TABLES SCHEMA ---\n";
foreach ($tables as $t) {
    echo "Table: {$t}\n";
    if (Schema::hasTable($t)) {
        $hasCol = Schema::hasColumn($t, 'file_balasan') ? "YES" : "NO";
        echo "  - Exists: YES\n";
        echo "  - 'file_balasan' column: {$hasCol}\n";

        // Count rows
        $count = DB::table($t)->count();
        echo "  - Total Rows: {$count}\n";

        // Rows per user
        $rows = DB::table($t)->select('user_id', 'id', 'status_pengajuan', 'file_balasan')->get();
        foreach ($rows as $r) {
            echo "    > Submission ID: {$r->id}, UserID: {$r->user_id}, Status: {$r->status_pengajuan}, FileBalasan: " . ($r->file_balasan ? 'SET' : 'NULL') . "\n";
        }

    } else {
        echo "  - Exists: NO\n";
    }
}
