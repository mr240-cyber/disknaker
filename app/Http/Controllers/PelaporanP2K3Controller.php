<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelaporanP2K3Controller extends Controller
{
    public function store(Request $request)
    {
        // Validation...

        $userId = Auth::id() ?? 1;

        // Map to 'pelaporan_p2k3' table
        DB::table('pelaporan_p2k3')->insert([
            'user_id' => $userId,
            'nama_perusahaan' => $request->json('nama_pelapor') ?? $request->input('nama_pelapor'), // Mapping pelapor to perusahaan for now
            'catatan' => "Jabatan: " . ($request->json('jabatan') ?? $request->input('jabatan')),
            'temuan' => $request->json('uraian') ?? $request->input('uraian'),
            'file_laporan' => $request->json('dokumen') ?? $request->input('dokumen'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Pelaporan P2K3 berhasil disimpan"
        ]);
    }
}

