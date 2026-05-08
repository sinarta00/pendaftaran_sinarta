<!-- resources/views/registration-success.blade.php -->
@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Pendaftaran Berhasil!</h1>
        <p class="text-gray-600 mb-6">
            Terima kasih telah mendaftar. Kami telah mengirim email konfirmasi ke alamat email Anda. 
            Silakan cek email untuk melihat rincian pendaftaran dan instruksi pembayaran DP.
        </p>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-yellow-800 mb-2">Langkah Selanjutnya:</h3>
            <ol class="text-left text-yellow-700 space-y-2">
                <li>1. Cek email konfirmasi pendaftaran</li>
                <li>2. Lakukan pembayaran DP minimal Rp 1.000.000</li>
                <li>3. Konfirmasi pembayaran ke admin via WhatsApp</li>
                <li>4. Tunggu konfirmasi dari admin</li>
                <li>5. Upload dokumen yang diperlukan</li>
            </ol>
        </div>
        
        <a href="{{ route('home') }}" 
           class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection