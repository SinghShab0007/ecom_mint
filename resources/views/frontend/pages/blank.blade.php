@extends('frontend.layouts.front')

@section('title',$page->title ?? 'Page Title')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title ?? __('Page Title') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    <section class="shop-list">
        <div class="container">
            <h2 class="text-center mb-5">{{ $page->title ?? __('Page Title') }}</h2>
            {!! $page->description ?? __('No content found') !!}
        </div>
    </section>

@stop

