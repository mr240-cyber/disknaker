<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionReceived;
use App\Services\VercelBlobService;

class PengesahanK3Controller extends Controller
{
    public function store(Request $request)
    {
        // Increase execution time limit for file uploads (local and production)
        set_time_limit(180); // 3 minutes

        // Validation (can be expanded)
        // $request->validate([ 'nama_perusahaan' => 'required', 'files.*' => 'mimes:pdf|max:2048' ]);

        $userId = Auth::id() ?? 1;

        // FIRST: Insert form data into database (without files)
        // This ensures data is saved even if file uploads fail
        $insertId = DB::table('pelayanan_kesekerja')->insertGetId([
            'user_id' => $userId,
            'email' => $request->input('email'),
            'jenis_pengajuan' => $request->input('jenis'),
            'tanggal_pengusulan' => $request->input('tanggal'),
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat_perusahaan' => $request->input('alamat'),
            'sektor' => $request->input('sektor'),
            'tk_wni_laki' => $request->input('wni_laki', 0),
            'tk_wni_perempuan' => $request->input('wni_perempuan', 0),
            'tk_wna_laki' => $request->input('wna_laki', 0),
            'tk_wna_perempuan' => $request->input('wna_perempuan', 0),
            'nama_dokter' => $request->input('dokter_nama'),
            'ttl_dokter' => $request->input('dokter_ttl'),
            'nomor_skp_dokter' => $request->input('nomor_skp'),
            'masa_berlaku_skp' => $request->input('masa_skp'),
            'nomor_hiperkes' => $request->input('no_hiperkes'),
            'nomor_str' => $request->input('str'),
            'nomor_sip' => $request->input('sip'),
            'kontak' => $request->input('kontak'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // THEN: Handle File Uploads (update the record afterwards)
        $fileFields = [
            'permohonan' => 'f_permohonan',
            'struktur' => 'f_struktur',
            'pernyataan' => 'f_pernyataan',
            'skp' => 'f_skp_dokter',
            'hiperkes_dokter' => 'f_hiperkes_dokter',
            'hiperkes_paramedis' => 'f_hiperkes_paramedis',
            'str_dokter' => 'f_str_dokter',
            'sip_dokter' => 'f_sip_dokter',
            'sarana' => 'f_sarana',
            'bpjs_ketenagakerjaan' => 'f_bpjs_kt',
            'bpjs_kesehatan' => 'f_bpjs_kes',
            'wlkp' => 'f_wlkp'
        ];

        $uploadedPaths = [];
        foreach ($fileFields as $inputName => $dbColumn) {
            if ($request->hasFile($inputName)) {
                try {
                    $blobUrl = VercelBlobService::upload(
                        $request->file($inputName),
                        'uploads/pelkes'
                    );

                    if ($blobUrl) {
                        $uploadedPaths[$dbColumn] = $blobUrl;
                    }
                } catch (\Exception $e) {
                    // Log error but continue with other uploads
                    \Illuminate\Support\Facades\Log::warning("Failed to upload {$inputName}: " . $e->getMessage());
                }
            }
        }

        // Update record with uploaded file URLs
        if (!empty($uploadedPaths)) {
            DB::table('pelayanan_kesekerja')->where('id', $insertId)->update($uploadedPaths);
        }

        // Send email notification
        try {
            $user = Auth::user() ?? \App\Models\User::find(1); // Fallback for testing if no auth
            if ($user) {
                Mail::to($user)->send(new SubmissionReceived($user, 'Pengesahan Pelayanan Kesehatan Kerja'));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return response()->json([
            "status" => "success",
            "message" => "Data pengesahan stored successfully"
        ]);
    }
    public function update(Request $request)
    {
        $userId = Auth::id();
        $id = $request->input('id');

        // Verify ownership
        $existing = DB::table('pelayanan_kesekerja')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$existing) {
            return response()->json(['status' => 'error', 'message' => 'Data not found'], 404);
        }

        // Handle File Uploads (Only replace if new file exists)
        $fileFields = [
            'permohonan' => 'f_permohonan',
            'struktur' => 'f_struktur',
            'pernyataan' => 'f_pernyataan',
            'skp' => 'f_skp_dokter',
            'hiperkes_dokter' => 'f_hiperkes_dokter',
            'hiperkes_paramedis' => 'f_hiperkes_paramedis',
            'str_dokter' => 'f_str_dokter',
            'sip_dokter' => 'f_sip_dokter',
            'sarana' => 'f_sarana',
            'bpjs_ketenagakerjaan' => 'f_bpjs_kt',
            'bpjs_kesehatan' => 'f_bpjs_kes',
            'wlkp' => 'f_wlkp'
        ];

        $updateData = [
            'email' => $request->input('email'),
            'jenis_pengajuan' => $request->input('jenis'),
            'tanggal_pengusulan' => $request->input('tanggal'),
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat_perusahaan' => $request->input('alamat'),
            'sektor' => $request->input('sektor'),
            'tk_wni_laki' => $request->input('wni_laki', 0),
            'tk_wni_perempuan' => $request->input('wni_perempuan', 0),
            'tk_wna_laki' => $request->input('wna_laki', 0),
            'tk_wna_perempuan' => $request->input('wna_perempuan', 0),
            'nama_dokter' => $request->input('dokter_nama'),
            'ttl_dokter' => $request->input('dokter_ttl'),
            'nomor_skp_dokter' => $request->input('nomor_skp'),
            'masa_berlaku_skp' => $request->input('masa_skp'),
            'nomor_hiperkes' => $request->input('no_hiperkes'),
            'nomor_str' => $request->input('str'),
            'nomor_sip' => $request->input('sip'),
            'kontak' => $request->input('kontak'),
            'status_pengajuan' => 'BERKAS DITERIMA', // Reset status
            'updated_at' => now(),
        ];

        foreach ($fileFields as $inputName => $dbColumn) {
            if ($request->hasFile($inputName)) {
                $blobUrl = VercelBlobService::upload(
                    $request->file($inputName),
                    'uploads/pelkes'
                );

                if ($blobUrl) {
                    $updateData[$dbColumn] = $blobUrl;
                } else {
                    \Illuminate\Support\Facades\Log::warning("Failed to upload {$inputName} to Vercel Blob during update");
                }
            }
        }

        DB::table('pelayanan_kesekerja')->where('id', $id)->update($updateData);

        return response()->json([
            "status" => "success",
            "message" => "Pengajuan berhasil diperbarui."
        ]);
    }
}

