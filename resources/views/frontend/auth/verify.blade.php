@extends('frontend.layouts.front')

@section('title','Customer Login')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Login') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Login Form Start -->
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-lg-6">
                    <div class="login-form text-center" >
                        <h4>{{ __('Thank you for Your registration.') }}</h4>
                        <p> {{ __('Your email '. auth('customer')->user()->email .' is not verified. Check you mail for email verification.') }}</p>
                        <p><a href="{{ route('verification.email.resend') }}">{{ __('Resend verification email.') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Form End -->

@stop
