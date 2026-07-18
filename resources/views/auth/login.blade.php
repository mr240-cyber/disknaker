<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENAKER</title>
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
        .login-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 50px;
            width: 100%;
            max-width: 450px;
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

        .login-title {
            color: var(--text-main);
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 30px;
            font-family: 'Outfit', sans-serif;
            transform: translateZ(30px);
        }

        .form-group {
            margin-bottom: 24px;
            transform: translateZ(20px);
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 45px 14px 16px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            transition: var(--transition);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        /* Hide Edge default password reveal */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
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
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            cursor: pointer;
            font-size: 18px;
            color: var(--text-muted);
            transition: color 0.3s;
            z-index: 10;
            width: auto;
            height: auto;
        }
        
        .toggle-password:hover, .toggle-password:focus, .toggle-password:active {
            color: var(--primary);
            transform: translateY(-50%) !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .forgot-pass {
            display: block;
            text-align: right;
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            margin-top: 8px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .forgot-pass:hover {
            color: var(--primary-dark);
            text-decoration: underline;
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
            margin-top: 20px;
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
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateZ(10px);
        }

        .register-link {
            margin-top: 30px;
            text-align: center;
            transform: translateZ(10px);
        }

        .register-link p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .register-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
        }

        .register-link a:hover {
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
            .login-card {
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
            <a href="{{ route('register') }}">Daftar</a>
            <a href="{{ route('login') }}" class="active">Login</a>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="main-container">
        <div class="login-card" id="tiltCard">
            <p class="welcome-text">Selamat Datang Kembali</p>
            <h2 class="login-title">Masuk Akun</h2>

            @if ($errors->any())
                <div class="error-alert">
                    <span>⚠️</span> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus placeholder="Masukkan email Anda">
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan kata sandi">
                        <button type="button" class="toggle-password" onclick="togglePassword(this)" title="Lihat Password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#64748b"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </button>
                    </div>
                    <a href="#" class="forgot-pass">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn-submit">Sign In</button>
            </form>

            <div class="register-link">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        const iconEye = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#64748b"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>`;
        const iconEyeOff = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#64748b"><path d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17zm-4.3.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.3-6.46l-2.04 2.04A11.723 11.723 0 0 1 12 4.5c5 0 9.27 3.11 11 7.5-.71 1.79-1.85 3.32-3.23 4.46l-2.04-2.04C18.92 13.51 20.31 12.83 21 12c-1.57-3.53-5.22-6.16-9.17-6.16zm-7.77-1.4l1.37 1.37a11.758 11.758 0 0 0-4.43 4.69c1.57 3.53 5.22 6.16 9.17 6.16 1.48 0 2.87-.36 4.12-.99l2.45 2.45 1.41-1.41L2.65 1.93 1.24 3.34z"/></svg>`;

        function togglePassword(btn) {
            const input = document.getElementById('password');
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = iconEyeOff;
                btn.title = 'Sembunyikan Password';
            } else {
                input.type = 'password';
                btn.innerHTML = iconEye;
                btn.title = 'Lihat Password';
            }
        }
    </script>
</body>
</html>