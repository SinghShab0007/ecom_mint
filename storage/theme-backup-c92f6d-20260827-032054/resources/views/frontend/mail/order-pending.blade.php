<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ __('Order Confirmation') }}</title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        {{ __('Order') }} #{{ $data['order_no'] }} - {{ currency($data['subTotal'],2) }}
    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <h2 style="margin:0 0 16px 0; font-size:20px; color:#222;">{{ __('Order Placed') }}</h2>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    {{ __('Thank you') }} {{ $data['name'] }},
                </p>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    {{ __('Your order has been placed successfully. Please confirm the order for fast shipment.') }}
                </p>

                <p style="margin:0 0 20px 0; font-size:15px; line-height:1.5;">
                    {{ __('Order number:') }} <strong>#{{ $data['order_no'] }}</strong><br>
                    {{ __('Subtotal:') }} {{ currency($data['subTotal'],2) }}<br>
                    @if(!empty($data['shippingCost']))
                        {{ __('Shipping:') }} {{ currency($data['shippingCost'],2) }}<br>
                    @endif
                    @if(!empty($data['couponDiscount']))
                        {{ __('Coupon Discount:') }} -{{ currency($data['couponDiscount'],2) }}<br>
                    @endif
                    @if(isset($data['grandTotal']))
                        {{ __('Total:') }} <strong style="color:#c92f6d;">{{ currency($data['grandTotal'],2) }}</strong><br>
                    @endif
                    @if(!empty($data['paymentBy']))
                        {{ __('Payment Method:') }} <strong>{{ $data['paymentBy'] }}</strong>
                        @if(!empty($data['paymentStatus']))
                            ({{ ucfirst($data['paymentStatus']) }})
                        @endif
                    @endif
                </p>

                @if(!empty($data['billing']) || !empty($data['shipping']))
                    <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; margin:0 0 16px 0;">
                        <tr>
                            @if(!empty($data['billing']))
                                <td valign="top" style="width:50%; padding:12px; border:1px solid #eaeaea; font-size:13px; line-height:1.6;">
                                    <strong style="display:block; margin-bottom:6px; color:#222;">{{ __('Billing Address') }}</strong>
                                    {{ $data['name'] }}<br>
                                    @if(!empty($data['mobile'])){{ $data['mobile'] }}<br>@endif
                                    {{ $data['billing']['address_1'] ?? '' }}<br>
                                    @if(!empty($data['billing']['address_2'])){{ $data['billing']['address_2'] }}<br>@endif
                                    {{ $data['billing']['city'] ?? '' }}@if(!empty($data['billing']['district'])), {{ $data['billing']['district'] }}@endif<br>
                                    {{ $data['billing']['state'] ?? '' }} - {{ $data['billing']['pincode'] ?? '' }}<br>
                                    {{ $data['billing']['country'] ?? 'India' }}
                                </td>
                            @endif
                            @if(!empty($data['shipping']))
                                <td valign="top" style="width:50%; padding:12px; border:1px solid #eaeaea; font-size:13px; line-height:1.6;">
                                    <strong style="display:block; margin-bottom:6px; color:#222;">{{ __('Shipping Address') }}</strong>
                                    {{ $data['name'] }}<br>
                                    @if(!empty($data['mobile'])){{ $data['mobile'] }}<br>@endif
                                    {{ $data['shipping']['address_1'] ?? '' }}<br>
                                    @if(!empty($data['shipping']['address_2'])){{ $data['shipping']['address_2'] }}<br>@endif
                                    {{ $data['shipping']['city'] ?? '' }}@if(!empty($data['shipping']['district'])), {{ $data['shipping']['district'] }}@endif<br>
                                    {{ $data['shipping']['state'] ?? '' }} - {{ $data['shipping']['pincode'] ?? '' }}<br>
                                    {{ $data['shipping']['country'] ?? 'India' }}
                                </td>
                            @endif
                        </tr>
                    </table>
                @endif

                <h3 style="margin:24px 0 12px 0; font-size:16px; color:#222;">{{ __('Order Items') }}</h3>

                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; border:1px solid #eaeaea;">
                    @if($data['cart'])
                        @foreach($data['cart'] as $item)
                            <tr>
                                <td style="padding:10px; border-bottom:1px solid #f0f0f0; width:130px;">
                                    <img src="{{ $message->embed('uploads/products/galleries/'.CartItem::thumbnail($item->id)) }}" alt="" width="120" style="display:block; border-radius:4px;">
                                </td>
                                <td style="padding:10px; font-size:14px; line-height:1.6; border-bottom:1px solid #f0f0f0;">
                                    <strong>{{ CartItem::name($item->id) }}</strong><br>
                                    <span style="color:#666;">{{ __('Price') }}:</span> {{ currency(CartItem::price($item->id),2) }}<br>
                                    <span style="color:#666;">{{ __('Quantity') }}:</span> {{ $item->quantity }}<br>
                                    <span style="color:#666;">{{ __('Total') }}:</span> <strong>{{ currency(CartItem::price($item->id,$item->quantity),2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
