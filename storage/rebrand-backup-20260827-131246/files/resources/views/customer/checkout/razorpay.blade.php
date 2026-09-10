@extends('frontend.layouts.front')

@section('title','Payment')

@section('content')
    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Payment') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Login Form Start -->
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-lg-6">
                    <div class="login-form">
                        <h4>{{ __('Payment Details') }}</h4>
                        <form action="{{ route('customer.razorpay') }}" method="POST" >
                            @csrf
                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ $configurations->KEY_ID }}"
                                    data-amount="{{ Cookie::get('total') * 100 }}"
                                    data-currency="INR"
                                    data-buttontext="Pay Now"
                                    data-name="POROSKART"
                                    data-description="Rozerpay"
                                    data-image="https://my-bazar.maantheme.com/uploads/favicon.svg"
                                    data-prefill.name="name"
                                    data-prefill.email="email"
                                    data-theme.color="#4C1D6B">
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Form End -->

@stop

@section('script')

@stop
