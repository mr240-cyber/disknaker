const fs = require('fs');
const docx = require('docx');
const { Document, Packer, Paragraph, TextRun, HeadingLevel, AlignmentType } = docx;

const doc = new Document({
    sections: [
        {
            properties: {},
            children: [
                new Paragraph({
                    text: "PROPOSAL E-GOVERNMENT",
                    heading: HeadingLevel.TITLE,
                    alignment: AlignmentType.CENTER,
                }),
                new Paragraph({
                    text: "SIPENAKER: INOVASI DIGITAL PELAYANAN DAN PENGAWASAN KESELAMATAN DAN KESEHATAN KERJA (K3)",
                    alignment: AlignmentType.CENTER,
                    spacing: { after: 1200 },
                }),
                new Paragraph({
                    text: "Oleh :",
                    alignment: AlignmentType.CENTER,
                }),
                new Paragraph({
                    text: "Ratikwara Tim",
                    alignment: AlignmentType.CENTER,
                    spacing: { after: 200 },
                }),
                new Paragraph({ text: "1. ZOYA NUJULA RAMADHONI", alignment: AlignmentType.CENTER }),
                new Paragraph({ text: "2. MUHAMMAD IRFAN AKBAR", alignment: AlignmentType.CENTER }),
                new Paragraph({ text: "3. NURUL TRI AMELIA", alignment: AlignmentType.CENTER, spacing: { after: 2000 } }),
                new Paragraph({
                    text: "POLITEKNIK NEGERI BANJARMASIN",
                    alignment: AlignmentType.CENTER,
                }),
                new Paragraph({
                    text: "TAHUN 2025",
                    alignment: AlignmentType.CENTER,
                    pageBreakBefore: true,
                }),
                
                new Paragraph({ text: "DAFTAR ISI", heading: HeadingLevel.HEADING_1, alignment: AlignmentType.CENTER }),
                new Paragraph({ text: "BAB 1. PENDAHULUAN ................................................................................... 1" }),
                new Paragraph({ text: "1.1 Latar Belakang ........................................................................................ 1" }),
                new Paragraph({ text: "1.2 Tujuan ..................................................................................................... 2" }),
                new Paragraph({ text: "1.3 Manfaat ................................................................................................... 2" }),
                new Paragraph({ text: "1.4 Target Pengguna...................................................................................... 2" }),
                new Paragraph({ text: "BAB 2. TINJAUAN PUSTAKA.......................................................................... 3" }),
                new Paragraph({ text: "2.1 Kondisi Aktual Permasalahan................................................................. 3" }),
                new Paragraph({ text: "2.2 Inovasi Teknologi.................................................................................... 4" }),
                new Paragraph({ text: "2.3 Rancangan Mockup................................................................................. 8" }),
                new Paragraph({ text: "2.4 Uraian dan Peran Kontribusi Pihak yang Terlibat ................................ 17" }),
                new Paragraph({ text: "2.5 Tahapan - Tahapan Strategis................................................................. 17" }),
                new Paragraph({ text: "BAB 3. KESIMPULAN ..................................................................................... 19", pageBreakBefore: true }),
                
                new Paragraph({ text: "BAB 1. PENDAHULUAN", heading: HeadingLevel.HEADING_1 }),
                new Paragraph({ text: "1.1 Latar Belakang", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({
                    text: "Keselamatan dan Kesehatan Kerja (K3) merupakan aspek fundamental yang wajib dipenuhi oleh setiap perusahaan guna menjamin kesejahteraan tenaga kerja dan kelancaran produktivitas. Pengawasan pelaksanaan K3 di lingkungan kerja menjadi tanggung jawab Dinas Tenaga Kerja (Disnaker). Namun, dalam praktiknya, proses administrasi terkait pelaporan, pengesahan, dan pengawasan K3 seringkali masih dilakukan secara manual.",
                    alignment: AlignmentType.JUSTIFIED,
                }),
                new Paragraph({
                    text: "Metode konvensional ini mengharuskan perwakilan perusahaan untuk datang langsung ke kantor instansi guna menyerahkan berkas fisik. Hal ini tidak hanya memakan waktu dan biaya, tetapi juga berisiko terhadap kehilangan dokumen, lambatnya proses verifikasi, serta kesulitan dalam pelacakan (tracking) status permohonan. Oleh karena itu, diperlukan sebuah transformasi digital untuk menyederhanakan birokrasi dan meningkatkan efisiensi pelayanan.",
                    alignment: AlignmentType.JUSTIFIED,
                }),
                new Paragraph({
                    text: "Sebagai solusi atas permasalahan tersebut, dikembangkanlah inovasi digital bernama \"SIPENAKER\" (Sistem Pelayanan Ketenagakerjaan). Sistem ini merupakan platform e-government yang dirancang khusus untuk mendigitalisasi proses pengesahan Panitia Pembina Keselamatan dan Kesehatan Kerja (P2K3), Pelayanan Kesehatan Kerja, serta pelaporan Kecelakaan Kerja (KK) dan Penyakit Akibat Kerja (PAK). Melalui platform ini, diharapkan tercipta tata kelola pelayanan publik yang transparan, cepat, dan responsif guna mewujudkan lingkungan kerja yang aman dan produktif.",
                    alignment: AlignmentType.JUSTIFIED,
                }),
                
                new Paragraph({ text: "1.2 Tujuan", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "Berikut adalah penjabaran tujuan utama pengembangan sistem SIPENAKER yaitu:" }),
                new Paragraph({ text: "1. Mengidentifikasi kendala birokrasi dan administrasi dalam proses pelayanan dan pengawasan K3 secara konvensional di lingkungan instansi ketenagakerjaan.", bullet: { level: 0 } }),
                new Paragraph({ text: "2. Merancang dan membangun website pelayanan publik yang terintegrasi untuk memfasilitasi pengajuan dokumen pengesahan dan pelaporan insiden kerja secara online.", bullet: { level: 0 } }),
                new Paragraph({ text: "3. Mengimplementasikan sistem yang mempercepat proses verifikasi oleh pihak instansi (Admin) serta memberikan kemudahan pelacakan status dokumen bagi perusahaan (Pengguna).", bullet: { level: 0 } }),

                new Paragraph({ text: "1.3 Manfaat", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "Berikut adalah penjabaran manfaat yang diharapkan dari pengembangan sistem ini yaitu:" }),
                new Paragraph({ text: "1. Bagi Perusahaan: Menghemat waktu dan biaya operasional karena pengajuan dan pelaporan dapat dilakukan secara daring tanpa harus membawa berkas fisik ke kantor dinas.", bullet: { level: 0 } }),
                new Paragraph({ text: "2. Bagi Pemerintah (Disnaker): Meningkatkan efisiensi kerja pegawai dalam memverifikasi dokumen, memudahkan pengarsipan data secara digital, serta mendukung pengambilan kebijakan berbasis data historis yang akurat.", bullet: { level: 0 } }),
                new Paragraph({ text: "3. Bagi Tenaga Kerja: Memastikan bahwa perusahaan tempat mereka bekerja telah mematuhi standar K3 dan pelaporan kecelakaan kerja dapat ditindaklanjuti dengan cepat.", bullet: { level: 0 } }),

                new Paragraph({ text: "1.4 Target Pengguna", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "Target pengguna untuk website ini adalah:" }),
                new Paragraph({ text: "A. Perusahaan / Masyarakat Umum", bullet: { level: 0 } }),
                new Paragraph({ text: "Perusahaan yang membutuhkan layanan pengesahan kelembagaan K3 (P2K3, Pelayanan Kesehatan Kerja) serta pihak yang ingin melaporkan terjadinya Kecelakaan Kerja atau Penyakit Akibat Kerja.", indent: { left: 720 } }),
                new Paragraph({ text: "B. Dinas Tenaga Kerja (Admin Instansi)", bullet: { level: 0 } }),
                new Paragraph({ text: "Pegawai instansi atau pengawas ketenagakerjaan yang bertugas menerima, memverifikasi, dan menyetujui pengajuan berkas serta menindaklanjuti laporan kecelakaan kerja yang masuk.", indent: { left: 720 }, pageBreakBefore: true }),
                
                new Paragraph({ text: "BAB 2. TINJAUAN PUSTAKA", heading: HeadingLevel.HEADING_1 }),
                new Paragraph({ text: "2.1 Kondisi Aktual Permasalahan", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({
                    text: "Pelayanan administrasi publik di bidang ketenagakerjaan, khususnya pengawasan K3, seringkali dihadapkan pada tumpukan dokumen fisik. Berdasarkan keluhan dari berbagai perusahaan, proses pengajuan pengesahan P2K3 membutuhkan proses bolak-balik jika terdapat kekurangan berkas. Selain itu, keterlambatan pelaporan Kecelakaan Kerja (KK) dapat berakibat fatal terhadap pemenuhan hak-hak pekerja (seperti asuransi dan kompensasi) serta menghambat evaluasi pencegahan kecelakaan di masa depan. Ketiadaan platform terpusat membuat pendataan menjadi tidak terstruktur, sulit untuk diaudit, dan memperlambat respons pemerintah terhadap aduan masyarakat.",
                    alignment: AlignmentType.JUSTIFIED,
                }),
                
                new Paragraph({ text: "2.2 Inovasi Teknologi", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "SIPENAKER hadir sebagai inovasi teknologi e-government yang mengubah paradigma pelayanan dari paper-based menjadi paperless dan real-time." }),
                
                new Paragraph({ text: "A. Fitur Utama", heading: HeadingLevel.HEADING_3 }),
                new Paragraph({ text: "Website ini dilengkapi dengan berbagai fitur inovatif yang dirancang untuk memudahkan perusahaan dan pemerintah, antara lain:" }),
                new Paragraph({ text: "1. Pengajuan Pengesahan P2K3 & Pelkes Online: Pengguna dapat mengisi formulir dan mengunggah dokumen persyaratan secara digital.", bullet: { level: 0 } }),
                new Paragraph({ text: "2. Pelaporan Kecelakaan Kerja (KK) / Penyakit Akibat Kerja (PAK): Fitur pelaporan cepat yang terintegrasi dengan data perusahaan untuk respons tanggap darurat dan investigasi.", bullet: { level: 0 } }),
                new Paragraph({ text: "3. Riwayat & Pelacakan Proses (Tracking): Pengguna dapat melihat status permohonannya secara transparan (Menunggu, Diproses, Selesai, atau Ditolak beserta alasannya).", bullet: { level: 0 } }),
                new Paragraph({ text: "4. Unduh Dokumen Digital: Dokumen yang telah disahkan dapat langsung diunduh dari dashboard tanpa harus mengambil cetakan fisik.", bullet: { level: 0 } }),
                new Paragraph({ text: "5. Dashboard Admin Integratif: Admin memiliki akses ke seluruh data pengajuan, statistik harian, serta panel verifikasi yang sangat mudah digunakan.", bullet: { level: 0 } }),

                new Paragraph({ text: "B. Keunggulan", heading: HeadingLevel.HEADING_3 }),
                new Paragraph({ text: "Berdasarkan fitur yang tersedia terdapat beberapa keunggulan yang ada pada SIPENAKER, antara lain:" }),
                new Paragraph({ text: "1. Desain UI/UX Modern & Responsif: Menggunakan pendekatan desain elegan dengan warna yang bersih, elemen glassmorphism, dan layout grid yang rapi, sehingga memberikan pengalaman pengguna yang sangat profesional.", bullet: { level: 0 } }),
                new Paragraph({ text: "2. Sistem Terpusat dan Transparan: Menghilangkan hambatan birokrasi yang berbelit, memastikan setiap dokumen yang masuk dapat dilacak progresnya secara langsung (real-time).", bullet: { level: 0 } }),
                new Paragraph({ text: "3. Notifikasi dan Validasi Cerdas: Sistem dilengkapi dengan validasi data untuk meminimalisir kesalahan input dari pengguna, sehingga berkas yang masuk sudah dipastikan kelengkapannya.", bullet: { level: 0 } }),

                new Paragraph({ text: "C. Teknologi yang digunakan", heading: HeadingLevel.HEADING_3 }),
                new Paragraph({ text: "1. Laravel: Laravel adalah framework open source berbasis PHP yang dirancang untuk memudahkan dan mempercepat proses pengembangan aplikasi web dengan struktur yang terorganisir dan efisien. Laravel diadopsi karena arsitektur Model-View-Controller (MVC) yang memisahkan logika aplikasi, tampilan, dan pengelolaan data sehingga kode menjadi lebih aman.", bullet: { level: 0 } }),
                new Paragraph({ text: "2. MySQL: Sistem manajemen basis data relasional yang andal untuk menyimpan data sensitif perusahaan, riwayat pelaporan, dan dokumen verifikasi dengan terstruktur dan aman.", bullet: { level: 0 } }),
                new Paragraph({ text: "3. Vanilla CSS & JavaScript Modern: Digunakan untuk membangun antarmuka interaktif. Melalui CSS kustom tanpa bergantung sepenuhnya pada pustaka eksternal, desain UI dibangun dengan tingkat eksklusivitas tinggi, memuat animasi transisi, dan responsivitas tata letak secara sempurna.", bullet: { level: 0 } }),
                
                new Paragraph({ text: "2.3 Rancangan Mockup", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "(Pada dokumen final, bagian ini diisi dengan tangkapan layar / screenshot dari halaman Dashboard Pengguna, halaman Pilihan Layanan, formulir pelaporan, dan Dashboard Admin sistem SIPENAKER.)" }),

                new Paragraph({ text: "2.4 Uraian dan Peran Kontribusi Pihak yang Terlibat", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "Berikut adalah uraian peran dan kontribusi pihak-pihak yang terlibat dalam implementasi website SIPENAKER:" }),
                new Paragraph({ text: "A. Perusahaan / Pengguna Layanan", bullet: { level: 0 } }),
                new Paragraph({ text: "Berperan aktif dalam mendaftarkan akun, mengisi data dengan valid, dan memanfaatkan platform untuk melaporkan kondisi K3 dan mengajukan pengesahan dokumen. Partisipasi mereka penting untuk menciptakan pengawasan ketenagakerjaan yang akurat dan berbasis data.", indent: { left: 720 } }),
                new Paragraph({ text: "B. Dinas Tenaga Kerja (Disnaker)", bullet: { level: 0 } }),
                new Paragraph({ text: "Berperan sebagai pengelola sistem (Admin), penentu kebijakan, dan pihak yang melakukan verifikasi serta persetujuan dokumen. Disnaker bertanggung jawab menjaga kualitas respon (SLA) dalam memberikan tanggapan atas permohonan yang masuk dari masyarakat dan perusahaan.", indent: { left: 720 } }),

                new Paragraph({ text: "2.5 Tahapan - Tahapan Strategis", heading: HeadingLevel.HEADING_2 }),
                new Paragraph({ text: "Agar pengembangan website ini sukses perlu dilakukan langkah-langkah strategis. Dimulai dengan analisis kebutuhan alur birokrasi, sistem kemudian dibangun dan akan diuji secara terbatas (versi beta) pada beberapa instansi. Melalui fase ini, masukan penting dikumpulkan untuk penyempurnaan UI/UX maupun kestabilan server. Proses validasi keamanan dokumen menjadi prioritas utama.", alignment: AlignmentType.JUSTIFIED }),
                new Paragraph({ text: "Setelah penyempurnaan, website akan dirilis resmi dengan sosialisasi menyeluruh kepada perwakilan perusahaan tentang tata cara pengajuan dokumen online. Selanjutnya, pemantauan (monitoring) akan dilakukan secara berkala. Pengembangan fitur lanjutan juga akan terus diupayakan berdasarkan tanggapan balik (feedback) demi tercapainya digitalisasi layanan K3 yang optimal.", alignment: AlignmentType.JUSTIFIED, pageBreakBefore: true }),

                new Paragraph({ text: "BAB 3. KESIMPULAN", heading: HeadingLevel.HEADING_1 }),
                new Paragraph({ text: "Pelayanan dan pengawasan K3 yang efisien merupakan aspek krusial dalam menciptakan ekosistem kerja yang produktif, aman, dan berdaya saing. Peran aktif perusahaan sangat dibutuhkan dalam melaporkan kegiatan K3. Namun, birokrasi manual selama ini menjadi hambatan kecepatan layanan. Oleh karena itu, dikembangkanlah platform SIPENAKER sebagai solusi e-government yang mengubah proses berbasis kertas menjadi sepenuhnya terdigitalisasi secara online.", alignment: AlignmentType.JUSTIFIED }),
                new Paragraph({ text: "Untuk keberhasilan implementasi platform ini, dukungan penuh dari instansi pemerintah sangat diperlukan, khususnya dalam sosialisasi dan komitmen operasional sistem. Diharapkan dengan hadirnya SIPENAKER, terjalin komunikasi yang lebih efektif antara perusahaan dan instansi ketenagakerjaan. Pada akhirnya, tata kelola administrasi publik yang transparan, bebas hambatan, dan cepat dapat terwujud demi peningkatan kualitas hidup dan keselamatan kerja berskala nasional.", alignment: AlignmentType.JUSTIFIED })

            ],
        },
    ],
});

Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync("Proposal_Sipenaker.docx", buffer);
    console.log("Created docx");
});
