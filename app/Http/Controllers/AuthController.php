<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Login simple tanpa enkripsi (disesuaikan dengan logic asli)
    public function login(Request $request)
    {
        $email = $request->input('email');

        // Menggunakan DB Facade agar sesuai dengan query asli
        $user = DB::table('users')->where('email', $email)->first();

        if ($user) {
            return response()->json([
                "status" => true,
                "message" => "Login berhasil",
                "data" => $user
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Email tidak ditemukan"
            ]);
        }
    }

    // Tambah user baru
    public function register(Request $request)
    {
        $email = $request->input('email');
        $nama = $request->input('nama');

        // Insert manual sesuai logic asli
        $inserted = DB::table('users')->insert([
            'email' => $email,
            'nama' => $nama
        ]);

        if ($inserted) {
            return response()->json(["status" => true, "message" => "User berhasil dibuat"]);
        } else {
            return response()->json(["status" => false, "message" => "Gagal membuat user"]);
        }
    }
}
