<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKP2K3 extends Model
{
    use HasFactory;

    protected $table = 'sk_p2k3';

    protected $fillable = [
        'user_id',
        'jenis_pengajuan',
        'f_sk_lama',
        'nama_perusahaan',
        'alamat_perusahaan',
        'sektor',
        'tk_laki',
        'tk_perempuan',
        'nama_ahli_k3',
        'kontak',
        'f_surat_permohonan',
        'f_sertifikat_ahli_k3',
        'f_sertifikat_tambahan',
        'f_bpjs_kt',
        'f_bpjs_kes',
        'f_wlkp',
        'status_pengajuan',
        'catatan',
        'tanggal',
    ];

    /**
     * Get the user that owns the SK P2K3.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
