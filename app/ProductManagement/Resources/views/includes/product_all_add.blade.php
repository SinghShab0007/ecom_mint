<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Product Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        @php
            $product_index_route = auth('seller')->user() ? route('seller.products.index.all') : route('backend.products.index.all');
            $product_create_route = auth('seller')->user() ? route('seller.products.create.all') : route('backend.products.create.all');
            $category_index_route = auth('seller')->user() ? route('seller.categories.index') : route('backend.categories.index');
            $category_create_route = auth('seller')->user() ? route('seller.categories.create') : route('backend.categories.create');
            $brand_index_route = auth('seller')->user() ? route('seller.brands.index') : route('backend.brands.index');
            $brand_create_route = auth('seller')->user() ? route('seller.brands.create') : route('backend.brands.create');
        @endphp
        @if(auth()->user()->can('browse_products') || auth()->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/products/index-all','seller/products/index-all'))active @endif"
                    id="all-product-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#all-product"
                    type="button" role="tab" aria-controls="all-product" aria-selected="true"
                    @if(url()->full()!=$product_index_route) onclick="location.href='{{$product_index_route}}'" @endif>
                {{__('All Product')}}
            </button>
        @endif
        @if(auth()->user()->can('create_products') || auth()->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/products/create-all','seller/products/create-all'))active @endif"
                    id="add-product-tab"
                    data-bs-toggle="tab" data-bs-target="#add-product"
                    type="button" role="tab" aria-controls="add-product" aria-selected="true"
                    @if(url()->full()!=$product_create_route) onclick="location.href='{{$product_create_route}}'" @endif>{{__('Add All Product')}}
            </button>
        @endif

    </div>
    <!-- Tab Manu End -->
</div>
