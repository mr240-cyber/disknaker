<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lacak Berkas - SIPENAKER K3</title>
    <link rel="stylesheet" href="{{ asset('css/modern-design.css') }}">
    <style>
        body { background-color: var(--bg-color); }
        .tracking-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
        }
        .result-card {
            display: none;
            margin-top: 30px;
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .timeline {
            margin-top: 30px;
            position: relative;
            padding-left: 30px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border-color);
        }
        .timeline-step {
            position: relative;
            margin-bottom: 25px;
        }
        .timeline-step::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #cbd5e1;
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--border-color);
            z-index: 1;
        }
        .timeline-step.active::before {
            background: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-light);
        }
        .timeline-step h4 {
            margin: 0 0 5px 0;
            color: var(--text-main);
        }
        .timeline-step p {
            margin: 0;
            font-size: 0.9em;
            color: var(--text-muted);
        }

        .rating-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: var(--radius-md);
            margin-top: 30px;
            text-align: center;
        }
        .stars {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 15px 0;
            flex-direction: row-reverse;
        }
        .stars input { display: none; }
        .stars label {
            font-size: 30px;
            color: #cbd5e1;
            cursor: pointer;
            transition: 0.2s;
        }
        .stars label:hover,
        .stars label:hover ~ label,
        .stars input:checked ~ label {
            color: #fbbf24;
        }
    </style>
