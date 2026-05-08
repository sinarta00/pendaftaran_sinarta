<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran SKP Lunas</title>
</head>
<body style="margin: 0; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #2c3e50;">
    
    <!-- Main Container -->
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <!-- Header with Logo -->
        <div style="background: #10b981; padding: 30px; text-align: center; color: white; position: relative;">
            <div style="background: white; display: inline-block; padding: 12px 24px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 18px; font-weight: 700; color: #10b981; letter-spacing: 1px;">SINARTA MJS</div>
            </div>
            <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #ffd700;">
                Pembayaran SKP Lunas! 🎉
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
                    Selamat, <span style="color: #10b981;">{{ $registration->full_name }}!</span>
                </h1>
                <p style="font-size: 16px; color: #64748b; margin: 10px 0 0 0;">
                    Pembayaran Anda untuk {{ ucfirst($registration->type) }} SKP telah <strong>LUNAS</strong>
                </p>
            </div>
            
            <!-- Payment Status -->
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; text-align: center;">
                <div style="font-size: 20px; font-weight: 600; margin-bottom: 15px;">
                    ✅ PEMBAYARAN LUNAS
                </div>
                <div style="background: rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 20px; margin: 20px 0;">
                    <div style="font-size: 32px; font-weight: 700; color: #ffd700; margin-bottom: 8px;">
                        Rp {{ number_format($registration->total_payment, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 14px; opacity: 0.9;">
                        Total pembayaran {{ ucfirst($registration->type) }} SKP
                    </div>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div style="background: #f0fdf4; border-radius: 12px; padding: 25px; margin-bottom: 30px; border: 1px solid #bbf7d0;">
                <h3 style="margin: 0 0 20px 0; color: #15803d; font-size: 18px; font-weight: 600;">Detail Pembayaran</h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <!-- Column 1 -->
                    <div style="flex: 1; min-width: 250px;">
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Nomor Registrasi</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->registration_number }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Nomor Invoice</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->invoice_number }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Tanggal Pembayaran</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->payment_date->format('d F Y') }}</div>
                        </div>
                    </div>
                    
                    <!-- Column 2 -->
                    <div style="flex: 1; min-width: 250px;">
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Jenis Layanan</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ ucfirst($registration->type) }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Perusahaan</div>
                            <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $registration->company_name }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 12px; color: #16a34a; margin-bottom: 4px; font-weight: 500;">Status</div>
                            <div style="display: inline-block; background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                LUNAS ✅
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Info -->
            <div style="background: #e6fffa; border: 1px solid #81e6d9; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                <div style="display: flex; align-items: flex-start;">
                    <div style="background: #38b2ac; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                        <span style="color: white; font-size: 14px; font-weight: bold;">📋</span>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #2d3748;">Informasi Selanjutnya:</p>
                        <ul style="margin: 0; color: #2d3748; font-size: 14px; line-height: 1.5; padding-left: 20px;">
                            <li>Pendaftaran Anda telah dikonfirmasi</li>
                            <li>Proses {{ $registration->type }} SKP akan segera dimulai</li>
                            <li>Informasi lebih lanjut akan dikirim melalui email atau WhatsApp</li>
                            <li>Simpan email ini sebagai bukti pembayaran</li>
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
                    Terima kasih telah mempercayai layanan kami. Kami akan memproses {{ $registration->type }} SKP Anda dengan sebaik-baiknya.
                </p>
            </div>
        </div>
        
        <!-- Contact Section -->
        <div style="background: #10b981; padding: 40px 30px; text-align: center; color: white; position: relative;">
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