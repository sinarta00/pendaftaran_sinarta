<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran Perpanjangan AK3U BNSP</title>
</head>
<body style="margin: 0; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #2c3e50;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="background: #10b981; padding: 30px; text-align: center; color: white;">
            <div style="background: white; display: inline-block; padding: 12px 24px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 18px; font-weight: 700; color: #10b981; letter-spacing: 1px;">SINARTA MJS</div>
            </div>
            <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px;">
                Pembayaran Lunas!
            </div>
            <div style="font-size: 16px; opacity: 0.9; font-weight: 300;">
                Perpanjangan AK3U BNSP
            </div>
        </div>

        <div style="padding: 40px 30px;">
            <p style="font-size: 16px; line-height: 1.6; color: #4a5568;">
                Halo <strong>{{ $registration->full_name }}</strong>, pembayaran untuk Perpanjangan AK3U BNSP Anda dengan nomor registrasi <strong>{{ $registration->registration_number }}</strong> telah berhasil diverifikasi dan dikonfirmasi.
            </p>

            <div style="background: #f8fafc; border-radius: 12px; padding: 25px; margin: 25px 0; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 15px 0; color: #10b981; font-size: 18px;">Rincian Pembayaran</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Nomor Invoice</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $registration->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Tanggal Pembayaran</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $registration->payment_date ? $registration->payment_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Total Pembayaran</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #10b981;">Rp {{ number_format($registration->total_payment, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 14px; color: #64748b; text-align: center;">
                Proses perpanjangan sedang diproses oleh tim kami. Terima kasih atas kepercayaan Anda.
            </p>
        </div>
    </div>
</body>
</html>
