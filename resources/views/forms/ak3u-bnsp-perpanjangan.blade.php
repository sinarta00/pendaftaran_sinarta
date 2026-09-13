{{-- resources/views/forms/ak3u-bnsp-perpanjangan.blade.php --}}
@extends('layouts.form-layout')

<style>
    .download-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
        color: var(--gray-800);
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 768px) {
        .download-btn {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }

        .header-download {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .input-wrapper input {
            padding-inline: 0.5rem;
        }

        .form-select {
            padding-right: 3rem;
        }

        .input-wrapper input::placeholder {
            font-size: 0.8rem;
        }

        .phone-prefix {
            font-size: 0.8rem;
        }
    }
</style>

@section('form-title', 'Pendaftaran Perpanjangan AK3U BNSP')
@section('form-description', 'Silakan lengkapi semua data diri dan dokumen yang diperlukan untuk perpanjangan sertifikat AK3U BNSP')
@section('form-content')
<form action="{{ route('ak3u.bnsp.perpanjangan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    
    @if(isset($templates) && $templates->where('is_active', true)->count() > 0)
    <div class="form-section">
        <div class="section-header">
            <h3 class="header-download">Download Template Berkas</h3>
            <p>Silakan download template berkas yang diperlukan untuk perpanjangan AK3U BNSP</p>

            <div class="form-group mt-4 flex flex-wrap gap-3 justify-center">
                @foreach($templates->filter(function($template) {
                    return str_starts_with($template->type, "bnsp") || str_starts_with($template->type, "integrity_pact") || str_starts_with($template->type, "ak3u_bnsp");
                }) as $template)
                    <a href="{{ url('storage/' . $template->file_path) }}" 
                       class="download-btn" 
                       target="_blank">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="7,10 12,15 17,10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Download {{ $template->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Personal Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>Informasi Personal</h3>
            <p>Lengkapi data pribadi Anda dengan benar</p>
        </div>
        
        <div class="form-row">
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" name="full_name" class="form-input" placeholder="Isi nama lengkap sesuai KTP" value="{{ old('full_name') }}" required>
                </div>
                @error('full_name')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Nomor WhatsApp -->
            <div class="form-group phone-input">
                <label class="form-label">Nomor WhatsApp <span class="required">*</span></label>
                <div class="input-wrapper">
                    <span class="phone-prefix">+62</span>
                    <input type="tel" name="phone" class="form-input" placeholder="8xxxxxxxxxx" value="{{ old('phone') }}" required pattern="[0-9]{10,15}">
                </div>
                @error('phone')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-input" placeholder="Masukkan email aktif" value="{{ old('email') }}" required>
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
            
            <!-- NIK -->
            <div class="form-group">
                <label class="form-label">NIK <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" name="nik" class="form-input" placeholder="Masukkan NIK (16 digit)" value="{{ old('nik') }}" required maxlength="20">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                </div>
                @error('nik')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Nomor Ijazah -->
            <div class="form-group">
                <label class="form-label">Nomor Ijazah <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" name="diploma_number" class="form-input" placeholder="Masukkan nomor ijazah" value="{{ old('diploma_number') }}" required>
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                </div>
                @error('diploma_number')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                <div class="input-wrapper">
                    <select name="gender" class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                @error('gender')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Golongan Darah -->
            <div class="form-group">
                <label class="form-label">Golongan Darah <span class="required">*</span></label>
                <div class="input-wrapper">
                    <select name="blood_type" class="form-select" required>
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
                @error('blood_type')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Pendidikan Terakhir -->
            <div class="form-group">
                <label class="form-label">Pendidikan Terakhir <span class="required">*</span></label>
                <div class="input-wrapper">
                    <select name="education" class="form-select" required>
                        <option value="">Pilih Jenjang Pendidikan</option>
                        <option value="SMA" {{ old('education') == 'SMA' ? 'selected' : '' }}>🎓 SMA/SMK/Sederajat</option>
                        <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>🎓 D3 (Diploma III)</option>
                        <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>🎓 S1 (Sarjana)</option>
                        <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>🎓 S2 (Magister)</option>
                        <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>🎓 S3 (Doktor)</option>
                    </select>
                </div>
                @error('education')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Company Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>🏢 Informasi Perusahaan & Sertifikat Lama</h3>
            <p>Data perusahaan dan dokumen perpanjangan sertifikat AK3U BNSP</p>
        </div>
        
        <div class="form-row">
            <!-- Nama Perusahaan -->
            <div class="form-group">
                <label class="form-label">Nama Perusahaan <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" name="company_name" class="form-input" placeholder="Masukkan nama perusahaan" value="{{ old('company_name') }}" required>
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                </div>
                @error('company_name')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Alamat Perusahaan -->
            <div class="form-group">
                <label class="form-label">Alamat Perusahaan <span class="required">*</span></label>
                <div class="input-wrapper">
                    <textarea name="company_address" class="form-textarea" rows="3" placeholder="Masukkan alamat lengkap perusahaan" required>{{ old('company_address') }}</textarea>
                </div>
                @error('company_address')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- No Sertifikat Lama -->
            <div class="form-group">
                <label class="form-label">No Sertifikat AK3U BNSP Lama</label>
                <div class="input-wrapper">
                    <input type="text" name="old_sk_number" class="form-input" placeholder="Masukkan nomor sertifikat lama" value="{{ old('old_sk_number') }}">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                        </svg>
                    </div>
                </div>
                @error('old_sk_number')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
                
            <!-- No Lisensi Lama -->
            <div class="form-group">
                <label class="form-label">No Lisensi/Kartu Kewenangan Lama</label>
                <div class="input-wrapper">
                    <input type="text" name="old_license_number" class="form-input" placeholder="Masukkan nomor lisensi lama" value="{{ old('old_license_number') }}">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                </div>
                @error('old_license_number')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Document Upload Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>📎 Upload Berkas Perpanjangan AK3U BNSP</h3>
            <p>Lengkapi semua dokumen yang diperlukan (PDF/JPG/PNG - Max 2MB)</p>
        </div>

        <div class="form-row">
            <!-- Scan KTP -->
            <div class="form-group">
                <label class="form-label">Scan KTP <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('ktp_file')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload KTP</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="ktp_file" name="ktp_file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'ktp_file')">
                <div id="ktp_file-status" class="file-status"></div>
                @error('ktp_file')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Surat Keterangan Kerja -->
            <div class="form-group">
                <label class="form-label">Surat Keterangan Aktif Bekerja <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('work_certificate')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Surat Keterangan Aktif Bekerja</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="work_certificate" name="work_certificate" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'work_certificate')">
                <div id="work_certificate-status" class="file-status"></div>
                @error('work_certificate')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Ijazah -->
            <div class="form-group">
                <label class="form-label">Ijazah Terakhir <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('diploma_file')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Ijazah</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="diploma_file" name="diploma_file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'diploma_file')">
                <div id="diploma_file-status" class="file-status"></div>
                @error('diploma_file')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Sertifikat AK3U BNSP -->
            <div class="form-group">
                <label class="form-label">Sertifikat AK3U BNSP <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('ak3u_certificate')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Sertifikat AK3U BNSP</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="ak3u_certificate" name="ak3u_certificate" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'ak3u_certificate')">
                <div id="ak3u_certificate-status" class="file-status"></div>
                @error('ak3u_certificate')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Pas Foto -->
            <div class="form-group">
                <label class="form-label">Pas Foto Latar Belakang Merah <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('photo_file')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Pas Foto</div>
                        <div class="file-upload-hint">JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="photo_file" name="photo_file" accept=".jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'photo_file')">
                <div id="photo_file-status" class="file-status"></div>
                @error('photo_file')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Surat Keterangan Bekerja Penuh -->
            <div class="form-group">
                <label class="form-label">Surat Keterangan Bekerja Penuh <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('full_work_certificate')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Surat Keterangan Bekerja Penuh</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="full_work_certificate" name="full_work_certificate" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'full_work_certificate')">
                <div id="full_work_certificate-status" class="file-status"></div>
                @error('full_work_certificate')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Surat Permohonan dari Perusahaan -->
            <div class="form-group">
                <label class="form-label">Surat Permohonan dari Perusahaan <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('company_application_later')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Surat Permohonan dari Perusahaan</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="company_application_later" name="company_application_later" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'company_application_later')">
                <div id="company_application_later-status" class="file-status"></div>
                @error('company_application_later')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div> 

            <!-- Dokumen Sertifikat AK3U BNSP Lama -->
            <div class="form-group">
                <label class="form-label">Dokumen Sertifikat AK3U BNSP Lama <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('skp__later')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Dokumen Sertifikat Lama</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="skp__later" name="skp__later" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'skp__later')">
                <div id="skp__later-status" class="file-status"></div>
                @error('skp__later')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <!-- Lisensi Lama -->
            <div class="form-group">
                <label class="form-label">Lisensi/Kartu Lama <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('license_later')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Lisensi Lama</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="license_later" name="license_later" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'license_later')">
                <div id="license_later-status" class="file-status"></div>
                @error('license_later')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <!-- Surat Laporan Kegiatan 2 Tahun Terakhir -->
            <div class="form-group">
                <label class="form-label">Surat Laporan Kegiatan 2 Tahun Terakhir <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('activity_report_later')">
                    <div class="file-upload-content">
                        <div class="file-upload-text">Klik untuk upload Laporan Kegiatan 2 Tahun Terakhir</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="activity_report_later" name="activity_report_later" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'activity_report_later')">
                <div id="activity_report_later-status" class="file-status"></div>
                @error('activity_report_later')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div> 
        </div>
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
</form>

