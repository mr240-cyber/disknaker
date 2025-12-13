<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class P2K3Controller extends Controller
{
    public function store(Request $request)
    {
        // Start validation
        // $request->validate([ 'nama_perusahaan' => 'required', ... ]);

        $userId = Auth::id() ?? 1; // Fallback to 1 if no auth implemented yet

        // Insert into 'sk_p2k3' table based on migration
        DB::table('sk_p2k3')->insert([
            'user_id' => $userId,
            'nama_perusahaan' => $request->json('nama_perusahaan') ?? $request->input('nama_perusahaan'),
            'alamat_perusahaan' => $request->json('alamat') ?? $request->input('alamat'),
            'sektor' => $request->json('sektor') ?? $request->input('sektor'),
            // Mapping existing logic: jumlah_tk -> tk_laki (assumption)
            'tk_laki' => $request->json('jumlah_tk') ?? $request->input('jumlah_tk') ?? 0,
            'nama_ahli_k3' => $request->json('ahli_k3') ?? $request->input('ahli_k3'),
            // 'dokumen' usually implies a file path or name.
            'f_sk_lama' => $request->json('dokumen') ?? $request->input('dokumen'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Pengajuan SK P2K3 tersimpan"
        ]);
    }
}

