<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Pelayanan K3</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #198754 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }

        .register-header {
            background: linear-gradient(135deg, #2e5c46 0%, #1a3d2e 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .register-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .register-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .register-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #2e5c46;
            box-shadow: 0 0 0 3px rgba(46, 92, 70, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: #739E82;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #5a8069;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #2e5c46;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: #1a3d2e;
            text-decoration: underline;
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .register-container {
                max-width: 100%;
                border-radius: 15px;
            }

            .register-header {
                padding: 30px 20px;
            }

            .register-header img {
                height: 50px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .register-header p {
                font-size: 13px;
            }

            .register-body {
                padding: 30px 20px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 14px 15px;
                font-size: 16px;
                /* Prevent zoom on iOS */
            }

            .btn-register {
                padding: 16px;
                font-size: 16px;
                min-height: 48px;
                /* Touch-friendly */
            }

            label {
                font-size: 13px;
            }

            .login-link {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .register-header {
                padding: 25px 15px;
            }

            .register-body {
                padding: 25px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <img src="{{ asset('logo_kalsel.png') }}" alt="Provinsi Logo">
            <h1>Daftar Akun</h1>
            <p>Buat akun baru untuk mengakses layanan K3</p>
        </div>
        <div class="register-body">
            @if ($errors->any())
                <div class="error-message">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                        autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-register">Daftar</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>

</html>