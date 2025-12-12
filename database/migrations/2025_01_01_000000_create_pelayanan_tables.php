<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Sessions Table (Required for SESSION_DRIVER=database)
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // Pelayanan Kesekerja
        Schema::create('pelayanan_kesekerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Umum
            $table->string('email', 150)->nullable();
            $table->string('jenis_pengajuan', 50)->nullable();
            $table->string('tanggal_pengusulan', 50)->nullable();
            $table->string('nama_perusahaan', 200);
            $table->text('alamat_perusahaan')->nullable();
            $table->string('sektor', 150)->nullable();

            // Tenaga Kerja
            $table->integer('tk_wni_laki')->default(0);
            $table->integer('tk_wni_perempuan')->default(0);
            $table->integer('tk_wna_laki')->default(0);
            $table->integer('tk_wna_perempuan')->default(0);

            // Dokter
            $table->string('nama_dokter', 150)->nullable();
            $table->string('ttl_dokter', 150)->nullable();
            $table->string('nomor_skp_dokter', 100)->nullable();
            $table->date('masa_berlaku_skp')->nullable();
            $table->string('nomor_hiperkes', 100)->nullable();
            $table->string('nomor_str', 100)->nullable();
            $table->string('nomor_sip', 100)->nullable();
            $table->string('kontak', 50)->nullable();

            // Uploads
            $table->string('f_permohonan')->nullable();
            $table->string('f_struktur')->nullable();
            $table->string('f_pernyataan')->nullable();
            $table->string('f_skp_dokter')->nullable();
            $table->string('f_hiperkes_dokter')->nullable();
            $table->string('f_hiperkes_paramedis')->nullable();
            $table->string('f_str_dokter')->nullable();
            $table->string('f_sip_dokter')->nullable();
            $table->string('f_sarana')->nullable();
            $table->string('f_bpjs_kt')->nullable();
            $table->string('f_bpjs_kes')->nullable();
            $table->string('f_wlkp')->nullable();

            $table->enum('status_pengajuan', ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'])->default('BERKAS DITERIMA');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });

        // Riwayat Pelayanan
        Schema::create('riwayat_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_pelayanan', 200);
            $table->enum('status_pengajuan', ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'])->default('BERKAS DITERIMA');
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });

        // Unduh Dokumen K3
        Schema::create('unduh_dokumen_k3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('email', 150);
            $table->string('nama_penerima', 150);
            $table->string('jabatan', 150);
            $table->string('nama_perusahaan', 200);
            $table->text('alamat_perusahaan');
            $table->string('sektor_perusahaan', 200);
            $table->date('tanggal_unduh');
            $table->enum('dokumen_diunduh', ['SK P2K3', 'SK Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja']);
            $table->timestamp('waktu_input')->useCurrent();
            $table->timestamps();
        });

        // SK P2K3
        Schema::create('sk_p2k3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('jenis_pengajuan', 50)->nullable();
            $table->string('f_sk_lama')->nullable();

            $table->string('nama_perusahaan', 200);
            $table->text('alamat_perusahaan')->nullable();
            $table->string('sektor', 150)->nullable();

            $table->integer('tk_laki')->default(0);
            $table->integer('tk_perempuan')->default(0);

            $table->string('nama_ahli_k3', 150)->nullable();
            $table->string('kontak', 50)->nullable();

            // Uploads
            $table->string('f_surat_permohonan')->nullable();
            $table->string('f_sertifikat_ahli_k3')->nullable();
            $table->string('f_sertifikat_tambahan')->nullable();
            $table->string('f_bpjs_kt')->nullable();
            $table->string('f_bpjs_kes')->nullable();
            $table->string('f_wlkp')->nullable();

            $table->enum('status_pengajuan', ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'])->default('BERKAS DITERIMA');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });

        // Pelaporan P2K3
        Schema::create('pelaporan_p2k3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_perusahaan', 200)->nullable();
            $table->string('periode', 50)->nullable();
            $table->integer('jumlah_anggota_p2k3')->nullable();
            $table->integer('jumlah_rapat')->nullable();
            $table->text('temuan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('file_laporan')->nullable();
            $table->enum('status_pengajuan', ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'])->default('BERKAS DITERIMA');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });

        // Pelaporan KK PAK
        Schema::create('pelaporan_kk_pak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_perusahaan', 200)->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('nama_korban', 150)->nullable();
            $table->string('jabatan_korban', 150)->nullable();
            $table->enum('jenis_kecelakaan', ['KK', 'PAK'])->nullable();
            $table->text('kronologi')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->string('file_bukti')->nullable();
            $table->enum('status_pengajuan', ['BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'DOKUMEN TERSEDIA', 'DITOLAK'])->default('BERKAS DITERIMA');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelayanan_kesekerja');
        Schema::dropIfExists('riwayat_pelayanan');
        Schema::dropIfExists('unduh_dokumen_k3');
        Schema::dropIfExists('sk_p2k3');
        Schema::dropIfExists('pelaporan_p2k3');
        Schema::dropIfExists('pelaporan_kk_pak');
        Schema::dropIfExists('sessions');
    }
};
