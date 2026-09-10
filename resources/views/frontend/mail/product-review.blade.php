<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ __('New Product Review') }}</title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        {{ __('A new review from') }} {{ $options['user'] }}
    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:560px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <h2 style="margin:0 0 16px 0; font-size:20px; color:#222;">{{ __('New Product Review') }}</h2>

                <p style="margin:0 0 8px 0; font-size:15px;">
                    {{ __('From') }}: <strong>{{ $options['user'] }}</strong>
                    <span style="color:#888;">({{ $options['email'] }})</span>
                </p>

                <p style="margin:0 0 16px 0; font-size:18px; letter-spacing:2px;">
                    @for ($i = 0; $i < $options['review_point']; $i++)⭐@endfor
                </p>

                <div style="background:#fafafa; border-left:3px solid #4C1D6B; padding:14px 18px; margin:0 0 24px 0; font-size:14px; line-height:1.6; color:#333;">
                    {{ $options['review_note'] }}
                </div>

                <table cellpadding="0" cellspacing="0" border="0" style="margin:0;">
                    <tr>
                        <td style="background:#4C1D6B; border-radius:4px;">
                            <a target="_blank" href="{{ $options['link'] }}"
                               style="display:inline-block; padding:12px 28px; color:#ffffff; font-size:15px; font-weight:600; text-decoration:none;">
                                {{ __('View Review') }}
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="margin:24px 0 0 0; font-size:14px;">
                    {{ __('Regards') }},<br>
                    {{ config('app.name') }}
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:12px 24px; border-top:1px solid #eaeaea; text-align:center; font-size:12px; color:#888;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved') }}.
            </td>
        </tr>
    </table>
</body>
</html>
