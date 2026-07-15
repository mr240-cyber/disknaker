<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$targetEmail = 'syauqi0200@gmail.com';
$sourceId = 3; // The ID we found having ~8 submissions
$targetUser = Illuminate\Support\Facades\DB::table('users')->where('email', $targetEmail)->first();

echo "Starting migration to '$targetEmail'...\n";

if ($targetUser) {
    echo "Target user exists (ID: {$targetUser->id}). Transferring data from ID $sourceId to {$targetUser->id}...\n";
    $tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];
    foreach ($tables as $table) {
        $affected = Illuminate\Support\Facades\DB::table($table)->where('user_id', $sourceId)->update(['user_id' => $targetUser->id]);
        echo " - $table: Moved $affected records.\n";
    }
} else {
    echo "Target user does not exist. Renaming User ID $sourceId to '$targetEmail'...\n";
    $affected = Illuminate\Support\Facades\DB::table('users')->where('id', $sourceId)->update(['email' => $targetEmail]);
    if ($affected)
        echo " - Success: User ID $sourceId email updated.\n";
    else
        echo " - Failed or already set.\n";
}

// Verification count
$finalUser = Illuminate\Support\Facades\DB::table('users')->where('email', $targetEmail)->first();
if ($finalUser) {
    echo "\nVerification for {$finalUser->email} (ID: {$finalUser->id}):\n";
    $tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];
    $total = 0;
    foreach ($tables as $table) {
        $c = Illuminate\Support\Facades\DB::table($table)->where('user_id', $finalUser->id)->count();
        echo " - $table: $c\n";
        $total += $c;
    }
    echo "TOTAL Submissions: $total\n";
}
