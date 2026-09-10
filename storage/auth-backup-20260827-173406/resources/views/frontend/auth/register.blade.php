@extends('frontend.layouts.auth')

@section('title','Create New Account')

@section('content')
    <h2>{{ __('Create Your Account') }}</h2>
    <form action="{{ route('customer.register') }}" method="post">
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/User.svg') }}" alt=""></span>
            <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" placeholder="{{ __('Full name') }}" required autocomplete="name">
            @if($errors->has('full_name')) <p>{{ $errors->first('full_name') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Call.svg') }}" alt=""></span>
            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="{{ __('10-digit mobile number') }}" required inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" autocomplete="tel">
            @if($errors->has('mobile')) <p>{{ $errors->first('mobile') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{ __('Email') }}" required autocomplete="email">
            @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <span class="hide-pass">
                <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
            </span>
            <input type="password" id="myPass" name="password" class="form-control" placeholder="{{ __('Password') }}" required autocomplete="new-password" minlength="8">
            @if($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <span class="hide-pas">
                <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
            </span>
            <input type="password" id="myPas" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm password') }}" required autocomplete="new-password" minlength="8">
        </div>
        <button type="submit" class="btn login-btn">{{ __('Verify Your Mail') }}</button>
        <p style="text-align:center;color:#777;font-size:13px;margin-top:10px;">
            {{ __('We will email you a 6-digit OTP to verify your address.') }}
        </p>
    </form>
    <div class="login-footer">
        <a href="{{ route('customer.login') }}"><span><img src="{{ asset('customer/img/icons/user.svg') }}" alt=""></span>{{ __('Go to login')}}</a>
        <a href="{{ route('customer.password.email') }}"><span><img src="{{ asset('customer/img/icons/lock1.svg') }}" alt=""></span>{{ __('Forgot Password?') }}</a>
    </div>
@stop

@push('script')
    <script>
        // Mobile: digits only, capped at 10.
        var mobileInput = document.getElementById('mobile');
        if (mobileInput) {
            mobileInput.addEventListener('input', function () {
                var digits = mobileInput.value.replace(/\D/g, '').slice(0, 10);
                if (mobileInput.value !== digits) { mobileInput.value = digits; }
            });
        }

        let showPass1 = document.querySelector('.hide-pas');
        if (showPass1) {
            showPass1.addEventListener('click', function() {
                showPass1.classList.toggle("show-pass");
                var y = document.getElementById("myPas");
                if (y && y.type === "password") {
                    y.type = "text";
                } else if (y) {
                    y.type = "password";
                }
            });
        }

        let showPass = document.querySelector('.hide-pass');
        if (showPass) {
            showPass.addEventListener('click', function() {
                showPass.classList.toggle("show-pass");
                var x = document.getElementById("myPass");
                if (x && x.type === "password") {
                    x.type = "text";
                } else if (x) {
                    x.type = "password";
                }
            });
        }
    </script>
@endpush
