<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Konfirmasi Pembayaran DP - POP BNSP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #059669; text-align: center;">Pembayaran DP Terkonfirmasi</h1>
        
        <p>Halo <strong>{{ $participant->full_name }}</strong>,</p>
        <p>Pembayaran DP Anda telah dikonfirmasi oleh admin kami.</p>
        
        <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3style="margin-top: 0;">Detail Pembayaran:</h3>
<table style="width: 100%;">
<tr>
<td><strong>Nomor Registrasi:</strong></td>
<td>{{ $participant->registration_number }}</td>
</tr>
<tr>
<td><strong>Nomor Invoice:</strong></td>
<td>{{ $payment->invoice_number }}</td>
</tr>
<tr>
<td><strong>Tanggal Pembayaran:</strong></td>
<td>{{ $payment->payment_date->format('d/m/Y') }}</td>
</tr>
<tr>
<td><strong>Jumlah DP:</strong></td>
<td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
</tr>
<tr>
<td><strong>Sisa Pembayaran:</strong></td>
<td>Rp {{ number_format($payment->remaining_amount, 0, ',', '.') }}</td>
</tr>
</table>
</div>
<div style="background-color: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
        <h3 style="margin-top: 0; color: #1e40af;">Langkah Selanjutnya:</h3>
        <ul style="color: #1e40af;">
            <li>Upload dokumen yang diperlukan melalui link: 
                <a href="{{ url('/pop-documents/' . $participant->id) }}" style="color: #2563eb; font-weight: bold;">Upload Dokumen</a>
            </li>
            <li><strong>Dokumen yang perlu disiapkan:</strong>
                <ul>
                    <li>Scan KTP</li>
                    <li>Scan Ijazah (minimal SMA)</li>
                    <li>CV (PDF)</li>
                    <li>SK Kerja (opsional)</li>
                    <li>Surat Pengalaman Kerja di Tambang:
                        <ul>
                            <li>SMA: Minimal 10 tahun</li>
                            <li>D3: Minimal 3 tahun</li>
                            <li>S1: Minimal 1 tahun</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    
    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
        <p style="color: #6b7280;">Terima kasih atas kepercayaan Anda.</p>
        <p style="color: #6b7280;"><strong>Tim POP BNSP Training</strong></p>
    </div>
</div>
</body>
</html>
