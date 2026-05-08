<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran SKP Diterima</title>
</head>
<body style="margin: 0; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #2c3e50;">
    
    <!-- Main Container -->
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <!-- Header with Logo -->
        <div style="background: #820000; padding: 30px; text-align: center; color: white; position: relative;">
            <div style="background: white; display: inline-block; padding: 12px 24px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 18px; font-weight: 700; color: #820000; letter-spacing: 1px;">SINARTA MJS</div>
            </div>
            <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #ffd700;">
                Pendaftaran Diterima
            </div>
            <div style="font-size: 16px; opacity: 0.9; font-weight: 300;">
                Layanan {{ ucfirst($registration->type) }} SKP
            </div>
        </div>
        
        <!-- Main Content -->
        <div style="padding: 40px 30px;">
            
            <!-- Greeting -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 28px; color: #2c3e50; margin: 0; font-weight: 600;">
                    Hi, <span style="color: #820000;">{{ $registration->full_name }}!</span>
                </h1>
            </div>
            
            <!-- Introduction -->
            <div style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); padding: 25px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #820000;">
                <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #4a5568;">
                    Pendaftaran {{ ucfirst($registration->type) }} SKP Anda telah kami terima dengan nomor registrasi: <strong>{{ $registration->registration_number }}</strong>
                </p>
            </div>
            
            <!-- Registration Information -->
            <div style="background: #f8fafc; border-radius: 12px; padding: 25px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 20px 0; color: #820000; font-size: 18px; font-weight: 600;">Detail Pendaftaran</h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <!-- Column 1 -->
                    <div style="flex: 1; min-width: 250px;">
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Nomor Registrasi</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->registration_number }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Nama Lengkap</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->full_name }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Email</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->email }}</div>
                        </div>
                    </div>
                    
                    <!-- Column 2 -->
                    <div style="flex: 1; min-width: 250px;">
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Jenis Layanan</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ ucfirst($registration->type) }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Perusahaan</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->company_name }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500;">Status</div>
                            <div style="display: inline-block; background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                Menunggu Konfirmasi Admin
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Next Steps -->
            <div style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                <div style="display: flex; align-items: flex-start;">
                    <div style="background: #f59e0b; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                        <span style="color: white; font-size: 14px; font-weight: bold;">📋</span>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #92400e;">Langkah Selanjutnya:</p>
                        <ul style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5; padding-left: 20px;">
                            <li>Mohon menunggu konfirmasi dari admin melalui WhatsApp</li>
                            <li>Setelah dikonfirmasi, lakukan pembayaran sesuai instruksi admin</li>
                            <li>Konfirmasi pembayaran kepada admin</li>
                            <li>Dapatkan email konfirmasi pembayaran lunas</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Signature -->
            <div style="margin: 40px 0 30px 0; text-align: right;">
                <p style="margin: 0 0 5px 0; color: #64748b; font-size: 14px;">Best Regards,</p>
                <div style="margin: 20px 0;">
                    <p style="margin: 0; font-size: 18px; font-weight: 600; color: #2c3e50;">Tim AK3U Training</p>
                    <p style="margin: 0; font-size: 14px; color: #64748b; font-style: italic;">PT. Sinarta Multi Jasa Sertifikasi</p>
                </div>
            </div>
            
            <!-- Divider -->
            <div style="border-top: 2px solid #e2e8f0; margin: 30px 0; padding-top: 20px;">
                <p style="margin: 0; font-size: 13px; color: #64748b; font-style: italic; text-align: center; line-height: 1.5;">
                    Terima kasih atas kepercayaan Anda. Kami akan segera memproses pendaftaran Anda dan menghubungi untuk informasi lebih lanjut.
                </p>
            </div>
        </div>
        
        <!-- Contact Section -->
        <div style="background: #820000; padding: 40px 30px; text-align: center; color: white; position: relative;">
            <div style="font-size: 28px; font-weight: 700; margin-bottom: 12px; letter-spacing: -0.5px; color: #ffd700;">
                Ada Pertanyaan?
            </div>
            <div style="font-size: 16px; opacity: 0.9; font-weight: 300;">
                Hubungi kami melalui berbagai saluran komunikasi di bawah ini
            </div>
        </div>
        
        <!-- Company Info -->
        <div style="padding: 30px; text-align: center; background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
            <div style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 8px;">
                PT. Sinarta Multi Jasa Sertifikasi
            </div>
            <div style="width: 60px; height: 3px; background: #820000; margin: 0 auto; border-radius: 2px;"></div>
        </div>
        
        <!-- Contact Information -->
        <div style="padding: 0 30px 30px 30px;">
            
            <!-- WhatsApp -->
            <div style="margin-bottom: 20px;">
                <a href="https://wa.me/6281351813731" style="text-decoration: none; color: inherit; display: block;" target="_blank">
                    <div style="display: flex; align-items: center; padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                        <div style="width: 44px; height: 44px; background: #820000; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <svg width="20" height="20" fill="#ffd700" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.05 3.687"/>
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #2c3e50; margin-bottom: 4px; font-size: 14px;">WhatsApp</div>
                            <div style="color: #64748b; font-size: 16px; font-weight: 600;">+62 813-5181-3731</div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Email -->
            <div style="margin-bottom: 30px;">
                <a href="mailto:admin@sinartamjs.com" style="text-decoration: none; color: inherit; display: block;" target="_blank">
                    <div style="display: flex; align-items: center; padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.04); transition: all 0.3s ease;">
                        <div style="width: 44px; height: 44px; background: #820000; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <svg width="20" height="20" fill="#ffd700" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #2c3e50; margin-bottom: 4px; font-size: 14px;">Email</div>
                            <div style="color: #64748b; font-size: 16px; font-weight: 600;">admin@sinartamjs.com</div>
                        </div>
                    </div>
                </a>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div style="background: #2c3e50; padding: 20px; text-align: center;">
            <div style="font-size: 12px; color: #94a3b8;">
                Email ini dikirim dari PT. Sinarta Multi Jasa Sertifikasi
            </div>
        </div>
        
    </div>
    
</body>
</html>