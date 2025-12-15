<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENAKER</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #2e5c46;
            /* Base Dark Green */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
        }

        .brand-text h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .brand-text p {
            font-size: 11px;
            color: #555;
            margin: 0;
        }

        .navbar-links {
            display: flex;
            gap: 25px;
        }

        .navbar-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .navbar-links a.active {
            color: #2e5c46;
        }

        /* MAIN CONTENT */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 20px;
        }

        /* CHARACTERS (Illustrations) */
        /* To simulate the "peeking" effect, we place them absolutely or flexibly relative to the card */
        .character-img {
            position: absolute;
            height: 380px;
            /* Adjust based on real image size */
            z-index: 1;
            bottom: auto;
            /* Aligned relative to card center usually, but here hardcoded for demo */
        }

        .char-left {
            margin-right: 480px;
            /* Push to left of card placeholder */
            transform: translateX(-50px);
        }

        .char-right {
            margin-left: 480px;
            transform: translateX(50px);
        }

        /* LOGIN CARD */
        .login-card {
            background: white;
            padding: 40px 50px;
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 2;
            /* Sit above chars */
            position: relative;
            text-align: center;
        }

        .welcome-text {
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
            text-align: left;
        }

        .login-title {
            color: #2e5c46;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #777;
            /* Darker border as per image */
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #2e5c46;
            box-shadow: 0 0 0 2px rgba(46, 92, 70, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #333;
        }

        .forgot-pass {
            display: block;
            text-align: right;
            font-size: 11px;
            color: #888;
            text-decoration: none;
            margin-top: 5px;
        }

        .btn-submit {
            background: #739E82;
            /* Matches mockup button color */
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 30px;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: #5a8069;
        }

        /* Error Message */
        .error-alert {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {

            .char-left,
            .char-right {
                opacity: 0.3;
                /* Fade specific images on smaller screens if overlapping */
                height: 300px;
            }
        }

        @media (max-width: 500px) {
            .navbar {
                padding: 10px 20px;
                height: auto;
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .navbar-links {
                gap: 15px;
            }

            .navbar-brand {
                gap: 8px;
            }

            .brand-text h1 {
                font-size: 16px;
            }

            .brand-text p {
                font-size: 10px;
            }

            .character-img {
                display: none;
            }

            /* Hide characters on mobile */
            .login-card {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <!-- Ganti dengan logo provinsi -->
            <img src="{{ asset('logo_kalsel.png') }}" alt="Logo">
            <div class="brand-text">
                <h1>SIPENAKER</h1>
                <p>Sistem Informasi Pengaduan Pengawasan Ketenagakerjaan</p>
            </div>
        </div>
        <div class="navbar-links">
            <a href="{{ route('register') }}">Daftar</a>
            <a href="{{ route('login') }}" class="active">Login</a>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="main-container">



        <div class="login-card">
            <p class="welcome-text">welcome !!!</p>
            <h2 class="login-title">Log In</h2>

            @if ($errors->any())
                <div class="error-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus placeholder="">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <!-- Icon mata sederhana -->
                            &#128065;
                        </button>
                    </div>
                    <a href="#" class="forgot-pass">Forgot Password ?</a>
                </div>

                <button type="submit" class="btn-submit">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>

</html>