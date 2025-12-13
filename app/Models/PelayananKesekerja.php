<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananKesekerja extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_kesekerja';

    protected $fillable = [
        'user_id',
        'email',
        'jenis_pengajuan',
        'tanggal_pengusulan',
        'nama_perusahaan',
        'alamat_perusahaan',
        'sektor',
        'tk_wni_laki',
        'tk_wni_perempuan',
        'tk_wna_laki',
        'tk_wna_perempuan',
        'nama_dokter',
        'ttl_dokter',
        'nomor_skp_dokter',
        'masa_berlaku_skp',
        'nomor_hiperkes',
        'nomor_str',
        'nomor_sip',
        'kontak',
        'f_permohonan',
        'f_struktur',
        'f_pernyataan',
        'f_skp_dokter',
        'f_hiperkes_dokter',
        'f_hiperkes_paramedis',
        'f_str_dokter',
        'f_sip_dokter',
        'f_sarana',
        'f_bpjs_kt',
        'f_bpjs_kes',
        'f_wlkp',
        'status_pengajuan',
        'catatan',
        'tanggal',
    ];

    protected $casts = [
        'masa_berlaku_skp' => 'date',
    ];

    /**
     * Get the user that owns the pelayanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
