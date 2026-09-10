<div class="">
    <div class="content-tab-title px-0">
        <h4>{{__('Wholesale Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu px-0" id="nav-tab" role="tablist">
        @php
            $product_index_route =  route('backend.products.wholesale');
            $product_create_route =  route('backend.products.wholesale.form');
        @endphp
        @if(auth()->user()->can('browse_products') || auth()->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/products/wholesale'))active @endif"
                    id="all-product-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#all-product"
                    type="button" role="tab" aria-controls="all-product" aria-selected="true"
                    @if(url()->full()!=$product_index_route) onclick="location.href='{{$product_index_route}}'" @endif>
                {{__('WholeSale Product')}}
            </button>
        @endif
        @if(auth()->user()->can('create_products') || auth()->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/products/wholesale/form'))active @endif"
                    id="add-product-tab"
                    data-bs-toggle="tab" data-bs-target="#add-product"
                    type="button" role="tab" aria-controls="add-product" aria-selected="true"
                    @if(url()->full()!=$product_create_route) onclick="location.href='{{$product_create_route}}'" @endif>{{__('Add WholeSale')}}
            </button>
        @endif



    </div>
    <!-- Tab Manu End -->
</div>
