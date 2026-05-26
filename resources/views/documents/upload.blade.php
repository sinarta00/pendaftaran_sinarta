{{-- resources/views/documents/upload.blade.php --}}
@extends('layouts.form-layout')

@section('form-title', 'Upload Dokumen')
@section('form-description', 'Lengkapi semua dokumen yang diperlukan untuk melanjutkan proses registrasi')

@section('form-content')
<div class="participant-info">
    <div class="info-card">
        <div class="info-header">
            <h3>👤 Data Peserta</h3>
        </div>
        <div class="info-content">
            <div class="info-row">
                <span class="info-label">Nama Lengkap:</span>
                <span class="info-value">{{ $participant->full_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. Registrasi:</span>
                <span class="info-value">{{ $participant->registration_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $participant->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tipe Program:</span>
                <span class="info-value program-badge program-{{ $participant->type }}">
                    {{ strtoupper($participant->type) }}
                </span>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('documents.store', $participant) }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Basic Information Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>📋 Informasi Dasar</h3>
            <p>Masukkan nomor identitas sesuai dengan dokumen asli</p>
        </div>
        
        <div class="form-row">
            <!-- Nomor KTP -->
            <div class="form-group">
                <label class="form-label">Nomor KTP <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" name="ktp_number" class="form-input" placeholder="Masukkan 16 digit NIK" value="{{ old('ktp_number') }}" required maxlength="20">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
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
                    <input type="text" name="diploma_number" class="form-input" placeholder="Masukkan nomor ijazah" value="{{ old('diploma_number') }}" required maxlength="50">
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
    </div>
    
    <!-- Document Upload Section -->
    <div class="form-section">
        <div class="section-header">
            <h3>📎 Upload Dokumen</h3>
            <p>Upload semua dokumen dalam format PDF/JPG/PNG dengan ukuran maksimal 2MB</p>
        </div>
        
        <div class="form-row">
            <!-- Scan Ijazah -->
            <div class="form-group">
                <label class="form-label">Scan Ijazah <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('scan_diploma')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">🎓</div>
                        <div class="file-upload-text">Klik untuk upload Ijazah</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="scan_diploma" name="scan_diploma" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'scan_diploma')">
                <div id="scan_diploma-status" class="file-status"></div>
                @error('scan_diploma')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Scan KTP -->
            <div class="form-group">
                <label class="form-label">Scan KTP <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('scan_ktp')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">📄</div>
                        <div class="file-upload-text">Klik untuk upload KTP</div>
                        <div class="file-upload-hint">PDF/JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="scan_ktp" name="scan_ktp" accept=".pdf,.jpg,.jpeg,.png" required style="display: none;" onchange="handleFileUpload(this, 'scan_ktp')">
                <div id="scan_ktp-status" class="file-status"></div>
                @error('scan_ktp')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <!-- Scan Photo -->
            <div class="form-group">
                <label class="form-label">Pas Foto Latar Belakang Merah <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('scan_photo')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">📸</div>
                        <div class="file-upload-text">Klik untuk upload Pas Foto</div>
                        <div class="file-upload-hint">JPG/PNG - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="scan_photo" name="scan_photo" accept=".jpg,.jpeg,.png" required style="display: none;" onchange="handleFileUpload(this, 'scan_photo')">
                <div id="scan_photo-status" class="file-status"></div>
                @error('scan_photo')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- CV -->
            <div class="form-group">
                <label class="form-label">CV (Curriculum Vitae) <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('cv_file')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">📋</div>
                        <div class="file-upload-text">Klik untuk upload CV</div>
                        <div class="file-upload-hint">PDF - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="cv_file" name="cv_file" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'cv_file')">
                <div id="cv_file-status" class="file-status"></div>
                @error('cv_file')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        @if($participant->type === 'kemnaker')
        <!-- Kemnaker Specific Documents -->
        <div class="form-subsection kemnaker-docs">
            <h4 class="subsection-title">🏥 Dokumen Khusus Kemnaker</h4>
            
            <div class="form-group">
                <label class="form-label">Surat Keterangan Sehat <span class="required">*</span></label>
                <div class="file-upload" onclick="triggerFileInput('health_certificate')">
                    <div class="file-upload-content">
                        <div class="file-upload-icon">🏥</div>
                        <div class="file-upload-text">Klik untuk upload Surat Keterangan Sehat</div>
                        <div class="file-upload-hint">PDF - Max 2MB</div>
                    </div>
                </div>
                <input type="file" id="health_certificate" name="health_certificate" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'health_certificate')">
                <div id="health_certificate-status" class="file-status"></div>
                @error('health_certificate')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        </div>
        @endif
        
        @if($participant->type === 'bnsp')
{{-- SECTION BARU UNTUK BNSP --}}
<div class="form-subsection bnsp-docs">
    <h4 class="subsection-title">🏢 Dokumen Khusus BNSP</h4>
    
    <div class="form-group">
        <label class="form-label">
            Surat Keterangan Kerja 
            <span class="optional">(Opsional)</span>
        </label>
        <div class="file-upload" onclick="triggerFileInput('work_certificate')">
            <div class="file-upload-content">
                <div class="file-upload-icon">📋</div>
                <div class="file-upload-text">Klik untuk upload Surat Kerja</div>
                <div class="file-upload-hint">PDF - Max 2MB</div>
            </div>
        </div>
        <input type="file" 
               id="work_certificate" 
               name="work_certificate" 
               accept=".pdf" 
               style="display: none;" 
               onchange="handleFileUpload(this, 'work_certificate')">
        <div id="work_certificate-status" class="file-status"></div>
        @error('work_certificate')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>