<style>
.form-section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--gray-50), var(--white));
    border-radius: 16px;
    border: 2px solid var(--gray-100);
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-200);
}

.section-header h3 {
    color: var(--primary);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.section-header p {
    color: var(--gray-600);
    font-size: 1rem;
}

.file-upload {
    border: 2px dashed var(--gray-300);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: var(--gray-50);
}

.file-upload:hover {
    border-color: var(--primary);
    background: rgba(130, 0, 0, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.file-upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.file-upload-text {
    color: var(--gray-700);
    font-weight: 600;
    font-size: 1rem;
}

.file-upload-hint {
    color: var(--gray-500);
    font-size: 0.875rem;
}

.file-status {
    margin-top: 0.5rem;
}

.file-success {
    padding: 0.5rem;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 8px;
    color: var(--success);
    font-size: 0.875rem;
    border-left: 4px solid var(--success);
}

.file-error {
    padding: 0.5rem;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 8px;
    color: var(--error);
    font-size: 0.875rem;
    border-left: 4px solid var(--error);
}
</style>

<script>
function triggerFileInput(id) {
    const fileInput = document.getElementById(id);
    if (fileInput) {
        fileInput.click();
    }
}

function handleFileUpload(input, statusId) {
    const statusDiv = document.getElementById(statusId + '-status');
    if (!statusDiv) return;

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
        
        if (file.size > 2 * 1024 * 1024) {
            statusDiv.innerHTML = '<div class="file-error"><span>❌ Ukuran file terlalu besar (' + fileSizeMB + 'MB). Maksimal 2MB.</span></div>';
            input.value = '';
            return;
        }

        statusDiv.innerHTML = '<div class="file-success"><span>✅ ' + file.name + ' (' + fileSizeMB + 'MB)</span></div>';
    } else {
        statusDiv.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const nikInput = document.querySelector('input[name="nik"]');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
    }

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let requiredFileFields = [
                'ktp_file', 
                'work_certificate', 
                'diploma_file', 
                'ak3u_certificate', 
                'photo_file', 
                'full_work_certificate',
                'company_application_later',
                'skp__later',
                'license_later',
                'activity_report_later'
            ];
            
            let hasFileError = false;
            let firstErrorElement = null;

            requiredFileFields.forEach(function(fieldName) {
                const input = document.getElementById(fieldName);
                const statusDiv = document.getElementById(fieldName + '-status');
                if (input && (!input.files || !input.files.length)) {
                    hasFileError = true;
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="file-error"><span>❌ File wajib diupload</span></div>';
                    }
                    if (!firstErrorElement) {
                        firstErrorElement = statusDiv || input.closest('.form-group');
                    }
                }
            });

            if (hasFileError) {
                e.preventDefault();
                if (firstErrorElement) {
                    firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                alert('Mohon lengkapi semua file yang wajib diupload!');
                return false;
            }

            if (typeof grecaptcha !== 'undefined') {
                try {
                    const recaptchaResponse = grecaptcha.getResponse();
                    if (!recaptchaResponse) {
                        e.preventDefault();
                        alert('Harap centang "I\'m not a robot"');
                        return false;
                    }
                } catch (err) {
                    console.warn('reCAPTCHA check skipped:', err);
                }
            }

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                const btnText = submitBtn.querySelector('.btn-text');
                const btnLoading = submitBtn.querySelector('.btn-loading');
                if (btnText) btnText.style.display = 'none';
                if (btnLoading) {
                    btnLoading.style.display = 'inline-flex';
                    btnLoading.style.alignItems = 'center';
                }
                setTimeout(function() {
                    submitBtn.disabled = true;
                }, 10);
            }
        });
    }

    console.log('Perpanjangan AK3U BNSP form loaded successfully');
});
</script>
@endsection
