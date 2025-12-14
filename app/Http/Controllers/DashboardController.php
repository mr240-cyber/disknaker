<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    private function getTableMap()
    {
        return [
            'Pelayanan Kesekerja' => 'pelayanan_kesekerja',
            'SK P2K3' => 'sk_p2k3',
            'Laporan KK/PAK' => 'pelaporan_kk_pak',
            'Laporan P2K3' => 'pelaporan_p2k3',
            'Pengajuan SK P2K3' => 'sk_p2k3', // Alias
            'Laporan Rutin P2K3' => 'pelaporan_p2k3', // Alias
        ];
    }

    private function resolveTable($type)
    {
        $map = $this->getTableMap();
        if (isset($map[$type])) {
            return $map[$type];
        }

        foreach ($map as $key => $val) {
            if (str_contains($type, $key)) {
                return $val;
            }
        }
        return null;
    }

    public function userIndex()
    {
        $userId = Auth::id();

        // 1. Pelayanan Kesekerja
        $pelkes = DB::table('pelayanan_kesekerja')
            ->where('user_id', $userId)
            ->select(
                'id',
                'jenis_pengajuan as title',
                'nama_perusahaan as subtitle',
                'created_at as date',
                'status_pengajuan as status',
                'catatan',
                'file_balasan',
                DB::raw("'Pelayanan Kesekerja' as type")
            )
            ->get();

        // 2. SK P2K3
        $p2k3 = DB::table('sk_p2k3')
            ->where('user_id', $userId)
            ->select(
                'id',
                DB::raw("'Pengajuan SK P2K3' as title"),
                'nama_perusahaan as subtitle',
                'created_at as date',
                'status_pengajuan as status',
                'catatan',
                'file_balasan',
                DB::raw("'SK P2K3' as type")
            )
            ->get();

        // 3. Pelaporan KK/PAK
        $kkpak = DB::table('pelaporan_kk_pak')
            ->where('user_id', $userId)
            ->select(
                'id',
                DB::raw("CONCAT('Laporan ', jenis_kecelakaan) as title"),
                'nama_perusahaan as subtitle',
                'created_at as date',
                'status_pengajuan as status',
                'catatan',
                'file_balasan',
                DB::raw("'Laporan KK/PAK' as type")
            )
            ->get();

        // 4. Pelaporan P2K3
        $laporP2k3 = DB::table('pelaporan_p2k3')
            ->where('user_id', $userId)
            ->select(
                'id',
                DB::raw("'Laporan Rutin P2K3' as title"),
                'nama_perusahaan as subtitle',
                'created_at as date',
                'status_pengajuan as status',
                'catatan',
                'file_balasan',
                DB::raw("'Laporan P2K3' as type")
            )
            ->get();

        // Merge all
        $history = $pelkes->concat($p2k3)->concat($kkpak)->concat($laporP2k3);

        // Sort by date descending
        $history = $history->sortByDesc('date')->values();

        // Calculate Stats
        $stats = [
            'total' => $history->count(),
            'diproses' => $history->filter(fn($i) => in_array($i->status, ['BERKAS DITERIMA', 'VERIFIKASI BERKAS']))->count(),
            'selesai' => $history->filter(fn($i) => in_array($i->status, ['DOKUMEN TERSEDIA', 'SELESAI']))->count(),
            'revisi' => $history->filter(fn($i) => in_array($i->status, ['DITOLAK', 'PERLU REVISI', 'DITOLAK (Revisi)']))->count(),
        ];

        return view('user.dashboard', compact('history', 'stats'));
    }

    public function adminIndex()
    {
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
                DB::raw("'Pelayanan Kesekerja' as type")
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
                DB::raw("'SK P2K3' as type")
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
                DB::raw("'Laporan KK/PAK' as type")
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
                DB::raw("'Laporan P2K3' as type")
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
            return response()->json(['status' => 'error', 'message' => 'Invalid type'], 400);
        }

        DB::table($table)->where('id', $id)->update([
            'status_pengajuan' => $status,
            'catatan' => $catatan,
            'updated_at' => now(),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Status berhasil diperbarui."
        ]);
    }

    public function uploadSurat(Request $request)
    {
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
            $path = $request->file('file_surat')->store('uploads/surat_balasan', 'public');

            DB::table($table)->where('id', $request->input('id'))->update([
                'file_balasan' => $path,
                'status_pengajuan' => 'DOKUMEN TERSEDIA', // Auto update status
                'updated_at' => now()
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Surat berhasil diupload dan status diperbarui menjadi DOKUMEN TERSEDIA."
            ]);
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
