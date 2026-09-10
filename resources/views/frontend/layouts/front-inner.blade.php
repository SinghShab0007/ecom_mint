<!DOCTYPE html>
<html dir="{{ lang('direction') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>@yield('title')</title>

    <!-- Vendor Stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/vendor.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery-ui.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('public/frontend/css/nice-select.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.carousel.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/frontend/fontawesome-free-6.1.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
    <!-- responsive Stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/responsive.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/storage/favicon.png') }}">
</head>
<body>

@include('frontend.includes.preloader')


<!-- .newsletter-modal start -->

<div class="news_letter_modal_section modal fade" id="myModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="news_letter_modal">
                    <img src="public/frontend/img/banner/modal.png" alt="">
                    <div class="modal_close  close" id="closeBtn" data-dismiss="modal"><i class="fa fa-times"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .newsletter-modal start -->

@include('frontend.includes.search-popup')

<!--sidebar menu start-->
<div class="sidebar-menu" id="sidebar-menu">
    <button class="sidebar-menu-close"><i class="flaticon-close"></i></button>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <img src="public/frontend/img/logo.png" alt="logo"/>
        </div>
        <div class="sidemenu-text">
            <p></p>
        </div>
        <div class="sidebar-contact">
            <h4>Contact Us</h4>
            <ul>
                <li><i class="fa fa-map-marker"></i></li>
                <li><i class="fa fa-envelope"></i></li>
                <li><i class="fa fa-phone"></i></li>
            </ul>
        </div>
        <div class="sidebar-subscribe">
            <input type="text" placeholder="Email">
            <button><i class="fa fa-long-arrow-right"></i></button>
        </div>
        <div class="social-link">
            <ul>
                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<!--sidebar menu end-->

<!-- navbar start -->
<div class="navbar-area nav_sticky">
    @include('frontend.includes.navbar-top')
    @include('frontend.includes.navbar-middle')
    @include('frontend.includes.navbar-bottom')
</div>
<!-- navbar end -->

@yield('content')

@include('frontend.includes.footer')

<!-- back to top area start -->
<div class="back-to-top">
    <span class="back-top"><i class="fa fa-angle-up"></i></span>
</div>
<!-- back to top area end -->


<!-- all plugins here -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="{{ asset('public/frontend/js/vendor.js') }}"></script>

<!-- main js  -->
<script src="{{ asset('public/frontend/js/main.js') }}"></script>

<script>
    function removeFromCart(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('customer.removeFromCart') }}",
            data: {_token:csrf,id:id},
            type: "POST"
        })
    }
</script>
</body>
</html>
