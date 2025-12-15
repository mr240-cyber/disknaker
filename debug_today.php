<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

// Check count for 2025-12-15
$date = '2025-12-15';
$count = Illuminate\Support\Facades\DB::table('pelayanan_kesekerja')->whereDate('created_at', $date)->count();
echo "Submissions on $date: $count\n";

if ($count === 0) {
    echo "Last 5 Submissions:\n";
    $last = Illuminate\Support\Facades\DB::table('pelayanan_kesekerja')->orderBy('created_at', 'desc')->limit(5)->get();
    foreach ($last as $l) {
        echo " - ID: {$l->id} | Date: {$l->created_at} | UserID: {$l->user_id}\n";
    }
}
