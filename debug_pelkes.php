<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "--- All Pelayanan Kesekerja Submissions ---\n";
$rows = Illuminate\Support\Facades\DB::table('pelayanan_kesekerja')
    ->join('users', 'pelayanan_kesekerja.user_id', '=', 'users.id')
    ->select('pelayanan_kesekerja.*', 'users.email', 'users.nama_lengkap')
    ->get();

foreach ($rows as $r) {
    echo "ID: {$r->id} | User: {$r->email} ({$r->user_id}) | Company: {$r->nama_perusahaan} | Date: {$r->created_at}\n";
}
echo "-------------------------------------------\n";
