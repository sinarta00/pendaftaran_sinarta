{{-- resources/views/forms/tot.blade.php --}}
@extends('layouts.form-layout')

@section('form-title', 'Pendaftaran Training of Trainers (TOT)')
@section('form-description', 'Silakan lengkapi semua data dan dokumen sesuai dengan level TOT yang Anda pilih')

@section('form-content')
<form action="{{ route('tot.store') }}" method="POST" enctype="multipart/form-data" x-data="{ level: '', education: '' }">
    @csrf
    
    <!-- Personal Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>👤 Informasi Personal</h3>
            <p>Lengkapi data pribadi Anda dengan benar sesuai identitas</p>
        </div>
        
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
        </div>
        
        <div class="form-group phone-input">
            <label class="form-label">Nomor Telepon (WhatsApp) <span class="required">*</span></label>
            <div class="input-wrapper">
                <span class="phone-prefix">+62</span>
                <input type="tel" name="phone" class="form-input" placeholder="8xxxxxxxxxx" value="{{ old('phone') }}" required pattern="[0-9]{10,13}">
            </div>
            <small class="help-text">Masukkan nomor WhatsApp aktif (contoh: 81234567890)</small>
            @error('phone')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-row">
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
                    <select name="education" class="form-select" x-model="education" required>
                        <option value="">Pilih Jenjang Pendidikan</option>
                        <option value="SMA" {{ old('education') == 'SMA' ? 'selected' : '' }}>🎓 SMA/SMK/Sederajat</option>
                        <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>🎓 D3 (Diploma III)</option>
                        <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>🎓 S1 (Sarjana)</option>
                        <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>🎓 S2 (Magister)</option>
                        <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>🎓 S3 (Doktor)</option>
                    </select>
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                </div>
                @error('education')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Level TOT -->
            <div class="form-group">
                <label class="form-label">Level TOT <span class="required">*</span></label>
                <div class="input-wrapper">
                    <select name="level" class="form-select" x-model="level" required>
                        <option value="">Pilih Level TOT</option>
                        <option value="3" {{ old('level') == '3' ? 'selected' : '' }}>⭐ Level 3 - Asisten Instruktur</option>
                        <option value="4" {{ old('level') == '4' ? 'selected' : '' }}>⭐⭐ Level 4 - Instruktur</option>
                        <option value="5" {{ old('level') == '5' ? 'selected' : '' }}>⭐⭐⭐ Level 5 - Instruktur Senior</option>
                        <option value="6" {{ old('level') == '6' ? 'selected' : '' }}>⭐⭐⭐⭐ Level 6 - Master Instruktur</option>
                    </select>
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                        </svg>
                    </div>
                </div>
                @error('level')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Document Upload Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>📎 Upload Berkas</h3>
            <p>Upload dokumen sesuai dengan persyaratan level TOT yang dipilih (Max 2MB per file)</p>
        </div>
        
        <!-- Required Documents for All Levels -->
        <div class="form-subsection">
            <h4 class="subsection-title">📋 Dokumen Wajib (Semua Level)</h4>
            
            <div class="form-row">
                <!-- Pas Foto -->
                <div class="form-group">
                    <label class="form-label">Pas Foto Background Merah <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('photo_file')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📸</div>
                            <div class="file-upload-text">Klik untuk upload Pas Foto</div>
                            <div class="file-upload-hint">JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="photo_file" name="photo_file" accept=".jpg,.jpeg,.png" required style="display: none;" onchange="handleFileUpload(this, 'photo_file')">
                    <div id="photo_file-status" class="file-status"></div>
                    @error('photo_file')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <!-- KTP -->
                <div class="form-group">
                    <label class="form-label">Scan KTP <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('ktp_file')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📄</div>
                            <div class="file-upload-text">Klik untuk upload KTP</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="ktp_file" name="ktp_file" accept=".pdf,.jpg,.jpeg,.png" required style="display: none;" onchange="handleFileUpload(this, 'ktp_file')">
                    <div id="ktp_file-status" class="file-status"></div>
                    @error('ktp_file')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Ijazah -->
            <div class="form-group">
                <label class="form-label">Ijazah Terakhir <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('diploma_file')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">🎓</div>
                        <div class="file-upload-text">Klik untuk upload Ijazah</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="diploma_file" name="diploma_file" accept=".pdf,.jpg,.jpeg,.png" required style="display: none;" onchange="handleFileUpload(this, 'diploma_file')">
                <div id="diploma_file-status" class="file-status"></div>
                @error('diploma_file')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <!-- Level-specific requirements -->
        <div x-show="level === '3'" x-transition class="form-subsection">
            <h4 class="subsection-title">⭐ Persyaratan Level 3 - Asisten Instruktur</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sertifikat T.O.T Asisten Instruktur <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('tot_assistant_cert')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏆</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat TOT Asisten</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="tot_assistant_cert" name="tot_assistant_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'tot_assistant_cert')">
                    <div id="tot_assistant_cert-status" class="file-status"></div>
                    @error('tot_assistant_cert')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Surat Pengalaman Kerja Asisten (Min 2 Tahun) <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('work_exp_assistant')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📋</div>
                            <div class="file-upload-text">Klik untuk upload Pengalaman Kerja</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="work_exp_assistant" name="work_exp_assistant" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'work_exp_assistant')">
                    <div id="work_exp_assistant-status" class="file-status"></div>
                    @error('work_exp_assistant')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        
        <div x-show="level === '4'" x-transition class="form-subsection">
            <h4 class="subsection-title">⭐⭐ Persyaratan Level 4 - Instruktur</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sertifikat T.O.T Instruktur <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('tot_instructor_cert')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏆</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat TOT Instruktur</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="tot_instructor_cert" name="tot_instructor_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'tot_instructor_cert')">
                    <div id="tot_instructor_cert-status" class="file-status"></div>
                    @error('tot_instructor_cert')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Surat Pengalaman Kerja Instruktur (Min 5 Tahun) <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('work_exp_instructor')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📋</div>
                            <div class="file-upload-text">Klik untuk upload Pengalaman Kerja Instruktur</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="work_exp_instructor" name="work_exp_instructor" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'work_exp_instructor')">
                    <div id="work_exp_instructor-status" class="file-status"></div>
                    @error('work_exp_instructor')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        
        <div x-show="level === '5'" x-transition class="form-subsection">
            <h4 class="subsection-title">⭐⭐⭐ Persyaratan Level 5 - Instruktur Senior</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sertifikat Instruktur KKNI Level 4 <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('kkni_level4_cert')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏆</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat KKNI Level 4</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="kkni_level4_cert" name="kkni_level4_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'kkni_level4_cert')">
                    <div id="kkni_level4_cert-status" class="file-status"></div>
                    @error('kkni_level4_cert')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Surat Pengalaman Kerja Instruktur (Min 5 Tahun) <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('work_exp_instructor_level5')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📋</div>
                            <div class="file-upload-text">Klik untuk upload Pengalaman Kerja</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="work_exp_instructor_level5" name="work_exp_instructor" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'work_exp_instructor_level5')">
                    <div id="work_exp_instructor_level5-status" class="file-status"></div>
                    @error('work_exp_instructor')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        
        <div x-show="level === '6'" x-transition class="form-subsection">
            <h4 class="subsection-title">⭐⭐⭐⭐ Persyaratan Level 6 - Master Instruktur</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sertifikat Instruktur KKNI Level 4 <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('kkni_level4_cert_level6')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏆</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat KKNI Level 4</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="kkni_level4_cert_level6" name="kkni_level4_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'kkni_level4_cert_level6')">
                    <div id="kkni_level4_cert_level6-status" class="file-status"></div>
                    @error('kkni_level4_cert')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Surat Pengalaman Kerja/Mengelola Lembaga (Min 7 Tahun) <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('work_exp_senior')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📋</div>
                            <div class="file-upload-text">Klik untuk upload Pengalaman Kerja Senior</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="work_exp_senior" name="work_exp_senior" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'work_exp_senior')">
                    <div id="work_exp_senior-status" class="file-status"></div>
                    @error('work_exp_senior')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Optional certificates -->
        <div class="form-subsection">
            <h4 class="subsection-title">📝 Sertifikat Tambahan (Opsional)</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sertifikat T.O.T Instruktur Senior/Madya <span style="color: #666;">(Opsional)</span></label>
                    <div class="file-upload" onclick="triggerFileInput('senior_instructor_cert')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏅</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat Senior/Madya</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="senior_instructor_cert" name="senior_instructor_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'senior_instructor_cert')">
                    <div id="senior_instructor_cert-status" class="file-status"></div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Sertifikat T.O.T Instruktur Master <span style="color: #666;">(Opsional)</span></label>
                    <div class="file-upload" onclick="triggerFileInput('master_instructor_cert')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🥇</div>
                            <div class="file-upload-text">Klik untuk upload Sertifikat Master</div>
                            <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="master_instructor_cert" name="master_instructor_cert" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="handleFileUpload(this, 'master_instructor_cert')">
                    <div id="master_instructor_cert-status" class="file-status"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>ℹ️ Informasi Tambahan</h3>
            <p>Sumber informasi dan kode referral (jika ada)</p>
        </div>
        
        <div class="form-row">
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
            <!--</div>-->
        </div>
    </div>

    <!-- Agreement -->
    <div class="form-group checkbox-terms">
        <label>
            <input type="checkbox" name="agreement_checkbox" value="1" required>
            <span class="checkbox-text">Dengan ini Saya menyatakan dengan sesungguhnya bahwa semua informasi yang disampaikan adalah <strong>benar adanya</strong> dan siap mengikuti seluruh rangkaian pelatihan TOT sesuai dengan level dan jadwal yang telah ditentukan.</span>
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

