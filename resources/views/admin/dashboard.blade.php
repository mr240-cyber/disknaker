<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel K3</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
        }

        header {
            background: linear-gradient(90deg, #198754, #146c43);
            color: white;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #198754;
            color: white;
            min-height: 100vh;
        }

        .sidebar h3 {
            margin: 0;
            padding: 20px;
            background: #146c43;
            font-size: 18px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar ul li:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .content {
            padding: 20px;
            flex: 1;
        }

        .page {
            display: none;
        }

        .active {
            display: block;
        }

        /* CARD */
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(12, 44, 102, 0.06);
            margin-bottom: 20px;
        }

        .card h2 {
            color: #198754;
            margin-top: 0;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #e6eefc;
            text-align: left;
        }

        th {
            background: #198754;
            color: white;
        }

        .btn {
            padding: 8px 14px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-view {
            background: #198754;
            color: white;
        }

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-doc {
            background: #198754;
            color: white;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 60%;
            max-width: 700px;
            padding: 30px;
            border-radius: 12px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-content h3 {
            color: #198754;
            margin-top: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #198754, #146c43);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }

        .stat-card p {
            margin: 5px 0 0;
            opacity: 0.9;
        }

        select,
        textarea,
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #e6eefc;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 250px;
            font-family: monospace;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            float: right;
        }
    </style>
</head>

<body>

    <header style="display: flex; align-items: center; gap: 15px;">
        <img src="{{ asset('logo_k3.png') }}" alt="Logo K3" style="height: 40px;">
        <span style="font-weight: 600; font-size: 1.1rem;">ADMIN PANEL – Pelayanan Pengawasan K3</span>
    </header>

    <div class="container">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <h3>Menu Admin</h3>
            <ul>
                <li onclick="showPage('dashboard')">📊 Dashboard</li>
                <li onclick="showPage('validasi')">✅ Validasi Berkas</li>
                <li onclick="showPage('surat')">📄 Pembuatan Surat</li>
                <li onclick="showPage('riwayat')">📋 Riwayat Proses</li>
                <li onclick="showPage('pengaturan')">⚙️ Pengaturan Admin</li>
            </ul>
            <form method="POST" action="{{ route('logout') }}" style="padding: 20px;">
                @csrf
                <button type="submit"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 8px; cursor: pointer; font-size: 14px;">
                    🚪 Keluar
                </button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- DASHBOARD -->
            <div id="dashboard" class="page active">
                <h2 style="color: var(--blue); margin-bottom: 20px;">Dashboard Admin</h2>

                <!-- Stats Grid -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Layanan Masuk</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">12</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Sedang Diproses</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">5</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Selesai</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">3</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Butuh Validasi</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">4</div>
                    </div>
                </div>

                <!-- Progress Bars -->
                <div class="card">
                    <h3
                        style="color: #198754; border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 20px;">
                        Rekap Status Layanan</h3>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Layanan Masuk</span>
                            <span style="font-weight: bold; color: #198754;">12</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 50%; height: 100%; background: #198754;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Sedang Diproses</span>
                            <span style="font-weight: bold; color: #198754;">5</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background: #198754;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Selesai</span>
                            <span style="font-weight: bold; color: #198754;">3</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 75%; height: 100%; background: #198754;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Butuh Validasi</span>
                            <span style="font-weight: bold; color: #198754;">4</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 60%; height: 100%; background: #198754;"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Placeholder -->
                <div class="card">
                    <h3
                        style="color: #198754; border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 20px;">
                        Grafik Pengajuan per Bulan</h3>
                    <div
                        style="display: flex; align-items: flex-end; justify-content: space-around; height: 200px; padding-top: 20px;">
                        <div style="width: 40px; height: 40%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                        <div style="width: 40px; height: 70%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                        <div style="width: 40px; height: 30%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                        <div style="width: 40px; height: 90%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                        <div style="width: 40px; height: 50%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                        <div style="width: 40px; height: 80%; background: #198754; border-radius: 4px 4px 0 0;"></div>
                    </div>
                </div>
            </div>

            <!-- VALIDASI BERKAS -->
            <div id="validasi" class="page">
                <div class="card">
                    <h2>Validasi Berkas</h2>
                    <p>Kelola dan validasi berkas pengajuan dari perusahaan.</p>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Perusahaan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <tbody id="tableValidasi"></tbody>
                    </table>
                </div>
            </div>

            <!-- PEMBUATAN SURAT -->
            <div id="surat" class="page">
                <div class="card">
                    <h2>Pembuatan Surat</h2>
                    <p>Generate surat resmi untuk pengajuan yang telah divalidasi.</p>

                    <label><strong>Pilih Template Surat:</strong></label>
                    <select id="pilihSurat" onchange="generatePreview()">
                        <option value="">-- Pilih Template Surat --</option>
                        <option value="sk_pengesahan">Surat Pengesahan</option>
                        <option value="sk_peringatan">Surat Peringatan</option>
                        <option value="surat_balasan">Surat Balasan</option>
                    </select>

                    <label><strong>Preview Surat:</strong></label>
                    <textarea id="previewSurat" placeholder="Preview surat akan muncul di sini"></textarea>

                    <button class="btn btn-doc" onclick="downloadSurat()">📥 Download Surat</button>
                </div>
            </div>

            <!-- RIWAYAT -->
            <div id="riwayat" class="page">
                <div class="card">
                    <h2>Riwayat Proses Pengajuan</h2>
                    <p>Log aktivitas dan perubahan status berkas.</p>
                    <ul style="line-height: 2;">
                        <li>📅 01/02 - PT Maju Terus: <strong>BERKAS DITERIMA</strong></li>
                        <li>📅 02/02 - PT Aman Sentosa: <strong>VERIFIKASI BERKAS</strong></li>
                        <li>📅 03/02 - PT Sehat Selalu: <strong>DOKUMEN TERSEDIA</strong></li>
                    </ul>
                </div>
            </div>

            <!-- PENGATURAN ADMIN -->
            <div id="pengaturan" class="page">
                <div class="card">
                    <h2>Pengaturan Akun Admin</h2>
                    <p>Ubah informasi akun administrator.</p>

                    <label><strong>Nama Admin:</strong></label>
                    <input type="text" placeholder="Nama Admin" value="{{ Auth::user()->nama_lengkap }}">

                    <label><strong>Email:</strong></label>
                    <input type="text" placeholder="Email" value="{{ Auth::user()->email }}" disabled>

                    <label><strong>Password Baru:</strong></label>
                    <input type="password" placeholder="Kosongkan jika tidak ingin mengubah">

                    <button class="btn btn-approve">💾 Simpan Perubahan</button>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL -->
    <div class="modal" id="modalDetail">
        <div class="modal-content">
            <h3>Detail Berkas</h3>
            <div id="detailContent"></div>
            <br>
            <h4>Ubah Status:</h4>
            <button class="btn btn-approve" onclick="setStatus('BERKAS DITERIMA')">✅ Berkas Diterima</button>
            <button class="btn btn-reject" onclick="setStatus('BERKAS TIDAK LENGKAP')">❌ Tidak Lengkap</button>
            <button class="btn btn-approve" onclick="setStatus('VERIFIKASI BERKAS')">🔍 Verifikasi</button>
            <button class="btn btn-approve" onclick="setStatus('DOKUMEN TERSEDIA')">📄 Dokumen Tersedia</button>
            <br><br>
            <button class="btn" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
        /* PAGE SWITCHER */
        function showPage(id) {
            document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
            document.getElementById(id).classList.add("active");
        }

        /* DATA DEMO */
        let berkas = [
            { id: 1, perusahaan: "PT Maju Terus", layanan: "Pengesahan Pelayanan", status: "Menunggu" },
            { id: 2, perusahaan: "PT Aman Sentosa", layanan: "Pelaporan P2K3", status: "Menunggu" },
            { id: 3, perusahaan: "PT Sehat Selalu", layanan: "Pelaporan KK/PAK", status: "Menunggu" },
        ];

        let selectedIndex = null;

        /* RENDER TABEL */
        function renderValidasi() {
            let html = "";
            berkas.forEach((b, i) => {
                html += `
            <tr>
                <td>${b.id}</td>
                <td>${b.perusahaan}</td>
                <td>${b.layanan}</td>
                <td><strong>${b.status}</strong></td>
                <td><button class="btn btn-view" onclick="viewDetail(${i})">👁️ Lihat</button></td>
            </tr>
        `;
            });
            document.getElementById("tableValidasi").innerHTML = html;
        }

        /* DETAIL MODAL */
        function viewDetail(i) {
            selectedIndex = i;
            let b = berkas[i];
            document.getElementById("detailContent").innerHTML = `
        <p><strong>ID:</strong> ${b.id}</p>
        <p><strong>Perusahaan:</strong> ${b.perusahaan}</p>
        <p><strong>Layanan:</strong> ${b.layanan}</p>
        <p><strong>Status Saat Ini:</strong> <span style="color: #198754; font-weight: bold;">${b.status}</span></p>
        <hr>
        <p><strong>Dokumen yang Diupload:</strong></p>
        <ul>
            <li>📎 Surat Permohonan</li>
            <li>📎 BPJS Ketenagakerjaan</li>
            <li>📎 STR/SIP Dokter</li>
            <li>📎 Sertifikat Ahli K3</li>
        </ul>
    `;
            document.getElementById("modalDetail").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("modalDetail").style.display = "none";
        }

        function setStatus(status) {
            berkas[selectedIndex].status = status;
            alert("✅ Status berhasil diperbarui menjadi: " + status);
            renderValidasi();
            closeModal();
        }

        /* GENERATE SURAT */
        function generatePreview() {
            let jenis = document.getElementById("pilihSurat").value;

            if (jenis === "sk_pengesahan") {
                document.getElementById("previewSurat").value =
                    `SURAT PENGESAHAN
BIDANG PENGAWASAN KESELAMATAN DAN KESEHATAN KERJA
-------------------------

Nomor: 001/SK-K3/2025
Tanggal: ${new Date().toLocaleDateString('id-ID')}

Dengan ini menetapkan bahwa perusahaan:
[Nama Perusahaan]

Telah memenuhi persyaratan penyelenggaraan pelayanan kesehatan kerja
sesuai dengan peraturan yang berlaku.

Tertanda,
Kepala Bidang Pengawasan K3`;
            }

            else if (jenis === "sk_peringatan") {
                document.getElementById("previewSurat").value =
                    `SURAT PERINGATAN
BIDANG PENGAWASAN KESELAMATAN DAN KESEHATAN KERJA
-------------------------

Nomor: 002/SP-K3/2025
Tanggal: ${new Date().toLocaleDateString('id-ID')}

Dengan ini memberi peringatan kepada:
[Nama Perusahaan]

Agar segera melengkapi dokumen yang dipersyaratkan.

Tertanda,
Kepala Bidang Pengawasan K3`;
            }

            else if (jenis === "surat_balasan") {
                document.getElementById("previewSurat").value =
                    `SURAT BALASAN
BIDANG PENGAWASAN KESELAMATAN DAN KESEHATAN KERJA
-------------------------

Nomor: 003/SB-K3/2025
Tanggal: ${new Date().toLocaleDateString('id-ID')}

Menanggapi surat dari perusahaan [Nama Perusahaan]
perihal pengajuan [Jenis Layanan].

Dengan ini kami sampaikan bahwa...

Tertanda,
Kepala Bidang Pengawasan K3`;
            }
        }

        function downloadSurat() {
            let isi = document.getElementById("previewSurat").value;
            if (!isi.trim()) return alert("⚠️ Pilih jenis surat terlebih dahulu.");

            let blob = new Blob([isi], { type: "text/plain" });
            let url = URL.createObjectURL(blob);

            let a = document.createElement("a");
            a.href = url;
            a.download = "surat_admin_" + Date.now() + ".txt";
            a.click();

            alert("✅ Surat berhasil didownload!");
        }

        // Initialize
        renderValidasi();
    </script>

</body>

</html>