<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Pelayanan Bidang Pengawasan K3 - Pengguna</title>
    <style>
        :root {
            --blue: #198754;
            /* SIPENAKER Green */
            --blue-2: #146c43;
            --muted: #6b7280
        }

        body {
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial;
            margin: 0;
            background: #f3f6fb;
            color: #0b1a2b
        }

        header {
            background: linear-gradient(90deg, var(--blue), var(--blue-2));
            color: #fff;
            padding: 14px 20px;
            font-size: 20px;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .layout {
            display: flex;
            min-height: calc(100vh - 60px)
        }

        .sidebar {
            width: 240px;
            background: #198754;
            color: #fff;
            padding: 18px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h3 {
            margin: 0 0 12px;
            font-size: 16px
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .sidebar li {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer
        }

        .sidebar li:hover {
            background: rgba(255, 255, 255, 0.04)
        }

        main {
            flex: 1;
            padding: 20px
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(12, 44, 102, 0.06);
            margin-bottom: 18px
        }

        label {
            display: block;
            font-weight: 600;
            margin: 10px 0 6px;
            font-size: 14px
        }

        .small {
            font-size: 13px;
            color: var(--muted);
            margin-top: -8px;
            margin-bottom: 8px
        }

        input[type=text],
        input[type=email],
        input[type=tel],
        input[type=date],
        input[type=month],
        select,
        textarea,
        input[type=number] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e6eefc;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 70px;
            resize: vertical
        }

        .row {
            display: flex;
            gap: 12px
        }

        .col {
            flex: 1
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 14px
        }

        button {
            background: var(--blue);
            color: #fff;
            padding: 10px 14px;
            border: 0;
            border-radius: 10px;
            cursor: pointer
        }

        .ghost {
            background: transparent;
            color: var(--blue);
            border: 1px solid rgba(12, 44, 102, 0.12)
        }

        .note {
            background: #fff8e6;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ffedd5;
            color: #7a4f00
        }

        .fieldset {
            margin: 12px 0;
            padding: 12px;
            border: 1px dashed #e6eefc;
            border-radius: 8px
        }

        .hidden {
            display: none
        }

        .error {
            color: #b00020;
            font-size: 13px;
            margin-top: 6px
        }

        .file-hint {
            font-size: 13px;
            color: var(--muted);
            margin-top: -8px;
            margin-bottom: 8px
        }

        .status {
            padding: 10px;
            border-radius: 8px;
            background: #e6f2ff;
            color: #0c2c66;
            margin-bottom: 12px
        }

        .no-border-padding {
            border: 0;
            padding: 0;
            margin: 0
        }

        .separator {
            margin: 14px 0;
            border: none;
            border-top: 1px solid #eef2ff
        }

        .flex-buttons {
            margin-top: 12px;
            display: flex;
            gap: 8px;
            align-items: center
        }

        .ml-auto {
            margin-left: auto
        }

        .mt-14 {
            margin-top: 14px
        }

        .mt-8 {
            margin-top: 8px
        }

        .json-preview {
            white-space: pre-wrap;
            max-height: 300px;
            overflow: auto
        }

        .bold-title {
            font-weight: 700
        }

        .login-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px
        }

        .account-info {
            display: flex;
            gap: 8px;
            align-items: center
        }

        .email-display {
            background: #f3f4f6;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #e6e9ef
        }

        .doc-links-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap
        }

        .mt-6 {
            margin-top: 6px
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
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: 0.3s;
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

        /* Mobile Responsive */
        @media(max-width:1024px) {
            aside {
                position: fixed;
                left: -280px;
                top: 0;
                width: 280px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s;
                overflow-y: auto;
            }

            aside.active {
                left: 0;
            }

            .hamburger {
                display: flex;
            }

            main {
                margin-left: 0;
                padding: 80px 15px 20px 15px;
            }

            header {
                padding-left: 60px;
            }

            .row {
                flex-direction: column;
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
                font-size: 16px !important;
                /* Prevent zoom on iOS */
            }

            button {
                min-height: 44px;
                /* Touch-friendly */
            }
        }

        @media(max-width:768px) {
            .stats {
                grid-template-columns: 1fr;
            }

            main {
                padding: 70px 10px 15px 10px;
            }

            header {
                font-size: 14px;
                padding: 12px 12px 12px 55px;
            }

            header img {
                height: 30px;
            }

            table {
                font-size: 12px;
            }

            table th,
            table td {
                padding: 8px 5px;
            }

            /* Make tables scrollable horizontally */
            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .card {
                padding: 15px;
            }

            h2 {
                font-size: 1.3rem;
            }

            h3 {
                font-size: 1.1rem;
            }
        }

        @media(max-width:480px) {
            main {
                padding: 65px 8px 12px 8px;
            }

            .stat-card h3 {
                font-size: 0.9rem;
            }

            .stat-card .number {
                font-size: 1.5rem;
            }

            button,
            .btn {
                font-size: 14px;
                padding: 10px 15px;
            }
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
        <button id="toggleSidebar"
            style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">
            <i class="fas fa-bars"></i>
        </button>
        <img src="{{ asset('logo_k3.png') }}" alt="Logo K3" style="height: 40px;">
        <span style="font-weight: 600; font-size: 1.1rem;">Pelayanan Bidang Pengawasan K3 – Pengguna</span>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <div
                style="font-size: 20px; font-weight: bold; margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                SIPENAKER
            </div>
            <ul>
                <li onclick="showPage('dashboard')"> Dashboard
                </li>
                <li onclick="showPage('pelayanan')"> Pelayanan
                </li>
                <li onclick="showPage('story')"> Riwayat Proses</li>
                <li onclick="showPage('unduhDok')"> Unduh Dokumen
                </li>
                <li onclick="window.location.href='{{ route('profile') }}'"> Profil</li>
            </ul>
            <form method="POST" action="{{ route('logout') }}" style="padding: 20px 0;" id="userLogoutForm">
                @csrf
                <button type="submit"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 8px; cursor: pointer; font-size: 14px;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </aside>

        <main>
            <!-- DASHBOARD -->
            <div id="dashboard" class="page">
                <h2 style="color: var(--blue); margin-bottom: 20px;">Dashboard Pengguna</h2>

                <!-- Stats Grid -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="card" style="text-align: center; border-left: 5px solid var(--blue);">
                        <h3 style="color: #666; font-size: 14px;">Layanan Masuk</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid var(--blue);">
                        <h3 style="color: #666; font-size: 14px;">Sedang Diproses</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['diproses'] ?? 0 }}
                        </div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid var(--blue);">
                        <h3 style="color: #666; font-size: 14px;">Selesai</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['selesai'] ?? 0 }}</div>
                    </div>
                    <div class="card" style="text-align: center; border-left: 5px solid var(--blue);">
                        <h3 style="color: #666; font-size: 14px;">Revisi</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $stats['revisi'] ?? 0 }}</div>
                    </div>
                </div>

                <!-- Progress Bars -->
                <div class="card">
                    <h3
                        style="color: var(--blue); border-bottom: 2px solid var(--blue); padding-bottom: 10px; margin-bottom: 20px;">
                        Rekap Status Layanan</h3>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Layanan Masuk</span>
                            <span style="font-weight: bold; color: var(--blue);">{{ $stats['total'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 0%; height: 100%; background: var(--blue);"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Sedang Diproses</span>
                            <span style="font-weight: bold; color: var(--blue);">{{ $stats['diproses'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background: var(--blue);"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Selesai</span>
                            <span style="font-weight: bold; color: var(--blue);">{{ $stats['selesai'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background: var(--blue);"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; mb-2;">
                            <span>Revisi</span>
                            <span style="font-weight: bold; color: var(--blue);">{{ $stats['revisi'] ?? 0 }}</span>
                        </div>
                        <div style="background: #e9ecef; height: 15px; border-radius: 10px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background: var(--blue);"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Placeholder -->
                <div class="card">
                    <h3
                        style="color: var(--blue); border-bottom: 2px solid var(--blue); padding-bottom: 10px; margin-bottom: 20px;">
                        Grafik Pengajuan per Bulan</h3>
                    <div
                        style="display: flex; align-items: flex-end; justify-content: space-around; height: 200px; padding-top: 20px;">
                        <div style="width: 40px; height: 40%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                        <div style="width: 40px; height: 70%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                        <div style="width: 40px; height: 30%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                        <div style="width: 40px; height: 90%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                        <div style="width: 40px; height: 50%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                        <div style="width: 40px; height: 80%; background: var(--blue); border-radius: 4px 4px 0 0;">
                        </div>
                    </div>
                </div>
                <!-- Riwayat Pengajuan -->
                <div class="card" style="margin-top: 30px;">
                    <h3
                        style="color: var(--blue); border-bottom: 2px solid var(--blue); padding-bottom: 10px; margin-bottom: 20px;">
                        Riwayat Pengajuan Saya</h3>

                    @if(count($submissions) > 0)
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f3f4f6; text-align: left;">
                                    <th style="padding: 10px; border-bottom: 2px solid #ddd;">Layanan</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #ddd;">Perusahaan</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #ddd;">Tanggal</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #ddd;">Status</th>
                                    <th style="padding: 10px; border-bottom: 2px solid #ddd;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $s)
                                    @php
                                        $badges = [
                                            'BERKAS DITERIMA' => 'background: #e0f2fe; color: #0284c7;',
                                            'VERIFIKASI BERKAS' => 'background: #fef9c3; color: #ca8a04;',
                                            'DOKUMEN TERSEDIA' => 'background: #dcfce7; color: #16a34a;',
                                            'DITOLAK' => 'background: #fee2e2; color: #dc2626;',
                                            'PERLU REVISI' => 'background: #ffedd5; color: #ea580c;'
                                        ];
                                        $style = $badges[$s->status] ?? 'background: #f3f4f6; color: #374151;';
                                    @endphp
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 10px;">{{ $s->type }}</td>
                                        <td style="padding: 10px;">{{ $s->subtitle ?? '-' }}</td>
                                        <td style="padding: 10px;">{{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</td>
                                        <td style="padding: 10px;">
                                            <span
                                                style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; {{ $style }}">
                                                {{ $s->status }}
                                            </span>
                                            @if(!empty($s->catatan))
                                                <div style="font-size: 11px; color: #666; margin-top: 4px;">Admin:
                                                    {{ $s->catatan ?? '' }}
                                                </div>
                                            @endif

                                            @if(in_array($s->status, ['DITOLAK', 'PERLU REVISI', 'DITOLAK (Revisi)']))
                                                <div style="margin-top: 5px;">
                                                    <button onclick="editSubmission({{ $s->id }}, '{{ $s->type }}')"
                                                        style="padding: 4px 8px; border: 1px solid #ea580c; background: #fff7ed; color: #ea580c; border-radius: 4px; cursor: pointer; font-size: 11px;">
                                                        ✏️ Perbaiki
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding: 10px;">
                                            <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                <button onclick="showDetailSubmission('{{ $s->type }}', {{ $s->id }})"
                                                    style="padding: 6px 10px; background: var(--blue); color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>

                                                @if($s->status == 'DOKUMEN TERSEDIA' && !empty($s->file_balasan))
                                                    <a href="{{ asset('storage/' . $s->file_balasan) }}" target="_blank"
                                                        style="display: inline-block; padding: 6px 10px; background: #0c2c66; color: white; border-radius: 4px; text-decoration: none; font-size: 12px; display: flex; align-items: center; gap: 4px;">
                                                        <i class="fas fa-download"></i> Surat
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p style="color: #666; font-style: italic;">Belum ada riwayat pengajuan.</p>
                    @endif
                </div>
            </div>

            <!-- PELAYANAN -->
            <div id="pelayanan" class="page hidden">
                <div class="card">
                    <h2>Pilih Jenis Pelayanan</h2>
                    <p class="small">Pilih layanan yang ingin diajukan. Untuk Pengesahan Penyelenggaraan Pelayanan
                        Kesehatan
                        Kerja, pilih opsi Form Lengkap di bawah.</p>

                    <select id="pilihanLayanan" onchange="tampilForm()">
                        <option value="">-- Pilih Layanan --</option>
                        <option value="pelkes_full">Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja di Perusahaan
                        </option>
                        <option value="pelkes">Form Pengajuan SK Pengesahan P2K3</option>
                        <option value="p2k3">Formulir Pelaporan P2K3 &amp; Pelayanan Kesehatan Kerja</option>
                        <option value="kk_pak">Pelaporan Kecelakaan Kerja (KK) / Penyakit Akibat Kerja (PAK)</option>
                    </select>
                </div>

                <div id="form_kk_pak" class="card formdata hidden">
                    <h2>Pelaporan Kecelakaan Kerja (KK) / Penyakit Akibat Kerja (PAK)</h2>

                    <form id="laporForm" novalidate>
                        <fieldset class="no-border-padding">
                            <legend class="section-title">Identitas Pelapor & Akun</legend>
                            <div class="grid">
                                <div>
                                    <label for="reporterEmail">Email</label>
                                    <input id="reporterEmail" type="email" required placeholder="email@example.com"
                                        value="email@example.com">
                                    <div class="muted">Nama, alamat email, dan foto terkait akun akan direkam saat
                                        upload file (sesuai
                                        pemberitahuan Google Forms).</div>
                                </div>
                                <div>
                                    <label for="reporterName">Nama Pelapor</label>
                                    <input id="reporterName" type="text" required placeholder="Nama pelapor">
                                </div>
                                <div>
                                    <label for="reporterPhone">No. HP Pelapor</label>
                                    <input id="reporterPhone" type="text" required placeholder="0812xxxx">
                                </div>
                                <div>
                                    <label for="companyName">Nama Perusahaan</label>
                                    <input id="companyName" type="text" required placeholder="Nama perusahaan">
                                </div>
                                <div>
                                    <label for="companyAddress">Alamat Perusahaan</label>
                                    <input id="companyAddress" type="text" required placeholder="Alamat lengkap">
                                </div>
                                <div>
                                    <label for="companySector">Sektor Perusahaan</label>
                                    <input id="companySector" type="text" required
                                        placeholder="Contoh: Manufaktur / Konstruksi">
                                </div>
                                <div>
                                    <label for="companyLeader">Nama Pimpinan / Pengurus</label>
                                    <input id="companyLeader" type="text" required placeholder="Nama pimpinan">
                                </div>
                                <div>
                                    <label for="leaderAddress">Alamat Pimpinan</label>
                                    <input id="leaderAddress" type="text" required placeholder="Alamat pimpinan">
                                </div>
                            </div>

                            <hr class="separator">

                            <div>
                                <label class="section-title">Jenis Pelaporan</label>
                                <div class="row">
                                    <label class="radio-group"><input type="radio" name="jenisPelaporan" value="kk"
                                            checked> Pelaporan
                                        Kecelakaan Kerja (KK)</label>
                                    <label class="radio-group"><input type="radio" name="jenisPelaporan" value="pak">
                                        Pelaporan Penyakit
                                        Akibat Kerja (PAK)</label>
                                </div>
                            </div>

                            <!-- KK section -->
                            <div id="sectionKK" class="kk-section">
                                <h3 class="section-title">Pelaporan Kecelakaan Kerja (KK)</h3>
                                <p class="muted">Pengisian berdasarkan SK Dirjen Kep.84/BW/1998. Silakan unggah Form
                                    Laporan KK1/PAK1
                                    (PDF, maks 1 MB).</p>
                                <div class="grid">
                                    <div>
                                        <label for="victimName">Nama Pekerja (Korban)</label>
                                        <input id="victimName" type="text" required>
                                    </div>
                                    <div>
                                        <label for="victimAddress">Alamat Pekerja (Korban)</label>
                                        <input id="victimAddress" type="text" required>
                                    </div>
                                    <div>
                                        <label for="victimBirthplace">Tempat / Tanggal Lahir</label>
                                        <input id="victimBirthplace" type="text" placeholder="Tempat, dd-mm-yyyy"
                                            required>
                                    </div>
                                    <div>
                                        <label for="victimKpj">Nomor KPJ Pekerja (Korban)</label>
                                        <input id="victimKpj" type="text" required>
                                    </div>
                                    <div>
                                        <label for="victimJob">Jenis Pekerjaan / Jabatan</label>
                                        <input id="victimJob" type="text" required>
                                    </div>
                                    <div>
                                        <label for="victimUnit">Unit / Bagian Perusahaan</label>
                                        <input id="victimUnit" type="text">
                                    </div>
                                    <div>
                                        <label for="victimWage">Upah Pekerja (Korban)</label>
                                        <input id="victimWage" type="number" min="0" placeholder="Dalam Rupiah">
                                    </div>
                                    <div>
                                        <label for="accidentPlace">Tempat Kecelakaan</label>
                                        <input id="accidentPlace" type="text" required>
                                    </div>
                                    <div>
                                        <label for="accidentDate">Tanggal Kecelakaan</label>
                                        <input id="accidentDate" type="date" required>
                                    </div>
                                    <div>
                                        <label for="accidentTime">Waktu Kecelakaan</label>
                                        <input id="accidentTime" type="time" required>
                                    </div>

                                    <div class="full">
                                        <label for="accidentDesc">Uraian Kejadian Kecelakaan (Kronologis
                                            Lengkap)</label>
                                        <textarea id="accidentDesc" required></textarea>
                                    </div>

                                    <div>
                                        <label for="accidentEffect">Akibat Kecelakaan</label>
                                        <input id="accidentEffect" type="text" required
                                            placeholder="Contoh: Luka, Cacat, Meninggal">
                                    </div>

                                    <div class="full">
                                        <label>Bagian Tubuh Yang Cedera (boleh pilih lebih dari satu)</label>
                                        <div class="row">
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A7">
                                                Kepala (A7)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A8">
                                                Mata (A8)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A9">
                                                Telinga (A9)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A10">
                                                Badan (A10)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A11">
                                                Lengan (A11)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A12">
                                                Tangan (A12)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A13">
                                                Jari Tangan
                                                (A13)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A14">
                                                Paha (A14)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A15">
                                                Kaki (A15)</label>
                                            <label class="checkbox"><input type="checkbox" name="bodyPart" value="A16">
                                                Jari Kaki / Organ
                                                Dalam (A16)</label>
                                        </div>
                                    </div>

                                    <div class="full">
                                        <label>Sumber Kecelakaan</label>
                                        <div class="row">
                                            <label class="checkbox"><input type="checkbox" name="source" value="B1">
                                                Mesin (B1)</label>
                                            <label class="checkbox"><input type="checkbox" name="source" value="B2">
                                                Penggerak Mula / Pompa
                                                (B2)</label>
                                            <label class="checkbox"><input type="checkbox" name="source" value="B10">
                                                Peralatan Listrik
                                                (B10)</label>
                                            <label class="checkbox"><input type="checkbox" name="source" value="B11">
                                                Bahan Kimia
                                                (B11)</label>
                                            <label class="checkbox"><input type="checkbox" name="source" value="B14">
                                                Faktor Lingkungan
                                                (B14)</label>
                                            <label class="checkbox"><input type="checkbox" name="source"
                                                    value="otherSource"> Yang
                                                lain</label>
                                            <input id="otherSourceText" class="hidden"
                                                placeholder="Sebutkan sumber lain" />
                                        </div>
                                    </div>

                                    <div class="full">
                                        <label>Tipe Kecelakaan</label>
                                        <div class="row">
                                            <label class="checkbox"><input type="checkbox" name="type" value="C1">
                                                Terbentur (C1)</label>
                                            <label class="checkbox"><input type="checkbox" name="type" value="C2">
                                                Terpukul (C2)</label>
                                            <label class="checkbox"><input type="checkbox" name="type" value="C3">
                                                Tertangkap (C3)</label>
                                            <label class="checkbox"><input type="checkbox" name="type" value="C4"> Jatuh
                                                sama level
                                                (C4)</label>
                                            <label class="checkbox"><input type="checkbox" name="type" value="C5"> Jatuh
                                                beda level
                                                (C5)</label>
                                            <label class="checkbox"><input type="checkbox" name="type" value="C9">
                                                Tersentuh listrik
                                                (C9)</label>
                                            <label class="checkbox"><input type="checkbox" name="type"
                                                    value="otherType"> Yang lain</label>
                                            <input id="otherTypeText" class="hidden" placeholder="Sebutkan tipe lain" />
                                        </div>
                                    </div>

                                    <div class="full">
                                        <label>Kondisi Yang Berbahaya</label>
                                        <div class="row">
                                            <label class="checkbox"><input type="checkbox" name="condition" value="D1">
                                                Pengamanan tidak
                                                sempurna (D1)</label>
                                            <label class="checkbox"><input type="checkbox" name="condition" value="D4">
                                                Prosedur tidak aman
                                                (D4)</label>
                                            <label class="checkbox"><input type="checkbox" name="condition" value="D6">
                                                Ventilasi tidak
                                                sempurna (D6)</label>
                                            <label class="checkbox"><input type="checkbox" name="condition"
                                                    value="otherCondition"> Yang
                                                lain</label>
                                            <input id="otherConditionText" class="hidden"
                                                placeholder="Sebutkan kondisi lain" />
                                        </div>
                                    </div>

                                    <div class="full">
                                        <label>Tindakan Yang Berbahaya</label>
                                        <div class="row">
                                            <label class="checkbox"><input type="checkbox" name="action" value="E1">
                                                Tanpa wewenang / lupa
                                                mengamankan (E1)</label>
                                            <label class="checkbox"><input type="checkbox" name="action" value="E4">
                                                Memakai peralatan tidak
                                                aman (E4)</label>
                                            <label class="checkbox"><input type="checkbox" name="action" value="E9">
                                                Melalaikan APD
                                                (E9)</label>
                                            <label class="checkbox"><input type="checkbox" name="action"
                                                    value="otherAction"> Yang
                                                lain</label>
                                            <input id="otherActionText" class="hidden"
                                                placeholder="Sebutkan tindakan lain" />
                                        </div>
                                    </div>

                                    <div class="full">
                                        <label>Unggah Dokumen Pelaporan (Form KK1/PAK1) - PDF, maks 1 MB</label>
                                        <input id="reportFile" type="file" accept="application/pdf" />
                                        <div id="fileErr" class="error hidden"></div>
                                        <div id="fileInfo" class="file-info">Belum ada file.</div>
                                    </div>

                                </div>
                            </div>

                            <!-- PAK section -->
                            <div id="sectionPAK" class="pak-section hidden">
                                <h3 class="section-title">Pelaporan Penyakit Akibat Kerja (PAK)</h3>
                                <div class="grid">
                                    <div>
                                        <label for="pakVictimName">Nama Pekerja (Korban)</label>
                                        <input id="pakVictimName" type="text">
                                    </div>
                                    <div>
                                        <label for="pakVictimAddress">Alamat Pekerja (Korban)</label>
                                        <input id="pakVictimAddress" type="text">
                                    </div>
                                    <div>
                                        <label for="pakBirthplace">Tempat / Tanggal Lahir</label>
                                        <input id="pakBirthplace" type="text" placeholder="Tempat, dd-mm-yyyy">
                                    </div>
                                    <div>
                                        <label for="pakKpj">Nomor KPJ Pekerja (Korban)</label>
                                        <input id="pakKpj" type="text">
                                    </div>
                                    <div>
                                        <label for="pakJob">Jenis Pekerjaan / Jabatan</label>
                                        <input id="pakJob" type="text">
                                    </div>
                                    <div>
                                        <label for="pakUnit">Unit / Bagian Perusahaan</label>
                                        <input id="pakUnit" type="text">
                                    </div>

                                    <div>
                                        <label for="pakWage">Upah Pekerja (Korban)</label>
                                        <input id="pakWage" type="number" min="0">
                                    </div>

                                    <div>
                                        <label for="pakDiagnosisDate">Tanggal Penegakan Diagnosis</label>
                                        <input id="pakDiagnosisDate" type="date">
                                    </div>

                                    <div class="full">
                                        <label for="pakDiagnosis">Diagnosis PAK (Nama Penyakit)</label>
                                        <input id="pakDiagnosis" type="text">
                                    </div>

                                    <div class="full">
                                        <label for="pakCause">Penyebab PAK</label>
                                        <textarea id="pakCause"></textarea>
                                    </div>

                                    <div class="full">
                                        <label for="pakWorkDesc">Uraian Pekerjaan Terakhir</label>
                                        <textarea id="pakWorkDesc"></textarea>
                                    </div>

                                    <div class="full">
                                        <label for="pakWorkHistory">Riwayat Jenis Pekerjaan (yang berhubungan)</label>
                                        <textarea id="pakWorkHistory"></textarea>
                                    </div>

                                    <div>
                                        <label for="pakDoctor">Nama Dokter yang Mendiagnosis</label>
                                        <input id="pakDoctor" type="text">
                                    </div>

                                    <div>
                                        <label for="pakFacility">Fasilitas Pelayanan Kesehatan</label>
                                        <input id="pakFacility" type="text">
                                    </div>

                                    <div class="full">
                                        <label for="pakFacilityAddress">Alamat Fasilitas Pelayanan Kesehatan</label>
                                        <input id="pakFacilityAddress" type="text">
                                    </div>

                                    <div class="full">
                                        <label>Unggah Dokumen Pelaporan (Form KK1/PAK1) - PDF, maks 1 MB</label>
                                        <input id="pakReportFile" type="file" accept="application/pdf" />
                                        <div id="pakFileErr" class="error hidden"></div>
                                        <div id="pakFileInfo" class="file-info">Belum ada file.</div>
                                    </div>

                                </div>
                            </div>

                            <div class="flex-buttons">
                                <button type="button" class="btn" id="previewBtn">Pratinjau & Simpan (Unduh
                                    JSON)</button>
                                <button type="reset" class="btn secondary">Reset</button>
                                <div id="formMsg" class="muted ml-auto">Pastikan semua kolom bertanda * terisi.</div>
                            </div>

                            <div id="previewArea" class="preview hidden"></div>

                        </fieldset>
                    </form>
                </div>

                <script>
                    (function () {
                        const root = document.getElementById('form_kk_pak');
                        if (!root) return;
                        const q = sel => root.querySelector(sel);
                        const qa = sel => Array.from(root.querySelectorAll(sel));

                        const jenisEls = qa('input[name="jenisPelaporan"]');
                        const sectionKK = q('#sectionKK');
                        const sectionPAK = q('#sectionPAK');
                        const otherSource = q('#otherSourceText');
                        const otherType = q('#otherTypeText');
                        const otherCondition = q('#otherConditionText');
                        const otherAction = q('#otherActionText');

                        const reportFile = q('#reportFile');
                        const fileInfo = q('#fileInfo');
                        const fileErr = q('#fileErr');

                        const pakReportFile = q('#pakReportFile');
                        const pakFileInfo = q('#pakFileInfo');
                        const pakFileErr = q('#pakFileErr');

                        const previewBtn = q('#previewBtn');
                        const previewArea = q('#previewArea');
                        const formEl = q('#laporForm');
                        const formMsg = q('#formMsg');

                        function toggleSections() {
                            const val = root.querySelector('input[name="jenisPelaporan"]:checked').value;
                            if (val === 'kk') {
                                sectionKK.classList.remove('hidden');
                                sectionPAK.classList.add('hidden');
                            } else {
                                sectionKK.classList.add('hidden');
                                sectionPAK.classList.remove('hidden');
                            }
                        }
                        jenisEls.forEach(el => el.addEventListener('change', toggleSections));
                        toggleSections();

                        // show other text when 'other' checked
                        const otherCb = qa('input[type=checkbox][value="otherSource"], input[type=checkbox][value="otherType"], input[type=checkbox][value="otherCondition"], input[type=checkbox][value="otherAction"]');
                        otherCb.forEach(cb => cb.addEventListener('change', e => {
                            const v = e.target.value;
                            if (v === 'otherSource') otherSource.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherType') otherType.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherCondition') otherCondition.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherAction') otherAction.classList.toggle('hidden', !e.target.checked);
                        }));

                        // file validation helper
                        function handleFileInput(inputEl, infoEl, errEl) {
                            if (!infoEl || !errEl) return null;
                            const f = inputEl.files[0];
                            infoEl.classList.remove('hidden');
                            if (!f) { infoEl.textContent = 'Belum ada file.'; errEl.classList.add('hidden'); return null }
                            if (f.type !== 'application/pdf') {
                                errEl.textContent = 'Tipe file tidak didukung. Harap unggah file PDF.'; errEl.classList.remove('hidden'); infoEl.textContent = 'File error'; return null;
                            }
                            const maxBytes = 1 * 1024 * 1024; // 1 MB
                            if (f.size > maxBytes) {
                                errEl.textContent = 'Ukuran file melebihi 1 MB.'; errEl.classList.remove('hidden'); infoEl.textContent = 'File error'; return null;
                            }
                            errEl.classList.add('hidden');
                            infoEl.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                            return f;
                        }

                        if (reportFile) reportFile.addEventListener('change', () => handleFileInput(reportFile, fileInfo, fileErr));
                        if (pakReportFile) pakReportFile.addEventListener('change', () => handleFileInput(pakReportFile, pakFileInfo, pakFileErr));

                        function gatherChecks(name) {
                            return qa('input[type=checkbox][name="' + name + '"]:checked').map(i => i.value);
                        }

                        async function buildPayload() {
                            const payload = {};
                            payload.reporter = {
                                email: (q('#reporterEmail') && q('#reporterEmail').value) || '',
                                name: (q('#reporterName') && q('#reporterName').value) || '',
                                phone: (q('#reporterPhone') && q('#reporterPhone').value) || ''
                            };
                            payload.company = {
                                name: (q('#companyName') && q('#companyName').value) || '',
                                address: (q('#companyAddress') && q('#companyAddress').value) || '',
                                sector: (q('#companySector') && q('#companySector').value) || '',
                                leader: (q('#companyLeader') && q('#companyLeader').value) || '',
                                leaderAddress: (q('#leaderAddress') && q('#leaderAddress').value) || ''
                            };
                            payload.jenisPelaporan = (root.querySelector('input[name="jenisPelaporan"]:checked') || {}).value || '';

                            if (payload.jenisPelaporan === 'kk') {
                                payload.kk = {
                                    victimName: (q('#victimName') && q('#victimName').value) || '',
                                    victimAddress: (q('#victimAddress') && q('#victimAddress').value) || '',
                                    victimBirthplace: (q('#victimBirthplace') && q('#victimBirthplace').value) || '',
                                    victimKpj: (q('#victimKpj') && q('#victimKpj').value) || '',
                                    job: (q('#victimJob') && q('#victimJob').value) || '',
                                    unit: (q('#victimUnit') && q('#victimUnit').value) || '',
                                    wage: (q('#victimWage') && q('#victimWage').value) || '',
                                    accidentPlace: (q('#accidentPlace') && q('#accidentPlace').value) || '',
                                    accidentDate: (q('#accidentDate') && q('#accidentDate').value) || '',
                                    accidentTime: (q('#accidentTime') && q('#accidentTime').value) || '',
                                    accidentDesc: (q('#accidentDesc') && q('#accidentDesc').value) || '',
                                    accidentEffect: (q('#accidentEffect') && q('#accidentEffect').value) || '',
                                    bodyParts: gatherChecks('bodyPart'),
                                    sources: (function () { const s = gatherChecks('source'); if (s.includes('otherSource')) { const t = (q('#otherSourceText') && q('#otherSourceText').value) || ''; if (t) s.push(t); } return s; })(),
                                    types: (function () { const s = gatherChecks('type'); if (s.includes('otherType')) { const t = (q('#otherTypeText') && q('#otherTypeText').value) || ''; if (t) s.push(t); } return s; })(),
                                    conditions: (function () { const s = gatherChecks('condition'); if (s.includes('otherCondition')) { const t = (q('#otherConditionText') && q('#otherConditionText').value) || ''; if (t) s.push(t); } return s; })(),
                                    actions: (function () { const s = gatherChecks('action'); if (s.includes('otherAction')) { const t = (q('#otherActionText') && q('#otherActionText').value) || ''; if (t) s.push(t); } return s; })()
                                };
                                const f = handleFileInput(reportFile, fileInfo, fileErr);
                                if (f) payload.kk.file = { name: f.name, size: f.size, type: f.type };
                            } else {
                                payload.pak = {
                                    victimName: (q('#pakVictimName') && q('#pakVictimName').value) || '',
                                    victimAddress: (q('#pakVictimAddress') && q('#pakVictimAddress').value) || '',
                                    victimBirthplace: (q('#pakBirthplace') && q('#pakBirthplace').value) || '',
                                    victimKpj: (q('#pakKpj') && q('#pakKpj').value) || '',
                                    job: (q('#pakJob') && q('#pakJob').value) || '',
                                    unit: (q('#pakUnit') && q('#pakUnit').value) || '',
                                    wage: (q('#pakWage') && q('#pakWage').value) || '',
                                    diagnosisDate: (q('#pakDiagnosisDate') && q('#pakDiagnosisDate').value) || '',
                                    diagnosis: (q('#pakDiagnosis') && q('#pakDiagnosis').value) || '',
                                    cause: (q('#pakCause') && q('#pakCause').value) || '',
                                    workDesc: (q('#pakWorkDesc') && q('#pakWorkDesc').value) || '',
                                    workHistory: (q('#pakWorkHistory') && q('#pakWorkHistory').value) || '',
                                    doctor: (q('#pakDoctor') && q('#pakDoctor').value) || '',
                                    facility: (q('#pakFacility') && q('#pakFacility').value) || '',
                                    facilityAddress: (q('#pakFacilityAddress') && q('#pakFacilityAddress').value) || ''
                                };
                                const f = handleFileInput(pakReportFile, pakFileInfo, pakFileErr);
                                if (f) payload.pak.file = { name: f.name, size: f.size, type: f.type };
                            }
                            return payload;
                        }

                        function validateRequired() {
                            let ok = true;
                            const requiredIds = ['reporterEmail', 'reporterName', 'reporterPhone', 'companyName', 'companyAddress', 'companySector', 'companyLeader', 'leaderAddress'];
                            requiredIds.forEach(id => {
                                const el = q('#' + id);
                                if (!el) return;
                                if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else { el.style.borderColor = '' }
                            });
                            const jenis = (root.querySelector('input[name="jenisPelaporan"]:checked') || {}).value;
                            if (jenis === 'kk') {
                                ['victimName', 'victimAddress', 'victimBirthplace', 'victimKpj', 'victimJob', 'accidentPlace', 'accidentDate', 'accidentTime', 'accidentDesc', 'accidentEffect'].forEach(id => { const el = q('#' + id); if (!el) return; if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else el.style.borderColor = ''; })
                            } else {
                                ['pakVictimName', 'pakVictimAddress', 'pakKpj', 'pakDiagnosisDate', 'pakDiagnosis', 'pakDoctor', 'pakFacility', 'pakFacilityAddress'].forEach(id => { const el = q('#' + id); if (!el) return; if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else el.style.borderColor = ''; })
                            }
                            return ok;
                        }

                        previewBtn.addEventListener('click', async () => {
                            previewArea.classList.add('hidden');
                            if (!validateRequired()) {
                                formMsg.textContent = 'Masih ada kolom wajib yang kosong. Periksa kolom berwarna merah.';
                                formMsg.style.color = '#b91c1c';
                                return;
                            }
                            formMsg.textContent = 'Siap. Menyiapkan pratinjau...'; formMsg.style.color = '';
                            const payload = await buildPayload();
                            previewArea.innerHTML = '<pre style="white-space:pre-wrap;max-height:420px;overflow:auto">' + JSON.stringify(payload, null, 2) + '</pre>';
                            previewArea.classList.remove('hidden');
                            const blob = new Blob([JSON.stringify(payload, null, 2)], { type: 'application/json' });
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            const ts = new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-');
                            a.download = (payload.jenisPelaporan === 'kk' ? 'laporan-KK-' : 'laporan-PAK-') + ts + '.json';
                            a.textContent = 'Unduh JSON laporan';
                            a.className = 'btn';
                            a.style.display = 'inline-block';
                            a.style.marginTop = '10px';
                            const prevLink = previewArea.querySelector('a'); if (prevLink) prevLink.remove();
                            previewArea.appendChild(a);
                            formMsg.textContent = 'Pratinjau siap. Klik "Unduh JSON laporan" untuk menyimpan data. Untuk pengiriman resmi, integrasikan ke backend atau kirim ke BPJS/Dinas melalui prosedur resmi.';
                            formMsg.style.color = 'green';
                        });

                        // reset handlers to clear preview
                        formEl.addEventListener('reset', () => {
                            setTimeout(() => {
                                previewArea.classList.add('hidden');
                                if (fileInfo) fileInfo.textContent = 'Belum ada file.';
                                if (pakFileInfo) pakFileInfo.textContent = 'Belum ada file.';
                                if (fileErr) fileErr.classList.add('hidden');
                                if (pakFileErr) pakFileErr.classList.add('hidden');
                                qa('input').forEach(i => { try { i.style.borderColor = ''; } catch (e) { } });
                            }, 50);
                        });

                        // prevent actual submit
                        (default behavior)
                        formEl.addEventListener('submit', e => { e.preventDefault(); });

                        // REAL SUBMIT TO SERVER
                        async function submitReport() {
                            if (!validateRequired()) {
                                formMsg.textContent = 'Masih ada kolom wajib yang kosong. Periksa kolom berwarna merah.';
                                formMsg.style.color = '#b91c1c';
                                return;
                            }
                            if (!confirm('Kirim laporan ke database?')) return;

                            const fd = new FormData();
                            // Common fields
                            const getVal = (id) => (document.getElementById(id) ? document.getElementById(id).value : '');

                            // Map to Controller Expectation (KKPAKController)
                            // Controller expects: jenis, nama_pekerja, alamat, pekerjaan, uraian, dokumen (file)
                            // Plus: kpj, unit, upah, tgl_lahir in 'catatan' field or separate if schema supports.
                            // Schema 'pelaporan_kk_pak': nama_perusahaan, alamat_perusahaan, nama_korban, jabatan_korban, jenis_kecelakaan, kronologi, tanggal_kejadian, file_bukti, catatan

                            const jenis = root.querySelector('input[name="jenisPelaporan"]:checked').value;
                            fd.append('jenis', jenis); // 'kk' or 'pak'

                            // Reporter & Company Info (shared)
                            fd.append('nama_perusahaan', getVal('companyName'));
                            fd.append('alamat', getVal('companyAddress'));

                            if (jenis === 'kk') {
                                fd.append('nama_pekerja', getVal('victimName'));
                                fd.append('pekerjaan', getVal('victimJob')); // maps to jabatan_korban
                                fd.append('uraian', getVal('accidentDesc')); // maps to kronologi
                                fd.append('tanggal_kejadian', getVal('accidentDate')); // schema has nullable date

                                // Extra info for 'catatan'
                                fd.append('kpj', getVal('victimKpj'));
                                fd.append('unit', getVal('victimUnit'));
                                fd.append('upah', getVal('victimWage'));
                                fd.append('tgl_lahir', getVal('victimBirthplace'));

                                // File
                                const f = reportFile.files[0];
                                if (f) fd.append('dokumen', f);

                            } else {
                                // PAK
                                fd.append('nama_pekerja', getVal('pakVictimName'));
                                fd.append('pekerjaan', getVal('pakJob'));
                                fd.append('uraian', getVal('pakCause')); // kronologi = cause ? or workDesc? Controller uses 'uraian' -> kronologi

                                // Extra info
                                fd.append('kpj', getVal('pakKpj'));
                                fd.append('unit', getVal('pakUnit'));
                                fd.append('upah', getVal('pakWage'));
                                fd.append('tgl_lahir', getVal('pakBirthplace'));

                                const f = pakReportFile.files[0];
                                if (f) fd.append('dokumen', f);
                            }

                            try {
                                const resp = await fetch('/submit-kkpak', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: fd
                                });

                                if (resp.status === 419) {
                                    alert('⏳ Sesi Anda telah berakhir. Silakan refresh halaman dan login kembali.');
                                    window.location.reload();
                                    return;
                                }

                                const json = await resp.json();
                                if (!resp.ok) throw json;
                                alert('Sukses: ' + (json.message || 'Laporan terkirim'));
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        }

                        // Add a button for Real Submit if not exists or replace the Preview logic? 
                        // The user UI has "Pratinjau & Simpan (Unduh JSON)". 
                        // Let's add a separate "Kirim ke Database" button next to "Preview" or change the logic.
                        // I will add a new button dynamically for clarity.
                        const btnArea = root.querySelector('.flex-buttons');
                        const sendBtn = document.createElement('button');
                        sendBtn.type = 'button';
                        sendBtn.className = 'btn-primary'; // assume btn-primary exists or btn
                        sendBtn.textContent = 'Kirim Laporan (Database)';
                        sendBtn.style.marginLeft = '10px';
                        sendBtn.style.backgroundColor = '#0c2c66';
                        sendBtn.style.color = 'white';
                        sendBtn.onclick = submitReport;

                        // Check if already added to avoid dupes on re-run (though this is page load script)
                        if (!btnArea.querySelector('button[data-real-submit]')) {
                            sendBtn.setAttribute('data-real-submit', 'true');
                            btnArea.insertBefore(sendBtn, btnArea.firstChild);
                        }
                    })();
                </script>




                <div id="form_p2k3" class="card formdata hidden">
                    <h2>Pelaporan Kegiatan P2K3 dan Pelayanan Kesehatan Kerja di Perusahaan</h2>

                    <p class="small">
                        Pelaporan kegiatan P2K3 dan penyelenggaraan pelayanan kesehatan kerja wajib dilakukan setiap 3
                        (tiga) bulan
                        sekali kepada Dinas yang membidangi ketenagakerjaan di Provinsi sesuai peraturan terkait.
                    </p>

                    <form id="form_p2k3_short" novalidate>
                        <!-- Contact / notice -->
                        <label for="p2k3_email">Email <span class="small">* (digunakan untuk notifikasi)</span></label>
                        <input id="p2k3_email" type="email" placeholder="email@example.com"
                            title="Masukkan alamat email" required>

                        <div class="fieldset">
                            <strong>Data Umum Perusahaan</strong>
                            <div class="small">Silahkan mengisi data umum perusahaan terlebih dahulu.</div>

                            <label for="p2k3_nama">Nama Perusahaan <span class="small">*</span></label>
                            <input id="p2k3_nama" type="text" placeholder="CONTOH: PT MAJU TERUS PANTANG MUNDUR"
                                title="Nama perusahaan (gunakan huruf besar)" required>

                            <label for="p2k3_alamat">Alamat Perusahaan <span class="small">*</span></label>
                            <textarea id="p2k3_alamat" placeholder="Alamat lengkap perusahaan" title="Alamat perusahaan"
                                required></textarea>

                            <label for="p2k3_sektor">Sektor Perusahaan <span class="small">*</span></label>
                            <input id="p2k3_sektor" type="text" placeholder="Contoh: Manufaktur / Jasa"
                                title="Sektor perusahaan" required>

                            <label for="p2k3_pimpinan">Nama Pimpinan Perusahaan <span class="small">*</span></label>
                            <input id="p2k3_pimpinan" type="text" placeholder="Nama lengkap pimpinan"
                                title="Nama pimpinan" required>

                            <label for="p2k3_jabatan">Jabatan Pimpinan <span class="small">*</span></label>
                            <input id="p2k3_jabatan" type="text" placeholder="Contoh: Direktur Utama"
                                title="Jabatan pimpinan" required>

                            <div class="row">
                                <div class="col">
                                    <label for="p2k3_wni_laki">Jumlah TK WNI Laki-Laki <span
                                            class="small">*</span></label>
                                    <input id="p2k3_wni_laki" type="number" min="0" value="0" placeholder="0"
                                        title="Angka saja" required>
                                </div>
                                <div class="col">
                                    <label for="p2k3_wni_perempuan">Jumlah TK WNI Perempuan <span
                                            class="small">*</span></label>
                                    <input id="p2k3_wni_perempuan" type="number" min="0" value="0" placeholder="0"
                                        title="Angka saja" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="p2k3_wna_laki">Jumlah TK WNA Laki-Laki <span
                                            class="small">*</span></label>
                                    <input id="p2k3_wna_laki" type="number" min="0" value="0" placeholder="0"
                                        title="Jika tidak ada isi 0" required>
                                </div>
                                <div class="col">
                                    <label for="p2k3_wna_perempuan">Jumlah TK WNA Perempuan <span
                                            class="small">*</span></label>
                                    <input id="p2k3_wna_perempuan" type="number" min="0" value="0" placeholder="0"
                                        title="Jika tidak ada isi 0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="p2k3_tahun">Tahun Pelaporan <span class="small">*</span></label>
                                    <input id="p2k3_tahun" type="number" min="2000" max="2100" placeholder="2025"
                                        title="Tahun pelaporan" required>
                                </div>
                                <div class="col">
                                    <label for="p2k3_tanggal">Tanggal Pelaporan <span class="small">*</span></label>
                                    <input id="p2k3_tanggal" type="text" placeholder="Contoh: 11 Januari 2025"
                                        title="Tanggal pelaporan contoh: 11 Januari 2025" required>
                                </div>
                            </div>

                            <label for="p2k3_jenis">Jenis Penyampaian Laporan <span class="small">*</span></label>
                            <select id="p2k3_jenis" title="Pilih jenis laporan" required>
                                <option value="">-- Pilih Jenis Laporan --</option>
                                <option value="p2k3">Laporan P2K3</option>
                                <option value="pelkes">Laporan Penyelenggaraan Pelayanan Kesehatan Kerja</option>
                            </select>
                        </div>

                        <!-- SECTION: Laporan P2K3 -->
                        <div id="p2k3_section" class="fieldset hidden">
                            <h3>Data Laporan P2K3</h3>

                            <label for="p2k3_triwulan">Pelaporan P2K3 <span class="small">*</span></label>
                            <select id="p2k3_triwulan" title="Pilih triwulan" required>
                                <option value="">-- Pilih Triwulan --</option>
                                <option>Triwulan I</option>
                                <option>Triwulan II</option>
                                <option>Triwulan III</option>
                                <option>Triwulan IV</option>
                            </select>

                            <label for="p2k3_ketua">Nama Ketua <span class="small">*</span></label>
                            <input id="p2k3_ketua" type="text" placeholder="Nama Ketua P2K3" title="Nama Ketua"
                                required>

                            <label for="p2k3_waket">Nama Wakil Ketua (Jika ada)</label>
                            <input id="p2k3_waket" type="text" placeholder="Nama Wakil Ketua" title="Nama Wakil Ketua">

                            <label for="p2k3_sekretaris">Nama Sekretaris <span class="small">*</span></label>
                            <input id="p2k3_sekretaris" type="text" placeholder="Nama Sekretaris"
                                title="Nama Sekretaris" required>

                            <label for="p2k3_nomorsk">Nomor SK P2K3 <span class="small">*</span></label>
                            <input id="p2k3_nomorsk" type="text" placeholder="Nomor SK P2K3" title="Nomor SK P2K3"
                                required>

                            <label for="p2k3_jumlah_ak3u">Jumlah Ahli K3 Umum <span class="small">*</span></label>
                            <input id="p2k3_jumlah_ak3u" type="number" min="0" value="0" placeholder="0"
                                title="Jumlah AK3U yang memiliki SKP" required>

                            <label>Ahli K3 Spesialis Yang Dimiliki</label>
                            <div>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="kebakaran"> Ahli K3
                                    Kebakaran</label><br>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="kimia"> Ahli K3
                                    Kimia</label><br>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="lingkungan"> Ahli K3
                                    Lingkungan
                                    Kerja</label><br>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="konstruksi"> Ahli K3
                                    Konstruksi</label><br>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="listrik"> Ahli K3
                                    Listrik</label><br>
                                <label><input type="checkbox" name="p2k3_ahli_spesialis" value="lainnya"> Yang
                                    lain</label>
                                <input id="p2k3_ahli_lain" type="text" placeholder="Keterangan jika ada"
                                    title="Keterangan ahli lain">
                            </div>

                            <label>Telah memiliki Kebijakan K3</label>
                            <div>
                                <label><input type="radio" name="p2k3_kebijakan" value="ya" required> Ya</label>
                                <label><input type="radio" name="p2k3_kebijakan" value="tidak"> Tidak</label>
                            </div>

                            <label>Telah membuat Program K3</label>
                            <div>
                                <label><input type="radio" name="p2k3_program" value="ya" required> Ya</label>
                                <label><input type="radio" name="p2k3_program" value="tidak"> Tidak</label>
                            </div>

                            <label>Pelaksanaan Evaluasi K3 (pilih yang relevan)</label>
                            <div>
                                <label><input type="checkbox" name="p2k3_eval" value="proses"> Proses Produksi</label>
                                <label><input type="checkbox" name="p2k3_eval" value="peralatan"> Peralatan
                                    Mesin</label>
                                <label><input type="checkbox" name="p2k3_eval" value="apd"> Alat Pengaman / APD</label>
                                <label><input type="checkbox" name="p2k3_eval" value="tenaga"> Tenaga Kerja</label>
                                <label><input type="checkbox" name="p2k3_eval" value="kebakaran"> Pencegahan
                                    Kebakaran</label>
                                <label><input type="checkbox" name="p2k3_eval" value="lingkungan"> Lingkungan
                                    Kerja</label>
                            </div>

                            <label>Pelaporan dan Pendataan Kecelakaan Kerja dan PAK</label>
                            <div>
                                <label><input type="radio" name="p2k3_pak" value="ada" required> Ada</label>
                                <label><input type="radio" name="p2k3_pak" value="tidak"> Tidak ada</label>
                            </div>

                            <label>Analisis Kecelakaan Kerja / PAK</label>
                            <div>
                                <label><input type="radio" name="p2k3_analisis" value="ada" required> Ada</label>
                                <label><input type="radio" name="p2k3_analisis" value="tidak"> Tidak Ada</label>
                            </div>

                            <label>Hambatan dalam pelaksanaan Program K3 <span class="small">*</span></label>
                            <textarea id="p2k3_hambatan" placeholder="Jelaskan hambatan"
                                title="Hambatan dalam pelaksanaan K3" required></textarea>

                            <label>Langkah tindak lanjut yang dilakukan <span class="small">*</span></label>
                            <textarea id="p2k3_tindaklanjut" placeholder="Langkah yang diambil untuk mengatasi hambatan"
                                title="Langkah tindak lanjut" required></textarea>

                            <label>Telah Selesai Melakukan Pengisian</label>
                            <div>
                                <label><input type="checkbox" id="p2k3_selesai" title="Cek jika telah selesai mengisi">
                                    Ya</label>
                            </div>

                            <label for="p2k3_file_report">Unggah Dokumen Pelaporan P2K3 <span
                                    class="small">*</span></label>
                            <input id="p2k3_file_report" type="file" accept="application/pdf"
                                title="Upload PDF, maks 10 MB" required>
                            <div class="file-hint">Upload 1 file PDF. Maks 10 MB.</div>
                            <div id="p2k3_err_file" class="error"></div>
                        </div>

                        <!-- SECTION: Laporan Penyelenggaraan Pelayanan Kesehatan Kerja -->
                        <div id="pelkes_section" class="fieldset hidden">
                            <h3>Data Laporan Penyelenggaraan Pelayanan Kesehatan Kerja</h3>

                            <label for="pelkes_triwulan">Pelaporan Pelayanan Kesehatan Kerja <span
                                    class="small">*</span></label>
                            <select id="pelkes_triwulan" title="Pilih triwulan" required>
                                <option value="">-- Pilih Triwulan --</option>
                                <option>Triwulan I</option>
                                <option>Triwulan II</option>
                                <option>Triwulan III</option>
                                <option>Triwulan IV</option>
                            </select>

                            <label>Bentuk Penyelenggaraan <span class="small">*</span></label>
                            <div>
                                <label><input type="radio" name="pelkes_bentuk" value="sendiri" required>
                                    Diselenggarakan sendiri oleh
                                    Pengurus Perusahaan</label><br>
                                <label><input type="radio" name="pelkes_bentuk" value="kerjasama"> Diselenggarakan
                                    melalui
                                    kerjasama</label><br>
                                <label><input type="radio" name="pelkes_bentuk" value="bersama"> Diselenggarakan bersama
                                    beberapa
                                    perusahaan</label>
                            </div>

                            <div id="pelkes_sendiri_type" class="small hidden">
                                <label>Bentuk Penyelenggaraan (jika sendiri)</label>
                                <label><input type="checkbox" name="pelkes_sendiri" value="rs"> Rumah Sakit
                                    Perusahaan</label>
                                <label><input type="checkbox" name="pelkes_sendiri" value="klinik"> Klinik
                                    Perusahaan</label>
                                <input id="pelkes_sendiri_lain" type="text" placeholder="Lainnya, sebutkan"
                                    title="Bentuk lain jika ada">
                            </div>

                            <label for="pelkes_nomorsk">Nomor SK Penyelenggaraan dari Disnaker</label>
                            <input id="pelkes_nomorsk" type="text" placeholder="Nomor SK dari Disnaker"
                                title="Nomor SK Penyelenggaraan">

                            <label for="pelkes_dokter">Nama Dokter Penanggung Jawab <span class="small">*</span></label>
                            <input id="pelkes_dokter" type="text" placeholder="Contoh: dr. ROGER, Ph.D"
                                title="Nama dokter lengkap dengan gelar" required>

                            <label>Dokter Penanggung Jawab memiliki SKP?</label>
                            <div>
                                <label><input type="radio" name="pelkes_skp" value="ya" required> Ya</label>
                                <label><input type="radio" name="pelkes_skp" value="tidak"> Tidak</label>
                            </div>

                            <label for="pelkes_nomorskp">Nomor SKP Dokter (jika ada)</label>
                            <input id="pelkes_nomorskp" type="text" placeholder="Nomor SKP" title="Nomor SKP">

                            <label for="pelkes_masa_skp">Masa Berlaku SKP Dokter</label>
                            <input id="pelkes_masa_skp" type="date" title="Tanggal masa berlaku SKP">

                            <div class="row">
                                <div class="col">
                                    <label for="pelkes_jumlah_dokter">Jumlah Dokter di perusahaan</label>
                                    <input id="pelkes_jumlah_dokter" type="number" min="0" value="0" placeholder="0"
                                        title="Jumlah dokter">
                                </div>
                                <div class="col">
                                    <label for="pelkes_jumlah_hiperkes">Jumlah Dokter yang memiliki Sertifikat
                                        Hiperkes</label>
                                    <input id="pelkes_jumlah_hiperkes" type="number" min="0" value="0" placeholder="0"
                                        title="Jumlah dokter bersertifikat">
                                </div>
                            </div>

                            <label>Sarana Dasar Pelayanan Kesehatan Kerja (centang yang ada)</label>
                            <div>
                                <label><input type="checkbox" name="pelkes_sarana" value="ruang_tunggu"> Ruang
                                    Tunggu</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="ruang_periksa"> Ruang
                                    Periksa</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="lemari_obat"> Lemari
                                    Obat</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="wc"> Kamar Mandi / WC</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="alat_ukur"> Timbangan /
                                    Pengukur
                                    Tinggi</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="register"> Register
                                    Pasien</label>
                                <label><input type="checkbox" name="pelkes_sarana" value="p3k"> Sarana P3K</label>
                            </div>

                            <label>Sarana Penunjang Pelayanan Kesehatan Kerja</label>
                            <div>
                                <label><input type="checkbox" name="pelkes_penunjang" value="apd"> Alat Pelindung Diri
                                    (APD)</label>
                                <label><input type="checkbox" name="pelkes_penunjang" value="spirometer">
                                    Spirometer</label>
                                <label><input type="checkbox" name="pelkes_penunjang" value="audiometer">
                                    Audiometer</label>
                                <label><input type="checkbox" name="pelkes_penunjang" value="gas_detector"> Gas
                                    Detector</label>
                            </div>

                            <label for="pelkes_jumlah_kecelakaan">Jumlah Kecelakaan Kerja tercatat selama periode
                                pelaporan</label>
                            <input id="pelkes_jumlah_kecelakaan" type="number" min="0" value="0" placeholder="0"
                                title="Jumlah kecelakaan">

                            <label>Telah selesai melakukan pengisian</label>
                            <div>
                                <label><input type="checkbox" id="pelkes_selesai" title="Cek jika telah selesai">
                                    Ya</label>
                            </div>

                            <label for="pelkes_file_report">Unggah Dokumen Pelaporan Pelayanan Kesehatan Kerja <span
                                    class="small">*</span></label>
                            <input id="pelkes_file_report" type="file" accept="application/pdf"
                                title="Upload PDF, maks 10 MB" required>
                            <div class="file-hint">Upload 1 file PDF. Maks 10 MB.</div>
                            <div id="pelkes_err_file" class="error"></div>
                        </div>

                        <div class="actions">
                            <button type="button" id="p2k3_preview">Preview JSON</button>
                            <button type="submit">Kirim Laporan</button>
                            <button type="button" id="p2k3_reset" class="ghost">Reset Form</button>
                        </div>

                        <div id="p2k3_result" class="fieldset hidden mt-14">
                            <strong>Hasil Preview (JSON)</strong>
                            <pre id="p2k3_json" class="json-preview"></pre>
                        </div>
                    </form>

                    <script>
                        // helper selectors
                        const jenis = document.getElementById('p2k3_jenis');
                        const sectionP2k3 = document.getElementById('p2k3_section');
                        const sectionPelkes = document.getElementById('pelkes_section');
                        const form = document.getElementById('form_p2k3_short');

                        // toggle sections by jenis
                        jenis.addEventListener('change', () => {
                            sectionP2k3.classList.toggle('hidden', jenis.value !== 'p2k3');
                            sectionPelkes.classList.toggle('hidden', jenis.value !== 'pelkes');
                        });

                        // show sub-type when 'sendiri' selected
                        Array.from(document.getElementsByName('pelkes_bentuk')).forEach(r => {
                            r.addEventListener('change', () => {
                                const el = document.getElementById('pelkes_sendiri_type');
                                el.classList.toggle('hidden', document.querySelector('input[name="pelkes_bentuk"]:checked')?.value !== 'sendiri');
                            });
                        });

                        // uppercase company name
                        document.getElementById('p2k3_nama').addEventListener('input', (e) => {
                            const s = e.target.selectionStart;
                            e.target.value = e.target.value.toUpperCase();
                            e.target.selectionStart = e.target.selectionEnd = s;
                        });

                        // file size validation (max 10 MB)
                        function validateFileMax10MB(input, errId) {
                            const errEl = document.getElementById(errId);
                            errEl.textContent = '';
                            if (!input.files || input.files.length === 0) { errEl.textContent = 'File belum dipilih.'; return false; }
                            const f = input.files[0];
                            if (f.type !== 'application/pdf') { errEl.textContent = 'File harus berformat PDF.'; return false; }
                            if (f.size > 10 * 1024 * 1024) { errEl.textContent = 'Ukuran file melebihi 10 MB.'; return false; }
                            return true;
                        }

                        document.getElementById('p2k3_file_report').addEventListener('change', () => validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file'));
                        document.getElementById('pelkes_file_report').addEventListener('change', () => validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file'));

                        // Preview JSON
                        document.getElementById('p2k3_preview').addEventListener('click', () => {
                            // basic required checks
                            const required = ['p2k3_email', 'p2k3_nama', 'p2k3_alamat', 'p2k3_sektor', 'p2k3_pimpinan', 'p2k3_jabatan', 'p2k3_tahun', 'p2k3_tanggal', 'p2k3_jenis'];
                            for (const id of required) {
                                const el = document.getElementById(id);
                                if (el && !el.value) { alert('Mohon isi field wajib: ' + id); return; }
                            }
                            const kind = jenis.value;
                            if (kind === 'p2k3') {
                                if (!validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file')) { alert('Periksa file laporan P2K3'); return; }
                            } else if (kind === 'pelkes') {
                                if (!validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file')) { alert('Periksa file laporan Pelayanan Kesehatan Kerja'); return; }
                            } else { alert('Pilih jenis laporan'); return; }

                            // collect minimal preview data
                            const data = {
                                email: document.getElementById('p2k3_email').value,
                                perusahaan: document.getElementById('p2k3_nama').value,
                                tahun: document.getElementById('p2k3_tahun').value,
                                tanggal_pelaporan: document.getElementById('p2k3_tanggal').value,
                                jenis_laporan: jenis.value,
                                jumlah_tenaga_kerja: {
                                    wni_laki: Number(document.getElementById('p2k3_wni_laki').value || 0),
                                    wni_perempuan: Number(document.getElementById('p2k3_wni_perempuan').value || 0),
                                    wna_laki: Number(document.getElementById('p2k3_wna_laki').value || 0),
                                    wna_perempuan: Number(document.getElementById('p2k3_wna_perempuan').value || 0)
                                }
                            };
                            if (kind === 'p2k3') {
                                data.p2k3 = {
                                    triwulan: document.getElementById('p2k3_triwulan').value,
                                    ketua: document.getElementById('p2k3_ketua').value,
                                    sekretaris: document.getElementById('p2k3_sekretaris').value,
                                    nomor_sk: document.getElementById('p2k3_nomorsk').value,
                                    hambatan: document.getElementById('p2k3_hambatan').value
                                };
                                const f = document.getElementById('p2k3_file_report').files[0];
                                if (f) data.p2k3.file = { name: f.name, size: f.size };
                            } else {
                                data.pelkes = {
                                    triwulan: document.getElementById('pelkes_triwulan').value,
                                    dokter: document.getElementById('pelkes_dokter').value,
                                    jumlah_dokter: Number(document.getElementById('pelkes_jumlah_dokter').value || 0)
                                };
                                const f = document.getElementById('pelkes_file_report').files[0];
                                if (f) data.pelkes.file = { name: f.name, size: f.size };
                            }

                            document.getElementById('p2k3_json').textContent = JSON.stringify(data, null, 2);
                            document.getElementById('p2k3_result').classList.remove('hidden');
                            document.getElementById('p2k3_result').scrollIntoView({ behavior: 'smooth' });
                        });

                        // simple submit handler (demo)
                        // simple submit handler (updated to Real Submit)
                        form.addEventListener('submit', async (e) => {
                            e.preventDefault();

                            // final validation
                            let isValid = true;
                            if (jenis.value === 'p2k3') {
                                if (!validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file')) isValid = false;
                            } else if (jenis.value === 'pelkes') {
                                if (!validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file')) isValid = false;
                            } else {
                                alert('Pilih jenis laporan'); return;
                            }
                            if (!isValid) return;

                            if (!confirm('Kirim Laporan P2K3 ke Dinas?')) return;

                            const fd = new FormData();
                            // Collect all inputs automatically
                            // This is a short-cut to collect p2k3_ data
                            form.querySelectorAll('input, select, textarea').forEach(el => {
                                if (el.id && el.type !== 'file' && el.type !== 'radio' && el.type !== 'checkbox') {
                                    fd.append(el.id, el.value);
                                }
                                if (el.type === 'radio' && el.checked) {
                                    fd.append(el.name, el.value);
                                }
                                if (el.type === 'checkbox' && el.checked) {
                                    fd.append(el.name, el.value); // handles array if name has []
                                }
                            });

                            // Files
                            if (jenis.value === 'p2k3') {
                                const f = document.getElementById('p2k3_file_report').files[0];
                                if (f) fd.append('dokumen', f);
                            } else {
                                const f = document.getElementById('pelkes_file_report').files[0];
                                if (f) fd.append('dokumen', f);
                            }

                            try {
                                const resp = await fetch('/submit-pelaporan-p2k3', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: fd
                                });

                                if (resp.status === 419) {
                                    alert('⏳ Sesi Anda telah berakhir. Silakan refresh halaman dan login kembali.');
                                    window.location.reload();
                                    return;
                                }

                                const json = await resp.json();
                                if (!resp.ok) throw json;
                                alert('Sukses: ' + (json.message || 'Laporan terkirim'));
                                // optional reset
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        });

                        // reset form
                        document.getElementById('p2k3_reset').addEventListener('click', () => {
                            if (confirm('Reset semua isian?')) {
                                form.reset();
                                sectionP2k3.classList.add('hidden');
                                sectionPelkes.classList.add('hidden');
                                document.getElementById('p2k3_result').classList.add('hidden');
                                document.getElementById('p2k3_err_file').textContent = '';
                                document.getElementById('pelkes_err_file').textContent = '';
                            }
                        });
                    </script>
                </div>

                <!-- ======= FORM SINGKAT: Pengajuan SK Pengesahan P2K3 ======= -->
                <div id="form_pelkes" class="card formdata hidden">
                    <h2>Form Pengajuan SK Pengesahan P2K3</h2>
                    <form id="real_form_sk_p2k3" onsubmit="handleSkP2k3Submit(event)">
                        <label>Jenis Pengajuan <span class="text-red-500">*</span></label>
                        <select id="sk_jenis" required>
                            <option value="">-- Pilih --</option>
                            <option value="baru">Pembuatan Baru SK Pengesahan P2K3</option>
                            <option value="perubahan">Perubahan SK Pengesahan P2K3</option>
                        </select>

                        <div id="div_sk_lama" class="hidden" style="margin-top:10px;">
                            <label>Dokumen SK Pengesahan P2K3 Lama</label>
                            <input id="sk_file_lama" type="file" accept="application/pdf">
                        </div>

                        <label>Nama Perusahaan <span class="text-red-500">*</span></label>
                        <input id="sk_nama_perusahaan" type="text" required placeholder="PT...">

                        <label>Alamat Perusahaan <span class="text-red-500">*</span></label>
                        <textarea id="sk_alamat" required placeholder="Alamat Lengkap"></textarea>

                        <label>Sektor Perusahaan <span class="text-red-500">*</span></label>
                        <input id="sk_sektor" type="text" required>

                        <div class="row">
                            <div class="col">
                                <label>Jumlah Tenaga Kerja (Laki-Laki) <span class="text-red-500">*</span></label>
                                <input id="sk_tk_laki" type="number" required min="0">
                            </div>
                            <div class="col">
                                <label>Jumlah Tenaga Kerja (Perempuan) <span class="text-red-500">*</span></label>
                                <input id="sk_tk_perempuan" type="number" required min="0">
                            </div>
                        </div>

                        <label>Surat Permohonan Pengesahan P2K3 <span class="text-red-500">*</span> (PDF)</label>
                        <input id="sk_file_permohonan" type="file" accept="application/pdf" required>

                        <label>Nama Ahli K3 / Sekretaris P2K3 <span class="text-red-500">*</span></label>
                        <input id="sk_ahli_k3" type="text" required>

                        <label>Sertifikat Ahli K3, SKP dan Kartu Kewenangan <span class="text-red-500">*</span>
                            (PDF)</label>
                        <input id="sk_file_sertifikat" type="file" accept="application/pdf" required>

                        <label>Sertifikat Ahli K3 Tambahan (Jika Ada) (PDF)</label>
                        <input id="sk_file_tambahan" type="file" accept="application/pdf">

                        <label>Tanda Bukti Kepesertaan BPJS Ketenagakerjaan <span class="text-red-500">*</span>
                            (PDF)</label>
                        <input id="sk_file_bpjs_tk" type="file" accept="application/pdf" required>

                        <label>Tanda Bukti Kepesertaan BPJS Kesehatan <span class="text-red-500">*</span> (PDF)</label>
                        <input id="sk_file_bpjs_kes" type="file" accept="application/pdf" required>

                        <label>Tanda Bukti Pengisian WLKP <span class="text-red-500">*</span> (PDF)</label>
                        <input id="sk_file_wlkp" type="file" accept="application/pdf" required>

                        <label>Nomor yang bisa dihubungi <span class="text-red-500">*</span></label>
                        <input id="sk_kontak" type="tel" placeholder="0812xxxxxxx" required>

                        <div style="margin-top: 20px;">
                            <button type="submit" class="btn-primary">Kirim Pengajuan SK P2K3</button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('sk_jenis').addEventListener('change', function (e) {
                            const val = e.target.value;
                            document.getElementById('div_sk_lama').classList.toggle('hidden', val !== 'perubahan');
                        });

                        async function handleSkP2k3Submit(e) {
                            e.preventDefault();
                            if (!confirm('Apakah data sudah benar?')) return;

                            const fd = new FormData();
                            fd.append('jenis', document.getElementById('sk_jenis').value);
                            fd.append('nama_perusahaan', document.getElementById('sk_nama_perusahaan').value);
                            fd.append('alamat', document.getElementById('sk_alamat').value);
                            fd.append('sektor', document.getElementById('sk_sektor').value);
                            fd.append('jumlah_tk', document.getElementById('sk_tk_laki').value); // Controller expects jumlah_tk
                            fd.append('tk_perempuan', document.getElementById('sk_tk_perempuan').value); // We will update controller to read this
                            fd.append('ahli_k3', document.getElementById('sk_ahli_k3').value);
                            fd.append('kontak', document.getElementById('sk_kontak').value);

                            // Files
                            const appendFile = (id, key) => {
                                const el = document.getElementById(id);
                                if (el && el.files[0]) fd.append(key, el.files[0]);
                            };

                            appendFile('sk_file_lama', 'dokumen'); // Controller maps 'dokumen' to f_sk_lama
                            appendFile('sk_file_permohonan', 'f_surat_permohonan');
                            appendFile('sk_file_sertifikat', 'f_sertifikat_ahli_k3');
                            appendFile('sk_file_tambahan', 'f_sertifikat_tambahan');
                            appendFile('sk_file_bpjs_tk', 'f_bpjs_kt');
                            appendFile('sk_file_bpjs_kes', 'f_bpjs_kes');
                            appendFile('sk_file_wlkp', 'f_wlkp');

                            try {
                                const resp = await fetch('/submit-p2k3', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: fd
                                });
                                const json = await resp.json();
                                if (!resp.ok) throw json;
                                alert('Berhasil: ' + (json.message || 'Pengajuan terkirim'));
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        }
                    </script>


                    <button type="submit">Kirim Pengajuan</button>
                    </form>
                </div>


                <!-- ======= FORM LENGKAP: Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja ======= -->
                <div id="form_pelkes_full" class="card formdata hidden">
                    <h2>Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja di Perusahaan</h2>

                    <p class="note">
                        Form ini adalah implementasi persyaratan administratif (Undang-undang dan Permenaker). <br>
                        Catatan: jika sudah mengisi formulir di website, tidak perlu mengirim berkas fisik lagi ke Dinas
                        (Alamat:
                        Jl. Jend.
                        A. Yani Km 6 No 23 Banjarmasin).
                    </p>

                    <form id="form" enctype="multipart/form-data" novalidate>
                        <!-- Hidden ID for Updates -->
                        <input type="hidden" id="editIdPengesahan">
                        <!-- Basic -->
                        <label>Email <span class="small">* (digunakan untuk notifikasi)</span></label>
                        <input id="email" type="email" placeholder="email@example.com" required>

                        <label>Pengajuan Pengesahan Pelayanan Kesehatan Kerja di Perusahaan <span
                                class="small">*</span></label>
                        <select id="jenis" required>
                            <option value="">-- Pilih --</option>
                            <option value="baru">Pengesahan Baru</option>
                            <option value="perpanjangan">Perpanjangan</option>
                        </select>

                        <!-- Data Umum Perusahaan (shared for both baru & perpanjangan) -->
                        <div id="data-umum" class="fieldset hidden">
                            <label>Tanggal Pengusulan <span class="small">*</span></label>
                            <input id="tanggal" type="text" placeholder="Contoh: 17 Juli 2025" required>

                            <label>Nama Perusahaan <span class="small">*</span></label>
                            <input id="nama-perusahaan" type="text" placeholder="PT ANGIN SEPOI SEJUK"
                                pattern="[A-Z0-9 \-()&,]+" required>
                            <div class="small">Gunakan huruf besar; jangan gunakan titik setelah PT/CV.</div>

                            <label>Alamat Perusahaan <span class="small">*</span></label>
                            <textarea id="alamat" required></textarea>

                            <label>Sektor Perusahaan <span class="small">*</span></label>
                            <input id="sektor" type="text" required>

                            <div class="row">
                                <div class="col">
                                    <label>Jumlah Tenaga Kerja WNI Laki-Laki <span class="small">*</span></label>
                                    <input id="wni-laki" type="number" min="0" value="0" required>
                                </div>
                                <div class="col">
                                    <label>Jumlah Tenaga Kerja WNI Perempuan <span class="small">*</span></label>
                                    <input id="wni-perempuan" type="number" min="0" value="0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Jumlah Tenaga Kerja WNA Laki-Laki <span class="small">*</span></label>
                                    <input id="wna-laki" type="number" min="0" value="0" required>
                                </div>
                                <div class="col">
                                    <label>Jumlah Tenaga Kerja WNA Perempuan <span class="small">*</span></label>
                                    <input id="wna-perempuan" type="number" min="0" value="0" required>
                                </div>
                            </div>

                            <label>Nama Dokter Penanggungjawab Pelayanan Kesehatan Kerja <span
                                    class="small">*</span></label>
                            <input id="dokter" type="text" placeholder="dr. ABRAHAM LINCOLN, P.Hd" required>

                            <label>Tempat / Tanggal Lahir Dokter Penanggungjawab <span class="small">*</span></label>
                            <input id="ttl" type="text" placeholder="Contoh: Los Angeles, 11 Juni 1990" required>

                            <label>Nomor SKP Dokter Pemeriksa <span class="small">*</span></label>
                            <input id="nomor-skp" type="text" required>

                            <label>Tanggal Masa Berlaku SKP Dokter Pemeriksa <span class="small">*</span></label>
                            <input id="masa-skp" type="date" required>

                            <label>Nomor Sertifikat Hiperkes Dokter Perusahaan <span class="small">*</span></label>
                            <input id="no-hiperkes" type="text" required>

                            <div class="row">
                                <div class="col">
                                    <label>Nomor STR Dokter <span class="small">*</span></label>
                                    <input id="str" type="text" required>
                                </div>
                                <div class="col">
                                    <label>Nomor SIP Dokter <span class="small">*</span></label>
                                    <input id="sip" type="text" required>
                                </div>
                            </div>

                            <label>Nomor Kontak Yang Bisa Dihubungi <span class="small">*</span></label>
                            <input id="kontak" type="tel" placeholder="08xx..." required>
                        </div>

                        <!-- Upload Dokumen Persyaratan -->
                        <div id="uploads" class="fieldset hidden">
                            <label>Unggah Dokumen Persyaratan (PDF, maks 1 MB tiap file)</label>
                            <div class="file-hint">jika sudah mengisi formulir di website, tidak perlu mengirim berkas
                                fisik lagi ke
                                Dinas.
                            </div>

                            <label>Surat Permohonan Pengesahan Pelayanan Kesehatan Kerja <span
                                    class="small">*</span></label>
                            <input id="f-permohonan" type="file" accept="application/pdf" required>
                            <div id="err-permohonan" class="error"></div>

                            <label>Struktur Organisasi Pelayanan Kesehatan Kerja <span class="small">*</span></label>
                            <input id="f-struktur" type="file" accept="application/pdf" required>
                            <div id="err-struktur" class="error"></div>

                            <label>Surat Pernyataan Penunjukan Dokter Penanggungjawab <span
                                    class="small">*</span></label>
                            <input id="f-pernyataan" type="file" accept="application/pdf" required>
                            <div id="err-pernyataan" class="error"></div>

                            <label>SKP Dokter Pemeriksa (SKP) <span class="small">*</span></label>
                            <input id="f-skp" type="file" accept="application/pdf" required>
                            <div id="err-skp" class="error"></div>

                            <label>Sertifikat Hiperkes Dokter Perusahaan <span class="small">*</span></label>
                            <input id="f-hiperkes-dokter" type="file" accept="application/pdf" required>
                            <div id="err-hiperkes-dokter" class="error"></div>

                            <label>Sertifikat Hiperkes Paramedis <span class="small">*</span></label>
                            <input id="f-hiperkes-paramedis" type="file" accept="application/pdf" required>
                            <div id="err-hiperkes-paramedis" class="error"></div>

                            <label>STR Dokter Perusahaan <span class="small">*</span></label>
                            <input id="f-str-dokter" type="file" accept="application/pdf" required>
                            <div id="err-str-dokter" class="error"></div>

                            <label>SIP Dokter Perusahaan <span class="small">*</span></label>
                            <input id="f-sip-dokter" type="file" accept="application/pdf" required>
                            <div id="err-sip-dokter" class="error"></div>

                            <label>Daftar Sarana Penyelenggaraan Pelayanan Kesehatan Kerja <span
                                    class="small">*</span></label>
                            <input id="f-sarana" type="file" accept="application/pdf" required>
                            <div id="err-sarana" class="error"></div>

                            <label>Tanda Bukti Kepesertaan BPJS Ketenagakerjaan <span class="small">*</span></label>
                            <input id="f-bpjs-kt" type="file" accept="application/pdf" required>
                            <div id="err-bpjs-kt" class="error"></div>

                            <label>Tanda Bukti Kepesertaan BPJS Kesehatan <span class="small">*</span></label>
                            <input id="f-bpjs-kes" type="file" accept="application/pdf" required>
                            <div id="err-bpjs-kes" class="error"></div>

                            <label>Tanda Bukti Pelaporan WLKP <span class="small">*</span></label>
                            <input id="f-wlkp" type="file" accept="application/pdf" required>
                            <div id="err-wlkp" class="error"></div>

                            <div class="small">Catatan: WLKP dapat dilaporkan di <a
                                    href="https://wajiblapor.kemnaker.go.id/" target="_blank"
                                    rel="noopener">wajiblapor.kemnaker.go.id</a> atau hubungi 081255774488 (Rahmat
                                Avandi
                                Katili)</div>
                        </div>

                        <div class="actions">
                            <button type="button" id="preview">Preview JSON</button>
                            <button type="submit">Kirim Pengajuan (simpan & kirim)</button>
                            <button type="button" id="reset" class="ghost">Reset Form</button>
                        </div>

                        <div id="result" class="fieldset hidden mt-14">
                            <strong>Hasil Preview (JSON)</strong>
                            <pre id="json-output" class="json-preview"></pre>
                            <div class="actions mt-8">
                            </div>
                        </div>
                    </form>

                    </form>
                    </form>
                </div>
            </div>

            <!-- STORY -->
            <div id="story" class="page hidden">
                <div class="card">
                    <h2>Riwayat Proses Pengajuan</h2>

                    <div id="storyList">@if(isset($history) && count($history) > 0)
                        @foreach($history as $item)
                            <div class="status" style="margin-bottom: 10px; padding: 10px; border-bottom: 1px solid #eee;">
                                <strong>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</strong> -
                                {{ $item->title }}
                                <div style="font-size: 13px; color: #555; margin-top: 2px;">{{ $item->subtitle ?? '' }}
                                </div>
                                <div
                                    style="margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span class="badge"
                                            style="background: {{ ($item->status === 'DITOLAK' || $item->status === 'PERLU REVISI') ? '#fee2e2' : '#e6fdf0' }}; 
                                                                           color: {{ ($item->status === 'DITOLAK' || $item->status === 'PERLU REVISI') ? '#dc2626' : '#198754' }}; 
                                                                           padding: 2px 8px; border-radius: 4px; font-size: 12px;">{{ $item->status ?? 'Diproses' }}</span>
                                        <span
                                            style="font-size: 12px; color: #888; margin-left: 6px;">({{ $item->type }})</span>
                                    </div>
                                    @if($item->status === 'DITOLAK' || $item->status === 'PERLU REVISI')
                                        <button onclick="editSubmission('{{ $item->type }}', {{ $item->id }})"
                                            class="btn btn-warning" style="padding: 4px 10px; font-size: 12px;">✏️
                                            Perbaiki</button>
                                    @endif
                                </div>
                                @if(!empty($item->catatan))
                                    <div
                                        style="margin-top: 8px; background: #fff5f5; border-left: 3px solid #ef4444; padding: 8px; font-size: 13px; color: #b91c1c;">
                                        <strong>Catatan Admin:</strong> {{ $item->catatan }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                            <p style="color: #666; font-style: italic;">Belum ada riwayat pengajuan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- UNDUH -->
            <div id="unduhDok" class="page hidden">
                <style>
                    /* Scoped styles for unduh form to avoid conflicts */
                    .unduh-container {
                        max-width: 880px;
                        margin: 16px auto;
                        padding: 20px
                    }

                    .unduh-header {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        margin-bottom: 12px
                    }

                    .unduh-brand {
                        background: #0c2c66;
                        color: #fff;
                        padding: 8px 12px;
                        border-radius: 8px;
                        font-weight: 700
                    }

                    .unduh-card {
                        background: #fff;
                        padding: 18px;
                        border-radius: 12px;
                        box-shadow: 0 6px 18px rgba(12, 44, 102, 0.06)
                    }

                    .unduh-lead {
                        color: #6b7280;
                        font-size: 13px
                    }

                    .unduh-row {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 12px
                    }

                    label {
                        display: block;
                        font-size: 13px;
                        margin-bottom: 6px
                    }

                    .unduh-required {
                        color: #e11d48;
                        margin-left: 6px
                    }

                    input[type=text],
                    input[type=email],
                    input[type=date],
                    select,
                    textarea {
                        width: 100%;
                        padding: 10px 12px;
                        border: 1px solid #e6e9ef;
                        border-radius: 8px;
                        font-size: 14px;
                        background: #fff
                    }

                    textarea {
                        min-height: 86px;
                        resize: vertical
                    }

                    .unduh-full {
                        grid-column: 1 / -1
                    }

                    .unduh-actions {
                        display: flex;
                        gap: 10px;
                        align-items: center;
                        margin-top: 16px
                    }

                    .unduh-btn {
                        background: #0c2c66;
                        color: #fff;
                        border: 0;
                        padding: 10px 14px;
                        border-radius: 10px;
                        cursor: pointer
                    }

                    .unduh-btn.secondary {
                        background: #f3f4f6;
                        color: #111;
                        border: 1px solid #e5e7eb
                    }

                    .unduh-muted {
                        color: #6b7280;
                        font-size: 13px
                    }

                    .unduh-success {
                        display: none;
                        margin-top: 18px;
                        padding: 14px;
                        border-radius: 10px;
                        background: linear-gradient(180deg, #ecfeff 0%, #f8fcff 100%);
                        border: 1px solid #c0f0f0
                    }

                    .unduh-links {
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                        margin-top: 8px
                    }

                    .unduh-doc-link {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 10px;
                        border-radius: 8px;
                        border: 1px dashed #dbeafe
                    }

                    .unduh-doc-link a {
                        color: #0c2c66;
                        text-decoration: none;
                        font-weight: 600
                    }

                    .unduh-note {
                        margin-top: 12px;
                        font-size: 13px;
                        color: #6b7280
                    }

                    @media (max-width:720px) {
                        .unduh-row {
                            grid-template-columns: 1fr
                        }
                    }
                </style>

                <div class="unduh-container">
                    <div class="unduh-header">
                        <div class="unduh-brand">K3</div>
                        <div>
                            <div class="bold-title">Tanda Terima Unduh Dokumen Layanan K3</div>
                            <div class="unduh-muted">Isi form sebelum mengunduh dokumen.</div>
                        </div>
                    </div>

                    <main>
                        <div class="unduh-card">
                            <form id="unduh_formUnduh" novalidate>
                                <div class="login-info">
                                    <div class="unduh-muted">Anda masuk sebagai</div>
                                    <div class="account-info">
                                        <input id="unduh_emailAccount" type="email" value="email@example.com" readonly
                                            class="email-display" />
                                        <a href="#" id="unduh_gantiAkun" class="unduh-muted">Ganti akun</a>
                                    </div>
                                </div>

                                <div class="unduh-row">
                                    <div>
                                        <label for="unduh_email">Email <span class="unduh-required">*</span></label>
                                        <input id="unduh_email" name="unduh_email" type="email"
                                            placeholder="email@contoh.com" required />
                                    </div>

                                    <div>
                                        <label for="unduh_nama">Nama Penerima Dokumen <span
                                                class="unduh-required">*</span></label>
                                        <input id="unduh_nama" name="unduh_nama" type="text" placeholder="Nama lengkap"
                                            required />
                                    </div>

                                    <div>
                                        <label for="unduh_jabatan">Jabatan <span class="unduh-required">*</span></label>
                                        <input id="unduh_jabatan" name="unduh_jabatan" type="text"
                                            placeholder="Contoh: HR Manager" required />
                                    </div>

                                    <div>
                                        <label for="unduh_namaPerusahaan">Nama Perusahaan <span
                                                class="unduh-required">*</span></label>
                                        <input id="unduh_namaPerusahaan" name="unduh_namaPerusahaan" type="text"
                                            placeholder="Nama perusahaan" required />
                                    </div>

                                    <div class="unduh-full">
                                        <label for="unduh_alamat">Alamat Perusahaan <span
                                                class="unduh-required">*</span></label>
                                        <textarea id="unduh_alamat" name="unduh_alamat" placeholder="Alamat lengkap"
                                            required></textarea>
                                    </div>

                                    <div>
                                        <label for="unduh_sektor">Sektor Perusahaan <span
                                                class="unduh-required">*</span></label>
                                        <select id="unduh_sektor" name="unduh_sektor" required>
                                            <option value="">-- Pilih sektor --</option>
                                            <option>Manufaktur</option>
                                            <option>Jasa</option>
                                            <option>Konstruksi</option>
                                            <option>Kesehatan</option>
                                            <option>Pendidikan</option>
                                            <option>Lainnya</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="unduh_tanggalUnduh">Tanggal Unduh Dokumen <span
                                                class="unduh-required">*</span></label>
                                        <input id="unduh_tanggalUnduh" name="unduh_tanggalUnduh" type="date" required />
                                    </div>

                                    <div class="unduh-full">
                                        <label>Dokumen yang diunduh <span class="unduh-required">*</span></label>
                                        <div class="doc-links-container">
                                            <label><input type="radio" name="unduh_dokumen" value="sk_p2k3" required />
                                                SK P2K3</label>
                                            <label><input type="radio" name="unduh_dokumen"
                                                    value="sk_pelayanan_kesehatan" /> SK Pengesahan
                                                Penyelenggaraan Pelayanan Kesehatan Kerja</label>
                                        </div>
                                    </div>

                                    <div id="unduh_pilihanDetail" class="unduh-full hidden">
                                        <label>Detail Dokumen</label>
                                        <div class="unduh-muted">(informasi tambahan jika perlu)</div>
                                        <input id="unduh_detailDokumen" name="unduh_detailDokumen" type="text"
                                            placeholder="Contoh: versi, nomor SK, catatan lain" />
                                    </div>

                                </div>

                                <div class="unduh-actions">
                                    <button type="submit" class="unduh-btn">Kirim &amp; Tampilkan Link Unduhan</button>
                                    <button type="button" class="unduh-btn secondary" id="unduh_resetBtn">Reset</button>
                                    <div class="unduh-muted ml-auto">* Menunjukkan pertanyaan yang wajib diisi</div>
                                </div>
                            </form>

                            <div id="unduh_successBox" class="unduh-success" role="status" aria-live="polite">
                                <strong>Tanda Terima Unduh Dokumen Layanan K3</strong>
                                <p class="unduh-muted mt-6">Terima kasih telah mengisi tanda terima unduh dokumen.
                                    Selanjutnya dapat mengunduh dokumen pada link berikut:</p>

                                <div class="unduh-links">
                                    <div class="unduh-doc-link" id="unduh_linkSkP2k3">
                                        <div>SK P2K3</div>
                                        <div class="account-info">
                                            <a href="https://shorturl.at/fFM7o" target="_blank" rel="noopener">Buka /
                                                Unduh</a>
                                            <button type="button" class="unduh-btn secondary"
                                                data-copy="https://shorturl.at/fFM7o">Salin</button>
                                        </div>
                                    </div>

                                    <div class="unduh-doc-link" id="unduh_linkSkPelayanan">
                                        <div>SK Pengesahan Penyelenggaraan Pelayanan Kesehatan Kerja</div>
                                        <div class="account-info">
                                            <a href="https://shorturl.at/DSuYx" target="_blank" rel="noopener">Buka /
                                                Unduh</a>
                                            <button type="button" class="unduh-btn secondary"
                                                data-copy="https://shorturl.at/DSuYx">Salin</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="unduh-note">Catatan: Link tersedia sesuai pilihan dokumen yang Anda pilih
                                    pada form. Jika
                                    hanya memilih satu, link lain tetap terlihat untuk referensi.</div>
                            </div>
                        </div>
                    </main>
                </div>

                <script>
                    (function () {
                        const form = document.getElementById('unduh_formUnduh');
                        const successBox = document.getElementById('unduh_successBox');
                        const pilihanDetail = document.getElementById('unduh_pilihanDetail');
                        const resetBtn = document.getElementById('unduh_resetBtn');
                        const emailAccount = document.getElementById('unduh_emailAccount');
                        const gantiAkun = document.getElementById('unduh_gantiAkun');

                        // show detail input when a dokumen option is selected
                        form.addEventListener('change', (e) => {
                            if (e.target.name === 'unduh_dokumen') {
                                pilihanDetail.style.display = 'block';
                            }
                        });

                        // copy buttons
                        document.addEventListener('click', (e) => {
                            const btn = e.target.closest('button[data-copy]');
                            if (!btn) return;
                            const url = btn.getAttribute('data-copy');
                            navigator.clipboard?.writeText(url).then(() => {
                                const prev = btn.textContent;
                                btn.textContent = 'Tersalin';
                                setTimeout(() => btn.textContent = prev, 1500);
                            }).catch(() => {
                                alert('Gagal menyalin. Silakan salin secara manual: ' + url);
                            });
                        });

                        // replace akun (simple prompt)
                        gantiAkun.addEventListener('click', (ev) => {
                            ev.preventDefault();
                            const v = prompt('Masukkan email baru (atau kosongkan untuk batal):', emailAccount.value);
                            if (v && /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)) {
                                emailAccount.value = v;
                                document.getElementById('unduh_email').value = v;
                            } else if (v !== null) {
                                alert('Format email tidak valid. Perubahan dibatalkan.');
                            }
                        });

                        // reset
                        resetBtn.addEventListener('click', () => {
                            form.reset();
                            pilihanDetail.style.display = 'none';
                            successBox.style.display = 'none';
                            document.getElementById('unduh_email').value = emailAccount.value;
                        });

                        // on submit: basic client-side validation + show links
                        form.addEventListener('submit', (ev) => {
                            ev.preventDefault();
                            // check required
                            const requiredFields = form.querySelectorAll('[required]');
                            let ok = true;
                            requiredFields.forEach(f => {
                                if (!f.value) {
                                    ok = false;
                                    f.style.outline = '2px solid rgba(225,29,72,0.12)';
                                    setTimeout(() => f.style.outline = '', 1200);
                                }
                            });
                            if (!ok) {
                                alert('Mohon lengkapi semua field yang bertanda *');
                                return;
                            }

                            // show success
                            successBox.style.display = 'block';
                            successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            successBox.setAttribute('aria-hidden', 'false');

                            // tailor visible links based on choice
                            const pilihan = form.querySelector('input[name="unduh_dokumen"]:checked')?.value;
                            const elSk = document.getElementById('unduh_linkSkP2k3');
                            const elPel = document.getElementById('unduh_linkSkPelayanan');
                            if (pilihan === 'sk_p2k3') {
                                elSk.style.display = 'flex';
                                elPel.style.display = 'none';
                            } else if (pilihan === 'sk_pelayanan_kesehatan') {
                                elSk.style.display = 'none';
                                elPel.style.display = 'flex';
                            } else {
                                elSk.style.display = 'flex';
                                elPel.style.display = 'flex';
                            }

                            // (Optional) Here you could send the form to server with fetch/ajax
                        });

                        // initialize email field from account
                        document.getElementById('unduh_email').value = emailAccount.value;
                    })();
                </script>
            </div>

        </main>
    </div>

    <script>
        // initial show
        function showPage(pageId) {
            document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));
            const el = document.getElementById(pageId);
            if (el) el.classList.remove('hidden');
            // Close sidebar on mobile if open
            const sidebar = document.querySelector('aside');
            const overlay = document.querySelector('.overlay');
            if (sidebar && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
            if (overlay && overlay.classList.contains('active')) {
                overlay.classList.remove('active');
            }
            window.scrollTo(0, 0);
        }
        showPage('dashboard');

        // tampil form sesuai pilihan
        function tampilForm() {
            const val = document.getElementById('pilihanLayanan').value;
            document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
            if (val === 'pelkes') document.getElementById('form_pelkes').classList.remove('hidden');
            if (val === 'p2k3') document.getElementById('form_p2k3').classList.remove('hidden');
            if (val === 'kk_pak') document.getElementById('form_kk_pak').classList.remove('hidden');
            if (val === 'sk_p2k3') document.getElementById('form_sk_p2k3').classList.remove('hidden');
            if (val === 'unduh') document.getElementById('form_unduh').classList.remove('hidden');
            if (val === 'pelkes_full') {
                document.getElementById('form_pelkes_full').classList.remove('hidden');
                // show inner sections
                document.getElementById('data-umum').classList.remove('hidden');
                document.getElementById('uploads').classList.remove('hidden');
            }
        }

        // auto-uppercase company name
        document.addEventListener('input', (e) => {
            if (e.target && e.target.id === 'nama-perusahaan') {
                const start = e.target.selectionStart;
                e.target.value = e.target.value.toUpperCase();
                e.target.selectionStart = e.target.selectionEnd = start;
            }
        });

        // file validation: PDF and <= 1MB
        function validateFileInput(input) {
            const errEl = document.getElementById('err-' + input.id.replace('f-', ''));
            if (!errEl) return false;
            errEl.textContent = '';
            if (!input.files || input.files.length === 0) {
                errEl.textContent = 'File belum dipilih.';
                return false;
            }
            const f = input.files[0];
            if (f.type !== 'application/pdf') {
                errEl.textContent = 'File harus berformat PDF.';
                return false;
            }
            if (f.size > 1_048_576) {
                errEl.textContent = 'Ukuran file melebihi 1 MB.';
                return false;
            }
            return true;
        }

        const fileInputs = Array.from(document.querySelectorAll('input[type=file]'));
        fileInputs.forEach(fi => {
            fi.addEventListener('change', () => validateFileInput(fi));
        });

        // collect form data preview
        function collectFormDataForPreview() {
            const data = {};
            data.email = document.getElementById('email').value;
            data.jenis = document.getElementById('jenis').value;
            data.tanggal = document.getElementById('tanggal').value;
            data.nama_perusahaan = document.getElementById('nama-perusahaan').value;
            data.alamat = document.getElementById('alamat').value;
            data.sektor = document.getElementById('sektor').value;
            data.kontak = document.getElementById('kontak').value;
            data.jumlah = {
                wni_laki: Number(document.getElementById('wni-laki').value || 0),
                wni_perempuan: Number(document.getElementById('wni-perempuan').value || 0),
                wna_laki: Number(document.getElementById('wna-laki').value || 0),
                wna_perempuan: Number(document.getElementById('wna-perempuan').value || 0)
            };
            data.dokter = {
                nama: document.getElementById('dokter').value,
                ttl: document.getElementById('ttl').value,
                nomor_skp: document.getElementById('nomor-skp').value,
                masa_skp: document.getElementById('masa-skp').value,
                no_hiperkes: document.getElementById('no-hiperkes').value,
                str: document.getElementById('str').value,
                sip: document.getElementById('sip').value
            };
            data.files = {};
            fileInputs.forEach(inp => {
                if (inp.files && inp.files[0]) data.files[inp.id] = { name: inp.files[0].name, size: inp.files[0].size };
            });
            return data;
        }

        // preview JSON
        document.getElementById('preview').addEventListener('click', () => {
            // quick required checks (basic)
            const requiredIds = ['email', 'jenis', 'tanggal', 'nama-perusahaan', 'alamat', 'sektor', 'kontak', 'dokter', 'ttl', 'nomor-skp', 'masa-skp', 'no-hiperkes', 'str', 'sip'];
            for (const id of requiredIds) {
                const el = document.getElementById(id);
                if (el && !el.value) {
                    alert('Mohon isi field wajib: ' + id); return;
                }
            }
            // files
            for (const inp of fileInputs) {
                if (!validateFileInput(inp)) { alert('Periksa file: ' + inp.id); return; }
            }
            const data = collectFormDataForPreview();
            document.getElementById('json-output').textContent = JSON.stringify(data, null, 2);
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('result').scrollIntoView({ behavior: 'smooth' });
        });

        // download JSON preview
        document.getElementById('download').addEventListener('click', () => {
            const txt = document.getElementById('json-output').textContent;
            const blob = new Blob([txt], { type: 'application/json' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'pengesahan_pengajuan.json';
            a.click();
            URL.revokeObjectURL(a.href);
        });

        // reset
        document.getElementById('reset').addEventListener('click', () => {
            if (confirm('Reset semua isian?')) {
                document.getElementById('form').reset();
                document.getElementById('result').classList.add('hidden');
                document.getElementById('editIdPengesahan').value = ''; // Clear edit ID on reset
            }
        });

        // story mock
        // story mock removed  -  using server-side rendering

        // submitReal (attached to form submit)
        async function submitReal(e) {
            e.preventDefault();
            const formEl = document.getElementById('form');
            const formData = new FormData();

            const editId = document.getElementById('editIdPengesahan').value;
            if (editId) {
                formData.append('id', editId); // Append ID for update
            }

            // simple fields
            formData.append('email', document.getElementById('email').value);
            formData.append('jenis', document.getElementById('jenis').value);
            formData.append('tanggal', document.getElementById('tanggal').value);
            formData.append('nama_perusahaan', document.getElementById('nama-perusahaan').value);
            formData.append('alamat', document.getElementById('alamat').value);
            formData.append('sektor', document.getElementById('sektor').value);
            formData.append('kontak', document.getElementById('kontak').value);

            // jumlah tenaga kerja
            formData.append('wni_laki', document.getElementById('wni-laki').value);
            formData.append('wni_perempuan', document.getElementById('wni-perempuan').value);
            formData.append('wna_laki', document.getElementById('wna-laki').value);
            formData.append('wna_perempuan', document.getElementById('wna-perempuan').value);

            // dokter
            formData.append('dokter_nama', document.getElementById('dokter').value);
            formData.append('dokter_ttl', document.getElementById('ttl').value);
            formData.append('nomor_skp', document.getElementById('nomor-skp').value);
            formData.append('masa_skp', document.getElementById('masa-skp').value);
            formData.append('no_hiperkes', document.getElementById('no-hiperkes').value);
            formData.append('str', document.getElementById('str').value);
            formData.append('sip', document.getElementById('sip').value);

            // files mapping - MUST match input IDs
            const mapFiles = {
                permohonan: 'f-permohonan',
                struktur: 'f-struktur',
                pernyataan: 'f-pernyataan',
                skp: 'f-skp',
                hiperkes_dokter: 'f-hiperkes-dokter',
                hiperkes_paramedis: 'f-hiperkes-paramedis',
                str_dokter: 'f-str-dokter',
                sip_dokter: 'f-sip-dokter',
                sarana: 'f-sarana',
                bpjs_ketenagakerjaan: 'f-bpjs-kt',
                bpjs_kesehatan: 'f-bpjs-kes',
                wlkp: 'f-wlkp'
            };

            // validate files & append
            for (const [field, inputId] of Object.entries(mapFiles)) {
                const inp = document.getElementById(inputId);
                // Only validate and append if a new file is selected
                if (inp && inp.files && inp.files.length > 0) {
                    const ok = validateFileInput(inp);
                    if (!ok) { alert('Periksa file: ' + inputId); return; }
                    formData.append(field, inp.files[0], inp.files[0].name);
                }
            }

            let url = '/submit-pengesahan';
            let editId = document.getElementById('editIdPengesahan').value;
            if (editId) {
                url = '/update-pengesahan';
                formData.append('id', editId);
            }

            try {
                const resp = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // 'Content-Type': 'multipart/form-data', // Do NOT set this manually for FormData, browser does it automatically with boundary
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const json = await resp.json();
                if (!resp.ok) throw json;
                alert('Terima kasih — ' + (json.message || 'Pengajuan sukses'));
                // window.location.reload();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Gagal mengirim: ' + (err.message || JSON.stringify(err)));
            }
        }

        // attach submit

        // attach submit
        const formPelkes = document.getElementById('form_pelkes_full');
        if (formPelkes) {
            formPelkes.addEventListener('submit', submitReal);
        }


        // show data-umum & uploads when jenis changes
        document.getElementById('jenis').addEventListener('change', (e) => {
            const show = !!e.target.value;
            document.getElementById('data-umum').classList.toggle('hidden', !show);
            document.getElementById('uploads').classList.toggle('hidden', !show);
        });

        // When page loads, make sure file validation nodes exist (for preview)
        window.addEventListener('DOMContentLoaded', () => {
            // nothing else for no      w
        });

        async function editSubmission(type, id) {
            try {
                alert("⏳ Sedang mengambil data pengajuan...");
                let res = await fetch(`/user/submission/${type}/${id}`);
                if (!res.ok) throw new Error("Gagal mengambil data.");
                let data = await res.json();

                if (type === 'pelayanan_kesekerja') {
                    // 1. Show Form
                    document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));
                    document.getElementById('pelayanan').classList.remove('hidden');
                    document.getElementById('pilihanLayanan').value = 'pelkes_full';
                    tampilForm();

                    // 2. Fill Data
                    document.getElementById('editIdPengesahan').value = data.id; // Important: ID for Update
                    document.getElementById('email').value = data.email || '';
                    document.getElementById('jenis').value = data.jenis_pengajuan || '';
                    document.getElementById('jenis').dispatchEvent(new Event('change')); // Trigger change logic

                    document.getElementById('tanggal').value = data.tanggal_pengusulan || '';
                    document.getElementById('nama-perusahaan').value = data.nama_perusahaan || '';
                    document.getElementById('alamat').value = data.alamat_perusahaan || '';
                    document.getElementById('sektor').value = data.sektor || '';

                    // Tenaga Kerja
                    document.getElementById('wni-laki').value = data.tk_wni_laki || 0;
                    document.getElementById('wni-perempuan').value = data.tk_wni_perempuan || 0;
                    document.getElementById('wna-laki').value = data.tk_wna_laki || 0;
                    document.getElementById('wna-perempuan').value = data.tk_wna_perempuan || 0;

                    // Dokter
                    document.getElementById('dokter').value = data.nama_dokter || '';
                    document.getElementById('ttl').value = data.ttl_dokter || '';
                    document.getElementById('nomor-skp').value = data.nomor_skp_dokter || '';
                    document.getElementById('masa-skp').value = data.masa_berlaku_skp || '';
                    document.getElementById('no-hiperkes').value = data.nomor_hiperkes || '';
                    document.getElementById('str').value = data.nomor_str || '';
                    document.getElementById('sip').value = data.nomor_sip || '';
                    document.getElementById('kontak').value = data.kontak || '';

                    alert("✅ Formulir telah diisi dengan data sebelumnya. Silakan perbaiki bagian yang salah dan upload ulang file jika diperlukan.");
                    window.scrollTo(0, 0);
                } else {
                    alert("⚠️ Fitur edit untuk layanan tipe ini belum tersedia di demo ini.");
                }
            } catch (e) {
                console.error(e);
                alert("❌ Error: " + e.message);
            }
        }

        // Handle logout - simplified
        const userLogoutForm = document.getElementById('userLogoutForm');
        if (userLogoutForm) {
            userLogoutForm.addEventListener('submit', function (e) {
                // Let form submit normally
                return true;
            });
        }
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const overlay = document.querySelector('.overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Also handle the existing toggle button
        const toggleBtn = document.getElementById('toggleSidebar');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
    </script>
</body>

</html>
```