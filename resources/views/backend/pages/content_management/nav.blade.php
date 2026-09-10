<div class="content-tab-title">
    <h4>{{__('Content Management')}}</h4>
</div>
<!-- Tab Manu Start  -->
<div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
    @php
        $banner_index_route = auth('seller')->user() ? route('seller.banners.index') : route('backend.banners.index');
        $product_review_index_route = auth('seller')->user() ? route('seller.product_review.index') : route('backend.product_review.index');
    @endphp
    @if(auth()->user()->can('browse_banners') || auth()->user()->hasRole('super-admin'))
        <button class="nav-link @if(Request::is('admin/banners'))active @endif" id="banner-tab" data-bs-toggle="tab"
                data-bs-target="#banner" type="button"
                role="tab" aria-controls="banner" aria-selected="true"
                @if(url()->full()!=$banner_index_route) onclick="location.href='{{$banner_index_route}}'" @endif
        >{{__('Banner')}}
        </button>
    @endif
    @if(auth()->user()->can('browse_product_review') || auth()->user()->hasRole('super-admin'))
        <button class="nav-link @if(Request::is('admin/product_review'))active @endif" id="product-review-tab"
                data-bs-toggle="tab"
                data-bs-target="#product-review" type="button" role="tab" aria-controls="product-review"
                aria-selected="true"
                @if(url()->full()!=$product_review_index_route) onclick="location.href='{{$product_review_index_route}}'" @endif
        >{{__('Product Review')}}
        </button>
    @endif
</div>
