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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Responsive Mobile Menu Fix & Modern Glass Bottom Nav -->
    <style>
        body {
            background-color: #F8FAFC !important;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        /* High Contrast Cards for Mobile */
        .card, .section .card {
            background-color: #ffffff !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.05) !important;
        }

        .card-body {
            background-color: #ffffff !important;
            border-radius: 20px !important;
        }

        /* Modern Glass Bottom Menu */
        .appBottomMenu {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-top: 1px solid rgba(226, 232, 240, 0.8) !important;
            box-shadow: 0 -10px 25px -5px rgba(15, 23, 42, 0.06) !important;
            height: 64px !important;
        }

        .appBottomMenu .item {
            color: #64748B !important;
            transition: color 0.2s ease, transform 0.2s ease !important;
        }

        .appBottomMenu .item.active {
            color: #2563EB !important;
        }

        .appBottomMenu .item .col strong {
            font-weight: 700 !important;
            font-size: 11px !important;
        }

        .appBottomMenu .item ion-icon {
            font-size: 22px !important;
        }

        /* Responsive 4-Column Menu Grid */
        .menu {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: flex-start !important;
            gap: 12px 8px !important;
            padding: 10px 12px 0 12px !important;
        }

        .menu a {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: calc(25% - 6px) !important;
            box-sizing: border-box !important;
            margin-bottom: 10px !important;
            transform: none !important;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important;
            border-radius: 16px !important;
            padding: 12px 4px !important;
            box-shadow: 0 8px 18px -4px rgba(37, 99, 235, 0.35) !important;
            color: #ffffff !important;
            text-decoration: none !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .menu a:active {
            transform: scale(0.95) !important;
        }

        .menu a .icon-menu, .menu a img {
            width: 32px !important;
            height: 32px !important;
            max-width: 100% !important;
            object-fit: contain !important;
            margin-bottom: 6px !important;
            display: block !important;
        }

        .menu a span {
            font-size: 11px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            margin-top: 2px !important;
            text-align: center !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            width: 100% !important;
            display: block !important;
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
    @elseif (Auth::guard('siswa')->check())
        <div class="appBottomMenu">
            <a href="{{ route('dashboard') }}" class="item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="home-outline"></ion-icon>
                    <strong>Home</strong>
                </div>
            </a>
            <a href="{{ route('viewAbsensiSiswa') }}"
                class="{{ request()->is('viewAbsensiSiswa*') ? 'active' : '' }}">
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
    @elseif (Auth::guard('kelas')->check() || Auth::check())
        <div class="appBottomMenu">
            <a href="{{ route('dashboard') }}" class="item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <div class="col">
                    <ion-icon name="home-outline"></ion-icon>
                    <strong>Home</strong>
                </div>
            </a>
            <a href="{{ route('viewAbsensiSiswa') }}" class="{{ request()->is('viewAbsensiSiswa*') ? 'active' : '' }}">
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
