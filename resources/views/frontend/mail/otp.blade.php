<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName }} verification code</title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        Your {{ $appName }} verification code is {{ $otp }}. It expires in 10 minutes.
    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:560px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong>{{ $appName }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                @if(!empty($name))
                    <p style="margin:0 0 12px 0; font-size:15px;">Hi {{ $name }},</p>
                @endif

                <p style="margin:0 0 16px 0; font-size:15px; line-height:1.5;">
                    Thank you for signing up. To complete your registration, please use the verification code below.
                </p>

                <p style="margin:24px 0; font-size:28px; letter-spacing:6px; font-weight:bold; color:#222;">
                    {{ $otp }}
                </p>

                <p style="margin:0 0 16px 0; font-size:14px; color:#555;">
                    This code will expire in 10 minutes.
                </p>

                <p style="margin:0 0 0 0; font-size:13px; color:#888;">
                    If you did not create an account, you can safely ignore this email.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:16px 24px; border-top:1px solid #eaeaea; font-size:12px; color:#888;">
                Thanks,<br>
                The {{ $appName }} Team
            </td>
        </tr>
    </table>
</body>
</html>
