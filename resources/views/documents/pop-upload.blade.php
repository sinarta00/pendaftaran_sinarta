{{-- resources/views/documents/pop-upload.blade.php --}}
@extends('layouts.form-layout')

@section('form-title', 'Upload Dokumen POP BNSP')
@section('form-description', 'Upload dokumen yang diperlukan untuk verifikasi')

@section('form-content')
<div class="alert alert-info mb-4">
    <strong>Nomor Registrasi:</strong> {{ $participant->registration_number }}<br>
    <strong>Nama:</strong> {{ $participant->full_name }}<br>
    <strong>Kategori:</strong> {{ $participant->category === 'online' ? 'Online' : 'Hybrid' }}<br>
    <strong>Pendidikan:</strong> {{ $participant->education }}
</div>

<div class="alert alert-warning mb-4">
    <strong>⚠️ Persyaratan Dokumen:</strong><br>
    <ul style="margin: 10px 0; padding-left: 20px;">
        <li><strong>KTP:</strong> Scan/foto yang jelas</li>
        <li><strong>Ijazah:</strong> Minimal SMA/Sederajat</li>
        <li><strong>CV:</strong> Format PDF</li>
        <li><strong>SK Kerja:</strong> Opsional (jika ada)</li>
        <li><strong>Surat Pengalaman Kerja di Tambang:</strong>
            <ul>
                <li>SMA: Minimal 10 tahun</li>
                <li>D3: Minimal 3 tahun</li>
                <li>S1: Minimal 1 tahun</li>
            </ul>
        </li>
    </ul>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('pop.documents.store', $participant->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Nomor KTP -->
    <div class="form-group">
        <label class="form-label">Nomor KTP <span class="required">*</span></label>
        <div class="input-wrapper">
            <input type="text" name="ktp_number" class="form-input" 
                   placeholder="Masukkan nomor KTP" 
                   value="{{ old('ktp_number', $existingDocuments->ktp_number ?? '') }}" 
                   required maxlength="16" pattern="[0-9]{16}">
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <line x1="7" y1="8" x2="17" y2="8"></line>
                    <line x1="7" y1="12" x2="17" y2="12"></line>
                    <line x1="7" y1="16" x2="12" y2="16"></line>
                </svg>
            </div>
        </div>
        @error('ktp_number')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- Nomor Ijazah -->
    <div class="form-group">
        <label class="form-label">Nomor Ijazah <span class="required">*</span></label>
        <div class="input-wrapper">
            <input type="text" name="diploma_number" class="form-input" 
                   placeholder="Masukkan nomor ijazah" 
                   value="{{ old('diploma_number', $existingDocuments->diploma_number ?? '') }}" 
                   required>
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
        </div>
        @error('diploma_number')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- Scan KTP -->
    <div class="form-group">
        <label class="form-label">Scan KTP <span class="required">*</span></label>
        <input type="file" name="scan_ktp" class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
        <small class="help-text">Format: PDF, JPG, PNG. Max: 2MB</small>
        @if($existingDocuments && $existingDocuments->scan_ktp)
            <small class="text-success">✓ File sudah diupload</small>
        @endif
        @error('scan_ktp')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- Scan Ijazah -->
    <div class="form-group">
        <label class="form-label">Scan Ijazah (Minimal SMA) <span class="required">*</span></label>
        <input type="file" name="scan_diploma" class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
        <small class="help-text">Format: PDF, JPG, PNG. Max: 2MB</small>
        @if($existingDocuments && $existingDocuments->scan_diploma)
            <small class="text-success">✓ File sudah diupload</small>
        @endif
        @error('scan_diploma')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- CV -->
    <div class="form-group">
        <label class="form-label">CV (Curriculum Vitae) <span class="required">*</span></label>
        <input type="file" name="cv_file" class="form-input" accept=".pdf" required>
        <small class="help-text">Format: PDF. Max: 2MB</small>
        @if($existingDocuments && $existingDocuments->cv_file)
            <small class="text-success">✓ File sudah diupload</small>
        @endif
        @error('cv_file')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- SK Kerja (Optional) -->
    <div class="form-group">
        <label class="form-label">SK Kerja <span style="color: #666;">(Opsional)</span></label>
        <input type="file" name="work_certificate" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
        <small class="help-text">Format: PDF, JPG, PNG. Max: 2MB</small>
        @if($existingDocuments && $existingDocuments->work_certificate)
            <small class="text-success">✓ File sudah diupload</small>
        @endif
        @error('work_certificate')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- Surat Pengalaman Kerja di Tambang -->
    <div class="form-group">
        <label class="form-label">Surat Pengalaman Kerja di Tambang <span class="required">*</span></label>
        <input type="file" name="mining_experience_letter" class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
        <small class="help-text">
            <strong>Syarat minimal pengalaman:</strong><br>
            • SMA: 10 tahun | D3: 3 tahun | S1: 1 tahun<br>
            Format: PDF, JPG, PNG. Max: 2MB
        </small>
        @if($existingDocuments && $existingDocuments->mining_experience_letter)
            <small class="text-success">✓ File sudah diupload</small>
        @endif
        @error('mining_experience_letter')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- reCAPTCHA -->
    <div class="form-group" style="margin: 2rem 0;">
        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" style="display: flex; justify-content: center;"></div>
        @error('g-recaptcha-response')
            <small class="error-text" style="text-align: center; display: block; margin-top: 0.5rem;">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-submit">
        <span class="btn-text">Upload Dokumen</span>
        <span class="btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
        </span>
    </button>
</form>
@endsection