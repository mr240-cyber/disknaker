<?php
require_once "./config/db.php";

class P2K3Controller {
    public function store() {
        $db = (new Database())->getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $db->prepare("
            INSERT INTO p2k3 
            (nama_perusahaan, alamat, sektor, jumlah_tk, ahli_k3, dokumen) 
            VALUES (?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['nama_perusahaan'],
            $data['alamat'],
            $data['sektor'],
            $data['jumlah_tk'],
            $data['ahli_k3'],
            $data['dokumen']
        ]);

        echo json_encode(["status"=>"success","message"=>"Pengajuan SK P2K3 tersimpan"]);
    }
}
?>
