{{-- resources/views/layouts/form-layout.blade.php --}}
@extends('layouts.app')

@section('title', $formTitle ?? 'Form Registration')

@section('content')
<style>
    :root {
        --primary: #820000;
        --primary-light: #a61e1e;
        --primary-dark: #5c0000;
        --secondary: #ffd700;
        --secondary-light: #fff347;
        --secondary-dark: #ccaa00;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --success: #10b981;
        --warning: #f59e0b;
        --error: #ef4444;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background: var(--white) !important;
        color: var(--gray-800);
        line-height: 1.6;
        overflow-x: hidden;
        position: relative;
    }

    /* Override Tailwind container */
    .form-page-container {
        max-width: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Particles Background */
    .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 0.6;
    }

    /* Background Shapes */
    .bg-shape {
        position: fixed;
        border-radius: 50%;
        z-index: -1;
        opacity: 0.03;
    }

    .circle-1 {
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        top: -300px;
        right: -300px;
        animation: float 20s ease-in-out infinite;
    }

    .circle-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
        bottom: -200px;
        left: -200px;
        animation: float 25s ease-in-out infinite reverse;
    }

    .circle-3 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, var(--primary-light), var(--secondary));
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: float 30s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-30px) rotate(120deg); }
        66% { transform: translateY(30px) rotate(240deg); }
    }

    /* Main Container */
    .form-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
        margin-top: -2rem; /* Offset the main container padding */
    }

    .form-container {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        max-width: 800px;
        width: 100%;
        overflow: hidden;
        position: relative;
        border: 1px solid var(--gray-100);
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
        background-size: 200% 100%;
        animation: gradientShift 3s ease-in-out infinite;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Header */
    .header {
        text-align: center;
        padding: 3rem 2rem 2rem;
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        position: relative;
    }

    .logo {
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .logo-circle {
        border-radius: 50%;
        box-shadow: var(--shadow-lg);
        border: 4px solid var(--white);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .logo-circle:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-xl);
    }

    .logo::after {
        content: '';
        position: absolute;
        inset: -8px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        z-index: 1;
        opacity: 0.1;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.1); opacity: 0.2; }
    }

    .header h2 {
        color: var(--primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .header-desc {
        color: var(--gray-600);
        font-size: 1.1rem;
        margin-bottom: 2rem;
        font-weight: 400;
    }

    .divider {
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--secondary), transparent);
        border-radius: 2px;
        margin: 0 auto;
        width: 100px;
    }

    /* Form Styles */
    .form-content {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-label .required {
        color: var(--error);
        font-weight: 700;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        padding-right: 3rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
        color: var(--gray-800);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
        padding-right: 1rem;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(130, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .form-input:hover,
    .form-select:hover,
    .form-textarea:hover {
        border-color: var(--gray-300);
    }

    .form-input.success,
    .form-select.success,
    .form-textarea.success {
        border-color: var(--success);
        background: rgba(16, 185, 129, 0.05);
    }

    .form-input.error,
    .form-select.error,
    .form-textarea.error {
        border-color: var(--error);
        background: rgba(239, 68, 68, 0.05);
    }

    .input-icon {
        position: absolute;
        right: 1rem;
        color: var(--gray-400);
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .input-wrapper:focus-within .input-icon {
        color: var(--primary);
    }

    /* Phone Input */
    .phone-input .input-wrapper {
        display: flex;
    }

    .phone-prefix {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: var(--white);
        padding: 0.875rem 1rem;
        border-radius: 12px 0 0 12px;
        font-weight: 600;
        border: 2px solid var(--primary);
        border-right: none;
        display: flex;
        align-items: center;
    }

    .phone-input .form-input {
        border-radius: 0 12px 12px 0;
        border-left: none;
    }

    /* Radio Groups */
    .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }

    .radio-option:hover {
        border-color: var(--primary);
        background: rgba(130, 0, 0, 0.05);
    }

    .radio-option input[type="radio"] {
        margin-right: 0.5rem;
        accent-color: var(--primary);
    }

    .radio-option input[type="radio"]:checked + .radio-text {
        color: var(--primary);
        font-weight: 600;
    }

    .radio-option:has(input:checked) {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(130, 0, 0, 0.1), rgba(255, 215, 0, 0.1));
    }

    /* Company Fields */
    .company-fields {
        margin-top: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        border-radius: 16px;
        border: 2px solid var(--gray-100);
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .company-fields.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .company-fields.slide-in {
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .company-header {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .company-header h4 {
        color: var(--primary);
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .company-header p {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Checkbox Terms */
    .checkbox-terms {
        margin: 2rem 0;
    }

    .checkbox-terms label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        cursor: pointer;
        padding: 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: normal;
    }

    .checkbox-terms label:hover {
        border-color: var(--primary);
        background: rgba(130, 0, 0, 0.05);
    }

    .checkbox-terms input[type="checkbox"] {
        accent-color: var(--primary);
        width: 18px;
        height: 18px;
        margin-top: 2px;
    }

    .checkbox-text {
        color: var(--gray-700);
        line-height: 1.5;
        font-size: 0.95rem;
    }

    /* Buttons */
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: var(--white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Error Messages */
    .error-text {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .help-text {
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .loading-overlay.show {
        display: flex;
    }

    .loading-content {
        text-align: center;
    }

    body.loading {
        overflow: hidden;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-page {
            padding: 0;
            margin: 0;
        }

        .form-container {
            border-radius: 16px;
        }

        .header {
            padding: 2rem 1rem;
        }

        .header h2 {
            font-size: 1.5rem;
            text-align: center;
        }

        .header-desc {
            font-size: 1rem;
            text-align: center;
        }

        .form-content {
            margin: 0;
            padding: 10px;
        }


        .radio-group {
            flex-direction: column;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-100);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(var(--primary), var(--secondary));
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(var(--primary-light), var(--secondary-light));
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<!-- Google reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="form-page-container">
    <div class="particles" id="particles"></div>
    <div class="bg-shape circle circle-1"></div>
    <div class="bg-shape circle circle-2"></div>
    <div class="bg-shape circle circle-3"></div>

    <section class="form-page">
        <div class="form-container">
            <div class="header">
                <div class="logo">
                    <img src="https://pendaftaran.sinartamjs.com/images/logosb.png" alt="Logo" width="150" height="150" class="logo-circle">

                </div>
                <h2>@yield('form-title', 'Formulir Pendaftaran')</h2>
                <p class="header-desc">@yield('form-description', 'Silakan isi data diri Anda untuk pendaftaran')</p>
                <div class="divider"></div>
            </div>

            <div class="form-content">
                @yield('form-content')
            </div>
        </div>
    </section>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-content">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-white fw-bold">Sedang Memproses...</p>
    </div>
</div>

<script>
// Particle.js initialization
if (typeof particlesJS !== 'undefined') {
    particlesJS('particles', {
        "particles": {
            "number": {
                "value": 60,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#820000"
            },
            "shape": {
                "type": "circle"
            },
            "opacity": {
                "value": 0.4,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0.1
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 2,
                    "size_min": 0.5
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#820000",
                "opacity": 0.2,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 2,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out"
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "grab"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                }
            },
            "modes": {
                "grab": {
                    "distance": 140,
                    "line_linked": {
                        "opacity": 0.5
                    }
                },
                "push": {
                    "particles_nb": 2
                }
            }
        }
    });
}

// Form Enhancement Functions
window.toggleCompanyFields = function() {
    const kategoriPersonal = document.querySelector('input[name="participant_category"][value="personal"]');
    const kategoriPerusahaan = document.querySelector('input[name="participant_category"][value="company"]');
    const companyFields = document.getElementById('companyFields');

    if (kategoriPersonal && kategoriPerusahaan && companyFields) {
        if (kategoriPerusahaan.checked) {
            companyFields.style.display = 'block';
            companyFields.classList.add('active');
            setTimeout(() => {
                companyFields.classList.add('slide-in');
            }, 10);
            companyFields.querySelectorAll('input, textarea, select').forEach(input => {
                input.setAttribute('required', 'required');
            });
        } else {
            companyFields.classList.remove('slide-in');
            setTimeout(() => {
                companyFields.style.display = 'none';
                companyFields.classList.remove('active');
            }, 300);
            companyFields.querySelectorAll('input, textarea, select').forEach(input => {
                input.removeAttribute('required');
                input.value = '';
            });
        }
    }
};

// Initialize form enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan loading overlay hidden saat halaman dimuat
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.remove('show');
        loadingOverlay.style.display = 'none';
    }
    
    // Remove loading class dari body
    document.body.classList.remove('loading');

    // Setup category radio listeners
    const categoryRadios = document.querySelectorAll('input[name="participant_category"]');
    categoryRadios.forEach(radio => {
        radio.addEventListener('change', window.toggleCompanyFields);
    });

    // Initial company fields state
    window.toggleCompanyFields();

    // Enhanced validation
    const inputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity() && this.value.trim() !== '') {
                this.classList.remove('error');
                this.classList.add('success');
            } else if (this.value.trim() !== '' && !this.checkValidity()) {
                this.classList.add('error');
                this.classList.remove('success');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error') && this.checkValidity()) {
                this.classList.remove('error');
                this.classList.add('success');
            }
        });
    });

    // Phone formatting
    const phoneInputs = document.querySelectorAll('input[name*="phone"], input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 13) {
                value = value.slice(0, 13);
            }
            e.target.value = value;
        });
    });

    // Form submit handler
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        form.addEventListener('submit', function(e) {
            // Cek reCAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                const recaptchaResponse = grecaptcha.getResponse();
                if (!recaptchaResponse) {
                    e.preventDefault();
                    alert('Harap centang "I\'m not a robot"');
                    return false;
                }
            }
            
            // Show loading
            submitBtn.disabled = true;
            if (btnText) btnText.style.display = 'none';
            if (btnLoading) {
                btnLoading.style.display = 'inline-flex';
                btnLoading.style.alignItems = 'center';
            }
            
            if (loadingOverlay) {
                loadingOverlay.classList.add('show');
                loadingOverlay.style.display = 'flex';
            }
            document.body.classList.add('loading');
            
            // Backup: hide loading setelah 30 detik
            setTimeout(function() {
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoading) btnLoading.style.display = 'none';
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('show');
                    loadingOverlay.style.display = 'none';
                }
                document.body.classList.remove('loading');
            }, 30000);
        });
    }
});

// Pastikan loading hidden saat page show (back button)
window.addEventListener('pageshow', function(event) {
    const loadingOverlay = document.getElementById('loadingOverlay');
    const submitBtn = document.getElementById('submitBtn');
    
    if (loadingOverlay) {
        loadingOverlay.classList.remove('show');
        loadingOverlay.style.display = 'none';
    }
    
    if (submitBtn) {
        submitBtn.disabled = false;
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        if (btnText) btnText.style.display = 'inline';
        if (btnLoading) btnLoading.style.display = 'none';
    }
    
    document.body.classList.remove('loading');
});

console.log('Enhanced Form Layout loaded successfully');
</script>
@endsection