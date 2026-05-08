<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran POP BNSP</title>
</head>
<body style="margin: 0; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #2c3e50;">
    
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: #820000; padding: 30px; text-align: center; color: white;">
            <div style="background: white; display: inline-block; padding: 12px 24px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 18px; font-weight: 700; color: #820000; letter-spacing: 1px;">SINARTA MJS</div>
            </div>
            <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #ffd700;">
                Konfirmasi Pendaftaran
            </div>
            <div style="font-size: 16px; opacity: 0.9; font-weight: 300;">
                Pelatihan POP BNSP
            </div>
        </div>
        
        <!-- Content -->
        <div style="padding: 40px 30px;">
            
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 28px; color: #2c3e50; margin: 0; font-weight: 600;">
                    Hi, <span style="color: #820000;">{{ $participant->full_name }}!</span>
                </h1>
            </div>
            
            <div style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); padding: 25px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #820000;">
                <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #4a5568;">
                    Kami sangat senang Anda memutuskan untuk mengikuti Program Pelatihan POP BNSP bersama Sinarta MJS.
                </p>
            </div>
            
            <!-- Registration Info -->
            <div style="background: #f8fafc; border-radius: 12px; padding: 25px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 20px 0; color: #820000; font-size: 18px; font-weight: 600;">Detail Pendaftaran</h3>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Nomor Registrasi</div>
                    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $participant->registration_number }}</div>
                </div>
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Nama Lengkap</div>
                    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $participant->full_name }}</div>
                </div>
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Email</div>
                    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">{{ $participant->email }}</div>
                </div>
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Kategori Pelatihan</div>
                    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">
                        {{ $participant->category === 'online' ? 'Online' : 'Hybrid' }}
                    </div>
                </div>
                <!-- ✅ TAMBAHKAN INI -->
<div style="margin-bottom: 16px;">
    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Jadwal Training</div>
    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">
        {{ $participant->trainingSchedule->name }}
    </div>
</div>
<div style="margin-bottom: 16px;">
    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Tanggal Pelaksanaan</div>
    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">
        {{ $participant->trainingSchedule->start_date->format('d F Y') }} - {{ $participant->trainingSchedule->end_date->format('d F Y') }}
    </div>
</div>
<div style="margin-bottom: 16px;">
    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Lokasi</div>
    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">
        {{ $participant->trainingSchedule->location }}
    </div>
</div>
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Biaya Training</div>
                    <div style="font-weight: 600; font-size: 14px; color: #2c3e50;">
                        Rp {{ number_format($participant->price, 0, ',', '.') }}
                    </div>
                </div>
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Hubungi Admin</div>
                    <div style="font-weight: 600; font-size: 14px; color: #10b981;">
                        <a href="https://wa.me/6281351813731" style="color: #10b981; text-decoration: none;">+62 813-5181-3731</a>
                    </div>
                </div>
            </div>
            
            <!-- Payment Section -->
            <div style="background: linear-gradient(135deg, #820000 0%, #a02c2c 100%); color: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; text-align: center;">
                <h3 style="margin: 0 0 15px 0; font-size: 20px; font-weight: 600; color: #ffd700;">Informasi Pembayaran</h3>
                <p style="margin: 0 0 20px 0; font-size: 16px; opacity: 0.9;">
                    Untuk melanjutkan ke tahap Pengumpulan Dokumen, silakan melakukan <strong>Down Payment (DP)</strong>:
                </p>
                
                <div style="background: rgba(255, 215, 0, 0.2); border: 2px solid #ffd700; border-radius: 12px; padding: 20px; margin: 20px 0;">
                    <div style="font-size: 32px; font-weight: 700; color: #ffd700; margin-bottom: 8px;">
                        Rp 1.000.000,-
                    </div>
                    <div style="font-size: 14px; opacity: 0.8;">
                        sebagai tanda jadi keikutsertaan
                    </div>
                </div>
                
                <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 15px; margin-top: 20px;">
                    <div style="font-size: 14px; margin-bottom: 5px; opacity: 0.9;">Sisa Pembayaran</div>
                    <div style="font-size: 20px; font-weight: 600; color: #ffd700;">
                        Rp {{ number_format($participant->price - 1000000, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            
            <!-- Bank Info -->
            <div style="background: #002060; border-radius: 12px; padding: 25px; margin-bottom: 30px; text-align: center;">
                <h4 style="margin: 0 0 20px 0; color: white; font-size: 16px; font-weight: 600;">Transfer ke Rekening:</h4>
                
                <div style="background: rgba(255, 192, 0, 0.1); border-radius: 8px; padding: 20px; margin-bottom: 15px;">
                    <div style="background: #ffc000; color: #002060; padding: 8px 16px; border-radius: 6px; display: inline-block; font-weight: 700; margin-bottom: 15px;">
                        BANK MANDIRI
                    </div>
                    <div style="font-size: 24px; font-weight: 700; color: #ffc000; margin-bottom: 8px; letter-spacing: 1px;">
                        148-00-1948618-5
                    </div>
                    <div style="color: white; font-weight: 600;">
                        PT. Sinarta Multi Jasa Sertifikasi
                    </div>
                </div>
            </div>
            
            <!-- Instructions -->
            <div style="background: #e6f7ff; border: 1px solid #91d5ff; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                <div style="display: flex; align-items: flex-start;">
                    <div style="background: #1890ff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                        <span style="color: white; font-size: 14px; font-weight: bold;">!</span>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #0050b3;">Instruksi Pembayaran:</p>
                        <ul style="margin: 0; color: #0050b3; font-size: 14px; line-height: 1.5; padding-left: 20px;">
                            <li>Lakukan pembayaran DP minimal <strong>Rp 1.000.000</strong></li>
                            <li>Upload bukti pembayaran via WhatsApp</li>
                            <li>Sertakan <strong>Nomor Registrasi: {{ $participant->registration_number }}</strong></li>
                            <li>Setelah DP dikonfirmasi, Anda akan menerima email dengan link upload dokumen</li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div style="background: #820000; padding: 40px 30px; text-align: center; color: white;">
            <div style="font-size: 28px; font-weight: 700; margin-bottom: 12px; color: #ffd700;">
                Ada Pertanyaan?
            </div>
            <div style="font-size: 16px; opacity: 0.9;">
                Hubungi kami melalui WhatsApp atau Email
            </div>
        </div>
        
        <div style="background: #2c3e50; padding: 20px; text-align: center;">
            <div style="font-size: 12px; color: #94a3b8;">
                © 2025 PT. Sinarta Multi Jasa Sertifikasi
            </div>
        </div>
        
    </div>
    
</body>
</html>