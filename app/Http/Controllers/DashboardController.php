<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    // Helper: Map Types to Table Names (Clean Keys)
    private function getTableMap()
    {
        return [
            'pelayanan_kesekerja' => 'pelayanan_kesekerja',
            'sk_p2k3' => 'sk_p2k3',
            'pelaporan_kk_pak' => 'pelaporan_kk_pak',
            'pelaporan_p2k3' => 'pelaporan_p2k3',
            // Fallback for messy legacy calls if necessary (though we will fix sources)
            'Pelayanan Kesekerja' => 'pelayanan_kesekerja',
            'SK P2K3' => 'sk_p2k3',
            'Laporan KK/PAK' => 'pelaporan_kk_pak',
            'Laporan P2K3' => 'pelaporan_p2k3',
            'Pengajuan SK P2K3' => 'sk_p2k3',
            'Laporan Rutin P2K3' => 'pelaporan_p2k3',
        ];
    }

    private function resolveTable($type)
    {
        $map = $this->getTableMap();

        // Direct match
        if (isset($map[$type])) {
            return $map[$type];
        }

        // Fuzzy match (legacy)
        foreach ($map as $key => $val) {
            if (stripos($type, $key) !== false) {
                return $val;
            }
        }
        return null; // Return null if invalid
    }

    public function userIndex()
    {
        $user = Auth::user();

        // 1. Pelayanan Kesekerja
        $pelkes = DB::table('pelayanan_kesekerja')
            ->where('user_id', $user->id)
            ->select('id', 'nama_perusahaan as subtitle', 'jenis_pengajuan as title', 'status_pengajuan as status', 'created_at as date', 'file_balasan', 'catatan', DB::raw("'pelayanan_kesekerja' as type"))
            ->get();

        // 2. SK P2K3
        $p2k3 = DB::table('sk_p2k3')
            ->where('user_id', $user->id)
            ->select('id', 'nama_perusahaan as subtitle', 'jenis_pengajuan as title', 'status_pengajuan as status', 'created_at as date', 'file_balasan', 'catatan', DB::raw("'sk_p2k3' as type"))
            ->get();

        // 3. KK/PAK
        $kkpak = DB::table('pelaporan_kk_pak')
            ->where('user_id', $user->id)
            ->select('id', 'nama_perusahaan as subtitle', DB::raw("CONCAT('Laporan ', jenis_kecelakaan) as title"), 'status_pengajuan as status', 'created_at as date', 'file_balasan', 'catatan', DB::raw("'pelaporan_kk_pak' as type"))
            ->get();

        // 4. Laporan P2K3
        $laporP2k3 = DB::table('pelaporan_p2k3')
            ->where('user_id', $user->id)
            ->select('id', 'nama_perusahaan as subtitle', DB::raw("'Laporan Rutin P2K3' as title"), 'status_pengajuan as status', 'created_at as date', 'file_balasan', 'catatan', DB::raw("'pelaporan_p2k3' as type"))
            ->get();

        // Merge
        $submissions = $pelkes->concat($p2k3)->concat($kkpak)->concat($laporP2k3);
        $submissions = $submissions->sortByDesc('date')->values();

        // Stats
        $stats = [
            'total' => $submissions->count(),
            'diproses' => $submissions->filter(fn($i) => in_array($i->status, ['BERKAS DITERIMA', 'VERIFIKASI BERKAS']))->count(),
            'selesai' => $submissions->filter(fn($i) => in_array($i->status, ['SELESAI', 'DOKUMEN TERSEDIA']))->count(),
            'revisi' => $submissions->filter(fn($i) => in_array($i->status, ['DITOLAK', 'PERLU REVISI']))->count(),
        ];

        $finishedSubmissions = $submissions->filter(
            fn($i) =>
            in_array($i->status, ['SELESAI', 'DOKUMEN TERSEDIA']) && !empty($i->file_balasan)
        )->map(function ($i) {
            // Vercel Blob URLs are public - use directly
            $i->download_url = $i->file_balasan;
            return $i;
        })->values();

        return view('user.dashboard', [
            'submissions' => $submissions,
            'stats' => $stats,
            'history' => $submissions, // Alias for 'story' page
            'finished' => $finishedSubmissions
        ]);
    }

    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard');
        }

        // 1. Pelayanan Kesekerja (Admin sees ALL)
        $pelkes = DB::table('pelayanan_kesekerja')
            ->join('users', 'pelayanan_kesekerja.user_id', '=', 'users.id')
            ->select(
                'pelayanan_kesekerja.id',
                'pelayanan_kesekerja.jenis_pengajuan as title',
                'pelayanan_kesekerja.nama_perusahaan as subtitle',
                'pelayanan_kesekerja.created_at as date',
                'pelayanan_kesekerja.status_pengajuan as status',
                'users.nama_lengkap as applicant_name',
                'pelayanan_kesekerja.file_balasan',
                DB::raw("'pelayanan_kesekerja' as type")
            )
            ->get();

        // 2. SK P2K3
        $p2k3 = DB::table('sk_p2k3')
            ->join('users', 'sk_p2k3.user_id', '=', 'users.id')
            ->select(
                'sk_p2k3.id',
                DB::raw("'Pengajuan SK P2K3' as title"),
                'sk_p2k3.nama_perusahaan as subtitle',
                'sk_p2k3.created_at as date',
                'sk_p2k3.status_pengajuan as status',
                'users.nama_lengkap as applicant_name',
                'sk_p2k3.file_balasan',
                DB::raw("'sk_p2k3' as type")
            )
            ->get();

        // 3. Pelaporan KK/PAK
        $kkpak = DB::table('pelaporan_kk_pak')
            ->join('users', 'pelaporan_kk_pak.user_id', '=', 'users.id')
            ->select(
                'pelaporan_kk_pak.id',
                DB::raw("CONCAT('Laporan ', pelaporan_kk_pak.jenis_kecelakaan) as title"),
                'pelaporan_kk_pak.nama_perusahaan as subtitle',
                'pelaporan_kk_pak.created_at as date',
                'pelaporan_kk_pak.status_pengajuan as status',
                'users.nama_lengkap as applicant_name',
                'pelaporan_kk_pak.file_balasan',
                DB::raw("'pelaporan_kk_pak' as type")
            )
            ->get();

        // 4. Pelaporan P2K3
        $laporP2k3 = DB::table('pelaporan_p2k3')
            ->join('users', 'pelaporan_p2k3.user_id', '=', 'users.id')
            ->select(
                'pelaporan_p2k3.id',
                DB::raw("'Laporan Rutin P2K3' as title"),
                'pelaporan_p2k3.nama_perusahaan as subtitle',
                'pelaporan_p2k3.created_at as date',
                'pelaporan_p2k3.status_pengajuan as status',
                'users.nama_lengkap as applicant_name',
                'pelaporan_p2k3.file_balasan',
                DB::raw("'pelaporan_p2k3' as type")
            )
            ->get();

        // Merge all
        $submissions = $pelkes->concat($p2k3)->concat($kkpak)->concat($laporP2k3);
        $submissions = $submissions->sortByDesc('date')->values();

        // Stats
        $stats = [
            'total' => $submissions->count(),
            'masuk' => $submissions->filter(fn($i) => $i->status == 'BERKAS DITERIMA')->count(),
            'diproses' => $submissions->filter(fn($i) => $i->status == 'VERIFIKASI BERKAS')->count(),
            'selesai' => $submissions->filter(fn($i) => in_array($i->status, ['SELESAI', 'DOKUMEN TERSEDIA']))->count(),
            'revisi' => $submissions->filter(fn($i) => in_array($i->status, ['DITOLAK', 'PERLU REVISI', 'DITOLAK (Revisi)']))->count(),
        ];

        return view('admin.dashboard', compact('submissions', 'stats'));
    }

    public function getSubmissionDetail($type, $id)
    {
        $table = $this->resolveTable($type);

        if (!$table) {
            return response()->json(['error' => 'Unknown type: ' . $type], 400);
        }

        $data = DB::table($table)->where('id', $id)->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function updateSubmissionStatus(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Update Status Request', $request->all());

        $request->validate([
            'id' => 'required',
            'type' => 'required',
            'status' => 'required',
            'catatan' => 'nullable|string'
        ]);

        $type = $request->type;
        $id = $request->id;
        $status = $request->status;
        $catatan = $request->catatan;

        $table = $this->resolveTable($type);

        if (!$table) {
            return response()->json(['status' => 'error', 'message' => 'Invalid type: ' . $type], 400);
        }

        try {
            $affected = DB::table($table)->where('id', $id)->update([
                'status_pengajuan' => $status,
                'catatan' => $catatan,
                'updated_at' => now(),
            ]);

            \Illuminate\Support\Facades\Log::info("Update Result for $table ID $id: $affected rows affected");

            if ($affected === 0) {
                // Check if it exists
                if (!DB::table($table)->where('id', $id)->exists()) {
                    return response()->json(["status" => "error", "message" => "Data ID $id tidak ditemukan"], 404);
                }
                // If exists, it means no changes (same status/note). We can consider this success or warning.
                // Usually for status update, we expect a change. But let's return success to avoid confusing user if they re-click.
            }

            return response()->json([
                "status" => "success",
                "message" => "Status berhasil diperbarui."
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Update Status Error: " . $e->getMessage());
            return response()->json(["status" => "error", "message" => "Server Error: " . $e->getMessage()], 500);
        }
    }

    public function uploadSurat(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Upload Surat Request', $request->all());

        $request->validate([
            'id' => 'required',
            'type' => 'required',
            'file_surat' => 'required|mimes:pdf|max:5120', // Max 5MB
        ]);

        $table = $this->resolveTable($request->input('type'));
        if (!$table) {
            return response()->json(["status" => "error", "message" => "Tipe layanan tidak valid."], 400);
        }

        if ($request->hasFile('file_surat')) {
            // Upload to Vercel Blob
            $blobUrl = \App\Services\VercelBlobService::upload(
                $request->file('file_surat'),
                'uploads/surat_balasan'
            );

            if (!$blobUrl) {
                return response()->json([
                    "status" => "error",
                    "message" => "Gagal upload ke Vercel Blob. Cek konfigurasi token."
                ], 500);
            }

            try {
                // Update database with Blob URL
                $updated = DB::table($table)->where('id', $request->input('id'))->update([
                    'file_balasan' => $blobUrl,
                    'status_pengajuan' => 'DOKUMEN TERSEDIA', // Auto update status
                    'updated_at' => now()
                ]);

                if ($updated === 0) {
                    \Illuminate\Support\Facades\Log::warning("Update failed: No row affected for ID {$request->input('id')} in table $table");

                    // Check if row actually exists
                    $exists = DB::table($table)->where('id', $request->input('id'))->exists();
                    if (!$exists) {
                        return response()->json(["status" => "error", "message" => "Data tidak ditemukan di database."], 404);
                    }
                }

                return response()->json([
                    "status" => "success",
                    "message" => "Surat berhasil diupload dan status diperbarui menjadi DOKUMEN TERSEDIA.",
                    "url" => $blobUrl
                ]);

            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Database Update Error: " . $e->getMessage());
                return response()->json(["status" => "error", "message" => "Gagal mengupdate database: " . $e->getMessage()], 500);
            }
        }

        return response()->json(["status" => "error", "message" => "File tidak ditemukan."], 400);
    }

    public function getUserSubmissionDetail($type, $id)
    {
        $table = $this->resolveTable($type);

        if (!$table) {
            return response()->json(['error' => 'Unknown type: ' . $type], 400);
        }

        // Ensure user owns the data
        $data = DB::table($table)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found or access denied'], 404);
        }

        return response()->json($data);
    }
}
