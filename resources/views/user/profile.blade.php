<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Pelayanan K3</title>
    <style>
        :root {
            --blue: #198754;
            /* same as dashboard */
            --blue-2: #146c43;
            --muted: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial;
            background: #f3f6fb;
            min-height: 100vh;
            display: flex;
        }

        .layout {
            display: flex;
            flex: 1;
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
            font-size: 16px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .sidebar li:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .profile-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(12, 44, 102, 0.06);
            max-width: 500px;
            margin: auto;
        }

        .profile-card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .profile-card h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .profile-card p {
            margin: 5px 0;
            color: #555;
        }

        .profile-card .field {
            margin-top: 10px;
        }

        .profile-card .field span {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <div>
                <h3>SIPENAKER</h3>
                <ul>
                    <li onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-tachometer-alt"
                            style="width:25px;"></i> Dashboard</li>
                    <li onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-concierge-bell"
                            style="width:25px;"></i> Pelayanan</li>
                    <li onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-history"
                            style="width:25px;"></i> Riwayat Proses</li>
                    <li onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-download"
                            style="width:25px;"></i> Unduh Dokumen</li>
                    <li class="active"><i class="fas fa-user" style="width:25px;"></i> Profil</li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" style="padding:20px 0;">
                    @csrf
                    <button type="submit"
                        style="width:100%;padding:12px;background:rgba(255,255,255,0.2);color:white;border:1px solid white;border-radius:8px;cursor:pointer;font-size:14px;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
        <main>
            <div class="profile-card">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=198754&color=fff&size=128"
                    alt="Avatar">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                <div class="field"><span>Role:</span> {{ Auth::user()->role ?? 'Pengguna' }}</div>
                @if (!Auth::user()->hasVerifiedEmail())
                    <form method="POST" action="{{ route('verification.resend') }}" style="margin-top:15px;">
                        @csrf
                        <button type="submit" class="btn-login"
                            style="background: linear-gradient(135deg, #198754 100%);">Kirim Verifikasi Email</button>
                    </form>
                @else
                    <p style="color: #28a745; margin-top:10px;">Email sudah terverifikasi.</p>
                @endif
                <!-- Add more user fields as needed -->
            </div>
        </main>
    </div>
</body>

</html>