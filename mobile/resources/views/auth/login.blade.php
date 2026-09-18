<!doctype html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#1E3A8A">
    <title>Login - SIARTAS Mobile</title>
    <meta name="description" content="Aplikasi Absensi & Sistem Informasi Sekolah SMK Artanita">
    
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1E40AF 0%, #3B82F6 50%, #60A5FA 100%);
            --button-gradient: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            --button-hover: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .login-hero {
            background: var(--primary-gradient);
            position: relative;
            padding: 48px 24px 72px 24px;
            border-bottom-right-radius: 36px;
            border-bottom-left-radius: 36px;
            text-align: center;
            overflow: hidden;
            box-shadow: 0 12px 30px -10px rgba(37, 99, 235, 0.35);
        }

        /* Ambient Glow Background Circles */
        .login-hero::before {
            content: '';
            position: absolute;
            top: -40px;
            left: -40px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            blur: 20px;
        }

        .login-hero::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
        }

        .logo-badge {
            width: 88px;
            height: 88px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
            margin-bottom: 16px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .logo-badge:hover {
            transform: translateY(-3px);
        }

        .logo-badge img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .brand-title {
            color: #FFFFFF;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0 0 4px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            font-weight: 500;
            margin: 0;
        }

        .login-container {
            max-width: 440px;
            width: 100%;
            margin: -40px auto 24px auto;
            padding: 0 20px;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 32px 24px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
        }

        .form-header {
            margin-bottom: 24px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 6px 0;
        }

        .form-header p {
            font-size: 13px;
            color: #64748B;
            margin: 0;
        }

        .custom-form-group {
            margin-bottom: 20px;
        }

        .custom-form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-field-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #94A3B8;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .custom-input {
            width: 100%;
            height: 52px;
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            padding: 0 44px 0 48px;
            font-size: 14px;
            font-weight: 500;
            color: #0F172A;
            box-sizing: border-box;
            outline: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .custom-input::placeholder {
            color: #94A3B8;
            font-weight: 400;
        }

        .custom-input:focus {
            background-color: #FFFFFF;
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .custom-input:focus + .input-icon,
        .input-field-wrapper:focus-within .input-icon {
            color: #2563EB;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94A3B8;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #475569;
        }

        .btn-submit-gradient {
            width: 100%;
            height: 54px;
            background: var(--button-gradient);
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
            margin-top: 10px;
        }

        .btn-submit-gradient:hover {
            background: var(--button-hover);
            box-shadow: 0 12px 24px -5px rgba(37, 99, 235, 0.5);
            transform: translateY(-1px);
        }

        .btn-submit-gradient:active {
            transform: scale(0.98);
        }

        .app-footer {
            margin-top: auto;
            text-align: center;
            padding: 16px 24px 28px 24px;
            color: #94A3B8;
            font-size: 12px;
            font-weight: 500;
        }

        .app-footer a {
            color: #2563EB;
            text-decoration: none;
            font-weight: 600;
        }

        /* Loader Animation */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #FFFFFF;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        .loading-icon {
            width: 60px;
            height: 60px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(0.9); opacity: 0.7; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.7; }
        }
    </style>
</head>

<body>

    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="SIARTAS Logo" class="loading-icon">
    </div>

    <!-- Main Content Capsule -->
    <div id="appCapsule">
        <!-- Hero Header -->
        <div class="login-hero">
            <div class="logo-badge">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SIARTAS Logo">
            </div>
            <h1 class="brand-title">SIARTAS</h1>
            <p class="brand-subtitle">Sistem Informasi & Presensi SMK Artanita</p>
        </div>

        <!-- Login Form Container -->
        <div class="login-container">
            <div class="login-card">
                <div class="form-header">
                    <h2>Selamat Datang! 👋</h2>
                    <p>Silakan masuk menggunakan akun Anda</p>
                </div>

                <form action="{{ route('customLogin') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <!-- Username Input -->
                    <div class="custom-form-group">
                        <label for="username">Username / NIS / NIP</label>
                        <div class="input-field-wrapper">
                            <input type="text" class="custom-input" name="username" id="username"
                                placeholder="Masukkan username Anda" required>
                            <span class="input-icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="custom-form-group">
                        <label for="password">Password</label>
                        <div class="input-field-wrapper">
                            <input type="password" class="custom-input" name="password" id="password"
                                placeholder="Masukkan password Anda" required autocomplete="current-password">
                            <span class="input-icon">
                                <ion-icon name="lock-closed-outline"></ion-icon>
                            </span>
                            <button type="button" class="toggle-password" id="togglePasswordBtn" title="Tampilkan/Sembunyikan Password">
                                <ion-icon name="eye-outline" id="eyeIcon"></ion-icon>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit-gradient" name="submit">
                        <span>Masuk ke Akun</span>
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="app-footer">
        <p>© 2026 SMK Artanita • Powered by SIARTAS</p>
    </div>

    <!-- Ionicons & Script -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <script>
        // Password Visibility Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePasswordBtn && passwordInput && eyeIcon) {
                togglePasswordBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        eyeIcon.setAttribute('name', 'eye-off-outline');
                    } else {
                        eyeIcon.setAttribute('name', 'eye-outline');
                    }
                });
            }

            // Hide Loader after page load
            setTimeout(function() {
                const loader = document.getElementById('loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 300);
                }
            }, 300);
        });
    </script>
</body>

</html>
