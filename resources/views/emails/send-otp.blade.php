<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: sans-serif; background-color: #f9f9f9; padding: 20px;">
  <div style="background-color: #ffffff; padding: 20px; border-radius: 5px;">
    <h2>Halo {{ $user->username ?? $user->name ?? $user->email ?? 'Pengguna' }},</h2>
    <p>Kami menerima permintaan untuk mereset password Anda.</p>
    <p><strong>Kode OTP Anda adalah:</strong></p>
    <h1 style="font-size: 36px; letter-spacing: 6px; text-align: center;">{{ $otp }}</h1>
    <p>Masukkan kode ini pada halaman verifikasi untuk melanjutkan proses reset password Anda.</p>
    <p style="margin-top: 20px;">Abaikan email ini jika Anda tidak meminta reset password.</p>
    <p>Salam,<br><strong>Tim Figure Collection Store</strong></p>
  </div>
</body>
</html>
