<?php
require_once "./config/db.php";

class PengesahanK3Controller {
    public function store() {
        // Use global $conn from config included in router
        global $conn;

        // Ensure Response is JSON
        header('Content-Type: application/json');

        // Basic validation
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Method not allowed"]);
            return;
        }

        // --- Handle File Uploads ---
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = [];
        $fileFields = [
            'permohonan', 'struktur', 'pernyataan', 'skp', 'hiperkes_dokter', 
            'hiperkes_paramedis', 'str_dokter', 'sip_dokter', 'sarana', 
            'bpjs_ketenagakerjaan', 'bpjs_kesehatan', 'wlkp'
        ];

        foreach ($fileFields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$field]['tmp_name'];
                $name = basename($_FILES[$field]['name']);
                $targetFile = $uploadDir . time() . '_' . $field . '_' . $name;
                
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $uploadedFiles[$field] = $targetFile;
                }
            }
        }

        // --- Prepare Data ---
        // Mapping form fields to table `pelayanan_kesekerja`
        // NOTE: Table schema is limited, so we map what we can.
        
        $nama_perusahaan = $_POST['nama_perusahaan'] ?? '';
        $alamat_perusahaan = $_POST['alamat'] ?? '';
        $sektor = $_POST['sektor'] ?? '';
        $jumlah_tenaga_kerja = (int)($_POST['wni_laki'] ?? 0) + (int)($_POST['wni_perempuan'] ?? 0) + (int)($_POST['wna_laki'] ?? 0) + (int)($_POST['wna_perempuan'] ?? 0);
        $nama_pj = $_POST['dokter_nama'] ?? '';
        $jabatan_pj = "Dokter Penanggung Jawab"; // Hardcoded/derived
        
        // Mapping specific files to columns (if available)
        $dokumen_surat_permohonan = $uploadedFiles['permohonan'] ?? '';
        
        // For 'dokumen_pendukung', we'll just put the Structure Organization or a combination if needed. 
        // Or leave it valid.
        $dokumen_pendukung = $uploadedFiles['struktur'] ?? '';
        
        // User ID is required by schema (FOREIGN KEY). 
        // For now, we hardcode 1 or need a way to get it. 
        // Assuming there's a user logged in or we just use a default user for this fix if no auth/session logic provided in request context.
        // The SQL says `user_id INT NOT NULL`.
        $user_id = 1; // Default fallback

        // --- Insert Database ---
        $sql = "INSERT INTO pelayanan_kesekerja 
                (user_id, nama_perusahaan, alamat_perusahaan, sektor, jumlah_tenaga_kerja, nama_pj, jabatan_pj, dokumen_surat_permohonan, dokumen_pendukung) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
             echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
             return;
        }

        $stmt->bind_param("isssissss", 
            $user_id, 
            $nama_perusahaan, 
            $alamat_perusahaan, 
            $sektor, 
            $jumlah_tenaga_kerja, 
            $nama_pj, 
            $jabatan_pj, 
            $dokumen_surat_permohonan, 
            $dokumen_pendukung
        );

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data pengesahan disimpan"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
        }
    }
}
?>
