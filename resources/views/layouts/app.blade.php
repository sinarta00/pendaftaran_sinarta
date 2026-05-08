<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AK3U Training Registration')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">

    <main class="container mx-auto py-8 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
    <!-- resources/views/layouts/app.blade.php (tambahkan sebelum </body>) -->
<script>
// Enhance form with real-time validation and interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[name="phone"], input[name="company_phone"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            }
            if (!value.startsWith('62')) {
                value = '62' + value;
            }
            e.target.value = value;
        });
    });
    
    // File size validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.size > 2048 * 1024) { // 2MB
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                e.target.value = '';
            }
        });
    });
    
    // Email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function(e) {
            const email = e.target.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                e.target.setCustomValidity('Format email tidak valid');
            } else {
                e.target.setCustomValidity('');
            }
        });
    });
});
</script>
</body>
</html>