</head>
<body>
    <header style="justify-content: center;">
        <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 15px; color: var(--text-main);">
            <img src="{{ asset('logo_kalsel.png') }}" alt="Logo" style="height: 40px;">
            <div style="line-height: 1.2;">
                <h1 style="margin:0; font-size: 1.2rem;">Lacak Berkas SIPENAKER</h1>
                <p style="margin:0; font-size: 0.8rem; color: var(--text-muted);">Dinas Tenaga Kerja Prov Kalsel</p>
            </div>
        </a>
    </header>

    <div class="tracking-container card">
        <h2 style="text-align: center;">Cek Status Pengajuan</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">Masukkan Nomor Resi Anda untuk mengetahui status terbaru.</p>
        
        <form id="trackForm" onsubmit="trackResi(event)">
            <div style="display: flex; gap: 10px;">
                <input type="text" id="resiInput" placeholder="Contoh: K3-26-ABCDEF" required style="text-transform: uppercase; font-size: 16px; padding: 15px;">
                <button type="submit" class="btn-primary" id="btnTrack" style="padding: 0 30px;">Cari</button>
            </div>
            <div id="errorMsg" class="error hidden" style="text-align: center; margin-top: 10px;"></div>
        </form>

        <!-- Result -->
        <div id="resultCard" class="result-card">
            <div class="status" style="justify-content: space-between; align-items: flex-start; background: var(--bg-color); border: 1px solid var(--border-color);">
                <div>
                    <div class="muted">Perusahaan</div>
                    <strong id="resPerusahaan" style="font-size: 18px;">-</strong>
                </div>
                <div style="text-align: right;">
                    <div class="muted">Jenis Layanan</div>
                    <strong id="resJenis">-</strong>
                </div>
            </div>

            <div class="timeline">
                <div class="timeline-step" id="step1">
                    <h4>Berkas Diterima</h4>
                    <p>Pengajuan telah masuk ke sistem kami.</p>
                </div>
                <div class="timeline-step" id="step2">
                    <h4>Verifikasi Berkas</h4>
                    <p>Tim kami sedang memverifikasi kelengkapan dokumen.</p>
                </div>
                <div class="timeline-step" id="step3">
                    <h4>Selesai / Dokumen Tersedia</h4>
                    <p>Surat Keputusan (SK) telah terbit.</p>
                </div>
                <div class="timeline-step hidden" id="stepReject">
                    <h4 style="color: #ef4444;">Ditolak / Revisi</h4>
                    <p>Ada berkas yang kurang/salah. Silakan periksa akun Anda.</p>
                </div>
            </div>

            <!-- IKM Rating -->
            <div id="ratingSection" class="rating-box hidden">
                <h4>Seberapa puas Anda dengan layanan ini?</h4>
                <p class="muted">Bantu kami meningkatkan pelayanan (Indeks Kepuasan Masyarakat)</p>
                
                <form id="ratingForm" onsubmit="submitRating(event)">
                    <div class="stars">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                    <input type="hidden" id="rateResi">
                    <input type="hidden" id="rateTable">
                    <input type="hidden" id="rateId">
                    <button type="submit" class="btn-primary" style="width: 100%;">Kirim Penilaian</button>
                </form>
                <div id="ratingSuccess" class="hidden" style="color: var(--primary); font-weight: bold; margin-top: 15px;">
                    ✅ Terima kasih atas penilaian Anda!
                </div>
            </div>
        </div>
    </div>

    <script>
        async function trackResi(e) {
            e.preventDefault();
            const btn = document.getElementById('btnTrack');
            const resi = document.getElementById('resiInput').value;
            const errorMsg = document.getElementById('errorMsg');
            const resultCard = document.getElementById('resultCard');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            btn.disabled = true;
            btn.innerHTML = "Mencari...";
            errorMsg.classList.add('hidden');
            resultCard.style.display = 'none';

            try {
                let res = await fetch('/lacak/cek', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ resi: resi })
                });

                let data = await res.json();
                
                if(data.status === 'success') {
                    // Fill data
                    document.getElementById('resPerusahaan').innerText = data.data.perusahaan;
                    document.getElementById('resJenis').innerText = data.data.jenis;
                    
                    // Reset Timeline
                    document.getElementById('step1').classList.remove('active');
                    document.getElementById('step2').classList.remove('active');
                    document.getElementById('step3').classList.remove('active');
                    document.getElementById('stepReject').classList.add('hidden');
                    
                    let status = data.data.status_pengajuan;
                    
                    if(status === 'BERKAS DITERIMA') {
                        document.getElementById('step1').classList.add('active');
                    } else if(status === 'VERIFIKASI BERKAS') {
                        document.getElementById('step1').classList.add('active');
                        document.getElementById('step2').classList.add('active');
                    } else if(status === 'DOKUMEN TERSEDIA' || status === 'SELESAI') {
                        document.getElementById('step1').classList.add('active');
                        document.getElementById('step2').classList.add('active');
                        document.getElementById('step3').classList.add('active');
                    } else if(status === 'DITOLAK') {
                        document.getElementById('step1').classList.add('active');
                        document.getElementById('stepReject').classList.remove('hidden');
                        document.getElementById('stepReject').classList.add('active');
                        document.getElementById('step3').style.display = 'none';
                    }

                    // Handle IKM Rating Form
                    let ratingSection = document.getElementById('ratingSection');
                    if((status === 'DOKUMEN TERSEDIA' || status === 'SELESAI') && data.data.rating_ikm == 0) {
                        ratingSection.classList.remove('hidden');
                        document.getElementById('ratingForm').classList.remove('hidden');
                        document.getElementById('ratingSuccess').classList.add('hidden');
                        
                        document.getElementById('rateResi').value = data.data.resi;
                        document.getElementById('rateTable').value = data.table;
                        document.getElementById('rateId').value = data.id;
                    } else if (data.data.rating_ikm > 0) {
                        ratingSection.classList.remove('hidden');
                        document.getElementById('ratingForm').classList.add('hidden');
                        document.getElementById('ratingSuccess').classList.remove('hidden');
                        document.getElementById('ratingSuccess').innerText = `✅ Anda telah memberikan penilaian Bintang ${data.data.rating_ikm}`;
                    } else {
                        ratingSection.classList.add('hidden');
                    }

                    resultCard.style.display = 'block';
                } else {
                    errorMsg.innerText = data.message;
                    errorMsg.classList.remove('hidden');
                }
            } catch(e) {
                errorMsg.innerText = "Terjadi kesalahan jaringan.";
                errorMsg.classList.remove('hidden');
            }

            btn.disabled = false;
            btn.innerHTML = "Cari";
        }

        async function submitRating(e) {
            e.preventDefault();
            const form = e.target;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let formData = new FormData(form);
            let rating = formData.get('rating');
            
            try {
                let res = await fetch('/lacak/rating', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        resi: document.getElementById('rateResi').value,
                        table: document.getElementById('rateTable').value,
                        id: document.getElementById('rateId').value,
                        rating: rating
                    })
                });

                let data = await res.json();
                if(data.status === 'success') {
                    form.classList.add('hidden');
                    let success = document.getElementById('ratingSuccess');
                    success.innerText = data.message;
                    success.classList.remove('hidden');
                } else {
                    alert(data.message);
                }
            } catch(e) {
                alert("Gagal menyimpan penilaian.");
            }
        }
    </script>
</body>
</html>
