<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/img/logo.png') }}" rel="shortcut icon">
    <title>E-SEKOLAH PRO - Sistem Presensi & Layanan Akademik</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.login-body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #060b17;
            background-image: 
                radial-gradient(circle at 18% 25%, rgba(14, 165, 233, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 82% 75%, rgba(37, 99, 235, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(56, 189, 248, 0.05) 0%, transparent 60%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #f1f5f9;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient high-tech background grid */
        body.login-body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(56, 189, 248, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(56, 189, 248, 0.03) 1px, transparent 1px);
            pointer-events: none;
            z-index: 0;
        }

        .login-card-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1040px;
            background: rgba(10, 19, 36, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(56, 189, 248, 0.18);
            border-radius: 28px;
            box-shadow: 
                0 30px 60px -15px rgba(0, 0, 0, 0.85),
                0 0 50px rgba(14, 165, 233, 0.08);
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            overflow: hidden;
            padding: 16px;
            gap: 16px;
        }

        /* Left Column - Futuristic Illustration & Banner */
        .visual-panel {
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            min-height: 570px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #091322 url("{{ asset('dist/images/smart-campus.jpg') }}") center/cover no-repeat;
            border: 1px solid rgba(56, 189, 248, 0.12);
        }

        /* Dark overlay for contrast on text */
        .visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg, 
                rgba(7, 13, 24, 0.5) 0%, 
                rgba(7, 13, 24, 0.1) 35%, 
                rgba(6, 12, 22, 0.75) 75%, 
                rgba(5, 10, 19, 0.95) 100%
            );
            pointer-events: none;
            z-index: 1;
        }

        /* Top Left Floating Badge */
        .top-brand-badge {
            position: relative;
            z-index: 2;
            margin: 20px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px 8px 10px;
            background: rgba(8, 16, 32, 0.75);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            align-self: flex-start;
        }

        .badge-icon-box {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .badge-icon-box svg {
            width: 20px;
            height: 20px;
        }

        .badge-text {
            display: flex;
            flex-direction: column;
        }

        .badge-title {
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .badge-subtitle {
            font-size: 9.5px;
            font-weight: 700;
            color: #38bdf8;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Bottom Text Card */
        .bottom-info-card {
            position: relative;
            z-index: 2;
            margin: 20px;
            background: rgba(8, 17, 34, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.18);
            border-radius: 18px;
            padding: 20px 22px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .info-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 6px;
        }

        .info-card-desc {
            font-size: 12.5px;
            color: #94a3b8;
            line-height: 1.55;
            margin: 0;
            font-weight: 400;
        }

        /* Right Column - Login Form */
        .form-panel {
            padding: 32px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Center Top App Brand */
        .brand-header-center {
            text-align: center;
            margin-bottom: 24px;
        }

        .app-icon-glowing {
            width: 58px;
            height: 58px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            margin-bottom: 12px;
            box-shadow: 
                0 0 25px rgba(56, 189, 248, 0.5),
                0 8px 16px rgba(37, 99, 235, 0.35);
        }

        .app-icon-glowing svg {
            width: 30px;
            height: 30px;
        }

        .app-main-title {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 3px;
        }

        .app-main-subtitle {
            font-size: 12.5px;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Welcome Row with Security Shield */
        .welcome-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .welcome-text-title {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
            letter-spacing: -0.2px;
        }

        .welcome-text-subtitle {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 400;
        }

        .security-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.08);
            border: 1.5px solid rgba(16, 185, 129, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.12);
            flex-shrink: 0;
        }

        .security-badge svg {
            width: 22px;
            height: 22px;
        }

        /* Notification Alerts */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.35);
            color: #fbbf24;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #f87171;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #34d399;
        }

        /* Form Controls */
        .form-group-field {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .input-box-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-lead-icon {
            position: absolute;
            left: 16px;
            color: #38bdf8;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .input-lead-icon svg {
            width: 18px;
            height: 18px;
        }

        .custom-cyber-input {
            width: 100%;
            height: 50px;
            background: rgba(15, 26, 46, 0.65);
            border: 1px solid #1e2e48;
            border-radius: 14px;
            padding: 0 46px 0 46px;
            font-size: 13.5px;
            font-weight: 500;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .custom-cyber-input::placeholder {
            color: #64748b;
            font-weight: 400;
        }

        .custom-cyber-input:focus {
            background: rgba(18, 32, 56, 0.95);
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.16);
        }

        /* Eye toggle for password */
        .toggle-password-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s ease;
        }

        .toggle-password-btn:hover {
            color: #38bdf8;
        }

        .toggle-password-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Submit Button */
        .btn-submit-action {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 8px 24px -4px rgba(37, 99, 235, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            margin-top: 22px;
            font-family: inherit;
        }

        .btn-submit-action:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #1d4ed8 100%);
            box-shadow: 0 12px 28px -4px rgba(37, 99, 235, 0.65);
            transform: translateY(-1px);
        }

        .btn-submit-action:active {
            transform: translateY(0);
        }

        .btn-submit-action svg {
            width: 18px;
            height: 18px;
            transition: transform 0.2s ease;
        }

        .btn-submit-action:hover svg {
            transform: translateX(3px);
        }

        /* Footer Text */
        .card-footer-note {
            margin-top: 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
        }

        .card-footer-note svg {
            width: 15px;
            height: 15px;
            color: #64748b;
        }

        /* Responsive Design */
        @media (max-width: 960px) {
            .login-card-container {
                grid-template-columns: 1fr;
                max-width: 480px;
                padding: 14px;
            }

            .visual-panel {
                min-height: 260px;
            }

            .bottom-info-card {
                display: none;
            }

            .form-panel {
                padding: 20px 16px;
            }
        }

        @media (max-width: 480px) {
            body.login-body {
                padding: 12px;
            }

            .visual-panel {
                min-height: 190px;
            }

            .welcome-text-title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body class="login-body">
    <div class="login-card-container">
        <!-- Left Panel: 3D Isometric Smart Campus & Info -->
        <div class="visual-panel">
            <div class="visual-overlay"></div>

            <!-- Top Left Floating Badge -->
            <div class="top-brand-badge">
                <div class="badge-icon-box">
                    <!-- Graduation Cap Icon -->
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <div class="badge-text">
                    <span class="badge-title">E-SEKOLAH PRO</span>
                    <span class="badge-subtitle">DIGITAL SMART CAMPUS</span>
                </div>
            </div>

            <!-- Bottom Floating Info Card -->
            <div class="bottom-info-card">
                <h3 class="info-card-title">Sistem Informasi Presensi & Manajemen Akademik</h3>
                <p class="info-card-desc">
                    Platform pintar yang menghubungkan administrator, tenaga pendidik, dan presensi kelas dalam satu ekosistem terpadu.
                </p>
            </div>
        </div>

        <!-- Right Panel: Login Form -->
        <div class="form-panel">
            <!-- Centered Brand Header -->
            <div class="brand-header-center">
                <div class="app-icon-glowing">
                    <!-- Graduation Cap Icon -->
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <h1 class="app-main-title">E-SEKOLAH PRO</h1>
                <p class="app-main-subtitle">Sistem Presensi & Layanan Akademik</p>
            </div>

            <!-- Welcome Row with Security Shield -->
            <div class="welcome-row">
                <div>
                    <h2 class="welcome-text-title">Selamat Datang</h2>
                    <p class="welcome-text-subtitle">Silakan masuk untuk mengakses sistem</p>
                </div>
                <div class="security-badge" title="Sistem Terenkripsi & Aman">
                    <!-- Shield Check SVG -->
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>

            <!-- Notification Messages -->
            @if (session('warning'))
                <div class="alert-custom alert-warning">
                    <span>⚠️</span>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-custom alert-error">
                    <span>❌</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-custom alert-success">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-custom alert-error">
                    <span>❌</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('customLogin') }}" method="POST" autocomplete="off">
                @csrf

                <!-- Username / NIP / Email Field -->
                <div class="form-group-field">
                    <label for="username" class="field-label">USERNAME / NIP / EMAIL</label>
                    <div class="input-box-wrapper">
                        <span class="input-lead-icon">
                            <!-- User SVG Icon -->
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            class="custom-cyber-input" 
                            placeholder="Masukkan NIP, Email, atau Username" 
                            value="{{ old('username') }}" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group-field">
                    <label for="password" class="field-label">PASSWORD</label>
                    <div class="input-box-wrapper">
                        <span class="input-lead-icon">
                            <!-- Lock SVG Icon -->
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="custom-cyber-input" 
                            placeholder="Masukkan password akun" 
                            required
                        >
                        <button type="button" class="toggle-password-btn" id="togglePasswordBtn" onclick="togglePasswordVisibility()" aria-label="Lihat Password">
                            <!-- Eye Icon -->
                            <svg id="eyeIcon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-action">
                    <span>Masuk Aplikasi</span>
                    <!-- Arrow Right SVG Icon -->
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Bottom Disclaimer / Motto -->
            <div class="card-footer-note">
                <!-- Book Open SVG Icon -->
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Presensi Digital Transparan & Akurat</span>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>

</html>
