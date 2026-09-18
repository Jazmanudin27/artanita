<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/img/logo.png') }}" rel="shortcut icon">
    <title>Login - SIARTAS Artanita</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

    <style>
        body.login-bg {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #2563EB 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        body.login-bg::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .login-glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(24px);
            border-radius: 28px;
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.35);
            width: 100%;
            max-width: 420px;
            padding: 42px 36px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 10;
        }

        .brand-logo-container {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo-badge {
            width: 80px;
            height: 80px;
            background: #F8FAFC;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 14px;
        }

        .brand-logo-badge img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .login-title {
            font-size: 24px;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 4px 0;
            text-align: center;
            letter-spacing: -0.4px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748B;
            margin: 0 0 28px 0;
            text-align: center;
            font-weight: 500;
        }

        .form-group-custom {
            margin-bottom: 20px;
        }

        .form-group-custom label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-custom {
            width: 100%;
            height: 52px;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            padding: 0 18px;
            font-size: 14px;
            font-weight: 600;
            color: #0F172A;
            box-sizing: border-box;
            outline: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .input-custom:focus {
            background: #FFFFFF;
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .btn-primary-custom {
            width: 100%;
            height: 54px;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 800;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.4);
            transition: all 0.25s ease;
            margin-top: 10px;
            font-family: inherit;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 100%);
            box-shadow: 0 16px 30px -6px rgba(37, 99, 235, 0.5);
            transform: translateY(-2px);
        }

        .quote-box {
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #E2E8F0;
            text-align: center;
            font-size: 12px;
            color: #64748B;
            font-style: italic;
            font-weight: 500;
        }
    </style>
</head>

<body class="login-bg">
    <div class="login-glass-card">
        <div class="brand-logo-container">
            <div class="brand-logo-badge">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SIARTAS Logo">
            </div>
            <h1 class="login-title">SIARTAS</h1>
            <p class="login-subtitle">Sistem Informasi SMK Artanita</p>
        </div>

        @if (session('warning'))
            <div style="background-color: #FEF3C7; border: 1.5px solid #FCD34D; color: #92400E; padding: 12px 16px; border-radius: 14px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #FEE2E2; border: 1.5px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 14px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div style="background-color: #D1FAE5; border: 1.5px solid #6EE7B7; color: #065F46; padding: 12px 16px; border-radius: 14px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #FEE2E2; border: 1.5px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 14px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customLogin') }}" method="POST" autocomplete="off">
            @csrf
            
            <div class="form-group-custom">
                <label for="username">Username / Email</label>
                <input type="text" class="input-custom" placeholder="Masukkan username" name="username" id="username" required>
            </div>

            <div class="form-group-custom">
                <label for="password">Password</label>
                <input type="password" class="input-custom" placeholder="Masukkan password" name="password" id="password" required>
            </div>

            <button class="btn-primary-custom" type="submit">Log In</button>
        </form>

        <div class="quote-box">
            "Kejujuran adalah prestasi yang paling tinggi"
        </div>
    </div>

    <script src="{{ asset('dist/js/app.js') }}"></script>
</body>

</html>
