@extends('frontend.layouts.front')

@section('title','Credit Card')

@section('content')

    <!-- Login Form Start -->
    <section class="login mybazar-paymentstatus-wrp">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-lg-6 text-center">
                    <h3 class="text-warning">
                    <span>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 125.668 125.668" style="enable-background:new 0 0 125.668 125.668;" xml:space="preserve">
                            <path d="M84.17,76.55l-16.9-9.557V32.102c0-2.541-2.061-4.601-4.602-4.601s-4.601,2.061-4.601,4.601v37.575   c0,0.059,0.016,0.115,0.017,0.174c0.006,0.162,0.025,0.319,0.048,0.479c0.021,0.146,0.042,0.291,0.076,0.433   c0.035,0.141,0.082,0.277,0.129,0.414c0.051,0.146,0.1,0.287,0.164,0.426c0.061,0.133,0.134,0.257,0.208,0.383   c0.075,0.127,0.148,0.254,0.234,0.374c0.088,0.122,0.188,0.235,0.288,0.349c0.097,0.11,0.192,0.217,0.299,0.317   c0.107,0.101,0.222,0.19,0.339,0.28c0.126,0.098,0.253,0.191,0.39,0.276c0.052,0.031,0.092,0.073,0.145,0.102L79.64,84.562   c0.716,0.404,1.493,0.597,2.261,0.597c1.605,0,3.163-0.841,4.009-2.337C87.161,80.608,86.381,77.801,84.17,76.55z"/>
                            <path d="M62.834,0C28.187,0,0,28.187,0,62.834c0,34.646,28.187,62.834,62.834,62.834c34.646,0,62.834-28.188,62.834-62.834   C125.668,28.187,97.48,0,62.834,0z M66.834,115.501v-9.167h-8v9.167c-24.77-1.865-44.823-20.872-48.292-45.167h9.459v-8h-9.988   c0.258-27.558,21.716-50.126,48.821-52.167v9.167h8v-9.167c27.104,2.041,48.563,24.609,48.821,52.167h-9.487v8h8.958   C111.657,94.629,91.605,113.636,66.834,115.501z"/>
                        </svg>
                    </span>
                    {{ __('Thank you for your purchase') }}</h3>
                    <p class="h5">{{ __('Your order no is') }} <b>{{ $order->order_id }}</b></p>
                    <p class="mt-5">{{ __('Please have the amount ready on delivery day') }}</p>
                    <h3 class="text-warning">{{ currency($total,2) }}</h3>
                    <h4>{{ __('Shopping List') }}</h4>
                    <table class="mt-5 table table-bordered">
                        @foreach($cart as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('uploads/products/galleries') }}/{{ $item->image }}" class="b-1" height="75" alt="{{ $item->name }}">
                                    <br>
                                    {{ $item->name }}
                                </td>
                                <td>{{ __('Estimated shipping') }} {{ $item->inside_shipping_days }}</td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="mybazar-payment-delivery-date-link">
                        <p>{{ __('For More Details, Track Your Delivery Status Under') }} <span>{{ __('My Account') }} > {{ __('Order') }}</span> <a href="{{ route('customer.order') }}">{{ __('View Order')}}</a></p>
                    </div>
                    <p class="my-5">{{ __('We have sent you an email at ') }}{{ auth('customer')->user()->email }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Product Start -->
    <section class="similar-product">
        <div class="container">
            <div class="title-center">
                <h4>{{ __('Similar Products') }}</h4>
                <p>{{ __('People who purchased your item also ordered these.') }}</p>
            </div>
            <div class="row auto-margin-3">
                @foreach($similarProducts as $product)
                    <div class="col-sm-6 col-lg">
                        <x-frontend.product-card :product="$product"></x-frontend.product-card>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Similar Product End -->
@stop
