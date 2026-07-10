{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - AK3U Training Registration')

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

    /* Override Tailwind container for homepage */
    .homepage-container {
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

    /* Hero Section */
    .hero-section {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 4rem 2rem;
        position: relative;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 1.5rem;
        line-height: 1.1;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: slideInDown 1s ease-out;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: var(--gray-600);
        margin-bottom: 3rem;
        max-width: 800px;
        font-weight: 400;
        animation: slideInUp 1s ease-out 0.3s both;
    }

    /* Cards Grid */
    .cards-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    /* Program Cards */
    .program-card {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-100);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .program-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .program-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
    }

    .program-card:hover::before {
        transform: scaleX(1);
    }

    .card-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: var(--white);
        transition: all 0.3s ease;
    }

    .card-kemnaker .card-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .card-bnsp .card-icon {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .card-tot .card-icon {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .card-skp .card-icon {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .card-pop .card-icon {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }

    .card-pop .card-title {
        color: #ef4444;
    }

    .card-pop .card-button {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }

    .card-pop .card-button:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-2px);
    }

    .program-card:hover .card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--gray-800);
    }

    .card-kemnaker .card-title {
        color: #3b82f6;
    }

    .card-bnsp .card-title {
        color: #10b981;
    }

    .card-tot .card-title {
        color: #8b5cf6;
    }

    .card-skp .card-title {
        color: #f59e0b;
    }

    .card-description {
        color: var(--gray-600);
        margin-bottom: 2rem;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .card-button {
        width: 100%;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        color: var(--white);
    }

    .card-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .card-button:hover::before {
        left: 100%;
    }

    .card-kemnaker .card-button {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .card-kemnaker .card-button:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
    }

    .card-bnsp .card-button {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .card-bnsp .card-button:hover {
        background: linear-gradient(135deg, #047857, #065f46);
        transform: translateY(-2px);
    }

    .card-tot .card-button {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .card-tot .card-button:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        transform: translateY(-2px);
    }

    .card-skp .card-button {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .card-skp .card-button:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
    }

    /* Floating particles for homepage */
    .particle {
        position: absolute;
        background: var(--primary);
        border-radius: 50%;
        opacity: 0.6;
        animation: float-particle linear infinite;
    }

    @keyframes float-particle {
        from {
            transform: translateY(100vh) rotate(0deg);
        }
        to {
            transform: translateY(-100px) rotate(360deg);
        }
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .cards-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .program-card {
            padding: 1.5rem;
        }

        .hero-section {
            padding: 2rem 1rem;
        }

        .cards-container {
            padding: 1rem;
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

<div class="homepage-container">
    <div class="particles" id="particles"></div>
    <div class="bg-shape circle circle-1"></div>
    <div class="bg-shape circle circle-2"></div>
    <div class="bg-shape circle circle-3"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1 class="hero-title">Selamat Datang di AK3U Training</h1>
        <p class="hero-subtitle">Bergabunglah dengan program pelatihan Keselamatan dan Kesehatan Kerja (K3) terpercaya untuk mengembangkan kompetensi profesional Anda</p>
    </section>

    <!-- Programs Section -->
    <section class="cards-container">
        <div class="cards-grid">
            <!-- AK3U Kemnaker Card -->
            <div class="program-card card-kemnaker">
                <div class="card-icon">
                    KRI
                </div>
                <h2 class="card-title">AK3U Kemnaker</h2>
                <p class="card-description">
                    Pelatihan Ahli K3 Umum yang diakui secara resmi oleh Kementerian Ketenagakerjaan Republik Indonesia. 
                    Dapatkan sertifikat yang berlaku nasional untuk karir K3 Anda.
                </p>
                <a href="{{ route('ak3u.kemnaker') }}" class="card-button">
                    <span>Daftar Sekarang</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12,5 19,12 12,19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- AK3U BNSP Card -->
            <div class="program-card card-bnsp">
                <div class="card-icon">
                    BNSP
                </div>
                <h2 class="card-title">AK3U BNSP</h2>
                <p class="card-description">
                    Pelatihan Ahli K3 Umum bersertifikat BNSP (Badan Nasional Sertifikasi Profesi) 
                    yang diakui internasional. Tingkatkan kredibilitas profesional K3 Anda.
                </p>
                <a href="{{ route('ak3u.bnsp') }}" class="card-button">
                    <span>Daftar Sekarang</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12,5 19,12 12,19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- TOT Card -->
            <div class="program-card card-tot">
                <div class="card-icon">
                    TOT
                </div>
                <h2 class="card-title">Training of Trainers</h2>
                <p class="card-description">
                    Pelatihan untuk menjadi instruktur K3 profesional dengan 4 level kompetensi 
                    (Level 3-6). Jadilah bagian dari trainer K3 berkualitas tinggi.
                </p>
                <a href="{{ route('tot.form') }}" class="card-button">
                    <span>Daftar TOT</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12,5 19,12 12,19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- SKP Card -->
            <div class="program-card card-skp">
                <div class="card-icon">
                    SKP
                </div>
                <h2 class="card-title">SKP K3</h2>
                <p class="card-description">
                    Layanan penerbitan dan perpanjangan Surat Keterangan Penunjukan K3. 
                    Proses cepat, mudah, dan terpercaya untuk kebutuhan legalitas K3 Anda.
                </p>
                <a href="{{ route('skp.form') }}" class="card-button">
                    <span>Daftar SKP</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12,5 19,12 12,19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- POP BNSP Card -->
            <div class="program-card card-pop">
                <div class="card-icon">
                    POP
                </div>
                <h2 class="card-title">POP BNSP</h2>
                <p class="card-description">
                    Pelatihan Pengawas Operasional Pertama (POP) bersertifikat BNSP untuk 
                    para supervisor di industri pertambangan. Tingkatkan kompetensi pengawasan K3 Anda.
                </p>
                <a href="{{ route('pop.form') }}" class="card-button">
                    <span>Daftar POP</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12,5 19,12 12,19"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>

<script>
// Particle.js initialization for homepage
if (typeof particlesJS !== 'undefined') {
    particlesJS('particles', {
        "particles": {
            "number": {
                "value": 80,
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
                "value": 0.3,
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
                "opacity": 0.15,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1.5,
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
                        "opacity": 0.4
                    }
                },
                "push": {
                    "particles_nb": 3
                }
            }
        }
    });
}

// Create floating particles
function createFloatingParticles() {
    const particlesContainer = document.querySelector('.particles');
    if (!particlesContainer) return;

    // Clear existing particles
    const existingParticles = particlesContainer.querySelectorAll('.particle');
    existingParticles.forEach(p => p.remove());

    // Create new particles
    for (let i = 0; i < 12; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.width = Math.random() * 4 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (Math.random() * 15 + 20) + 's';
        particlesContainer.appendChild(particle);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    createFloatingParticles();
    
    // Add staggered animation to cards
    const cards = document.querySelectorAll('.program-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = (0.8 + index * 0.2) + 's';
        card.classList.add('animate-card');
    });
});

// Recreate particles periodically
setInterval(createFloatingParticles, 45000);

console.log('AK3U Training Homepage loaded successfully');
</script>

<style>
.animate-card {
    animation: fadeInUp 0.8s ease-out both;
}
</style>
@endsection