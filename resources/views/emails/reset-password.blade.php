<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2563eb;">Password Anda Telah Direset</h2>
        
        <p>Halo,</p>
        <p>Password Anda telah direset oleh admin. Berikut password baru Anda:</p>
        <p><b>{{ $password }}</b></p>
        <p>Silakan login dan segera ganti password Anda demi keamanan akun.</p>
        <p>Terima kasih.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px;">Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html> 