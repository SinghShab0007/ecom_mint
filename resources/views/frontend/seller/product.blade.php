@extends('frontend.layouts.front')

@section('title','Seller Product')

@section('content')
<div class="multivendor-shop-bg">
    <div class="container">
        <div class="img-wrapper">
            <img src="{{ asset('uploads/sellers/'.$seller->banner) }}" alt="">
        </div>
    </div>
</div>
<!-- Shop List Start -->
<section class="shop-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="multivendors-filter">
                    <div class="follow">
                        <div class="img">
                            <img src="{{ asset('uploads/sellers/'.$seller->image) }}" alt="">
                        </div>
                        <div class="content">
                            <h5>{{ __($seller->company_name) }}</h5>
                            {{-- <a href="">{{ __('Follow +') }}</a> --}}
                        </div>
                    </div>
                    <div class="page-tabs">
                        <ul>
                            <li><a href="{{ url('/') }}">{{ __('Home Page') }}</a></li>
                            <li><a class="active" href="{{ route('seller.product',$seller->slug) }}">{{ __('All Products') }}</a></li>
                            <li><a href="{{ route('seller.profile',$seller->slug) }}">{{ __('Profile') }}</a></li>
                        </ul>
                    </div>
                    <div class="search-tabs">
                        {{-- <form >
                            <input type="text" class="form-control" placeholder="Search in Store...">
                        </form> --}}
                        <div class="nav multi-vendors-shop-tab">
                            <a class="" href="#ShopGrid" data-bs-toggle="tab">
                                <i class="fa-solid fa-table-cells"></i>
                            </a>
                            <a href="#ShopList" data-bs-toggle="tab" class="active">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="ShopGrid">
                        <div class="row auto-margin-3">
                            @foreach($products as $product)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <x-frontend.product-card4 :product="$product"></x-frontend.product-card4>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ShopList">
                        <div class="row auto-margin-3">
                            <div class="col-lg-12">
                                @foreach($products as $product)
                                    <x-frontend.product-card3 :product="$product"></x-frontend.product-card3>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <x-frontend.page-navigation :paginator="$products"></x-frontend.page-navigation>
            </div>
        </div>
    </div>
</section>
<!-- Shop List End -->
@stop
