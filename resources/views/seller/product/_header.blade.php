<div class="container">
    <div class="content-tab-title">
        <h4>{{ __('Product Management') }}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if (Request::is('seller/products')) active @endif" id="all-product-tab" data-bs-toggle="tab"
            data-bs-target="#all-product" type="button" role="tab" aria-controls="all-product" aria-selected="true"
            onclick="location.href='{{ route('seller.products') }}'">
            {{ __('All Product') }}
        </button>
        <button class="nav-link @if (Request::is('seller/product/create')) active @endif" id="add-product-tab"
            data-bs-toggle="tab" data-bs-target="#add-product" type="button" role="tab" aria-controls="add-product"
            aria-selected="true" onclick="location.href='{{ route('seller.product.create') }}'">{{ __('Add Product') }}
        </button>
        <button class="nav-link @if (Request::is('seller/product/categories')) active @endif" id="category-tab" data-bs-toggle="tab"
            data-bs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false"
            onclick="location.href='{{ route('seller.categories') }}'">{{ __('Category') }}
        </button>
        <button class="nav-link @if (Request::is('seller/product/brands')) active @endif" id="brand-tab" data-bs-toggle="tab"
            data-bs-target="#brand" type="button" role="tab" aria-controls="brand" aria-selected="false"
            onclick="location.href='{{ route('seller.brands') }}'">{{ __('Brand') }}
        </button>
    </div>
    <!-- Tab Manu End -->
</div>
