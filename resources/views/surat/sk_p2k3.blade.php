<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Pengesahan P2K3 - {{ $nama_perusahaan }}</title>
    <style>
        @page {
            margin: 2cm 2.5cm;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 1cm 2cm;
            background: white;
        }

        /* KOP SURAT */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-surat .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .kop-surat img.logo {
            width: 70px;
            height: auto;
        }

        .kop-surat .kop-text {
            text-align: center;
        }

        .kop-surat .provinsi {
            font-size: 14pt;
            font-weight: bold;
            color: #c00;
        }

        .kop-surat .dinas {
            font-size: 16pt;
            font-weight: bold;
        }

        .kop-surat .alamat {
            font-size: 10pt;
        }

        .kop-surat .kontak {
            font-size: 9pt;
        }

        /* JUDUL SURAT */
        .judul-surat {
            text-align: center;
            margin: 30px 0 20px;
        }

        .judul-surat h1 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .judul-surat .nomor {
            font-size: 12pt;
            margin-top: 5px;
        }

        .judul-surat .tentang {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 15px;
        }

        .judul-surat .perihal {
            font-size: 12pt;
            font-weight: bold;
        }

        .judul-surat .otomatis {
            font-size: 11pt;
            color: #c00;
            font-style: italic;
        }

        /* KEPALA DINAS TITLE */
        .kepala-title {
            text-align: center;
            font-weight: bold;
            margin: 25px 0 20px;
        }

        /* BAGIAN CONTENT */
        .section {
            margin-bottom: 15px;
        }

        .section-row {
            display: flex;
            margin-bottom: 10px;
        }

        .section-label {
            width: 120px;
            font-weight: normal;
        }

        .section-colon {
            width: 20px;
        }

        .section-content {
            flex: 1;
            text-align: justify;
        }

        .section-content p {
            margin-bottom: 10px;
        }

        /* MENGINGAT LIST */
        .mengingat-list {
            margin-left: 0;
        }

        .mengingat-list li {
            margin-bottom: 8px;
            text-align: justify;
        }

        /* MEMUTUSKAN */
        .memutuskan {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            letter-spacing: 8px;
            margin: 30px 0 20px;
        }

        /* MENETAPKAN */
        .menetapkan {
            margin-bottom: 15px;
        }

        .menetapkan-row {
            display: flex;
            margin-bottom: 12px;
        }

        .menetapkan-label {
            width: 100px;
            font-weight: normal;
        }

        .menetapkan-colon {
            width: 20px;
        }

        .menetapkan-content {
            flex: 1;
            text-align: justify;
        }

        /* TTD */
        .ttd-section {
            margin-top: 40px;
            text-align: right;
        }

        .ttd-box {
            display: inline-block;
            text-align: center;
            width: 280px;
        }

        .ttd-box .tempat-tanggal {
            margin-bottom: 5px;
        }

        .ttd-box .jabatan {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .ttd-box .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-box .pangkat {
            font-size: 11pt;
        }

        .ttd-box .nip {
            font-size: 11pt;
        }

        /* TEMBUSAN */
        .tembusan {
            margin-top: 30px;
            font-size: 11pt;
        }

        .tembusan h4 {
            margin-bottom: 5px;
        }

        .tembusan ol {
            margin-left: 20px;
        }

        /* PAGE BREAK */
        .page-break {
            page-break-before: always;
        }

        /* LAMPIRAN */
        .lampiran-header {
            margin-bottom: 20px;
        }

        .lampiran-header table {
            font-size: 11pt;
        }

        .lampiran-header td {
            vertical-align: top;
            padding: 2px 5px;
        }

        .data-perusahaan {
            margin: 20px 0;
        }

        .data-perusahaan h3 {
            text-decoration: underline;
            margin-bottom: 15px;
        }

        .data-perusahaan table {
            width: 100%;
        }

        .data-perusahaan td {
            padding: 5px;
            vertical-align: top;
        }

        .data-perusahaan .no {
            width: 30px;
        }

        .data-perusahaan .label {
            width: 180px;
        }

        .data-perusahaan .colon {
            width: 20px;
        }

        /* SUSUNAN PENGURUS */
        .susunan-pengurus {
            margin: 30px 0;
        }

        .susunan-pengurus h3 {
            text-decoration: underline;
            margin-bottom: 15px;
        }

        .pengurus-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pengurus-table th,
        .pengurus-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .pengurus-table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        /* PRINT BUTTON */
        .print-controls {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: #198754;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .print-controls button {
            background: white;
            color: #198754;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 0 5px;
        }

        .print-controls button:hover {
            background: #e9ecef;
        }

        @media print {
            .print-controls {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .container {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="print-controls">
        <button onclick="window.print()">🖨️ Cetak Surat</button>
        <button onclick="window.close()">✖️ Tutup</button>
    </div>

    <div class="container">
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="provinsi">PEMERINTAH PROVINSI KALIMANTAN SELATAN</div>
            <div class="dinas">DINAS TENAGA KERJA DAN TRANSMIGRASI</div>
            <div class="alamat">Alamat: Jalan. Jend. A. Yani Km.6 No.23 Banjarmasin Kode Pos 70249</div>
            <div class="kontak">
                Email: nakertranskalsel@yahoo.co.id Website: http://disnakertrans.kalselprov.go.id<br>
                Wasnaker: wasnaker.provkalsel@gmail.com, HI: hi.jamsosnaker@gmail.com,<br>
                P4TK: pkpdisnakertrans@gmail.com, Transmigrasi: ketransmigrasian@gmail.com
            </div>
        </div>

        <!-- JUDUL SURAT -->
        <div class="judul-surat">
            <h1>KEPUTUSAN</h1>
            <div class="nomor">KEPALA DINAS TENAGA KERJA DAN TRANSMIGRASI</div>
            <div class="nomor">PROVINSI KALIMANTAN SELATAN</div>
            <div class="nomor">Nomor : {{ $nomor_surat }}</div>
            <div class="tentang">TENTANG</div>
            @if($jenis == 'perubahan')
                <div class="perihal">PENGESAHAN PERUBAHAN PANITIA PEMBINA KESELAMATAN DAN<br>KESEHATAN KERJA DI PERUSAHAAN
                </div>
            @else
                <div class="perihal">PENGESAHAN PANITIA PEMBINA KESELAMATAN DAN<br>KESEHATAN KERJA DI PERUSAHAAN</div>
            @endif
            <div class="otomatis">&lt;&lt; {{ $nama_perusahaan }} &gt;&gt;</div>
        </div>

        <!-- KEPALA DINAS -->
        <div class="kepala-title">
            KEPALA DINAS TENAGA KERJA DAN TRANSMIGRASI<br>
            PROVINSI KALIMANTAN SELATAN
        </div>

        <!-- MENIMBANG -->
        <div class="section">
            <div class="section-row">
                <div class="section-label">Menimbang</div>
                <div class="section-colon">:</div>
                <div class="section-content">
                    <p>a. bahwa dalam rangka meningkatkan dan mengembangkan upaya-upaya Keselamatan dan Kesehatan Kerja
                        di perusahaan perlu dilakukan pembinaan secara terus menerus dan terarah;</p>
                    <p>b. bahwa untuk melakukan pembinaan keselamatan dan kesehatan kerja yang terus menerus di
                        perusahaan atau tempat kerja, perlu dibentuk dan disahkan Panitia Pembina Keselamatan dan
                        Kesehatan Kerja;</p>
                    <p>c. bahwa untuk maksud huruf a dan b konsideran diatas perlu dituangkan dalam Keputusan Kepala
                        Dinas Tenaga Kerja dan Transmigrasi Provinsi Kalimantan Selatan.</p>
                </div>
            </div>
        </div>

        <!-- MENGINGAT -->
        <div class="section">
            <div class="section-row">
                <div class="section-label">Mengingat</div>
                <div class="section-colon">:</div>
                <div class="section-content">
                    <ol class="mengingat-list">
                        <li>Undang-undang Nomor 13 Tahun 2003 tentang Ketenagakerjaan pasal 86 dan 87;</li>
                        <li>Undang-undang Nomor 1 Tahun 1970 tentang Keselamatan Kerja pasal 9 dan 10;</li>
                        <li>Peraturan Presiden Republik Indonesia Nomor 21 Tahun 2010 Tentang Pengawasan
                            Ketenagakerjaan.</li>
                        <li>Peraturan Menteri Tenaga Kerja R.I. Nomor: Per – 04/MEN/1987 tentang Panitia Keselamatan dan
                            Kesehatan Kerja serta tatacara Penunjukan Ahli Keselamatan Kerja;</li>
                        <li>Peraturan Menteri Tenaga Kerja R.I. Nomor: Per – 02/MEN/1992 tentang tatacara Penunjukan,
                            Kewajiban dan Wewenang Ahli Keselamatan dan Kesehatan Kerja;</li>
                        <li>Peraturan Menteri Ketenagakerjaan RI Nomor 18 Tahun 2016 tentang Dewan keselamatan dan
                            Kesehatan Kerja.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- MEMPERHATIKAN -->
        <div class="section">
            <div class="section-row">
                <div class="section-label">Memperhatikan</div>
                <div class="section-colon">:</div>
                <div class="section-content">
                    <ol class="mengingat-list">
                        <li>Surat Permohonan dari {{ $nama_perusahaan }} perihal Permohonan Pengesahan Struktur P2K3
                        </li>
                        <li>Hasil verifikasi Tim Verifikator Permohonan Pengesahan Lembaga Panitia Pembina Keselamatan
                            dan Kesehatan Kerja (P2K3) di Perusahaan</li>
                        @if($jenis == 'perubahan' && $nomor_sk_lama)
                            <li>Surat Keputusan Kepala Dinas Tenaga Kerja dan Transmigrasi Provinsi Kalimantan Selatan
                                Nomor: {{ $nomor_sk_lama }} tentang Pengesahan Panitia Pembina Keselamatan dan Kesehatan
                                Kerja di {{ $nama_perusahaan }}.</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>

        <!-- MEMUTUSKAN -->
        <div class="memutuskan">M E M U T U S K A N</div>

        <!-- MENETAPKAN -->
        <div class="menetapkan">
            <div class="menetapkan-row">
                <div class="menetapkan-label">Menetapkan</div>
                <div class="menetapkan-colon">:</div>
                <div class="menetapkan-content"></div>
            </div>

            @if($jenis == 'perubahan' && $nomor_sk_lama)
                <div class="menetapkan-row">
                    <div class="menetapkan-label">KESATU</div>
                    <div class="menetapkan-colon">:</div>
                    <div class="menetapkan-content">
                        Mencabut Surat Keputusan Kepala Dinas Tenaga Kerja dan Transmigrasi Provinsi Kalimantan Selatan
                        Nomor: {{ $nomor_sk_lama }} tentang Pengesahan Panitia Pembina Keselamatan dan Kesehatan Kerja di
                        {{ $nama_perusahaan }} dan dinyatakan tidak berlaku lagi.
                    </div>
                </div>
            @endif

            <div class="menetapkan-row">
                <div class="menetapkan-label">{{ $jenis == 'perubahan' && $nomor_sk_lama ? 'KEDUA' : 'KESATU' }}</div>
                <div class="menetapkan-colon">:</div>
                <div class="menetapkan-content">
                    @if($jenis == 'perubahan')
                        Mengesahkan Perubahan Panitia Pembina Keselamatan dan Kesehatan Kerja di Perusahaan
                        {{ $nama_perusahaan }}, {{ $alamat_perusahaan }} sebagaimana lampiran surat keputusan ini.
                    @else
                        Mengesahkan Panitia Pembina Keselamatan dan Kesehatan Kerja di Perusahaan {{ $nama_perusahaan }},
                        {{ $alamat_perusahaan }} sebagaimana lampiran surat keputusan ini.
                    @endif
                </div>
            </div>

            <div class="menetapkan-row">
                <div class="menetapkan-label">{{ $jenis == 'perubahan' && $nomor_sk_lama ? 'KETIGA' : 'KEDUA' }}</div>
                <div class="menetapkan-colon">:</div>
                <div class="menetapkan-content">
                    Panitia Pembina Keselamatan dan Kesehatan Kerja dapat segera melaksanakan kegiatan sesuai dengan
                    tugas dan fungsi yang telah ditetapkan serta melaporkan secara berkala hasil kegiatannya.
                </div>
            </div>

            <div class="menetapkan-row">
                <div class="menetapkan-label">{{ $jenis == 'perubahan' && $nomor_sk_lama ? 'KEEMPAT' : 'KETIGA' }}</div>
                <div class="menetapkan-colon">:</div>
                <div class="menetapkan-content">
                    Keputusan ini berlaku selama perusahaan dan susunan pengurusnya tidak berubah dengan ketentuan
                    apabila ternyata dikemudian hari terdapat kekeliruan dalam penetapan surat keputusan ini, akan
                    diadakan perbaikan sebagaimana mestinya.
                </div>
            </div>
        </div>

        <!-- TTD -->
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="tempat-tanggal">Ditetapkan di : Banjarmasin</div>
                <div class="tempat-tanggal">Pada tanggal : {{ $tanggal_surat }}</div>
                <br>
                <div class="jabatan">KEPALA DINAS</div>
                <div class="nama">{{ $kepala_dinas }}</div>
                <div class="pangkat">{{ $jabatan_kepala }}</div>
                <div class="nip">NIP. {{ $nip_kepala }}</div>
            </div>
        </div>

        <!-- TEMBUSAN -->
        <div class="tembusan">
            <h4>Tembusan Yth :</h4>
            <ol>
                <li>Menteri Ketenagakerjaan R.I. di JAKARTA.</li>
                <li>Dirjen Binwasnaker dan K3 Kementerian Ketenagakerjaan R.I. di JAKARTA.</li>
                <li>Direktur PNK3 Kementerian Ketenagakerjaan R.I. di JAKARTA.</li>
                <li>Anggota P2K3 yang bersangkutan.</li>
                <li>A r s i p.</li>
            </ol>
        </div>

        <!-- PAGE BREAK FOR LAMPIRAN -->
        <div class="page-break"></div>

        <!-- LAMPIRAN -->
        <div class="lampiran-header">
            <table>
                <tr>
                    <td>LAMPIRAN</td>
                    <td>:</td>
                    <td>Surat Keputusan Kepala Dinas Tenaga Kerja<br>dan Transmigrasi Provinsi Kalimantan
                        Selatan<br>Nomor : {{ $nomor_surat }}<br>Tanggal : {{ $tanggal_surat }}</td>
                </tr>
            </table>
        </div>

        <!-- DATA PERUSAHAAN -->
        <div class="data-perusahaan">
            <h3>DATA PERUSAHAAN :</h3>
            <table>
                <tr>
                    <td class="no">1.</td>
                    <td class="label">Nama Perusahaan</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $nama_perusahaan }}</strong></td>
                </tr>
                <tr>
                    <td class="no">2.</td>
                    <td class="label">Alamat Perusahaan</td>
                    <td class="colon">:</td>
                    <td>{{ $alamat_perusahaan }}</td>
                </tr>
                <tr>
                    <td class="no">3.</td>
                    <td class="label">Jenis Usaha</td>
                    <td class="colon">:</td>
                    <td>{{ $sektor_perusahaan }}</td>
                </tr>
            </table>
        </div>

        <!-- SUSUNAN PENGURUS P2K3 -->
        <div class="susunan-pengurus">
            <h3>SUSUNAN PENGURUS P2K3</h3>

            @if($pengurus && count($pengurus) > 0)
                <table class="pengurus-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama</th>
                            <th>Jabatan di Perusahaan</th>
                            <th>Jabatan di P2K3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengurus as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->nama ?? '-' }}</td>
                                <td>{{ $p->jabatan_perusahaan ?? '-' }}</td>
                                <td>{{ $p->jabatan_p2k3 ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #c00; font-style: italic;">&lt;&lt; isi Otomatis - Data Pengurus P2K3 belum diisi &gt;&gt;
                </p>
            @endif
        </div>

        <!-- TTD LAMPIRAN -->
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="jabatan">KEPALA DINAS</div>
                <div class="nama">{{ $kepala_dinas }}</div>
                <div class="pangkat">{{ $jabatan_kepala }}</div>
                <div class="nip">NIP. {{ $nip_kepala }}</div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus for printing
        window.onload = function () {
            document.title = 'SK Pengesahan P2K3 - {{ $nama_perusahaan }}';
        };
    </script>
</body>

</html>