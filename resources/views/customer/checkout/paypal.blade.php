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
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Form End -->

@stop

@section('script')
    <script

        src="https://www.paypal.com/sdk/js?client-id={{ $configurations->CLIENT_ID }}"> // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.

    </script>

    <script>
        "use strict";

        paypal.Buttons({

            createOrder: function() {
                return fetch('{{ route('customer.paypal') }}', {
                    method: 'post',
                    body: JSON.stringify({_token:"{{@csrf_token()}}"}),
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    return data[0].result.id; // Use the key sent by your server's response, ex. 'id' or 'token'
                });
            },

            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    fetch('{{ route('customer.paypal-order') }}',{
                        method: 'post',
                        body: JSON.stringify({_token:"{{@csrf_token()}}"}),
                        headers: {
                            'content-type': 'application/json'
                        }
                    }).then(function(){
                        // alert('payment success');
                        window.location.replace("{{ url('payment-success') }}")
                    });
                    //window.location.replace("{{ url('payment-success') }}");
                    //alert('Transaction completed by ' + details.payer.name.given_name);
                });
            }

        }).render('#paypal-button-container');

    </script>
@stop
