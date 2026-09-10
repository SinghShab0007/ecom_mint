@extends('frontend.layouts.front')

@section('title','BillMintMall')

@section('content')

    @include('frontend._banner')

   {{--  @include('frontend._notice') --}}

     @include('frontend._discount') 
    
   {{--  @include('frontend._categories') --}}
    
    @include('frontend._offer-count')

    {{-- @include('frontend._ad-poster') --}}

    {{-- Mixed "Deal of the week" grid replaced by the category sections below.
         Re-enable this include if you want the tabbed all-products view back. --}}
    {{-- @include('frontend._product-tab') --}}

    @include('frontend._products')

    @include('frontend._service')

     @include('frontend._brand-logo')

    {{-- Newsletter popup removed - it interrupted the landing experience.
         Re-add this include (and re-enable pageLoadModal() in js/index.js) to restore it. --}}

@stop
