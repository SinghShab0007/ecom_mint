@extends('customer.layouts.master')

@section('content')
    <!-- invoice start  -->
    <div class="maan-mybazar-invoice">
        <div class="my-bazar-invoice-header">
            <a href="" class="logo"><img src="{{ asset('uploads/logo.png') }}" alt="logo"></a>
            <div class="customer-detail">
                <p><b>{{ maanAppearance('get_in_touch') }}</b></p>
                <p>{{ maanAppearance('city') }}, {{ maanAppearance('country') }}</p>
                <p>{{ maanAppearance('hotline_number') }}</p>
                <p>{{ maanAppearance('email') }}</p>
            </div>
        </div>
        <div class="mybazar-billing-info">
            <div class="row-billing-wrp">
                <div class="col-billing-items">
                    <div class="billing-info">
                        <h4>{{ __('Billing Address') }}</h4>
                        <ul>
                            <li><span>{{ __('Name') }}:</span> {{ $order->user_first_name }} {{ $order->user_last_name }}</li>
                            <li><span>{{ __('Address') }}:</span> {{ $order->user_address_1 }}</li>
                            <li><span>{{ __('Phone') }} :</span> {{ $order->user_mobile }}</li>
                            <li><span>{{ __('Email') }}:</span> {{ $order->user_email }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-billing-items">
                    <div class="billing-info">
                        <h4>{{ __('Shipping Address') }}</h4>
                        <ul>
                            <li><span>{{ __('Name') }}:</span> {{ $order->shipping_name ?? '' }}</li>
                            <li><span>{{ __('Address') }}:</span> {{ $order->user_address_1 ?? '' }}</li>
                            <li><span>{{ __('Phone') }} :</span> {{ $order->shipping_mobile ?? '' }}</li>
                            <li><span>{{ __('Email') }}:</span> {{ $order->shipping_email ?? '' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <h5><span>{{ __('Invoice No') }}: </span>{{ $order->order_no }}</h5>
            <h5><span>{{ __('Invoice Date') }}: </span>{{ $order->created_at->format('M dS Y') }}</h5>
            <h5><span>{{ __('Sold By') }}: </span>{{ maanAppearance('meta_title') }}</h5>
        </div>
        <div class="mybazar-product-info-billing">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{ __('Item') }}</th>
                    <th scope="col">{{ __('QTY') }}</th>
                    <th scope="col">{{ __('Rate') }}</th>
                    <th scope="col">{{ __('Subtotal') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td scope="row">
                            {{ $item->product->name }}
                            @if($item->color)
                                <span class="badge bg-light text-dark">Color: {{ $item->color }}</span>
                            @endif
                            @if($item->size)
                                <span class="badge bg-light text-dark">Size: {{ $item->size }}</span>
                            @endif
                            <p class="small fst-italic">
                                {{ __('Shipping') }}:
                                @if($item->total_shipping_cost > 0)
                                    {{ orderCurrency($item->currency_id,$item->total_shipping_cost,2) }}
                                @else
                                    {{ __('Free') }}
                                @endif
                            </p>
                        </td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ orderCurrency($item->currency_id,$item->sale_price,2) }}</td>
                        <td>{{ orderCurrency($item->currency_id,$item->total_price,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mybazar-total-info">
            <ul>
                <li>{{ __('Item(s) Subtotal') }}:<span>{{ orderCurrency($order->currency_id,$order->total_price,2) }}</span></li>
                <li>{{ __('Shipping & Handling') }}:
                    <span>
                        @if($order->shipping_cost > 0)
                            {{ orderCurrency($order->currency_id,$order->shipping_cost,2) }}
                        @else
                            {{ __('Free') }}
                        @endif
                    </span>
                </li>
                <li>------------------------------------------------------------------------</li>
                <li>{{ __('SubTotal') }}:<span>{{ orderCurrency($order->currency_id,($order->total_price + $order->shipping_cost),2) }}</span></li>
                <li>------------------------------------------------------------------------</li>
                <li>{{ __('Total') }}:<span>{{ orderCurrency($order->currency_id,($order->total_price + $order->shipping_cost),2) }}</span></li>
            </ul>
        </div>
        <div class="signature">
            <p>{{ __('signature') }}</p>
        </div>
    </div>
    <!-- invoice end  -->
@stop
