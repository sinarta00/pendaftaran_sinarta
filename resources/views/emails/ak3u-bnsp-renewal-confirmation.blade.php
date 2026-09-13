<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Perpanjangan AK3U BNSP Diterima</title>
</head>
<body style="margin: 0; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #2c3e50;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="background: #820000; padding: 30px; text-align: center; color: white; position: relative;">
            <div style="background: white; display: inline-block; padding: 12px 24px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 18px; font-weight: 700; color: #820000; letter-spacing: 1px;">SINARTA MJS</div>
            </div>
            <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #ffd700;">
                Pendaftaran Diterima
            </div>
            <div style="font-size: 16px; opacity: 0.9; font-weight: 300;">
                Layanan Perpanjangan AK3U BNSP
            </div>
        </div>
        
        <div style="padding: 40px 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 28px; color: #2c3e50; margin: 0; font-weight: 600;">
                    Hi, <span style="color: #820000;">{{ $registration->full_name }}!</span>
                </h1>
            </div>
            
            <div style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); padding: 25px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #820000;">
                <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #4a5568;">
                    Pendaftaran Perpanjangan AK3U BNSP Anda telah kami terima dengan nomor registrasi: <strong>{{ $registration->registration_number }}</strong>
                </p>
            </div>
            
            <div style="background: #f8fafc; border-radius: 12px; padding: 25px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 20px 0; color: #820000; font-size: 18px; font-weight: 600;">Detail Pendaftaran</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Nomor Registrasi</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #2c3e50;">{{ $registration->registration_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Nama Lengkap</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #2c3e50;">{{ $registration->full_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Email</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #2c3e50;">{{ $registration->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Perusahaan</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #2c3e50;">{{ $registration->company_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Status</td>
                        <td style="padding: 8px 0;">
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                Menunggu Konfirmasi Admin
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #92400e;">Langkah Selanjutnya:</p>
                <ul style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5; padding-left: 20px;">
                    <li>Mohon menunggu konfirmasi dari admin melalui WhatsApp</li>
                    <li>Setelah dikonfirmasi, lakukan pembayaran sesuai instruksi admin</li>
                    <li>Konfirmasi pembayaran kepada admin</li>
                </ul>
            </div>

            <div style="text-align: center; color: #64748b; font-size: 14px;">
                <p>Terima kasih telah menggunakan layanan SINARTA MJS.</p>
            </div>
        </div>
    </div>
</body>
</html>
