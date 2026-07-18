<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function track(Request $request)
    {
        $resi = $request->input('resi');
        if (!$resi) {
            return response()->json(['status' => 'error', 'message' => 'Resi tidak boleh kosong']);
        }

        $tables = [
            'pelayanan_kesekerja' => 'Pengesahan K3',
            'sk_p2k3' => 'SK P2K3',
            'pelaporan_p2k3' => 'Laporan P2K3',
            'pelaporan_kk_pak' => 'Laporan KK/PAK'
        ];

        $found = null;
        $jenisLayanan = '';
        $foundTable = '';

        foreach ($tables as $table => $nama) {
            $data = DB::table($table)->where('resi_pengajuan', $resi)->first();
            if ($data) {
                $found = $data;
                $jenisLayanan = $nama;
                $foundTable = $table;
                break;
            }
        }

        if (!$found) {
            return response()->json(['status' => 'not_found', 'message' => 'Resi tidak ditemukan']);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'resi' => $found->resi_pengajuan,
                'perusahaan' => $found->nama_perusahaan,
                'jenis' => $jenisLayanan,
                'tanggal' => $found->created_at,
                'status_pengajuan' => $found->status_pengajuan,
                'rating_ikm' => $found->rating_ikm ?? 0
            ],
            'table' => $foundTable,
            'id' => $found->id
        ]);
    }

    public function rate(Request $request)
    {
        $resi = $request->input('resi');
        $rating = $request->input('rating');
        $table = $request->input('table');
        $id = $request->input('id');

        if (!$resi || !$rating || !$table || !$id) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }

        DB::table($table)->where('id', $id)->update(['rating_ikm' => $rating]);

        return response()->json(['status' => 'success', 'message' => 'Terima kasih atas penilaian Anda!']);
    }
}
