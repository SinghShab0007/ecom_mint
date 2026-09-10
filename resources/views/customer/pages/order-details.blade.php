@extends('customer.layouts.master')

@section('content')
    <div class="container">
        <div class="maan-mybazar-order-details">
            <h3>{{ __('Order Details') }}</h3>
            <div class="maan-order-heading">
                <div class="order-side">
                    <h6>{{ __('Order') }} #{{ $order->order->order_no }}</h6>
                    <p>{{ __('Placed On') }} <span>{{ $order->created_at->format('d M Y') }}</span> <span>{{ $order->created_at->format('H:i:s') }}</span></p>
                </div>
                <div class="price-side">
                    <p>{{ __("Total") }}: <span>@if($order->coupon_discount>0)
                                {{ currency($order->grand_total-($order->coupon_discount??0),2) }}
                            @else
                                {{ currency($order->grand_total-($order->order->coupon_discount??0),2) }}
                            @endif
                            </span></p>
                </div>
            </div>
            <div class="mybazar-order-processing">
                <div class="processing-heading">
                    <div class="left-side">
                        <p>{{ __('Package 1') }}</p>
                        <span>{{ __('Sold by') }} <a href="">{{ $order->seller->company_name?? null }}</a></span>
                    </div>
                    {{-- <div class="right-side">
                        <a href="">{{ __('Chat Now') }}</a>
                    </div> --}}
                </div>
                <div class="mybazar-processing-body">
                    <div class="mybazar-delivery-title">
                        <p>{{ __('Estimated Delivery day') }} {{ $order->product->inside_shipping_days ?? null }}</p>
                        <span>{{ __('Standard') }}</span>
                    </div>
                    <div class="processing-timeline">
                        <ul class="mybazar-timeline">
                            @if($order->order_stat == 7)
                                <li class="active-tl"><span>{{ __('Processing') }}</span></li>
                                <li class="active-tl"><span>{{ __('Canceled') }}</span></li>
                            @else
                                <li class="active-tl" ><span>{{ __('Processing') }}</span></li>
                                <li class="{{ $order->order_stat >= 5 ? 'active-tl' : '' }}"><span>{{ __('Shipped') }}</span></li>
                                <li class="{{ $order->order_stat == 6 ? 'active-tl' : '' }}"><span>{{ __('Delivered') }}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="maan-timeline-tab-content">
                        <div class="timeline-content tab-active">
                            @foreach($order->timelines as $timeline)
                                <p>{{ date('d M Y - H:i', strtotime($timeline->order_stat_datetime)) }}<span>{{ $timeline->status->name }} - {{ $timeline->order_stat_desc }}</span></p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mybazar-product-items-wrp">
                    <div class="mybazar-product-items-with-details">
                        <div class="thumb">
                            <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}" alt="{{ $order->product->name }}">
                            <div class="text">
                                <p>{{ $order->product->name }}</p>
                                <p>
                                    @if($order->color!= null && $order->color!='undefined')
                                        <span class="badge bg-light text-dark">Color: {{ $order->color }}</span>
                                    @endif
                                    @if($order->size!= null && $order->size!='undefined')
                                        <span class="badge bg-light text-dark">Size: {{ $order->size }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="price">
                            <p>{{ currency($order->total_price,2) }}  @if ($order->order->coupon_discount)@if($order->coupon_discount>0)
                                    - {{ currency($order?->coupon_discount,2) }}
                                @else
                                    - {{ currency($order?->order?->coupon_discount,2) }}
                                @endif

                                @endif+ {{ $order->shipping_cost > 0 ? currency($order->total_shipping_cost,2) : 'Free' }} </p>
                        </div>
                        <div class="qty">
                            <p>{{ __('Qty') }}: {{ $order->qty }}</p>
                        </div>
                        @if($order->order_stat != 7 && $order->order_stat != 8)
                        <div class="btn-group">
                            <a class="btn btn-warning text-light" class="btn btn-dang" href="{{ route('order.order-status-change', ['order_id' => $order->id, 'status' => '8']) }}"><i class="fa-solid fa-arrow-rotate-left"></i> {{ __('Return') }}</a>
                            @if($order->order_stat < 6)
                            <a class="btn btn-danger text-light" href="{{ route('order.order-status-change', ['order_id' => $order->id, 'status' => '7']) }}"><i class="fa-solid fa-xmark"></i> {{ __('Cancel') }}</a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
