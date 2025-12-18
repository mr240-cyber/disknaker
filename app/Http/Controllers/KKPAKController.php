<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionReceived;
use App\Services\CloudinaryService;

class KKPAKController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        $uploadPath = null;
        if ($request->hasFile('dokumen')) {
            $uploadPath = CloudinaryService::upload(
                $request->file('dokumen'),
                'uploads/kk_pak'
            );
        }

        // Extra info for 'catatan'
        $extras = [
            'kpj' => $request->input('kpj'),
            'unit' => $request->input('unit'),
            'upah' => $request->input('upah'),
            'tgl_lahir' => $request->input('tgl_lahir'),
        ];
        // Format catatan readable string or JSON. Let's stick to string for now or JSON. 
        // Previous code used string concat. Let's use JSON for cleaner data if needed, or string.
        // User saw "KPJ: ..., Unit: ..." in previous code. Let's keep it similar but robust.
        $catatan = "KPJ: " . ($extras['kpj'] ?? '-') .
            ", Unit: " . ($extras['unit'] ?? '-') .
            ", Upah: " . ($extras['upah'] ?? '-') .
            ", Tgl Lahir: " . ($extras['tgl_lahir'] ?? '-');

        DB::table('pelaporan_kk_pak')->insert([
            'user_id' => $userId,
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat_perusahaan' => $request->input('alamat'),
            'nama_korban' => $request->input('nama_pekerja'),
            'jabatan_korban' => $request->input('pekerjaan'),
            'jenis_kecelakaan' => strtoupper($request->input('jenis')), // KK or PAK
            'kronologi' => $request->input('uraian'),
            'tanggal_kejadian' => $request->input('tanggal_kejadian'),
            'file_bukti' => $uploadPath,
            'catatan' => $catatan,
            'status_pengajuan' => 'BERKAS DITERIMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            Mail::to(Auth::user())->send(new SubmissionReceived(Auth::user(), 'Laporan KK/PAK'));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return response()->json([
            "status" => "success",
            "message" => "Laporan KK/PAK berhasil dikirim."
        ]);
    }
}

