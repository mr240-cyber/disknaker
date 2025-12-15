<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$users = Illuminate\Support\Facades\DB::table('users')->get();

echo "--- LIST OF USERS ---\n";
foreach ($users as $u) {
    echo "ID: " . $u->id . " | Email: " . $u->email . " | Name: " . $u->nama_lengkap . " | Role: " . $u->role . "\n";
}
echo "---------------------\n";
