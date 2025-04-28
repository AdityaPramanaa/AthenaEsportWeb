<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>UKM Athena E-Sport</h2>
    </div>

    <div class="content">
        <p>Halo {{ $user->name }},</p>

        <p>Terima kasih telah mendaftar di UKM Athena E-Sport. Untuk menyelesaikan proses pendaftaran, silakan verifikasi email Anda dengan mengklik tombol di bawah ini:</p>

        <p style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">Verifikasi Email</a>
        </p>

        <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:</p>
        <p>{{ $verificationUrl }}</p>

        <p>Link verifikasi ini akan kadaluarsa dalam 60 menit.</p>

        <p>Jika Anda tidak merasa mendaftar di UKM Athena E-Sport, Anda dapat mengabaikan email ini.</p>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} UKM Athena E-Sport. All rights reserved.</p>
    </div>
</body>
</html> 