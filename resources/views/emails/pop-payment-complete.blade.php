<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Lunas - POP BNSP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #059669; text-align: center;">✅ Pembayaran Lunas</h1>
        
        <p>Selamat <strong>{{ $participant->full_name }}</strong>!</p>
        <p>Pembayaran Anda telah lunas dan pendaftaran POP BNSP telah selesai.</p>
        
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Rincian Pembayaran Lengkap:</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nomor Registrasi:</strong></td>
                    <td>{{ $participant->registration_number }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Invoice Pelunasan:</strong></td>
                    <td>{{ $payment->invoice_number }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Pelunasan:</strong></td>
                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Pelunasan:</strong></td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Total Pembayaran:</strong></td>
                    <td>Rp {{ number_format($participant->price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori Pelatihan:</strong></td>
                    <td>{{ $participant->category === 'online' ? 'Online' : 'Hybrid' }}</td>
                </tr>
            </table>
        </div>
        
        <div style="background-color: #dcfce7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #16a34a;">
            <h3 style="margin-top: 0; color: #166534;">Informasi Pelatihan:</h3>
            <ul style="color: #166534;">
                <li>Informasi detail jadwal dan pelaksanaan pelatihan akan dikirim menjelang tanggal pelatihan</li>
                <li>Pastikan dokumen yang telah diupload sudah lengkap dan sesuai</li>
                <li>Jika ada pertanyaan, hubungi admin melalui WhatsApp: <strong>+62 813-5181-3731</strong></li>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280;">Selamat bergabung dalam pelatihan POP BNSP!</p>
            <p style="color: #6b7280;"><strong>Tim POP BNSP Training</strong></p>
            <p style="color: #6b7280; font-size: 12px;">PT. Sinarta Multi Jasa Sertifikasi</p>
        </div>
    </div>
</body>
</html>