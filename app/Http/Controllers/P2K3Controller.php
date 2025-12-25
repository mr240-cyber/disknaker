<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionReceived;
use App\Services\VercelBlobService;

class P2K3Controller extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Handle file uploads
        $paths = [];
        $files = [
            'dokumen' => 'f_sk_lama',
            'f_surat_permohonan' => 'f_surat_permohonan',
            'f_sertifikat_ahli_k3' => 'f_sertifikat_ahli_k3',
            'f_sertifikat_tambahan' => 'f_sertifikat_tambahan',
            'f_bpjs_kt' => 'f_bpjs_kt',
            'f_bpjs_kes' => 'f_bpjs_kes',
            'f_wlkp' => 'f_wlkp'
        ];

        foreach ($files as $input => $col) {
            if ($request->hasFile($input)) {
                $blobUrl = VercelBlobService::upload(
                    $request->file($input),
                    'uploads/p2k3'
                );

                if ($blobUrl) {
                    $paths[$col] = $blobUrl;
                }
            }
        }

        DB::table('sk_p2k3')->insert(array_merge([
            'user_id' => $userId,
            'jenis_pengajuan' => $request->input('jenis'),
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat_perusahaan' => $request->input('alamat'),
            'sektor' => $request->input('sektor'),
            'tk_laki' => $request->input('jumlah_tk') ?? 0,
            'tk_perempuan' => $request->input('tk_perempuan') ?? 0,
            'nama_ahli_k3' => $request->input('ahli_k3'),
            'kontak' => $request->input('kontak'),
            'status_pengajuan' => 'BERKAS DITERIMA',
            'created_at' => now(),
            'updated_at' => now(),
        ], $paths));

        try {
            Mail::to(Auth::user())->send(new SubmissionReceived(Auth::user(), 'Pengajuan SK P2K3'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return response()->json([
            "status" => "success",
            "message" => "Pengajuan SK P2K3 telah tersimpan."
        ]);
    }
}

