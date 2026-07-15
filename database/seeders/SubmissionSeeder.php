<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure we have some users
        $userIds = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => "pemohon$i@example.com"],
                [
                    'nama_lengkap' => "Pemohon $i", // Reverted to nama_lengkap
                    'password' => Hash::make('password'),
                    'role' => 'pengguna',
                    'email_verified_at' => now(),
                ]
            );
            $userIds[] = $user->id;
        }

        // 'SELESAI' removed as it is not in the database ENUM definition
        $statuses = ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'];

        // 2. Seed Pelayanan Kesekerja
        foreach ($userIds as $uid) {
            DB::table('pelayanan_kesekerja')->insert([
                'user_id' => $uid,
                'jenis_pengajuan' => 'Pengesahan P2K3 Baru',
                'nama_perusahaan' => "PT Maju Jaya $uid",
                'alamat_perusahaan' => 'Jl. Merdeka No. ' . $uid,
                'status_pengajuan' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 3. Seed SK P2K3
        foreach ($userIds as $uid) {
            DB::table('sk_p2k3')->insert([
                'user_id' => $uid,
                'jenis_pengajuan' => 'Perpanjangan SK',
                'nama_perusahaan' => "PT Sejahtera $uid",
                'status_pengajuan' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 4. Seed Pelaporan KK/PAK
        foreach ($userIds as $uid) {
            DB::table('pelaporan_kk_pak')->insert([
                'user_id' => $uid,
                'nama_perusahaan' => "PT Aman $uid",
                'jenis_kecelakaan' => 'KK',
                'status_pengajuan' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 5. Seed Pelaporan P2K3
        foreach ($userIds as $uid) {
            DB::table('pelaporan_p2k3')->insert([
                'user_id' => $uid,
                'nama_perusahaan' => "PT Sentosa $uid",
                'periode' => 'Triwulan I',
                'status_pengajuan' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
