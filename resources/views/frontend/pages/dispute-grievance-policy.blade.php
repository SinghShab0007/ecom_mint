@extends('frontend.layouts.front')

@section('title','Dispute & Grievance Policy')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dispute &amp; Grievance Policy</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    @include('frontend.pages.static.dispute-grievance-policy')

@stop
