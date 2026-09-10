@extends('frontend.layouts.front')

@section('title',__('All Brands'))

@section('content')
    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('All Brands') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Brand Logo Start -->
    <section class="shop-list">
        <div class="container">
            <div class="row all-logos justify-content-center align-items-center">
                @foreach($brands as $brand)
                    <div class="col-lg-2 col-md-2 mb-3">
                        <div class="logo">
                            <a href="{{ route('frontend.brand',$brand->slug) }}">
                                <img src="{{ asset('uploads/brands/120x80') }}/{{ $brand->image }}" alt="{{ $brand->name }}" class="img-thumbnail">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Brand Logo End -->
@stop
