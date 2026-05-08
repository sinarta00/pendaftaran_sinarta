{{-- resources/views/pop-registration-success.blade.php --}}
@extends('layouts.form-layout')

@section('form-title', 'Pendaftaran Berhasil!')

@section('form-content')
<div style="text-align: center; padding: 40px 20px;">
    <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
    
    <h2 style="color: #059669; margin-bottom: 20px;">Pendaftaran POP BNSP Berhasil!</h2>
    
    @if(session('participant'))
        <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 30px 0; text-align: left;">
            <h3 style="margin-top: 0;">Detail Pendaftaran:</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nomor Registrasi:</strong></td>
                    <td>{{ session('participant')->registration_number }}</td>
                </tr>
                <tr>
                    <td><strong>Nama:</strong></td>
                    <td>{{ session('participant')->full_name }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ session('participant')->email }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori:</strong></td>
                    <td>{{ session('participant')->category === 'online' ? 'Online (Rp 3.800.000)' : 'Hybrid (Rp 4.800.000)' }}</td>
                </tr>
            </table>
        </div>
    @endif
    
    <div style="background: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
        <h3 style="margin-top: 0; color: #1e40af;">Langkah Selanjutnya:</h3>
        <ol style="color: #1e40af; text-align: left;">
            <li>Cek email Anda untuk konfirmasi pendaftaran</li>
            <li>Lakukan pembayaran DP sebesar <strong>Rp 1.000.000</strong></li>
            <li>Konfirmasi pembayaran ke admin via WhatsApp</li>
            <li>Setelah DP dikonfirmasi, Anda akan menerima email dengan link upload dokumen</li>
        </ol>
    </div>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('home') }}" style="display: inline-block; background: #820000; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection