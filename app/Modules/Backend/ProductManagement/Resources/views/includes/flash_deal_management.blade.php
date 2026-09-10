<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Product Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        @php
            $product_index_route = auth('seller')->user() ? route('seller.products.flash-deal') : route('backend.products.flash-deal');

        @endphp
        @if(auth()->user()->can('browse_products') || auth()->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/flash-deal','seller/flash-deal'))active @endif"
                    id="all-product-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#all-product"
                    type="button" role="tab" aria-controls="all-product" aria-selected="true"
                    @if(url()->full()!=$product_index_route) onclick="location.href='{{$product_index_route}}'" @endif>
                {{__('Flash Deal')}}
            </button>
        @endif

    </div>
    <!-- Tab Manu End -->
</div>
