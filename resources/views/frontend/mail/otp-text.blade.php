{{ $appName }} - Email Verification

@if(!empty($name))Hi {{ $name }},
@endif
Thank you for signing up. To complete your registration, please use the verification code below:

Verification code: {{ $otp }}

This code will expire in 10 minutes.

If you did not create an account, you can safely ignore this email.

Thanks,
The {{ $appName }} Team
