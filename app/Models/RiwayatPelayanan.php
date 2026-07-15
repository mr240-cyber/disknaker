<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelayanan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pelayanan';

    protected $fillable = [
        'user_id',
        'jenis_pelayanan',
        'status_pengajuan',
        'tanggal',
    ];

    /**
     * Get the user that owns the service history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
