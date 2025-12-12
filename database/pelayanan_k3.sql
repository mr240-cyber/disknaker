-- DATABASE: pelayanan_k3
CREATE DATABASE IF NOT EXISTS pelayanan_k3;
USE pelayanan_k3;

-- TABLE: users
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('pengguna','admin') DEFAULT 'pengguna',
    dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- TABLE: password_reset_tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- TABLE: sessions
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id)
);

-- TABLE: pelayanan_kesekerja
CREATE TABLE pelayanan_kesekerja (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    
    -- Data Umum
    email VARCHAR(150),
    jenis_pengajuan VARCHAR(50),
    tanggal_pengusulan VARCHAR(50),
    nama_perusahaan VARCHAR(200) NOT NULL,
    alamat_perusahaan TEXT,
    sektor VARCHAR(150),
    
    -- Tenaga Kerja
    tk_wni_laki INT DEFAULT 0,
    tk_wni_perempuan INT DEFAULT 0,
    tk_wna_laki INT DEFAULT 0,
    tk_wna_perempuan INT DEFAULT 0,
    
    -- Dokter
    nama_dokter VARCHAR(150),
    ttl_dokter VARCHAR(150),
    nomor_skp_dokter VARCHAR(100),
    masa_berlaku_skp DATE,
    nomor_hiperkes VARCHAR(100),
    nomor_str VARCHAR(100),
    nomor_sip VARCHAR(100),
    kontak VARCHAR(50),
    
    -- Uploads
    f_permohonan VARCHAR(255),
    f_struktur VARCHAR(255),
    f_pernyataan VARCHAR(255),
    f_skp_dokter VARCHAR(255),
    f_hiperkes_dokter VARCHAR(255),
    f_hiperkes_paramedis VARCHAR(255),
    f_str_dokter VARCHAR(255),
    f_sip_dokter VARCHAR(255),
    f_sarana VARCHAR(255),
    f_bpjs_kt VARCHAR(255),
    f_bpjs_kes VARCHAR(255),
    f_wlkp VARCHAR(255),
    
    status_pengajuan ENUM('BERKAS DITERIMA','VERIFIKASI BERKAS','DOKUMEN TERSEDIA','DITOLAK') DEFAULT 'BERKAS DITERIMA',
    catatan TEXT NULL, 
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- TABLE: riwayat_pelayanan
CREATE TABLE riwayat_pelayanan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    jenis_pelayanan VARCHAR(200) NOT NULL,
    status_pengajuan ENUM('BERKAS DITERIMA','VERIFIKASI BERKAS','DOKUMEN TERSEDIA','DITOLAK') DEFAULT 'BERKAS DITERIMA',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- TABLE: unduh_dokumen_k3
CREATE TABLE unduh_dokumen_k3 (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    email VARCHAR(150) NOT NULL,
    nama_penerima VARCHAR(150) NOT NULL,
    jabatan VARCHAR(150) NOT NULL,
    nama_perusahaan VARCHAR(200) NOT NULL,
    alamat_perusahaan TEXT NOT NULL,
    sektor_perusahaan VARCHAR(200) NOT NULL,
    tanggal_unduh DATE NOT NULL,
    dokumen_diunduh ENUM('SK P2K3','SK Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja') NOT NULL,
    waktu_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- TABLE: sk_p2k3
CREATE TABLE sk_p2k3 (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    
    jenis_pengajuan VARCHAR(50),
    f_sk_lama VARCHAR(255),
    
    nama_perusahaan VARCHAR(200) NOT NULL,
    alamat_perusahaan TEXT,
    sektor VARCHAR(150),
    
    tk_laki INT DEFAULT 0,
    tk_perempuan INT DEFAULT 0,
    
    nama_ahli_k3 VARCHAR(150),
    kontak VARCHAR(50),
    
    -- Uploads
    f_surat_permohonan VARCHAR(255),
    f_sertifikat_ahli_k3 VARCHAR(255),
    f_sertifikat_tambahan VARCHAR(255),
    f_bpjs_kt VARCHAR(255),
    f_bpjs_kes VARCHAR(255),
    f_wlkp VARCHAR(255),
    
    status_pengajuan ENUM('BERKAS DITERIMA','VERIFIKASI BERKAS','DOKUMEN TERSEDIA','DITOLAK') DEFAULT 'BERKAS DITERIMA',
    catatan TEXT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- TABLE: pelaporan_p2k3
CREATE TABLE pelaporan_p2k3 (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nama_perusahaan VARCHAR(200),
    periode VARCHAR(50),
    jumlah_anggota_p2k3 INT,
    jumlah_rapat INT,
    temuan TEXT,
    tindak_lanjut TEXT,
    file_laporan VARCHAR(255),
    status_pengajuan ENUM('BERKAS DITERIMA','VERIFIKASI BERKAS','DOKUMEN TERSEDIA','DITOLAK') DEFAULT 'BERKAS DITERIMA',
    catatan TEXT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- TABLE: pelaporan_kk_pak
CREATE TABLE pelaporan_kk_pak (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nama_perusahaan VARCHAR(200),
    alamat_perusahaan TEXT,
    nama_korban VARCHAR(150),
    jabatan_korban VARCHAR(150),
    jenis_kecelakaan ENUM('KK','PAK'),
    kronologi TEXT,
    tanggal_kejadian DATE,
    file_bukti VARCHAR(255),
    status_pengajuan ENUM('BERKAS DITERIMA','VERIFIKASI BERKAS','DOKUMEN TERSEDIA','DITOLAK') DEFAULT 'BERKAS DITERIMA',
    catatan TEXT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