</div>
@endif
        
        <!-- Pakta Integritas -->
        <div class="form-group">
            <label class="form-label">Pakta Integritas <span class="required">*</span></label>
            <div class="template-downloads">
                @foreach($templates->filter(function($template) use ($participant) {
                    return str_starts_with($template->type, $participant->type);
                }) as $template)

                    <a href="{{ url('storage/' . $template->file_path) }}" 
                    class="download-btn" 
                    target="_blank">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 0 0 1-2 2H5a2 0 0 1-2-2v-4"></path>
                            <polyline points="7,10 12,15 17,10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>

                        Download Template {{ $template->name }}
                    </a>

                @endforeach
            </div>
            <div class="file-upload" onclick="triggerFileInput('integrity_pact')">
                <div class="file-upload-content">
                    <div class="file-upload-icon">📜</div>
                    <div class="file-upload-text">Klik untuk upload Pakta Integritas</div>
                    <div class="file-upload-hint">PDF - Max 2MB</div>
                </div>
            </div>
            <input type="file" id="integrity_pact" name="integrity_pact" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'integrity_pact')">
            <div id="integrity_pact-status" class="file-status"></div>
            @error('integrity_pact')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
        
        @if($participant->type === 'kemnaker' && $participant->participant_category === 'company')
        <!-- Company Documents for Kemnaker -->
        <div class="form-subsection company-docs">
            <h4 class="subsection-title">🏢 Dokumen Utusan Perusahaan</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Surat Keterangan Kerja <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('work_certificate')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📋</div>
                            <div class="file-upload-text">Klik untuk upload Surat Kerja</div>
                            <div class="file-upload-hint">PDF - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="work_certificate" name="work_certificate" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'work_certificate')">
                    <div id="work_certificate-status" class="file-status"></div>
                    @error('work_certificate')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">NPWP Perusahaan <span class="required">*</span></label>
                    <div class="file-upload" onclick="triggerFileInput('company_npwp')">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">🏛️</div>
                            <div class="file-upload-text">Klik untuk upload NPWP</div>
                            <div class="file-upload-hint">PDF - Max 2MB</div>
                        </div>
                    </div>
                    <input type="file" id="company_npwp" name="company_npwp" accept=".pdf" required style="display: none;" onchange="handleFileUpload(this, 'company_npwp')">
                    <div id="company_npwp-status" class="file-status"></div>
                    @error('company_npwp')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        @endif
    </div>

    <button type="submit" class="btn-submit">
        <span class="btn-text">Upload Dokumen</span>
        <span class="btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7,10 12,15 17,10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
        </span>
    </button>
</form>

<style>
/* Participant Info Card */
.participant-info {
    margin-bottom: 2rem;
}

