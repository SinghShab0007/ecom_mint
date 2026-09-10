@extends('frontend.layouts.auth')

@section('title','Verify Email')

@section('content')
    <h2>{{ __('Verify Your Email') }}</h2>

    <p style="margin-bottom:18px; color:#555;">
        {{ __('We sent a 6-digit OTP to') }} <strong>{{ $email ?? '' }}</strong>.
        {{ __('Enter it below to verify your account.') }}
    </p>

    <form action="{{ route('customer.verification.verify') }}" method="post">
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <input type="text"
                   name="otp"
                   class="form-control"
                   placeholder="{{ __('Enter 6-digit OTP') }}"
                   maxlength="6"
                   inputmode="numeric"
                   pattern="[0-9]{6}"
                   autofocus
                   required>
            @if($errors->has('otp')) <p>{{ $errors->first('otp') }}</p> @endif
        </div>
        <button type="submit" class="btn">{{ __('Verify Email') }}</button>
    </form>

    <form action="{{ route('customer.verification.resend') }}" method="post" style="margin-top:14px;">
        @csrf
        <p style="text-align:center; color:#666;">
            {{ __("Didn't receive the code?") }}
            <button type="submit" style="background:none; border:none; color:#4C1D6B; cursor:pointer; padding:0; font-weight:600;">
                {{ __('Resend OTP') }}
            </button>
        </p>
    </form>
@endsection
