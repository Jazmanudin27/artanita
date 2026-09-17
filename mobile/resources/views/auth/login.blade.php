<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login</title>
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<style>
    .header {
        background-color: #006eff;
        min-height: 45vh;
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .logo h1 {
        max-width: 100%;
        height: auto;
        font-size: 24px;
        text-align: center;
        color: white;
        padding-bottom: 5%;
    }

    .logo img {
        max-width: 100%;
        height: auto;
        text-align: center;
        padding-right: 25%;
        padding-left: 25%;
    }
</style>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="{{ 'assets/img/logo.png' }}" alt="icon" class="loading-icon">
    </div>
    <div id="appCapsule">
        <header class="header mb-5">
            <div class="logo">
                <img src="{{ 'assets/img/logo.png' }}" alt="logo">
                <h1>SIARTAS</h1>
            </div>
        </header>
        <div class="section mb-5 p-2">

            <form action="{{ route('customLogin') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Username">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password1">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    autocomplete="off" placeholder="Your password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-button-group  transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="submit">Log in</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->



    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="{{ asset('assets/js/plugins/splide/splide.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>


</body>

</html>
