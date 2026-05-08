<!-- resources/views/emails/registration-confirmation2.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2563eb; text-align: center;">✅ Pendaftaran Diterima!</h1>
        
        <p>Yth. <strong>{{ $participant->full_name }}</strong>,</p>
        
        <p>Terima kasih telah mendaftar pelatihan AK3U {{ strtoupper($participant->type) }} kategori <strong>Utusan Perusahaan</strong>.</p>
        
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0;">📋 Detail Pendaftaran:</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nomor Registrasi:</strong></td>
                    <td>{{ $participant->registration_number }}</td>
                </tr>
                <tr>
                    <td><strong>Perusahaan:</strong></td>
                    <td>{{ $participant->company_name }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $participant->email }}</td>
                </tr>
                <tr>
                    <td><strong>No. Telepon:</strong></td>
                    <td>{{ $participant->phone }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis AK3U:</strong></td>
                    <td>{{ strtoupper($participant->type) }}</td>
                </tr>
                <tr>
                    <td><strong>Jadwal Training:</strong></td>
                    <td>{{ $participant->trainingSchedule->name }}</td>
                </tr>
            </table>
        </div>
        
        <h3 style="color: #2563eb;">📝 Langkah Selanjutnya:</h3>
        
        <div style="background-color: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
            <h4 style="margin-top: 0; color: #1e40af;">1. Upload Dokumen</h4>
            <p style="color: #1e40af; margin: 10px 0;">Silakan lengkapi dan upload dokumen yang diperlukan melalui sistem kami.</p>
            <div style="margin-top: 15px; text-align: center;">
                <a href="{{ route('documents.show', $participant) }}" style="background-color: #2563eb; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">
                    📤 Upload Dokumen Sekarang
                </a>
            </div>
        </div>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 10px 0;">
            <strong style="color: #2563eb;">2. Verifikasi Dokumen</strong>
            <p style="margin: 5px 0;">Tim kami akan memverifikasi kelengkapan dan kesesuaian dokumen Anda.</p>
        </div>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 10px 0;">
            <strong style="color: #2563eb;">3. Terima Invoice</strong>
            <p style="margin: 5px 0;">Setelah dokumen diverifikasi, Anda akan menerima invoice pembayaran via email.</p>
        </div>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 10px 0;">
            <strong style="color: #2563eb;">4. Lakukan Pembayaran</strong>
            <p style="margin: 5px 0;">Lakukan pembayaran sesuai invoice yang diterima.</p>
        </div>
        
        <div style="background-color: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">⚠️ Penting:</h3>
            <ul style="color: #92400e;">
                <li>Pastikan semua dokumen yang diupload jelas dan sesuai dengan persyaratan</li>
                <li>Periksa email secara berkala untuk update invoice dan informasi lainnya</li>
                <li>Simpan nomor registrasi <strong>{{ $participant->registration_number }}</strong> untuk referensi</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280;">Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
            <p style="color: #6b7280;"><strong>Tim AK3U Training</strong></p>
        </div>
    </div>
</body>
</html>