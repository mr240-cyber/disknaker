<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KKPAKController extends Controller
{
    public function store(Request $request)
    {
        // Validation (optional for now)
        // $request->validate([...]);

        $userId = Auth::id() ?? 1;

        // Map inputs to 'pelaporan_kk_pak' table
        DB::table('pelaporan_kk_pak')->insert([
            'user_id' => $userId,
            'jenis_kecelakaan' => strtoupper($request->json('jenis') ?? $request->input('jenis')), // KK or PAK
            'nama_korban' => $request->json('nama_pekerja') ?? $request->input('nama_pekerja'),
            'alamat_perusahaan' => $request->json('alamat') ?? $request->input('alamat'), // Assuming this maps to company address
            // 'tgl_lahir' doesn't have direct column, putting in notes/catatan
            'tanggal_kejadian' => now(), // Default to now as input is missing or ambiguous
            'jabatan_korban' => $request->json('pekerjaan') ?? $request->input('pekerjaan'),
            'kronologi' => $request->json('uraian') ?? $request->input('uraian'),
            'file_bukti' => $request->json('dokumen') ?? $request->input('dokumen'),
            'catatan' => "KPJ: " . ($request->json('kpj') ?? '') . ", Unit: " . ($request->json('unit') ?? '') . ", Upah: " . ($request->json('upah') ?? '') . ", Tgl Lahir: " . ($request->json('tgl_lahir') ?? ''),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Pelaporan KK/PAK berhasil disimpan"
        ]);
    }
}

