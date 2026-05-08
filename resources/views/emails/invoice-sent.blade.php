<!-- resources/views/emails/invoice-sent.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #059669; text-align: center;">✅ Pendaftaran Berhasil!</h1>
        
        <p>Yth. <strong>{{ $participant->full_name }}</strong>,</p>
        
        <div style="background-color: #dcfce7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #16a34a; text-align: center;">
            <h2 style="margin: 0; color: #059669;">Selamat! Pendaftaran Anda Telah Diverifikasi</h2>
        </div>
        
        <p>Dokumen Anda telah diverifikasi dan pendaftaran Anda telah berhasil diproses.</p>
        
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Detail Pendaftaran:</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nomor Registrasi:</strong></td>
                    <td>{{ $participant->registration_number }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Pelatihan:</strong></td>
                    <td>AK3U {{ strtoupper($participant->type) }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori:</strong></td>
                    <td>{{ $participant->participant_category === 'company' ? 'Utusan Perusahaan' : 'Personal' }}</td>
                </tr>
                @if($participant->participant_category === 'company')
                <tr>
                    <td><strong>Perusahaan:</strong></td>
                    <td>{{ $participant->company_name }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Jadwal Training:</strong></td>
                    <td>{{ $participant->trainingSchedule->name }}</td>
                </tr>
            </table>
        </div>
        
        <div style="background-color: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
            <h3 style="margin-top: 0; color: #1e40af;">📄 Invoice Pembayaran</h3>
            <p style="color: #1e40af; margin: 10px 0;">Invoice pembayaran terlampir pada email ini. Silakan lakukan pembayaran sesuai dengan invoice yang terlampir.</p>
        </div>
        
        <div style="background-color: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">Informasi Pembayaran:</h3>
            <ul style="color: #92400e;">
                <li>Silakan cek invoice terlampir untuk detail pembayaran lengkap</li>
                <li>Lakukan pembayaran sesuai jumlah yang tertera pada invoice</li>
                <li>Setelah transfer, konfirmasi pembayaran ke admin via WhatsApp: <strong>[NOMOR WA ADMIN]</strong></li>
                <li>Sertakan nomor registrasi <strong>{{ $participant->registration_number }}</strong> saat konfirmasi</li>
            </ul>
        </div>
        
        <p>Setelah pembayaran dikonfirmasi, Anda akan menerima email konfirmasi dan informasi lebih lanjut mengenai pelatihan.</p>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280;">Terima kasih atas kepercayaan Anda. Kami tunggu kehadiran Anda di pelatihan.</p>
            <p style="color: #6b7280;"><strong>Tim AK3U Training</strong></p>
        </div>
    </div>
</body>
</html>