<style>
/* Additional styles for TOT form sections */
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

.form-subsection {
    margin-top: 2rem;
    padding: 1.5rem;
    background: rgba(130, 0, 0, 0.02);
    border-radius: 12px;
    border: 1px solid rgba(130, 0, 0, 0.1);
}

.subsection-title {
    color: var(--primary);
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-align: center;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(130, 0, 0, 0.2);
}

/* File Upload Styles */
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

.file-upload-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
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

/* File Status */
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

.file-warning {
    padding: 0.5rem;
    background: rgba(245, 158, 11, 0.1);
    border-radius: 8px;
    color: var(--warning);
    font-size: 0.875rem;
    border-left: 4px solid var(--warning);
}
</style>

<script>
// File upload functions
window.triggerFileInput = function(id) {
    const element = document.getElementById(id);
    if (element) {
        element.click();
    }
};

window.handleFileUpload = function(input, fieldName) {
    const statusElement = document.getElementById(fieldName + '-status');
    const file = input.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!file) {
        if (statusElement) statusElement.innerHTML = '';
        return;
    }

    // File size validation
    if (file.size > maxSize) {
        if (statusElement) {
            statusElement.innerHTML = '<div class="file-error"><span>❌ File terlalu besar (maksimal 2MB)</span></div>';
        }
        input.value = '';
        return;
    }

    // File type validation
    const allowedTypes = {
        'photo_file': ['jpg', 'jpeg', 'png'],
        'ktp_file': ['pdf', 'jpg', 'jpeg', 'png'],
        'diploma_file': ['pdf', 'jpg', 'jpeg', 'png'],
        'tot_assistant_cert': ['pdf', 'jpg', 'jpeg', 'png'],
        'work_exp_assistant': ['pdf', 'jpg', 'jpeg', 'png'],
        'tot_instructor_cert': ['pdf', 'jpg', 'jpeg', 'png'],
        'work_exp_instructor': ['pdf', 'jpg', 'jpeg', 'png'],
        'work_exp_instructor_level5': ['pdf', 'jpg', 'jpeg', 'png'],
        'kkni_level4_cert': ['pdf', 'jpg', 'jpeg', 'png'],
        'kkni_level4_cert_level6': ['pdf', 'jpg', 'jpeg', 'png'],
        'work_exp_senior': ['pdf', 'jpg', 'jpeg', 'png'],
        'senior_instructor_cert': ['pdf', 'jpg', 'jpeg', 'png'],
        'master_instructor_cert': ['pdf', 'jpg', 'jpeg', 'png']
    };
    
    const fileExtension = file.name.split('.').pop().toLowerCase();
    const allowedExtensions = allowedTypes[fieldName] || [];

    if (allowedExtensions.length > 0 && !allowedExtensions.includes(fileExtension)) {
        if (statusElement) {
            statusElement.innerHTML = `<div class="file-error"><span>❌ Format file tidak valid. Hanya ${allowedExtensions.join(', ').toUpperCase()} yang diizinkan</span></div>`;
        }
        input.value = '';
        return;
    }

    // Show success status
    if (statusElement) {
        statusElement.innerHTML = `
            <div class="file-success">
                <span>✅ ${file.name} (${formatFileSize(file.size)})</span>
            </div>
        `;
    }
};

