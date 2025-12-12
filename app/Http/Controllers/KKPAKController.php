<?php
require_once "./config/db.php";

class KKPAKController {
    public function store() {
        $db = (new Database())->getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $db->prepare("
            INSERT INTO kk_pak 
            (jenis, nama_pekerja, alamat, tgl_lahir, kpj, pekerjaan, unit, upah, uraian, dokumen) 
            VALUES (?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->execute([
            $data['jenis'],
            $data['nama_pekerja'],
            $data['alamat'],
            $data['tgl_lahir'],
            $data['kpj'],
            $data['pekerjaan'],
            $data['unit'],
            $data['upah'],
            $data['uraian'],
            $data['dokumen']
        ]);

        echo json_encode(["status"=>"success","message"=>"Pelaporan KK/PAK berhasil disimpan"]);
    }
}
?>