.info-card {
    background: linear-gradient(135deg, var(--gray-50), var(--white));
    border-radius: 16px;
    border: 2px solid var(--gray-100);
    overflow: hidden;
    position: relative;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
}

.info-header {
    padding: 1.5rem 2rem 1rem;
    border-bottom: 1px solid var(--gray-200);
}

.info-header h3 {
    color: var(--primary);
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.info-content {
    padding: 1.5rem 2rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: var(--gray-700);
    font-size: 0.95rem;
}

.info-value {
    font-weight: 500;
    color: var(--gray-800);
    text-align: right;
}

.program-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.program-kemnaker {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.program-bnsp {
    background: linear-gradient(135deg, #10b981, #047857);
    color: white;
}

/* Form Sections */
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

.kemnaker-docs {
    background: rgba(59, 130, 246, 0.02);
    border-color: rgba(59, 130, 246, 0.1);
}

.kemnaker-docs .subsection-title {
    color: #3b82f6;
    border-bottom-color: rgba(59, 130, 246, 0.2);
}

.company-docs {
    background: rgba(245, 158, 11, 0.02);
    border-color: rgba(245, 158, 11, 0.1);
}

.company-docs .subsection-title {
    color: #f59e0b;
    border-bottom-color: rgba(245, 158, 11, 0.2);
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

/* Template Downloads */
.template-downloads {
    margin-bottom: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

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

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    background: linear-gradient(135deg, var(--secondary-light), var(--secondary));
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

/* STYLE BARU UNTUK BNSP */
.bnsp-docs {
    background: rgba(16, 185, 129, 0.02);
    border-color: rgba(16, 185, 129, 0.1);
}

.bnsp-docs .subsection-title {
    color: #10b981;
    border-bottom-color: rgba(16, 185, 129, 0.2);
}

/* Optional Label Style */
.optional {
    color: #6b7280;
    font-weight: 400;
    font-size: 0.85rem;
    font-style: italic;
}

/* Responsive Design */
@media (max-width: 768px) {
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .info-value {
        text-align: left;
    }

    .template-downloads {
        flex-direction: column;
    }

    .form-section,
    .form-subsection {
        padding: 1.5rem;
    }
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
        'scan_diploma': ['pdf', 'jpg', 'jpeg', 'png'],
        'scan_ktp': ['pdf', 'jpg', 'jpeg', 'png'],
        'scan_photo': ['jpg', 'jpeg', 'png'],
        'cv_file': ['pdf'],
        'health_certificate': ['pdf', 'jpg', 'jpeg', 'png'],
        'integrity_pact': ['pdf'],
        'work_certificate': ['pdf', 'jpg', 'jpeg', 'png'],
        'company_npwp': ['pdf', 'jpg', 'jpeg', 'png']
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

// Initialize document upload form
document.addEventListener('DOMContentLoaded', function() {
    // KTP number validation (numeric only, max 16 digits)
    const ktpInput = document.querySelector('input[name="ktp_number"]');
    if (ktpInput) {
        ktpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
    }

    // Enhanced form validation for required files
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFileFields = [
                'scan_diploma', 
                'scan_ktp', 
                'scan_photo', 
                'cv_file', 
                'integrity_pact'
            ];
            
            // Add conditional required files
            const participantType = '{{ $participant->type }}';
            const participantCategory = '{{ $participant->participant_category ?? "" }}';
            
            if (participantType === 'kemnaker') {
                requiredFileFields.push('health_certificate');
                
                if (participantCategory === 'company') {
                    requiredFileFields.push('work_certificate', 'company_npwp');
                }
            }
            
            let hasFileError = false;

            requiredFileFields.forEach(function(fieldName) {
                const input = document.getElementById(fieldName);
                if (input && input.hasAttribute('required') && !input.files.length) {
                    hasFileError = true;
                    const statusDiv = document.getElementById(fieldName + '-status');
                    if (statusDiv) {
                        statusDiv.innerHTML = '<div class="file-error"><span>❌ File wajib diupload</span></div>';
                    }
                }
            });

            if (hasFileError) {
                e.preventDefault();
                alert('Mohon lengkapi semua file yang wajib diupload!');
                return false;
            }
        });
    }

    console.log('Document upload form enhancement loaded successfully');
});
</script>
@endsection