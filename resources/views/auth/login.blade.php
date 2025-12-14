<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pelayanan K3</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #198754 0%, #198754 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(90deg, var(--blue), var(--blue-2));
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .remember-me label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #198754 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }

        .register-link a {
            color: #198754;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
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

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 18px;
            /* Slightly larger for emoji */
            padding: 0;
            line-height: 1;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .login-container {
                max-width: 100%;
                border-radius: 15px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-header img {
                height: 50px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-header p {
                font-size: 13px;
            }

            .login-body {
                padding: 30px 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            input[type="email"],
            input[type="password"],
            input[type="text"] {
                padding: 14px 15px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            .btn-login {
                padding: 16px;
                font-size: 16px;
                min-height: 48px; /* Touch-friendly */
            }

            label {
                font-size: 13px;
            }

            .register-link {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 25px 15px;
            }

            .login-body {
                padding: 25px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('logo_kalsel.png') }}" alt="Provinsi Logo" class="logo">
            <h1>Pelayanan K3</h1>
            <p>Masuk ke akun Anda</p>
        </div>
        <div class="login-body">
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <div style="margin-top: 10px; display: flex; align-items: center;">
                        <input type="checkbox" id="showPass" onclick="togglePassword()">
                        <label for="showPass"
                            style="margin: 0 0 0 8px; font-weight: normal; cursor: pointer; font-size: 14px;">Tampilkan
                            sandi</label>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const checkbox = document.getElementById('showPass');

            if (checkbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }

        // Handle form submission without browser warning
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.querySelector('form[action*="login"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;

                    submitButton.disabled = true;
                    submitButton.textContent = 'Memproses...';

                    // Get fresh CSRF token first
                    fetch('/login', {
                        method: 'GET',
                        credentials: 'same-origin'
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Extract CSRF token from response
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newToken = doc.querySelector('input[name="_token"]')?.value;

                            if (newToken) {
                                // Update token in current form
                                const tokenInput = loginForm.querySelector('input[name="_token"]');
                                if (tokenInput) {
                                    tokenInput.value = newToken;
                                }
                            }

                            // Now submit with fresh token
                            const formData = new FormData(loginForm);

                            return fetch(loginForm.action, {
                                method: 'POST',
                                body: formData,
                                credentials: 'same-origin',
                                redirect: 'follow'
                            });
                        })
                        .then(response => {
                            if (response.redirected) {
                                window.location.href = response.url;
                            } else if (response.ok) {
                                return response.text();
                            } else {
                                throw new Error('Login failed');
                            }
                        })
                        .then(html => {
                            if (html) {
                                // Show error page
                                document.open();
                                document.write(html);
                                document.close();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                            alert('Terjadi kesalahan. Silakan refresh halaman dan coba lagi.');
                        });
                });
            }
        });
    </script>
</body>

</html>