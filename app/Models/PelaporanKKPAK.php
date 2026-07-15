<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanKKPAK extends Model
{
    use HasFactory;

    protected $table = 'pelaporan_kk_pak';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'nama_korban',
        'jabatan_korban',
        'jenis_kecelakaan',
        'kronologi',
        'tanggal_kejadian',
        'file_bukti',
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
