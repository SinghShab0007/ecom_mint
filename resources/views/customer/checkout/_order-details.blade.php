<li>{{ __('Subtotal') }}<span class="sub-total">{{ currency($subTotal,2) }}</span></li>
<li>{{ __('Shipping Charge') }} @if( request('area') == 'inside'){{ __('(inside India)') }}
    @else {{ __('(outside India)') }} @endif
    @if($totalShipping == 0)
        <span>{{ __('Free') }}</span>
    @else
        <span>{{ currency($totalShipping,2) }}</span>
    @endif
</li>
@isset($discount)
<li>{{ __('Coupon') }}<span>{{ currency($discount ?? 0, 2) }} </span></li>
@endisset
<li>{{ __('Total') }}<span class="total">{{ currency($total,2) }}</span></li>
