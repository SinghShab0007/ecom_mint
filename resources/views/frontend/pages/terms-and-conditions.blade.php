@extends('frontend.layouts.front')

@section('title','Terms and Conditions')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms and Conditions</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    @include('frontend.pages.static.terms-and-conditions')

@stop

