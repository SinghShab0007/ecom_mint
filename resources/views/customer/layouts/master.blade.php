<!DOCTYPE html>
<html dir="{{ lang('direction') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ maanAppearance('keywords') }}" />
    <meta name="description" content="{{ maanAppearance('meta_desc') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">

    <!-- All Device Favicon -->
    <link rel="icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('customer/css/bootstrap.min.css') }}">

    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('customer/css/normalize.css') }}">

    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('customer/css/nice-select.css') }}">

    <!-- SweetAlert -->
    <script src="{{ asset('frontend/js/vendor/sweetalert.min.js') }}"></script>

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('customer/css/default.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('customer/css/style.css') }}">

    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('customer/css/responsive.css') }}">

    <!-- Timeline CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/timeline.css') }}">

    <!-- Invoice CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/invoice.css') }}">

    <!-- Cancel CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/cancel.css') }}">

    <!-- My Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/my-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.rtl.css') }}">

    <!-- Print CSS -->
    <link rel="stylesheet" href="{{ asset('customer/css/print.css') }}">
    
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

    <!-- Customer dashboard (loaded last so it wins) -->
    <link rel="stylesheet" href="{{ asset('customer/css/pk-dashboard.css') }}?v=1">
</head>

<body>

@if(session()->has('locale')) {{ app()->setLocale(Session::get('locale')) }} @endif

<div id="main-wrapper">
    <!-- Main Header Start -->
    <div class="main-header">
        @include('frontend.includes.top-bar')
        @include('frontend.includes.mid-bar')
        @include('frontend.includes.menu-bar')
    </div>
    <!-- Main Header End -->
    <div class="pk-dash">
        <div class="container">

            <div class="pk-dash-topbar">
                <button type="button" class="pk-dash-toggle" id="pkDashToggle">
                    <span></span><span></span><span></span>
                    {{ __('Menu') }}
                </button>
                <div class="pk-dash-breadcrumb">
                    <a href="{{ url('/') }}">{{ __('Home') }}</a>
                    <span>/</span>
                    <strong>@yield('page_title', __('Dashboard'))</strong>
                </div>
            </div>

            <div class="pk-dash-grid">
                @include('customer.includes.sidebar')
                <main class="pk-dash-main">
                    @yield('content')
                </main>
            </div>

        </div>
    </div>
    <footer>
        @include('frontend.includes.info-footer')
        @include('frontend.includes.main-footer')
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('customer/js/vendor/jquery-3.6.0.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('customer/js/vendor/bootstrap.min.js') }}"></script>

<!-- Popper -->
<script src="{{ asset('customer/js/vendor/popper.min.js') }}"></script>

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

<!-- Form Pass -->
<script src="{{ asset('customer/js/form-pass.js') }}"></script>

<script>
    (function () {
        var toggle  = document.getElementById('pkDashToggle');
        var sidebar = document.getElementById('pkDashSidebar');
        var overlay = document.getElementById('pkDashOverlay');
        var close   = sidebar ? sidebar.querySelector('.pk-dash-close') : null;

        function open()  { sidebar.classList.add('is-open'); overlay.classList.add('is-open'); }
        function shut()  { sidebar.classList.remove('is-open'); overlay.classList.remove('is-open'); }

        if (toggle && sidebar && overlay) {
            toggle.addEventListener('click', open);
            overlay.addEventListener('click', shut);
            if (close) { close.addEventListener('click', shut); }
            document.addEventListener('keyup', function (e) { if (e.key === 'Escape') { shut(); } });
        }
    })();
</script>

@yield('script')

</body>

</html>
