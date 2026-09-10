@extends('frontend.layouts.auth')

@section('title','Customer Login')

@section('content')
    <h2>{{ __('Welcome to POROSKART Please Login') }}</h2>
    <form action="{{ route('customer.login') }}" method="post" autocomplete="off">
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
            <input type="text" name="username" class="form-control" placeholder="User Name/E-mail" autocomplete="off">
            @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
        @if($errors->has('username')) <p>{{ $errors->first('username') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <span class="hide-pass">
                            <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                            <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
                        </span>
            <input type="password" id="myPass" name="password" class="form-control" placeholder="Password" autocomplete="new-password">
            @if($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
            @if($errors->has('current_password')) <p>{{ $errors->first('current_password') }}</p> @endif
        </div>
        <button type="submit" class="btn login-btn">{{ __('Login') }}</button>
    </form>
    <div class="login-footer">
        <a href="{{ route('customer.register') }}"><span><img src="{{ asset('customer/img/icons/user.svg') }}" alt=""></span>{{ __('Create Your Account')}}</a>
        <a href="{{ route('customer.password.email') }}"><span><img src="{{ asset('customer/img/icons/lock1.svg') }}" alt=""></span>{{ __('Forgot Password?') }}</a>
    </div>
@stop


@push('script')
    <script>
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

