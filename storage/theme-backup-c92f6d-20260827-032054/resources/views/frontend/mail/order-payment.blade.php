<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ __('Payment Received') }}</title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        {{ __('Payment received for order') }} #{{ $data['order_no'] }}
    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <h2 style="margin:0 0 16px 0; font-size:20px; color:#222;">{{ __('Payment Received') }}</h2>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    {{ __('Thank you for your payment.') }}
                </p>

                <p style="margin:0 0 20px 0; font-size:15px; line-height:1.5;">
                    {{ __('We have received') }} <strong>{{ currency($data['subTotal'],2) }}</strong>
                    {{ __('for order') }} <strong>#{{ $data['order_no'] }}</strong>.
                </p>

                <h3 style="margin:24px 0 12px 0; font-size:16px; color:#222;">{{ __('Order Items') }}</h3>

                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; border:1px solid #eaeaea;">
                    <thead>
                        <tr style="background:#fafafa;">
                            <th align="left" style="padding:10px; font-size:13px; color:#555; border-bottom:1px solid #eaeaea;">{{ __('Item') }}</th>
                            <th align="right" style="padding:10px; font-size:13px; color:#555; border-bottom:1px solid #eaeaea;">{{ __('Qty') }}</th>
                            <th align="right" style="padding:10px; font-size:13px; color:#555; border-bottom:1px solid #eaeaea;">{{ __('Price') }}</th>
                            <th align="right" style="padding:10px; font-size:13px; color:#555; border-bottom:1px solid #eaeaea;">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['cart'] as $item)
                            <tr>
                                <td style="padding:10px; font-size:14px; border-bottom:1px solid #f0f0f0;">{{ $item->name }}</td>
                                <td align="right" style="padding:10px; font-size:14px; border-bottom:1px solid #f0f0f0;">{{ $item->quantity }}</td>
                                <td align="right" style="padding:10px; font-size:14px; border-bottom:1px solid #f0f0f0;">{{ currency($item->price,2) }}</td>
                                <td align="right" style="padding:10px; font-size:14px; border-bottom:1px solid #f0f0f0;">{{ currency($item->total,2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" align="right" style="padding:12px 10px; font-size:14px; font-weight:bold;">{{ __('Total Paid') }}</td>
                            <td align="right" style="padding:12px 10px; font-size:14px; font-weight:bold; color:#c92f6d;">{{ currency($data['subTotal'],2) }}</td>
                        </tr>
                    </tbody>
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
