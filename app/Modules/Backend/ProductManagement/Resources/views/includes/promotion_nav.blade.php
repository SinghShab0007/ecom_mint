<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Promotion Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        @php
            $promotions_index_route = auth('seller')->user() ? route('seller.promotional_products.index') : route('backend.promotional_products.index');
            $promotions_create_route = auth('seller')->user() ? route('seller.promotional_products.create') : route('backend.promotional_products.create');
        @endphp
        @if(auth()->user()->can('browse_promotional_products') || auth()->user()->hasRole('super-admin'))
        <button class="nav-link @if(Request::is('admin/promotional_products','seller/promotional_products'))active @endif" id="all-product-tab" data-bs-toggle="tab"
                data-bs-target="#all-product"
                type="button" role="tab" aria-controls="all-product" aria-selected="true"
                @if(url()->full()!=$promotions_index_route) onclick="location.href='{{$promotions_index_route}}'" @endif>
            {{__('All Promotion')}}
        </button>
        @endif
        @if(auth()->user()->can('create_promotional_products') || auth()->user()->hasRole('super-admin'))
        <button class="nav-link @if(Request::is('admin/promotional_products/create','seller/promotional_products/create'))active @endif" id="add-product-tab"
                data-bs-toggle="tab" data-bs-target="#add-product"
                type="button" role="tab" aria-controls="add-product" aria-selected="true"
                @if(url()->full()!=$promotions_create_route) onclick="location.href='{{$promotions_create_route}}'" @endif>
            {{__('Add Promotion')}}
        </button>
        @endif
    </div>
    <!-- Tab Manu End -->
</div>
