<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name', 'Mybazar')}} {{__('Forgot Password')}}">
    <meta name="description" content="{{ config('app.name', 'Mybazar')}} {{__('Forgot Password')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Mybazar')}} - {{__('Forgot Password')}}</title>

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
                <h2 class="m-0">{{ __('Forgot Password?') }}</h2>
                <p>{{ __('Please enter your email address. You will receive a link to create a new password via email.') }}</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form method="POST" action="{{ route('backend.password.email') }}">
                    @csrf
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend/')}}/img/icons/mail.svg" alt=""></span>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Your email Address">
                        @error('email')
                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn login-btn">
                        {{ __('Submit') }}
                    </button>
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
