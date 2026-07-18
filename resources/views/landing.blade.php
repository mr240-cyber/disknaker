<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENAKER - Dinas Tenaga Kerja</title>
    <!-- Premium Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #064e3b; /* Emerald 900 */
            --primary-light: #10b981; /* Emerald 500 */
            --accent: #3b82f6;
            --text-dark: #0f172a;
            --text-light: #f8fafc;
            --bg-color: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 45px;
            width: auto;
        }

        .brand-text h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-dark);
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            margin-left: 20px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary-light);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
            color: white !important;
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(46, 92, 70, 0.3);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 92, 70, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 5% 50px;
            background-color: #f0fdf4;
            background-image: 
                radial-gradient(at 0% 0%, hsla(158, 82%, 87%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(198, 93%, 89%, 1) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(202, 100%, 89%, 1) 0, transparent 50%),
                radial-gradient(at 0% 100%, hsla(152, 100%, 89%, 1) 0, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        .blob-1 {
            position: absolute;
            top: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 8s ease-in-out infinite;
        }

        .blob-2 {
            position: absolute;
            bottom: -10%;
            left: -5%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
            100% { transform: translateY(0) scale(1); }
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 900px;
            z-index: 1;
        }

        .badge {
            background: rgba(46, 92, 70, 0.1);
            color: var(--primary-dark);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            display: inline-block;
            backdrop-filter: blur(5px);
            animation: fadeUp 0.8s ease-out;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 20px;
            line-height: 1.2;
            animation: fadeUp 1s ease-out 0.2s both;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--primary-light), #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.2rem;
            color: #4b5563;
            margin-bottom: 40px;
            max-width: 700px;
            animation: fadeUp 1s ease-out 0.4s both;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            animation: fadeUp 1s ease-out 0.6s both;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            color: white;
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(46, 92, 70, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(46, 92, 70, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--primary-dark);
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            border-color: var(--primary-light);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.08);
        }

        /* Features Section */
        .features {
            padding: 100px 5%;
            background: white;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .section-header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 40px 30px;
            border-radius: 24px;
            text-align: center;
            transition: all 0.1s ease-out; /* Fast for JS mousemove */
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            transform-style: preserve-3d;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(46,92,70,0.1), rgba(68,128,99,0.1));
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: var(--primary-dark);
            color: white;
        }

        .feature-card h3 {
            font-size: 1.4rem;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* Footer */
        footer {
            background: var(--primary-dark);
            color: white;
            padding: 40px 5%;
            text-align: center;
        }

        footer p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 6px;
            z-index: 1001;
        }

        .hamburger span {
            width: 30px;
            height: 3px;
            background-color: var(--primary-dark);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        .link-lacak {
            margin-right: 15px; 
            color: var(--primary-dark) !important; 
            font-weight: 700 !important;
            padding: 8px 16px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .link-lacak:hover {
            background: rgba(16, 185, 129, 0.2);
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero-buttons { flex-direction: column; width: 100%; max-width: 300px; margin: 0 auto; }
            
            .hamburger { display: flex; }
            
            .nav-links { 
                position: fixed;
                top: 0;
                right: -100%;
                width: 100vw;
                height: 100vh;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                gap: 30px;
            }
            .nav-links.active {
                right: 0;
            }
            .nav-links a {
                margin: 0;
                font-size: 1.5rem;
            }
            .link-lacak { margin: 0; }
        }
    </style>
    <!-- Add FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('logo_kalsel.png') }}" alt="Logo Kalsel">
            <div class="brand-text">
                <h1>SIPENAKER</h1>
                <p>Dinas Tenaga Kerja</p>
            </div>
        </a>
        <div class="hamburger" id="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-links" id="nav-links">
            <a href="/lacak" class="link-lacak">Lacak Berkas</a>
            <a href="#layanan">Layanan</a>
            <a href="{{ route('login') }}" class="btn-login">Masuk Portal</a>
        </div>
    </nav>

    <section class="hero">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
        
        <div class="hero-content">
            <div class="badge">Sistem Pelayanan Ketenagakerjaan</div>
            <h1>Pelayanan K3 <span>Lebih Mudah</span> & Transparan</h1>
            <p>Sistem informasi digital terintegrasi untuk pengesahan K3, pelaporan P2K3, dan pengawasan ketenagakerjaan di lingkungan Provinsi Kalimantan Selatan.</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">Mulai Sekarang <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></a>
                <a href="#layanan" class="btn-secondary">Lihat Layanan</a>
            </div>
        </div>
    </section>

    <section id="layanan" class="features">
        <div class="section-header">
            <h2>Layanan Utama Kami</h2>
            <p>Kemudahan mengurus administrasi dan pelaporan K3 secara online.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3>Pengesahan K3</h3>
                <p>Pengajuan pengesahan panitia pembina K3, alat berat, dan sertifikasi keahlian lebih praktis tanpa perlu antri.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3>Laporan P2K3</h3>
                <p>Fasilitas pelaporan rutin P2K3 triwulan untuk perusahaan guna memantau keselamatan dan kesehatan kerja.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-ambulance"></i>
                </div>
                <h3>Pelaporan KK & PAK</h3>
                <p>Sistem pelaporan Cepat Kecelakaan Kerja (KK) dan Penyakit Akibat Kerja (PAK) untuk penanganan segera.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; {{ date('Y') }} Dinas Tenaga Kerja Prov. Kalimantan Selatan. All rights reserved.</p>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const nav = document.getElementById('nav-links');
        
        btn.addEventListener('click', () => {
            nav.classList.toggle('active');
            btn.classList.toggle('active');
        });

        // 3D Tilt Effect on Feature Cards
        const cards = document.querySelectorAll('.feature-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -10;
                const rotateY = ((x - centerX) / centerX) * 10;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            });
        });
    </script>
</body>
</html>
