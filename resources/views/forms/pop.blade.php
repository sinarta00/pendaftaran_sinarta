{{-- resources/views/forms/pop.blade.php --}}
@extends('layouts.form-layout')

@section('form-title', 'Pendaftaran POP BNSP')
@section('form-description', 'Silakan isi data diri Anda untuk pendaftaran pelatihan POP BNSP')

@section('form-content')
<form action="{{ route('pop.store') }}" method="POST">
    @csrf
    
    <div class="form-row">
        <!-- Nama Lengkap -->
        <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
            <div class="input-wrapper">
                <input type="text" name="full_name" class="form-input" placeholder="Isi nama lengkap sesuai KTP" value="{{ old('full_name') }}" required>
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
            </div>
            @error('full_name')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- Email -->
        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <div class="input-wrapper">
                <input type="email" name="email" class="form-input" placeholder="Masukkan email aktif (Disarankan menggunakan Gmail)" value="{{ old('email') }}" required>
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
            </div>
            @error('email')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group phone-input">
        <label class="form-label">Nomor Telepon (WhatsApp) <span class="required">*</span></label>
        <div class="input-wrapper">
            <span class="phone-prefix">+62</span>
            <input type="tel" name="phone" class="form-input" placeholder="8xxxxxxxxxx" value="{{ old('phone') }}" required pattern="[0-9]{10,13}" title="Masukkan nomor telepon yang valid (10-13 digit)">
        </div>
        <small class="help-text">Masukkan nomor WhatsApp aktif (contoh: 81234567890)</small>
        @error('phone')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-row">
        <!-- Tempat Lahir -->
        <div class="form-group">
            <label class="form-label">Tempat Lahir <span class="required">*</span></label>
            <div class="input-wrapper">
                <input type="text" name="birth_place" class="form-input" placeholder="Tempat Lahir Anda" value="{{ old('birth_place') }}" required>
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
            </div>
            @error('birth_place')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <!-- Tanggal Lahir -->
        <div class="form-group">
            <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
            <div class="input-wrapper">
                <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}" required max="{{ date('Y-m-d', strtotime('-17 years')) }}" min="{{ date('Y-m-d', strtotime('-65 years')) }}">
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            @error('birth_date')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <!-- Pendidikan Terakhir -->
        <div class="form-group">
            <label class="form-label">Pendidikan Terakhir <span class="required">*</span></label>
            <div class="input-wrapper">
                <select name="education" class="form-select" required>
                    <option value="">Pilih Jenjang Pendidikan Terakhir</option>
                    <option value="SMA" {{ old('education') == 'SMA' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                    <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>D3 (Diploma III)</option>
                    <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                    <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                    <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                </select>
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
            </div>
            <small class="help-text">
                <strong>Syarat pengalaman kerja di tambang:</strong><br>
                • SMA: Minimal 10 tahun<br>
                • D3: Minimal 3 tahun<br>
                • S1: Minimal 1 tahun
            </small>
            @error('education')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <!-- ✅ JADWAL PELATIHAN (BARU) -->
        <div class="form-group">
            <label class="form-label">Jadwal Pelatihan <span class="required">*</span></label>
            <div class="input-wrapper">
                <select name="training_schedule_id" class="form-select" required>
                    <option value="">Pilih Jadwal Yang Akan Diikuti</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}" {{ old('training_schedule_id') == $schedule->id ? 'selected' : '' }}>
                            {{ $schedule->name }} 
                            ({{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                <div class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            @error('training_schedule_id')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <!-- Kategori Pelatihan -->
    <div class="form-group">
        <label class="form-label">Kategori Pelatihan <span class="required">*</span></label>
        <div class="input-wrapper">
            <select name="category" class="form-select" required>
                <option value="">Pilih Kategori Pelatihan</option>
                <option value="online" {{ old('category') == 'online' ? 'selected' : '' }}>Online - Rp 3.800.000</option>
                <option value="hybrid" {{ old('category') == 'hybrid' ? 'selected' : '' }}>Hybrid - Rp 4.800.000</option>
            </select>
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
        </div>
        @error('category')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>
    

    <!-- Nama Perusahaan -->
    <div class="form-group">
        <label class="form-label">Nama Perusahaan <span style="color: #666;">(Opsional)</span></label>
        <div class="input-wrapper">
            <input type="text" name="company_name" class="form-input" placeholder="Masukkan nama perusahaan jika ada" value="{{ old('company_name') }}">
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
        </div>
        @error('company_name')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <!-- Sumber Informasi -->
    <x-form-select
        name="information_source"
        label="Sumber Informasi"
        :required="true"
        :options="\App\Enums\InformationSource::options()"
    >
    </x-form-select>
<!-- Kode Referral -->
<!--<div class="form-group">-->
<!--    <label class="form-label">Kode Referral <span style="color: #666;">(Opsional)</span></label>-->
<!--    <div class="input-wrapper">-->
<!--        <input type="text" name="referral_code" class="form-input" placeholder="Masukkan kode referral jika ada" value="{{ old('referral_code') }}">-->
<!--        <div class="input-icon">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">-->
<!--                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>-->
<!--            </svg>-->
<!--        </div>-->
<!--    </div>-->
<!--    <small class="help-text">Jika Anda memiliki kode referral dari rekan/partner, masukkan di sini</small>-->
<!--    @error('referral_code')-->
<!--        <small class="error-text">{{ $message }}</small>-->
<!--    @enderror-->
<!--</div>-->

<!-- Agreement -->
<div class="form-group checkbox-terms">
    <label>
        <input type="checkbox" name="agreement_checkbox" value="1" required>
        <span class="checkbox-text">Dengan ini Saya menyatakan dengan sesungguhnya bahwa semua informasi yang disampaikan adalah <strong>benar adanya</strong> dan siap mengikuti seluruh rangkaian pelatihan POP BNSP sesuai dengan jadwal yang telah ditentukan.</span>
    </label>
    @error('agreement_checkbox')
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

<button type="submit" class="btn-submit" id="submitBtn">
    <span class="btn-text">Daftar Sekarang</span>
    <span class="btn-loading" style="display: none;">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></span>
        Sedang Memproses...
    </span>
    <span class="btn-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12,5 19,12 12,19"></polyline>
        </svg>
    </span>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    form.addEventListener('submit', function(e) {
        const recaptchaResponse = grecaptcha.getResponse();
        if (!recaptchaResponse) {
            e.preventDefault();
            alert('Harap centang "I\'m not a robot"');
            return false;
        }
        
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-flex';
        btnLoading.style.alignItems = 'center';
    });
});
</script>
</form>
@endsection