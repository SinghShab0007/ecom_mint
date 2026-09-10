<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ __('Password Reset') }}</title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        {{ __('Reset your :app password. This link expires in 60 minutes.', ['app' => config('app.name')]) }}
    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:560px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <h2 style="margin:0 0 16px 0; font-size:20px; color:#222;">{{ __('Reset your password') }}</h2>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    {{ __('You are receiving this email because we received a password reset request for your account.') }}
                </p>

                <p style="margin:0 0 8px 0; font-size:14px; color:#555;">{{ __('Your verification code is:') }}</p>
                <p style="margin:0 0 24px 0; font-size:24px; letter-spacing:4px; font-weight:bold; color:#222;">
                    {{ $data['code'] }}
                </p>

                <p style="margin:0 0 20px 0; font-size:15px; line-height:1.5;">
                    {{ __('Click the button below to reset your password:') }}
                </p>

                <table cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0;">
                    <tr>
                        <td style="background:#4C1D6B; border-radius:4px;">
                            <a href="{{ url($data['url']) }}"
                               style="display:inline-block; padding:12px 28px; color:#ffffff; font-size:15px; font-weight:600; text-decoration:none;">
                                {{ __('Reset Password') }}
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="margin:0 0 14px 0; font-size:14px; color:#555;">
                    {{ __('This password reset link will expire in 60 minutes.') }}
                </p>

                <p style="margin:0 0 20px 0; font-size:13px; color:#888;">
                    {{ __('If you did not request a password reset, no further action is required.') }}
                </p>

                <p style="margin:0; font-size:14px;">
                    {{ __('Regards') }},<br>
                    {{ config('app.name') }}
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:16px 24px; border-top:1px solid #eaeaea; font-size:12px; color:#888; word-break:break-all;">
                <p style="margin:0 0 8px 0;">
                    {{ __('If you are having trouble clicking the button, copy and paste the URL below into your web browser:') }}
                </p>
                <a href="{{ url($data['url']) }}" style="color:#4C1D6B; text-decoration:none;">{{ $data['url'] }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding:12px 24px; text-align:center; font-size:12px; color:#888;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved') }}.
            </td>
        </tr>
    </table>
</body>
</html>
