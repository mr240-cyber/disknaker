<?php
require_once "./config/db.php";

class PelaporanP2K3Controller {
    public function store() {
        $db = (new Database())->getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $db->prepare("
            INSERT INTO pelaporan_p2k3 
            (nama_pelapor, jabatan, uraian, dokumen) 
            VALUES (?,?,?,?)
        ");

        $stmt->execute([
            $data['nama_pelapor'],
            $data['jabatan'],
            $data['uraian'],
            $data['dokumen']
        ]);

        echo json_encode(["status"=>"success","message"=>"Pelaporan P2K3 berhasil disimpan"]);
    }
}
?>
