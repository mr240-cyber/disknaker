<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$email = 'syauqi0200@gmail.com';
$user = Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();

if ($user) {
    echo "User Found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->nama_lengkap . "\n";
    echo "Role: " . $user->role . "\n\n";

    $tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];
    $total = 0;

    foreach ($tables as $table) {
        $count = Illuminate\Support\Facades\DB::table($table)->where('user_id', $user->id)->count();
        echo "Table '$table': $count records\n";
        $total += $count;

        if ($count > 0) {
            $rows = Illuminate\Support\Facades\DB::table($table)->where('user_id', $user->id)->get();
            foreach ($rows as $r) {
                echo "  - Submission ID: " . $r->id . " | Status: " . $r->status_pengajuan . "\n";
            }
        }
    }
    echo "\nTotal Submissions: $total\n";
} else {
    echo "User with email '$email' NOT FOUND.\n";
}