window.formatFileSize = function(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Initialize TOT form
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Alpine.js data from old values
    const oldLevel = '{{ old("level") }}';
    const oldEducation = '{{ old("education") }}';
    
    if (oldLevel || oldEducation) {
        setTimeout(() => {
            const form = document.querySelector('[x-data]');
            if (form && form._x_dataStack) {
                if (oldLevel) form._x_dataStack[0].level = oldLevel;
                if (oldEducation) form._x_dataStack[0].education = oldEducation;
            }
        }, 100);
    }

    // NIK input validation (numeric only, max 16 digits)
    const nikInput = document.querySelector('input[name="nik"]');
    if (nikInput) {
        nikInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
    }

    // Enhanced form validation for required files based on level
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const level = form.querySelector('select[name="level"]').value;
            const requiredFileFields = ['photo_file', 'ktp_file', 'diploma_file'];
            
            // Add level-specific required files
            switch(level) {
                case '3':
                    requiredFileFields.push('tot_assistant_cert', 'work_exp_assistant');
                    break;
                case '4':
                    requiredFileFields.push('tot_instructor_cert', 'work_exp_instructor');
                    break;
                case '5':
                    requiredFileFields.push('kkni_level4_cert', 'work_exp_instructor_level5');
                    break;
                case '6':
                    requiredFileFields.push('kkni_level4_cert_level6', 'work_exp_senior');
                    break;
            }
            
            let hasFileError = false;

            requiredFileFields.forEach(function(fieldName) {
                const input = document.getElementById(fieldName);
                if (input && !input.files.length) {
                    hasFileError = true;
                    const statusDiv = document.getElementById(fieldName + '-status');
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="file-error"><span>❌ File wajib diupload untuk level ini</span></div>';
                    }
                }
            });

            if (hasFileError) {
                e.preventDefault();
                alert('Mohon lengkapi semua file yang wajib diupload sesuai level TOT yang dipilih!');
                return false;
            }
        });
    }

    console.log('TOT form enhancement loaded successfully');
});
</script>
@endsection