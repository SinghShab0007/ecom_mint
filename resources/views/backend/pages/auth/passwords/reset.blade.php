<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}">
    <meta name="description" content="{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}</title>

    <link rel="icon" href="@if(config('app.favicon')){{asset(config('app.favicon'))}}@endif">

    @include('backend.includes.layout_css')
</head>

<body>

<div class="mybazar-login-section">
    <div class="mybazar-login-wrapper">
        <div class="login-wrapper">
            <div class="login-header">
                <img src="@if(config('app.logo')){{asset(config('app.logo'))}}@endif" alt="logo">
            </div>
            <div class="login-body">
                <h2 class="m-0">{{__('Reset Password')}}</h2>
                <p>{{__('Please Set your New Password')}}</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form method="POST" action="{{ route('backend.password.update') }}">
                    @csrf

                    <div class="input-group">
                        <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@domain.com">
                        @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
                    </div>
                    <div class="input-group">
                        <span><img src="{{ asset('customer/img/icons/pin-2.png') }}" alt=""></span>
                        <input type="text" name="verification_code" value="{{ old('verification_code') }}" class="form-control" placeholder="Verification Code">
                        @if($errors->has('verification_code')) <p>{{ $errors->first('verification_code') }}</p> @endif
                    </div>
                    <div class="input-group">
                        <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
                        <span class="hide-pass">
                            <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                            <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
                        </span>
                        <input type="password" id="myPass" name="password" class="form-control" placeholder="Password">
                        @if($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
                    </div>
                    <div class="input-group">
                        <span>
                            <img src="{{ asset('customer/img/icons/Lock.svg') }}" alt="">
                        </span>
                        <span class="hide-pas">
                            <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                            <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
                        </span>
                        <input type="password" id="myPas" name="password_confirmation" class="form-control" placeholder="Re-type Password">
                    </div>
                    <button type="submit" class="btn login-btn">{{ __('Reset Password') }}</button>
                </form>
                <div class="login-footer">
                    <span><span><img src="{{URL::to('/backend/')}}/img/icons/lock1.svg" alt=""> {{__('Remember the Password?')}}</span>
                        <a href="{{url('/admin')}}"> {{__('Login')}}</a>
                    </span>
                    <a href="{{url('/')}}"><span><img src="{{URL::to('/backend/')}}/img/icons/global.svg" alt=""></span>{{__('Front-End')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.includes.layout_js')
<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {


        });
    })(jQuery);

</script>
</body>

</html>

