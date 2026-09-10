<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Product Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
{{--        @php--}}
{{--            $product_index_route = auth('seller')->user() ? route('seller.products.index') : route('backend.products.index');--}}
{{--            $product_create_route = auth('seller')->user() ? route('seller.products.create') : route('backend.products.create');--}}
{{--            $category_index_route = auth('seller')->user() ? route('seller.categories.index') : route('backend.categories.index');--}}
{{--            $category_create_route = auth('seller')->user() ? route('seller.categories.create') : route('backend.categories.create');--}}
{{--            $brand_index_route = auth('seller')->user() ? route('seller.brands.index') : route('backend.brands.index');--}}
{{--            $brand_create_route = auth('seller')->user() ? route('seller.brands.create') : route('backend.brands.create');--}}
{{--        @endphp--}}
        @if(auth('seller')->user()->can('browse_products') || auth('seller')->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('seller/products'))active @endif"
                    id="all-product-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#all-product"
                    type="button" role="tab" aria-controls="all-product" aria-selected="true"
                    onclick="location.href='{{ route('seller.products') }}'">
                {{__('All Product')}}
            </button>
        @endif
        @if(auth('seller')->user()->can('create_products') || auth('seller')->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/products/create','seller/products/create'))active @endif"
                    id="add-product-tab"
                    data-bs-toggle="tab" data-bs-target="#add-product"
                    type="button" role="tab" aria-controls="add-product" aria-selected="true"
                    onclick="location.href='{{ route('seller.products.create') }}'">{{__('Add Product')}}
            </button>
        @endif
        @if(auth('seller')->user()->can('browse_categories') || auth('seller')->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/categories','seller/categories'))active @endif"
                    id="category-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#category" type="button"
                    role="tab" aria-controls="category" aria-selected="false"
                    onclick="location.href='{{ route('seller.categories.index') }}'">{{__('Category')}}
            </button>
        @endif
        @if(auth('seller')->user()->can('create_categories') || auth('seller')->user()->hasRole('super-admin'))
            <button
                class="nav-link @if(Request::is('admin/categories/create','seller/categories/create'))active @endif"
                id="add-category-tab"
                data-bs-toggle="tab" data-bs-target="#add-category"
                type="button" role="tab" aria-controls="add-category" aria-selected="false"
                onclick="location.href='{{ route('seller.categories.create') }}'">{{__('Add Category')}}
            </button>
        @endif
        @if(auth('seller')->user()->can('browse_brands') || auth('seller')->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/brands','seller/brands'))active @endif" id="brand-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#brand" type="button"
                    role="tab" aria-controls="brand" aria-selected="false"
                    onclick="location.href='{{ route('seller.brands.index') }}'">{{__('Brand')}}
            </button>
        @endif
        @if(auth('seller')->user()->can('create_brands') || auth('seller')->user()->hasRole('super-admin'))
            <button class="nav-link @if(Request::is('admin/brands/create','seller/brands/create'))active @endif"
                    id="add-brand-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#add-brand"
                    type="button" role="tab" aria-controls="add-brand" aria-selected="false"
                    onclick="location.href='{{ route('seller.brands.create') }}'">{{__('Add Brand')}}
            </button>
        @endif
    </div>
    <!-- Tab Manu End -->
</div>
