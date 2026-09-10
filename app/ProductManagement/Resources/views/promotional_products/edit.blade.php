@extends('backend.layouts.app')
@section('title','Promotion Update - ')
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-product" aria-labelledby="add-product-tab">
                <div class="container content-title">
                    <h4>{{__('Promotion Information')}}</h4>
                </div>
                <div class="container">
                    <form class="add-brand-form" id="promo_productsForm" action="@auth('admin'){{route('backend.promotional_products.update',$promo_product->id)}}@elseauth('seller'){{route('seller.promotional_products.update',$promo_product->id)}}@endauth"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('productmanagement::promotional_products.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Update')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
