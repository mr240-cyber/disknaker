<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIPENAKER</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modern-design.css') }}">
    <style>
        body {
            /* Animated Mesh Gradient Background */
            background: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(59, 130, 246, 0.2) 0px, transparent 50%);
            background-color: #f8fafc;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            animation: bgShift 15s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        /* Glassmorphism Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .brand-text h1 {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2px;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.5px;
        }

        .brand-text p {
            font-size: 11px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 500;
        }

        .navbar-links {
            display: flex;
            gap: 25px;
        }

        .navbar-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            padding: 8px 16px;
            border-radius: 20px;
        }

        .navbar-links a:hover {
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary-dark);
        }

        .navbar-links a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        /* Main Section */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            perspective: 1000px;
        }

        /* Glassmorphism Card with 3D Tilt */
        .register-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 40px 50px;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08), inset 0 0 0 1px rgba(255,255,255,0.5);
            text-align: left;
            transition: transform 0.1s ease-out;
            transform-style: preserve-3d;
        }

        .welcome-text {
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            transform: translateZ(20px);
        }

        .register-title {
            color: var(--text-main);
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 25px;
            font-family: 'Outfit', sans-serif;
            transform: translateZ(30px);
        }

        .form-group {
            margin-bottom: 20px;
            transform: translateZ(20px);
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            transition: var(--transition);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: var(--text-muted);
            transition: color 0.3s;
        }
        
        .toggle-password:hover {
            color: var(--primary);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            transform: translateZ(25px);
        }

        .btn-submit:hover {
            transform: translateZ(30px) translateY(-2px);
            box-shadow: 0 15px 25px rgba(16, 185, 129, 0.3);
        }

        .error-alert {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            transform: translateZ(10px);
        }

        .error-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .login-link {
            margin-top: 25px;
            text-align: center;
            transform: translateZ(10px);
        }

        .login-link p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .login-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
        }

        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .navbar {
                padding: 10px 20px;
                height: auto;
                flex-direction: column;
                gap: 15px;
            }
            .register-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('logo_kalsel.png') }}" alt="Logo">
            <div class="brand-text">
                <h1>SIPENAKER</h1>
                <p>Sistem Informasi Pengaduan Ketenagakerjaan</p>
            </div>
        </a>
        <div class="navbar-links">
            <a href="{{ route('register') }}" class="active">Daftar</a>
            <a href="{{ route('login') }}">Login</a>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="main-container">
        <div class="register-card" id="tiltCard">
            <p class="welcome-text">Bergabung Sekarang</p>
            <h2 class="register-title">Daftar Akun Baru</h2>

            @if ($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap Pemohon</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required autofocus placeholder="Contoh: Budi Santoso">
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Contoh: budi@perusahaan.com">
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                        <button type="button" class="toggle-password" onclick="togglePassword('password')" title="Lihat Password">👁️</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')" title="Lihat Password">👁️</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>

            <div class="login-link">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }

        // 3D Tilt Effect on Desktop
        const card = document.getElementById('tiltCard');
        if (window.matchMedia("(min-width: 768px)").matches) {
            document.addEventListener('mousemove', (e) => {
                let xAxis = (window.innerWidth / 2 - e.pageX) / 50;
                let yAxis = (window.innerHeight / 2 - e.pageY) / 50;
                card.style.transform = \`rotateY(\${xAxis}deg) rotateX(\${yAxis}deg)\`;
            });
            document.addEventListener('mouseleave', () => {
                card.style.transform = \`rotateY(0deg) rotateX(0deg)\`;
            });
        }
    </script>
</body>
</html>