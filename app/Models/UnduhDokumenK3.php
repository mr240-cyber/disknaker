<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnduhDokumenK3 extends Model
{
    use HasFactory;

    protected $table = 'unduh_dokumen_k3';

    protected $fillable = [
        'user_id',
        'email',
        'nama_penerima',
        'jabatan',
        'nama_perusahaan',
        'alamat_perusahaan',
        'sektor_perusahaan',
        'tanggal_unduh',
        'dokumen_diunduh',
        'waktu_input',
    ];

    protected $casts = [
        'tanggal_unduh' => 'date',
    ];

    /**
     * Get the user that downloaded the document.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
