@extends('frontend.layouts.front')

@section('title','Cancellation Policy')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cancellation Policy</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    @include('frontend.pages.static.cancellation-policy')

@stop

