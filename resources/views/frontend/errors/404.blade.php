@extends('frontend.layouts.front')

@section('title','404 | Not Found')

@section('content')
    <section class="maan-error-section">
        <div class="container">
            <div class="maan-error-wrapper">
                <img src="{{ asset('frontend/img/additional-page/error.png') }}" alt="">
                <div class="error-content">
                    <h2>{{ __('error 404') }}</h2>
                    <p>{{ __('page not found') }}</p>
                </div>
                <a class="link-anime" href="{{ url('/') }}">{{ __('Back to Home') }}</a>
            </div>
        </div>
    </section>
@stop
