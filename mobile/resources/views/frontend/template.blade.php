<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>SIARTAS</title>
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-geolocation/dist/leaflet-geolocation.min.js"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>

    <!-- Responsive Mobile UI Enhancements -->
    <style>
        body {
            background-color: #f1f5f9 !important;
        }

        /* Fixed 4-Column Responsive Menu Grid */
        .menu {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 12px 8px !important;
            padding: 15px 10px !important;
            background: #ffffff !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #e2e8f0 !important;
        }

        .menu a {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            padding: 8px 4px !important;
            border-radius: 12px !important;
            transition: all 0.2s ease !important;
        }

        .menu a:active, .menu a:hover {
            background-color: #f8fafc !important;
            transform: translateY(-2px);
        }

        .menu a .icon-menu, .menu a img {
            width: 44px !important;
            height: 44px !important;
            object-fit: contain !important;
            margin-bottom: 6px !important;
        }

        .menu a span {
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            text-align: center !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            width: 100% !important;
        }

        /* Wallet Header Card */
        .wallet-card {
            background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
            border-radius: 20px !important;
            padding: 20px !important;
            color: #ffffff !important;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25) !important;
            border: none !important;
        }

        .wallet-card .balance .total {
            color: #ffffff !important;
            font-size: 1.3rem !important;
            font-weight: 700 !important;
        }

        .wallet-card .balance .title {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.8rem !important;
        }

        .wallet-card .avatar {
            width: 48px !important;
            height: 48px !important;
            border-radius: 14px !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
        }

        .wallet-card .wallet-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
            margin-top: 15px !important;
            padding-top: 15px !important;
            display: flex !important;
            justify-content: space-around !important;
        }

        .wallet-card .wallet-footer .item strong {
            color: #ffffff !important;
            font-size: 0.75rem !important;
            margin-top: 4px !important;
        }

        /* Stat Box Enhancement */
        .stat-box {
            border-radius: 16px !important;
            padding: 15px !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06) !important;
        }

        /* App Bottom Navigation Bar */
        .appBottomMenu {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px) !important;
            border-top: 1px solid #e2e8f0 !important;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05) !important;
            height: 65px !important;
        }

        .appBottomMenu .item strong {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
        }

        .appBottomMenu .item.active {
            color: #2563eb !important;
        }

        .appBottomMenu .item.active ion-icon {
            color: #2563eb !important;
        }

        .appBottomMenu .big-icon {
            background: linear-gradient(135deg, #2563eb, #00d2ff) !important;
            width: 54px !important;
            height: 54px !important;
            border-radius: 50% !important;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4) !important;
            border: 4px solid #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: -20px auto 0 !important;
        }

        .appBottomMenu .big-icon ion-icon {
            color: #ffffff !important;
            font-size: 26px !important;
        }
    </style>
</head>

<body>
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="icon" class="loading-icon">
    </div>

    @yield('contents')

    @if (Auth::guard('guru')->check())
        <div class="appBottomMenu">
            <a href="{{ route('dashboard') }}"
                class="item {{ request()->is('dashboard*') ? 'active' : '' }} {{ request()->is('customLogin*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="home-outline"></ion-icon>
                    <strong>Home</strong>
                </div>
            </a>
            <a href="{{ route('scan') }}">
                <div class="big-icon">
                    <ion-icon name="finger-print-outline" class="icon"></ion-icon>
                </div>
            </a>
            <a href="{{ route('settings') }}" class="item {{ request()->is('settings*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="settings-outline"></ion-icon>
                    <strong>Settings</strong>
                </div>
            </a>
        </div>
    @endif
    @if (Auth::guard('siswa')->check())
        <div class="appBottomMenu">
            <a href="{{ route('dashboard') }}" class="item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="home-outline"></ion-icon>
                    <strong>Home</strong>
                </div>
            </a>
            <a href="{{ route('viewAbsensiSiswa') }}"
                class=" {{ request()->is('viewAbsensiSiswa*') ? 'active' : '' }}">
                <div class="big-icon">
                    <ion-icon name="finger-print-outline" class="icon"></ion-icon>
                </div>
            </a>
            <a href="{{ route('settings') }}" class="item {{ request()->is('settings*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="settings-outline"></ion-icon>
                    <strong>Settings</strong>
                </div>
            </a>
        </div>
    @endif
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/plugins/splide/splide.min.js') }}"></script>
    <script src="{{ asset('assets/js/base.js') }}"></script>

    <script>
        AddtoHome("2000", "once");

        function haversineDistance(lat1, lon1, lat2, lon2) {
            var R = 6371;
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c;
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }
    </script>

</body>

</html>
