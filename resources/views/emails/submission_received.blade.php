<!DOCTYPE html>
<html>

<head>
    <title>Laporan Diterima</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #198754;">Terima Kasih, {{ $user->nama_lengkap ?? 'Pengguna' }}!</h2>
    <p>Laporan/Permohonan Anda telah kami terima dengan detail sebagai berikut:</p>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold; width: 150px;">Jenis Layanan</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $type }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Tanggal</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ now()->translatedFormat('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Status Saat Ini</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;"><span
                    style="color: #198754; font-weight: bold;">BERKAS DITERIMA</span></td>
        </tr>
    </table>

    <p>Admin kami akan segera melakukan verifikasi berkas Anda. Mohon pantau status pengajuan Anda secara berkala
        melalui Dashboard.</p>

    <div style="margin-top: 30px; font-size: 12px; color: #777;">
        <p>Email ini dikirim secara otomatis oleh Sistem Pelayanan K3.</p>
    </div>
</body>

</html>