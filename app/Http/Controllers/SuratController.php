<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Generate SK P2K3 letter
     */
    public function generateSkP2k3($id)
    {
        // Get submission data
        $submission = DB::table('p2k3_submissions')->where('id', $id)->first();

        if (!$submission) {
            abort(404, 'Data pengajuan tidak ditemukan');
        }

        // Set locale for Indonesian date format
        Carbon::setLocale('id');

        // Prepare data for the letter
        $data = [
            'submission' => $submission,
            'jenis' => $submission->jenis ?? 'baru', // 'baru' or 'perubahan'
            'nama_perusahaan' => $submission->nama_perusahaan ?? '-',
            'alamat_perusahaan' => $submission->alamat ?? '-',
            'sektor_perusahaan' => $submission->sektor ?? '-',
            'nomor_surat' => '566/' . str_pad($id, 3, '0', STR_PAD_LEFT) . '/Was-NKT/' . date('Y'),
            'tanggal_surat' => Carbon::now()->translatedFormat('d F Y'),
            'tahun_surat' => date('Y'),
            'kepala_dinas' => 'IRFAN SAYUTI, S.Sos, M.Si',
            'nip_kepala' => '19720305 199811 1 001',
            'jabatan_kepala' => 'Pembina Utama Muda',
            // SK Lama (untuk perubahan)
            'nomor_sk_lama' => $submission->nomor_sk_lama ?? null,
            // Jumlah tenaga kerja
            'jumlah_tk' => ($submission->jumlah_tk ?? 0) + ($submission->tk_perempuan ?? 0),
        ];

        // Get pengurus P2K3 if exists
        $pengurus = DB::table('pengurus_p2k3')
            ->where('p2k3_submission_id', $id)
            ->orderBy('urutan')
            ->get();

        $data['pengurus'] = $pengurus;

        return view('surat.sk_p2k3', $data);
    }

    /**
     * Download SK P2K3 as PDF
     */
    public function downloadSkP2k3Pdf($id)
    {
        // Get submission data
        $submission = DB::table('p2k3_submissions')->where('id', $id)->first();

        if (!$submission) {
            abort(404, 'Data pengajuan tidak ditemukan');
        }

        Carbon::setLocale('id');

        $data = [
            'submission' => $submission,
            'jenis' => $submission->jenis ?? 'baru',
            'nama_perusahaan' => $submission->nama_perusahaan ?? '-',
            'alamat_perusahaan' => $submission->alamat ?? '-',
            'sektor_perusahaan' => $submission->sektor ?? '-',
            'nomor_surat' => '566/' . str_pad($id, 3, '0', STR_PAD_LEFT) . '/Was-NKT/' . date('Y'),
            'tanggal_surat' => Carbon::now()->translatedFormat('d F Y'),
            'tahun_surat' => date('Y'),
            'kepala_dinas' => 'IRFAN SAYUTI, S.Sos, M.Si',
            'nip_kepala' => '19720305 199811 1 001',
            'jabatan_kepala' => 'Pembina Utama Muda',
            'nomor_sk_lama' => $submission->nomor_sk_lama ?? null,
            'jumlah_tk' => ($submission->jumlah_tk ?? 0) + ($submission->tk_perempuan ?? 0),
        ];

        $pengurus = DB::table('pengurus_p2k3')
            ->where('p2k3_submission_id', $id)
            ->orderBy('urutan')
            ->get();

        $data['pengurus'] = $pengurus;

        $pdf = Pdf::loadView('surat.sk_p2k3_pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'SK_P2K3_' . str_replace(' ', '_', $submission->nama_perusahaan) . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
