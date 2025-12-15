<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
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

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            gap: 4px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                width: 280px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s;
                overflow-y: auto;
            }

            .sidebar.active {
                left: 0;
            }

            .hamburger {
                display: flex;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
            }

            .content {
                width: 100%;
                padding: 80px 15px 20px 15px;
            }

            header {
                padding: 15px 15px 15px 60px !important;
                font-size: 14px !important;
            }

            header img {
                height: 30px !important;
            }

            header span {
                font-size: 0.9rem !important;
            }

            .card {
                padding: 15px;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            table {
                font-size: 13px;
            }

            table th,
            table td {
                padding: 10px 8px;
            }

            .modal-content {
                width: 95%;
                max-width: 95%;
                padding: 20px;
                max-height: 90vh;
                overflow-y: auto;
            }

            input,
            select,
            textarea {
                font-size: 16px;
                /* Prevent zoom on iOS */
            }

            button {
                min-height: 44px;
                /* Touch-friendly */
            }
        }

        @media (max-width: 480px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 70px 10px 15px 10px;
            }

            header {
                padding: 12px 12px 12px 55px !important;
            }

            header span {
                font-size: 0.8rem !important;
                line-height: 1.2;
            }

            table {
                font-size: 12px;
            }

            table th,
            table td {
                padding: 8px 5px;
            }

            /* Make tables scrollable horizontally on very small screens */
            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Overlay for mobile menu */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Hamburger Menu Button -->
    <div class="hamburger" onclick="toggleSidebar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <header style="display: flex; align-items: center; gap: 15px;">
        <img src="{{ asset('logo_k3.png') }}" alt="Logo K3" style="height: 40px;">
        <span style="font-weight: 600; font-size: 1.1rem;">ADMIN PANEL – Pelayanan Pengawasan K3</span>
    </header>

    <div class="container">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <h3>Menu Admin</h3>
            <ul>
                <li onclick="showPage('dashboard')">Dashboard</li>
                <li onclick="showPage('validasi')">Validasi Berkas</li>
                <li onclick="showPage('surat')">Pembuatan Surat</li>
                <li onclick="showPage('riwayat')">Riwayat Proses</li>
                <li onclick="showPage('pengaturan')">Pengaturan Admin</li>
            </ul>
            <form method="POST" action="{{ route('logout') }}" style="padding: 20px;" id="logoutForm">
                @csrf
                <button type="submit"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 8px; cursor: pointer; font-size: 14px;">
                    Keluar
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
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['masuk'] ?? 0 }}</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Sedang Diproses</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['diproses'] ?? 0 }}
                        </div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Selesai</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['selesai'] ?? 0 }}</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid #198754;">
                        <h3 style="color: #666; font-size: 14px;">Revisi / Ditolak</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['revisi'] ?? 0 }}</div>
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
                            <span style="font-weight: bold; color: #198754;">{{ $stats['total'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="width: {{ $stats['total'] > 0 ? 100 : 0 }}%; height: 100%; background: #198754;">
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Sedang Diproses</span>
                            <span style="font-weight: bold; color: #198754;">{{ $stats['diproses'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="width: {{ $stats['total'] > 0 ? round(($stats['diproses'] / $stats['total']) * 100) : 0 }}%; height: 100%; background: #198754;">
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Selesai</span>
                            <span style="font-weight: bold; color: #198754;">{{ $stats['selesai'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="width: {{ $stats['total'] > 0 ? round(($stats['selesai'] / $stats['total']) * 100) : 0 }}%; height: 100%; background: #198754;">
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Revisi / Ditolak</span>
                            <span style="font-weight: bold; color: #198754;">{{ $stats['revisi'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="width: {{ $stats['total'] > 0 ? round(($stats['revisi'] / $stats['total']) * 100) : 0 }}%; height: 100%; background: #198754;">
                            </div>
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
                    <h2>Pembuatan Surat & Upload Dokumen</h2>
                    <p>Buat draft surat untuk pengajuan yang telah diverifikasi, lalu upload hasil scan bertanda tangan.
                    </p>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Perusahaan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableSurat">
                            <!-- Data populated by JS -->
                        </tbody>
                    </table>
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
            <h3>Detail Berkas (Updated)</h3>
            <div id="detailContent"></div>
            <br>
            <br>
            <label><strong>Catatan (Revisi / Penolakan):</strong></label>
            <textarea id="catatanInput" style="width: 100%; height: 80px; margin-bottom: 15px;"
                placeholder="Tulis alasan penolakan atau catatan revisi di sini..."></textarea>

            <h4>Ubah Status:</h4>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button class="btn btn-warning" onclick="setStatus('VERIFIKASI BERKAS')">🔍 Mulai Verifikasi</button>
                <button class="btn btn-success" onclick="setStatus('DOKUMEN TERSEDIA')">📄 Selesai / Dokumen
                    Tersedia</button>
                <button class="btn btn-reject" onclick="setStatus('PERLU REVISI')">❌ Tolak / Revisi</button>
            </div>
            <br><br>
            <button class="btn" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <!-- MODAL DRAFT SURAT -->
    <div class="modal" id="modalDraft">
        <div class="modal-content">
            <h3>📝 Edit Draft Surat</h3>
            <label><strong>Pilih Template:</strong></label>
            <select id="draftTemplate" onchange="applyTemplate()">
                <option value="sk_pengesahan">Surat Pengesahan</option>
                <option value="sk_peringatan">Surat Peringatan</option>
                <option value="surat_balasan">Surat Balasan</option>
            </select>
            <label><strong>Isi Surat:</strong></label>
            <textarea id="draftContent" style="height: 300px;"></textarea>
            <br>
            <div style="display: flex; justify-content: space-between;">
                <button class="btn btn-doc" onclick="downloadDraft()">💾 Download .txt</button>
                <button class="btn" onclick="document.getElementById('modalDraft').style.display='none'">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL UPLOAD SURAT -->
    <div class="modal" id="modalUpload">
        <div class="modal-content" style="max-width: 500px;">
            <h3>📤 Upload Surat Bertanda Tangan</h3>
            <p>Upload file PDF hasil scan surat yang sudah ditanda tangani.</p>
            <input type="file" id="fileSuratInput" accept="application/pdf">
            <br><br>
            <button class="btn btn-approve" onclick="submitUpload()">Upload & Selesai</button>
            <button class="btn" onclick="document.getElementById('modalUpload').style.display='none'">Batal</button>
        </div>
    </div>

    <script>
        /* PAGE SWITCHER */
        function showPage(id) {
            document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
            document.getElementById(id).classList.add("active");
        }

        /* DATA DEMO */
        let berkas = @json($submissions);

        let selectedIndex = null;

        /* RENDER TABEL */
        function renderValidasi() {
            let html = "";
            berkas.forEach((b, i) => {
                // Map properties if needed or use direct
                // Controller gives: title, subtitle (perusahaan), status, date, type
                html += `
            <tr>
                <td>${b.id}</td>
                <td>${b.subtitle || b.perusahaan || '-'}</td>
                <td>${b.title || b.layanan || '-'}</td>
                <td><strong>${b.status}</strong></td>
                <td><button class="btn btn-view" onclick="viewDetail(${i})">👁️ Lihat</button></td>
            </tr>
        `;
            });
            document.getElementById("tableValidasi").innerHTML = html;
        }

        /* DETAIL MODAL */
        /* DETAIL MODAL */
        function viewDetail(i) {
            selectedIndex = i;
            let b = berkas[i];

            // Set basic info to modal first
            document.getElementById("detailContent").innerHTML = `
                <p><strong>ID:</strong> ${b.id}</p>
                <p><strong>Perusahaan:</strong> ${b.subtitle || '-'}</p>
                <p><strong>Layanan:</strong> ${b.title || '-'}</p>
                <p><strong>Tanggal:</strong> ${b.date || '-'}</p>
                <p><strong>Pemohon:</strong> ${b.applicant_name || '-'}</p>
                <p><strong>Status Saat Ini:</strong> <span style="color: #198754; font-weight: bold;">${b.status}</span></p>
                <hr>
                <div style="text-align: center; color: #666;">⏳ Mengambil data lengkap...</div>
            `;

            // Reset note
            document.getElementById("catatanInput").value = "";
            document.getElementById("modalDetail").style.display = "flex";

            // Fetch detail from server
            // Use 'type' which is the fixed table identifier, not 'title' which is the display name
            fetch(`/admin/submission/${b.type}/${b.id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById("detailContent").innerHTML += `<p style="color:red">Error: ${data.error}</p>`;
                        return;
                    }

                    // 1. Render Basic Info
                    let html = `
                        <p><strong>ID:</strong> ${b.id}</p>
                        <p><strong>Perusahaan:</strong> ${b.subtitle || '-'}</p>
                        <p><strong>Layanan:</strong> ${b.title || '-'}</p>
                        <p><strong>Tanggal:</strong> ${b.date || '-'}</p>
                        <p><strong>Pemohon:</strong> ${b.applicant_name || '-'}</p>
                        <p><strong>Status Saat Ini:</strong> <span style="color: #198754; font-weight: bold;">${b.status}</span></p>
                        <hr>
                        <h4>Data Pengajuan:</h4>`;

                    // 2. Prepare Data Fields
                    const fieldOrder = [
                        'email', 'jenis_pengajuan',
                        'tanggal_pengusulan', 'nama_perusahaan',
                        'alamat_perusahaan', 'sektor', 'sektor_usaha',
                        'nama_dokter', 'ttl_dokter',
                        'nomor_skp_dokter', 'masa_berlaku_skp',
                        'nomor_hiperkes', 'nomor_str',
                        'nomor_sip', 'kontak', 'kontak_dokter',
                        'nama_paramedis', 'hiperkes_paramedis',
                        'nama_korban', 'jabatan_korban', 'jenis_kecelakaan',
                        'tanggal_kejadian', 'kronologi'
                    ];

                    let orderedFields = {};
                    let otherFields = {};
                    let fileFields = {};

                    // Sort keys based on priority list
                    fieldOrder.forEach(k => {
                        if (data[k]) orderedFields[k] = data[k];
                    });

                    for (const [key, value] of Object.entries(data)) {
                        // Skip system fields
                        if (['id', 'user_id', 'created_at', 'updated_at', 'file_balasan', 'status_pengajuan', 'catatan'].includes(key)) continue;

                        // Skip if already in ordered list
                        if (orderedFields[key]) continue;

                        // Check for file columns
                        if (key.startsWith('f_') || key.startsWith('file_')) {
                            fileFields[key] = value;
                        } else if (value !== null && value !== '' && (typeof value === 'string' || typeof value === 'number')) {
                            otherFields[key] = value;
                        }
                    }

                    // 3. Render Fields to HTML
                    html += `<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 14px;">`;

                    // Render Ordered Text Fields
                    for (const [key, value] of Object.entries(orderedFields)) {
                        html += `
                                <div style="margin-bottom: 8px;">
                                    <strong style="font-size: 11px; color: #6b7280; display: block; margin-bottom: 2px;">${key.replace(/_/g, ' ').toUpperCase()}</strong>
                                    <div style="color: #111827;">${value}</div>
                                </div>
                            `;
                    }

                    // Render Other Text Fields
                    for (const [key, value] of Object.entries(otherFields)) {
                        html += `
                                <div style="margin-bottom: 8px;">
                                    <strong style="font-size: 11px; color: #6b7280; display: block; margin-bottom: 2px;">${key.replace(/_/g, ' ').toUpperCase()}</strong>
                                    <div style="color: #111827;">${value}</div>
                                </div>
                            `;
                    }

                    // Render File Fields
                    for (const [key, value] of Object.entries(fileFields)) {
                        let label = key.replace(/^f_|^file_/, '').toUpperCase().replace(/_/g, ' ');
                        let fileLink = value 
                            ? `<a href="/storage/${value}" target="_blank" style="color: #198754; font-weight: 600; text-decoration: none; border-bottom: 1px dotted #198754;">📂 Download / Lihat File</a>` 
                            : `<span style="color: #9ca3af; font-style: italic;">Tidak ada file</span>`;

                        html += `
                                <div style="grid-column: span 2; background: #f8fafc; padding: 10px; border-radius: 6px; border: 1px solid #eef2ff;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <strong style="color: #4b5563;">${label}:</strong> 
                                        ${fileLink}
                                    </div>
                                </div>
                            `;
                    }

                    html += `</div>`;

                    // 4. Show Note
                    if (data.catatan) {
                        html += `<div style="margin-top: 15px; padding: 10px; background: #FFF3CD; border: 1px solid #FFEEBA; border-radius: 4px;">
                            <strong>Catatan Sebelumnya:</strong><br>${data.catatan}
                        </div>`;
                        document.getElementById("catatanInput").value = data.catatan;
                    }

                    document.getElementById("detailContent").innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById("detailContent").innerHTML += `<p style="color:red">Gagal mengambil data detail.</p>`;
                });
        }

        function closeModal() {
            document.getElementById("modalDetail").style.display = "none";
        }

        async function setStatus(status) {
            if (!confirm(`Apakah Anda yakin mengubah status menjadi ${status}?`)) return;

            let b = berkas[selectedIndex];
            let catatan = document.getElementById("catatanInput").value;

            try {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let res = await fetch('/admin/submission/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: b.id,
                        type: b.type, // Use b.type here too
                        status: status,
                        catatan: catatan
                    })
                });

                if (res.status === 419) {
                    alert('⏳ Sesi Anda telah berakhir. Silakan refresh halaman dan login kembali.');
                    window.location.reload();
                    return;
                }

                let result = await res.json();
                if (result.status === 'success') {
                    alert("✅ Status berhasil diperbarui!");
                    // Update local data just for UI
                    berkas[selectedIndex].status = status;
                    renderValidasi();
                    closeModal();
                    // Optional: reload page to refresh data strictly
                    // window.location.reload(); 
                } else {
                    alert("❌ Gagal memperbarui: " + result.message);
                }
            } catch (e) {
                console.error(e);
                alert("❌ Terjadi kesalahan sistem.");
            }
        }

        /* LEGACY FUNCTIONS REMOVED */

        // Initialize
        renderValidasi();
        renderSurat();

        /* LOGIC SURAT */
        function renderSurat() {
            let html = "";
            let dataSurat = berkas.filter(b => b.status === 'VERIFIKASI BERKAS' || b.status === 'DOKUMEN TERSEDIA');

            dataSurat.forEach((b, i) => {
                // Find original index in 'berkas' to pass to functions
                let originalIndex = berkas.indexOf(b);

                let btnUpload = `< button class="btn btn-approve" onclick = "openUpload(${originalIndex})" >📤 Upload</button > `;
                if (b.status === 'DOKUMEN TERSEDIA') {
                    btnUpload = `< button class="btn btn-success" disabled >✅ Tersedia</button >
                            <button class="btn btn-doc" onclick="openUpload(${originalIndex})" title="Re-upload">🔄</button>`;
                }

                html += `
                                < tr >
                        <td>${b.id}</td>
                        <td>${b.subtitle || '-'}</td>
                        <td>${b.title || '-'}</td>
                        <td><strong>${b.status}</strong></td>
                        <td>
                            <button class="btn btn-warning" onclick="openDraft(${originalIndex})">📝 Draft</button>
                            ${btnUpload}
                        </td>
                    </tr >
                            `;
            });

            if (dataSurat.length === 0) {
                html = `< tr > <td colspan="5" style="text-align:center;">Belum ada berkas yang diverifikasi. Silakan validasi berkas terlebih dahulu.</td></tr > `;
            }

            document.getElementById("tableSurat").innerHTML = html;
        }

        let currentDraftIndex = null;

        function openDraft(i) {
            currentDraftIndex = i;
            let b = berkas[i];

            // Auto select template based on service type? For now default.
            document.getElementById("draftContent").value = `[Memuat template...]`;
            document.getElementById("modalDraft").style.display = "flex";
            applyTemplate(); // Apply default
        }

        function applyTemplate() {
            let b = berkas[currentDraftIndex];
            let jenis = document.getElementById("draftTemplate").value;
            let text = "";

            if (jenis === "sk_pengesahan") {
                text = `SURAT PENGESAHAN\nNomor: 001 / SK - K3 / ${new Date().getFullYear()}\n\nMemberikan pengesahan kepada: \nPerusahaan: ${b.subtitle}\nLayanan: ${b.title}\n\n...`;
            } else if (jenis === "sk_peringatan") {
                text = `SURAT PERINGATAN\nKepada: \n${b.subtitle}\n\nHarap lengkapi kekurangan...`;
            } else {
                text = `SURAT BALASAN\nKepada: ${b.subtitle}\nPerihal: ${b.title}\n\nKami sampaikan bahwa...`;
            }
            document.getElementById("draftContent").value = text;
        }

        function downloadDraft() {
            let isi = document.getElementById("draftContent").value;
            let blob = new Blob([isi], { type: "text/plain" });
            let a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = "draft_surat.txt";
            a.click();
        }

        let currentUploadIndex = null;

        function openUpload(i) {
            currentUploadIndex = i;
            document.getElementById("modalUpload").style.display = "flex";
        }

        async function submitUpload() {
            let fileInput = document.getElementById("fileSuratInput");
            if (fileInput.files.length === 0) return alert("Pilih file PDF dulu!");

            let b = berkas[currentUploadIndex];
            let formData = new FormData();
            formData.append('id', b.id);
            formData.append('type', b.type);
            formData.append('file_surat', fileInput.files[0]);

            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                let res = await fetch('/admin/submission/upload', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken }, // Don't set Content-Type for FormData
                    body: formData
                });

                if (res.status === 419) {
                    alert("Session expired"); window.location.reload(); return;
                }

                let data = await res.json();
                if (data.status === 'success') {
                    alert("✅ Berhasil upload!");
                    berkas[currentUploadIndex].status = "DOKUMEN TERSEDIA";
                    renderSurat();
                    renderValidasi(); // Update main table too
                    document.getElementById("modalUpload").style.display = "none";
                } else {
                    alert("❌ Gagal: " + data.message);
                }
            } catch (e) {
                console.error(e);
                alert("❌ Error sistem.");
            }
        }

        // Handle logout - simplified
        const logoutForm = document.getElementById('logoutForm');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function (e) {
                // Let form submit normally
                return true;
            });
        }

        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    </script>
</body>

</html>