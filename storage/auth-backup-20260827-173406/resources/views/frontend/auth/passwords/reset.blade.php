@extends('frontend.layouts.auth')

@section('title','Reset Password Link')

@section('content')
    <h2>{{ __('Reset Your Password') }}</h2>
    <form action="{{ route('customer.reset') }}" method="post" >
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
            <input type="email" name="email" value="{{ old('email', session('reset_email')) }}" class="form-control" placeholder="example@domain.com" required>
            @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/pin-2.png') }}" alt=""></span>
            <input type="text" name="verification_code" value="{{ old('verification_code') }}" class="form-control" placeholder="Verification Code">
            <p class="text-danger">@if($errors->has('verification_code')) {{ $errors->first('verification_code') }} @endif</p>
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
        <a href="{{ route('customer.register') }}"><span><img src="{{ asset('customer/img/icons/user.svg') }}" alt=""></span>{{ __('Create New Account')}}</a>
        <a href="{{ route('customer.login') }}"><span><img src="{{ asset('customer/img/icons/lock1.svg') }}" alt=""></span>{{ __('Login Here') }}</a>
    </div>
@stop


@push('script')
    <script>
        let showPass1 = document.querySelector('.hide-pas');
        showPass1.addEventListener('click', function() {
            showPass1.classList.toggle("show-pass");
            var y = document.getElementById("myPas");
            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        })

        let showPass = document.querySelector('.hide-pass');
        showPass.addEventListener('click', function() {
            showPass.classList.toggle("show-pass");
            var x = document.getElementById("myPass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })
    </script>
@endpush

