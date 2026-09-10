<!DOCTYPE html>
<html dir="{{ lang('direction') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ maanAppearance('keywords') }}">
    <meta name="description" content="{{ maanAppearance('meta_desc') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">

    <!-- All Device Favicon -->
    <link rel="icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('frontend/css/normalize.css') }}">

    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('customer/css/nice-select.css') }}">

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('customer/css/default.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('customer/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/style.rtl.css') }}">

    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('customer/css/responsive.css') }}">
</head>

<body>
<div class="mybazar-login-section">
    <div class="mybazar-login-wrapper">
        <div class="login-wrapper">
            <div class="login-header">
                <img src="{{ asset('uploads') }}/{{ maanAppearance('logo') }}" alt="">
            </div>
            <div class="login-body">

                {{-- Global flash messages for every auth screen --}}
                @if(session('status') || session('success'))
                    <div style="background:#e8f6ec;border:1px solid #b7e4c7;color:#1b6b3a;padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:14px;line-height:1.6;">
                        {{ session('status') ?: session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background:#fdecec;border:1px solid #f5b5b5;color:#a12626;padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:14px;line-height:1.6;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background:#fdecec;border:1px solid #f5b5b5;color:#a12626;padding:12px 15px;border-radius:8px;margin-bottom:16px;font-size:14px;line-height:1.6;">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('customer/js/vendor/jquery-3.6.0.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('customer/js/vendor/bootstrap.min.js') }}"></script>

<!-- Nice Select -->
<script src="{{ asset('customer/js/vendor/jquery.nice-select.min.js') }}"></script>

<!-- Waypoints -->
<script src="{{ asset('customer/js/vendor/waypoints.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('customer/js/vendor/counterup.min.js') }}"></script>

<!-- Count Down -->
<script src="{{ asset('customer/js/vendor/countdown.js') }}"></script>
<script src="{{ asset('customer/js/vendor/chart.min.js') }}"></script>

<!-- Index -->
<script src="{{ asset('customer/js/index.js') }}"></script>

<script src="{{ asset('customer/js/form-pass.js') }}"></script>

@stack('script')

</body>

</html>
