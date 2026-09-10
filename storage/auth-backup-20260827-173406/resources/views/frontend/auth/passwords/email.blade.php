@extends('frontend.layouts.auth')

@section('title','Email Password Link')

@section('content')
    <h2>{{ __('Reset Your Password') }}</h2>
    <form action="{{ route('customer.password.send') }}" method="post" >
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@domain.com">
            @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
        </div>
        <button type="submit" class="btn login-btn">{{ __('Send Verification Code') }}</button>
    </form>
    <div class="login-footer">
        <a href="{{ route('customer.register') }}"><span><img src="{{ asset('customer/img/icons/user.svg') }}" alt=""></span>{{ __('Create New Account')}}</a>
        <a href="{{ route('customer.login') }}"><span><img src="{{ asset('customer/img/icons/lock1.svg') }}" alt=""></span>{{ __('Login Here') }}</a>
    </div>
@stop
