<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionReceived;
use App\Services\VercelBlobService;

class PelaporanP2K3Controller extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        $uploadPath = null;
        if ($request->hasFile('dokumen')) {
            $uploadPath = VercelBlobService::upload(
                $request->file('dokumen'),
                'uploads/laporan_p2k3'
            );
        }

        // Gather all extra form data to store in 'catatan' JSON
        // The frontend form has many fields (p2k3_*, stats, etc.)
        $extras = $request->except(['dokumen', 'p2k3_hambatan', 'p2k3_tindaklanjut', 'p2k3_triwulan', 'p2k3_nama']);

        DB::table('pelaporan_p2k3')->insert([
            'user_id' => $userId,
            'nama_perusahaan' => $request->input('p2k3_nama') ?? $request->input('nama_perusahaan'),
            'periode' => ($request->input('p2k3_triwulan') ?? '') . ' ' . ($request->input('p2k3_tahun') ?? ''),
            'temuan' => $request->input('p2k3_hambatan'),
            'tindak_lanjut' => $request->input('p2k3_tindaklanjut'),
            'file_laporan' => $uploadPath,
            'status_pengajuan' => 'BERKAS DITERIMA', // Default status
            'catatan' => json_encode($extras),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            Mail::to(Auth::user())->send(new SubmissionReceived(Auth::user(), 'Laporan Rutin P2K3'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return response()->json([
            "status" => "success",
            "message" => "Laporan P2K3 berhasil dikirim."
        ]);
    }
}

