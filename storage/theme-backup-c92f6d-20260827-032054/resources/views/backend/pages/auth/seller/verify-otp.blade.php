<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name')}}">
    <meta name="description" content="{{ config('app.name')}} email verification">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'POROSKART')}} {{__('Verify Email')}}</title>

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
                <h2>{{__('Verify Your Email')}}</h2>

                @if(session('status'))
                    <div style="background:#e8f6ec; color:#2a7a3b; padding:10px 14px; border-radius:6px; margin-bottom:14px;">
                        {{ session('status') }}
                    </div>
                @endif

                <p style="margin-bottom:18px; color:#555; font-size:14px;">
                    {{ __('We sent a 6-digit OTP to') }} <strong>{{ $email ?? '' }}</strong>.
                    {{ __('Enter it below to verify your account.') }}
                </p>

                <form action="{{ route('seller.verification.verify') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend')}}/img/icons/Lock.svg" alt=""></span>
                        <input id="otp"
                               type="text"
                               name="otp"
                               class="form-control @error('otp') is-invalid @enderror"
                               placeholder="{{ __('Enter 6-digit OTP') }}"
                               maxlength="6"
                               inputmode="numeric"
                               pattern="[0-9]{6}"
                               autofocus
                               required>
                        @error('otp')
                            <label class="error" for="otp">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn login-btn">{{__('Verify Email')}}</button>
                </form>

                <form action="{{ route('seller.verification.resend') }}" method="post" style="margin-top:14px;">
                    @csrf
                    <div class="login-footer" style="justify-content:center;">
                        <button type="submit" style="background:none; border:none; color:#c92f6d; cursor:pointer; padding:0; font-weight:600;">
                            {{ __('Resend OTP') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('backend.includes.layout_js')
</body>

</html>
