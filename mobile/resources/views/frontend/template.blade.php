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

    <!-- Responsive Mobile Menu Fix -->
    <style>
        body {
            background-color: #f1f5f9 !important;
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
            transform: none !important; /* Remove broken -40% Y translation */
            background: #006eff !important;
            border-radius: 12px !important;
            padding: 12px 4px !important;
            box-shadow: 0 4px 10px rgba(0, 110, 255, 0.2) !important;
            color: #ffffff !important;
            text-decoration: none !important;
            transition: transform 0.15s ease, background-color 0.15s ease !important;
        }

        .menu a:active {
            transform: scale(0.94) !important;
            background: #0056cc !important;
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
            font-weight: 600 !important;
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
