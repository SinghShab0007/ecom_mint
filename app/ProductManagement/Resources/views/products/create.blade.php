@extends('backend.layouts.app')
@section('title', 'Product - ')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/image-uploader/image-uploader.min.css') }}">
@endpush
@section('content')
    <div class="content-body">
        @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-product" aria-labelledby="add-product-tab">
                <form id="productForm" class="add-brand-form ajaxform_instant_reload" action="@auth('admin'){{ route('backend.products.store') }}@elseauth('seller'){{ route('seller.products.store') }}@endauth" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="container content-title">
                        <h4>{{ __('Product Information') }}</h4>
                    </div>
                    <div class="container">
                        <div class="add-product-form">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>{{ __('Product Name') }}
                                        <span class="text-red">*</span>
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Product Name" autofocus required>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Minimum Qty') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-4">
                                    <input type="number" name="minimum_qty" class="form-control" min="1" required>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Category') }} <span class="text-red">*</span> <a target="_blank" class="rounded-circle w-50 h-50" href="{{ route("backend.categories.create") }}"><i class="fas fa-plus-circle text-primary"></i></a></p>
                                </div>
                                <div class="col-lg-4">
                                    <select name="category_id" class="category form-select form-control">
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach ($categories as $key => $cat)
                                            <option value="{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </option>
                                            @if (isset($cat->children))
                                                @include('productmanagement::includes.category_option', [
                                                    'child' => 1,
                                                    'categories' => $cat->children,
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Tags') }} </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="sm-title-group">
                                        <div class="input-group overflow-visible">
                                            <select class="form-control tags" multiple="multiple" name="tags[]">
                                                @foreach ($tags ?? [] as $tg)
                                                <option value="{{ $tg }}">{{ $tg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="sm-text">{{ __('This is used for search. Input those words by which customer can find this product.') }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Brand') }}  <a target="_blank" class="rounded-circle w-50 h-50" href="{{ route("backend.brands.create") }}"><i class="fas fa-plus-circle text-primary"></i></a></p>
                                </div>
                                <div class="col-lg-4">
                                    <select name="brand_id" class="brand form-select form-control">
                                        <option value="">{{ __('Select Brand') }}</option>
                                        @foreach ($brands as $key => $brand)
                                            <option value="{{ $brand->id }}"> {{ $brand->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Barcode') }} </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="barcode" class="form-control" placeholder="Barcode">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <p>{{ __('Unit') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <select name="unit" class="form-select form-control" required>
                                        <option value="">{{ __('Select Unit') }}</option>
                                        <option value="Kg">{{ __('Kg') }}</option>
                                        <option value="Piece">{{ __('Piece') }}</option>
                                        <option value="Meter">{{ __('Meter') }}</option>
                                        <option value="Litre">{{ __('Litre') }}</option>
                                        <option value="Pound">{{ __('Pound') }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Refundable') }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <div class="form-check form-switch btn-one-off">
                                            <label>Disable</label>
                                            <input type="hidden" value="0" name="is_refundable">
                                            <input name="is_refundable" class="form-check-input" value="1" type="checkbox">
                                            <label>Enable</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Slug') }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="slug" class="form-control" placeholder="Slug">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('SKU') }} </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="sku" class="form-control" value="{{ $sku }}" placeholder="sku">
                                    </div>
                                </div>
                                @if (auth()->user()->getRoleNames()->first() != 'Seller')
                                <div class="col-lg-2">
                                    <p>{{ __('Seller') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-4">
                                    <select name="seller_id" class="seller form-select form-control">
                                        <option value="">{{ __('Select Seller') }}</option>
                                        @foreach ($sellers as $key => $seller)
                                        <option value="{{ $seller->id }}">{{ $seller->company_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-lg-2">
                                    <p>{{ __('Product Warranty') }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="warranty" class="form-control" placeholder="Product Warranty">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <p>{{ __('Return Policy') }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="return_policy" class="form-control" placeholder="Product Return in Days">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-tr">
                        <div class="row">
                            <div class="col-lg-8 center-content">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Product Images') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('Images') }} <span class="text-red">*</span></p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="sm-title-group">
                                                    <div class="input-images"></div>
                                                    <span class="sm-text product_image">{{ __('Use 330x430 size image for Best Fit.Minimum 1 and maximum 4 image.These images are visible in product details page gallery.') }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Product Videos') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('Video Provider') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group file-upload">
                                                    <input type="text" name="video_provider" class="form-control" placeholder="Youtube">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Video Link') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="sm-title-group">
                                                    <div class="input-group">
                                                        <input type="url" name="video_link" class="form-control" placeholder="Video Link">
                                                    </div>
                                                    <span class="sm-text">{{ __('Use proper link without extra parameter. Don’t use short share link/embeded iframe code.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Product Variation') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('Colors') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <select id="colors" multiple="multiple" name="colors[]" class="colors form-select form-control">
                                                        <option value="">{{ __('Select Colors') }}</option>
                                                        @foreach ($colors as $key => $color)
                                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Sizes') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <select name="size[]" class="form-select size" multiple="multiple" aria-label="Nothing selected">
                                                        <option value="">{{ __('Select Size') }}</option>
                                                        @foreach ($sizes as $key => $sz)
                                                            <option value="{{ $sz->id }}">{{ $sz->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Attributes') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="sm-title-group">
                                                    <div class="input-group">
                                                        <select name="attributes[]" multiple="multiple" class="attributes form-select" aria-label="Select Attribute">
                                                            <option value="">Select Attribute</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Product price + stock') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('Unit price') }} <span class="text-red">*</span></p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <input name="unit_price" type="number" class="form-control" placeholder="0" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Purchase price') }}</p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <input name="purchase_price" min="0" type="number" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Discount Type') }}</p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <select name="discount_type" class="form-control">
                                                        <option value="">-{{ __('Select') }}-</option>
                                                        <option value="fixed">{{ __('Fixed') }}</option>
                                                        <option value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Discount') }}</p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <input name="discount" min="0" type="number" class="form-control" placeholder="0">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <p>{{ __('Available Quantity') }} <span class="text-red">*</span></p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <input name="quantity" min="1" type="number" class="form-control" placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Shipping Cost') }}</p>
                                            </div>
                                            <div class="col-lg-8 mb-2">
                                                <div class="overflow-visible">
                                                    <input name="shipping_cost" min="0" type="number" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Product Description') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-lg-12">
                                                <textarea name="description" class="editor" id="textEditor"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('PDF Specification') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('PDF Specification') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group file-upload">
                                                    <label class="file-title">Browse</label>
                                                    <input name="pdf_specification" type="file" class="form-control" accept="application/pdf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('SEO Meta Tags') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>{{ __('Meta Title') }} </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <input name="meta_title" type="text" class="form-control" placeholder="Meta Title">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Description') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <textarea name="meta_description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>{{ __('Meta Image') }}</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group file-upload">
                                                    <label class="file-title">Browse</label>
                                                    <input name="meta_image" type="file" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 sidebar-items">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Shipping Configuration') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ __('Free Shipping') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_free_shipping">
                                                    <input name="is_free_shipping" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p>{{ __('Flat Rate') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_flat_rate">
                                                    <input name="is_flat_rate" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p>{{ __('Product Wise Shipping') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_product_wise_shipping">
                                                    <input name="is_product_wise_shipping" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p>{{ __('Is Product Quantity Multiply') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_quantity_multiply">
                                                    <input name="is_quantity_multiply" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Low Stock Quantity Warning') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p>{{ __('Qty') }} <span class="text-red">*</span></p>
                                            </div>
                                            <div class="col-lg-9">
                                                <input name="warning_quantity" type="number" class="form-control" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Stock Visibility State') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ __('Show Stock Quantity') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_show_stock_quantity">
                                                    <input name="is_show_stock_quantity" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p>{{ __('Show Stock with Text Only') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_show_stock_with_text_only">
                                                    <input name="is_show_stock_with_text_only" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p>{{ __('Hide Stock') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_hide_stock">
                                                    <input name="is_hide_stock" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Cash on Delivery') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ __('Status') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_cash_on_delivery">
                                                    <input name="is_cash_on_delivery" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Featured') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ __('Status') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_featured">
                                                    <input name="is_featured" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Best Selling') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ __('Status') }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_best_sell">
                                                    <input name="is_best_sell" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ 'Todays Deal' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ 'Status' }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_todays_deal">
                                                    <input name="is_todays_deal" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Flash Deal') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p>{{ 'Status' }}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-switch">
                                                    <input type="hidden" value="0" name="is_flesh_deal">
                                                    <input name="is_flash_deal" value="1" class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Estimate Shipping Time') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ __('Shipping Days') }} <span class="text-red">*</span></p>
                                        <div class="mb-3">
                                            <select name="inside_shipping_days" class="form-control" required>
                                                <option value="">{{ __('Select Shipping') }}</option>
                                                <option selected value="1-3 days"> 1-3 days </option>
                                                <option value="3-5 days"> 3-5 days </option>
                                                <option value="3-7 days"> 3-7 days </option>
                                                <option value="5-10 days"> 5-10 days </option>
                                                <option value="5-15 days"> 5-15 days </option>
                                                <option value="15-30 days"> 15-30 days </option>
                                            </select>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ __('Vat & TAX') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-lg-12 mb-2">
                                                <div class="form-group">
                                                    <label for="">{{ __('Vat') }}</label>
                                                    <input name="vat" min="0" type="number" class="form-control" placeholder="Enter vat amount">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-2">
                                                <div class="form-group">
                                                    <label for="">{{ __('Tax') }}</label>
                                                    <input name="tax" type="number" min="0" class="form-control" placeholder="Enter tax amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="publish_stat">{{ __('Publish status') }} <span class="text-red">*</span></label>
                                            <select name="publish_stat" id="publish_stat" class="form-control" required>
                                                <option value="1">{{ __('Save As Draft') }}</option>
                                                <option value="0">{{ __('Save & Unpublish') }}</option>
                                                <option selected value="2">{{ __('Save & Publish') }}</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-warning submit-btn mb-4 mt-3 d-block w-100"><i class="fa-solid fa-floppy-disk"></i> {{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ asset('plugins/image-uploader/image-uploader.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                "use strict";

                $('#name').keyup(function (event) {
                    $("input[name='slug']").val(clean($(this).val()));
                    $("input[name='meta_title']").val(clean($(this).val()));
                });

                $("input[name='unit_price']").change(function () {
                    var max = parseInt($(this).val());
                    if (max) {
                        $("input[name='discount']").attr('max', max);
                    }
                });

                $(".tags").select2({
                    tags: true,
                    tokenSeparators: [',', ' '],
                    minimumResultsForSearch: Infinity,
                    placeholder: "Type and hit space to add a tag"
                });
                $(".attributes").select2({
                    tags: true,
                    tokenSeparators: [',', ' '],
                    minimumResultsForSearch: Infinity,
                    placeholder: "Type and hit space to add a attribute"
                });
                $(".category").select2();
                $(".brand").select2();
                $(".seller").select2();
                $(".colors").select2({
                    placeholder: 'Select a Color'
                });
                $(".size").select2({
                    placeholder: 'Select a Size'
                });

                /*rich text editor set*/
                $('.editor').summernote({
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['codeview', 'help']]
                    ]
                })

                $('.input-images').imageUploader({
                    imagesInputName: 'images',
                    preloadedInputName: 'old'
                });
            });
        </script>
    @endpush
