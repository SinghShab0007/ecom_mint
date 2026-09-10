<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', '') }}</title>
    <link rel="icon" href="@if(config('app.favicon')){{asset(config('app.favicon'))}}@endif" type="image/x-icon">
    <script type="text/javascript">
        'use strict';
        var public_path = "<?php echo url('/'); ?>";
    </script>

    @include('seller.includes.layout_css')
</head>
<body>

<div id="main-wrapper">
    <header>
        <!-- Side Bar Start -->
        <!-- Lorem bhai -->
{{--        @auth('seller')--}}
            @include('seller.includes.seller_side_bar')
{{--        @else--}}
{{--            @include('backend.includes.side_bar')--}}
{{--        @endauth--}}
        <!-- Side Bar End -->
    </header>
    <main>
        <!-- Content Header Start -->
        @include('seller.includes.navbar')
        <!-- Content Header End -->

        <!-- Content Body Start -->
        @yield('content')
        <!-- Content Body end -->
    </main>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('seller.includes.layout_js')
</body>
</html>
