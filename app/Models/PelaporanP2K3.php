<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanP2K3 extends Model
{
    use HasFactory;

    protected $table = 'pelaporan_p2k3';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'periode',
        'jumlah_anggota_p2k3',
        'jumlah_rapat',
        'temuan',
        'tindak_lanjut',
        'file_laporan',
        'status_pengajuan',
        'catatan',
        'tanggal',
    ];

    /**
     * Get the user that owns the pelaporan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
