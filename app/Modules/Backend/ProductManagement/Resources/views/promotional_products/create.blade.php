@extends('backend.layouts.app')
@section('title','Promotion - ')
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.promotion_nav')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-product" aria-labelledby="add-product-tab">
                <div class="container content-title">
                    <h4>{{__('Promotion Information')}}</h4>
                </div>
                <div class="container">
                <form class="add-brand-form" id="promo_productsForm"  action="@auth('admin'){{route('backend.promotional_products.store')}}@elseauth('seller'){{route('seller.promotional_products.store')}}@endauth" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('productmanagement::promotional_products.form')
                    <div class="col-lg-7 offset-3">
                        <div class="from-submit-btn">
                            <button class="submit-btn" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection
