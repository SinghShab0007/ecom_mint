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
                <input id="name" type="text" class="form-control" name="name" placeholder="Product Name" value="{{ $product->name ?? '' }}" required>
            </div>
            <div class="col-lg-2">
                <p>{{ __('Minimum Qty') }} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="number" name="minimum_qty" class="form-control" min="1" value="1" value="{{ $product->minimum_qty ?? '' }}" required>
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{ __('Category') }} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <select name="category_id" class="category form-select form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach ($categories as $key => $cat)
                        <option value="{{ $cat->id }}" @if ($cat->id == $product->category_id || $cat->id == old('category_id')) selected @endif>
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
                @error('category_id')
                    <label class="error " id="category_id-error" for="category_id">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-lg-2">
                <p>{{ __('Brand') }}</p>
            </div>
            <div class="col-lg-4">
                <select name="brand_id" class="brand form-select form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                    <option value="">{{ __('Select Brand') }}</option>
                    @foreach ($brands as $key => $brand)
                        <option value="{{ $brand->id }}" @if ($brand->id == $product->brand_id || $brand->id == old('brand_id')) selected @endif>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <label class="error " id="brand_id-error" for="brand_id">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-lg-2">
                <p>{{ __('Tags') }} </p>
            </div>
            <div class="col-lg-4">
                <div class="sm-title-group">
                    <div class="input-group overflow-visible">
                        <select name="tags[]" multiple="multiple" class="tags form-select" aria-label="Select Tags">
                            <option value="">Select Attribute</option>
                            @if ($product->tags != '' && $product->tags != 'null')
                                @foreach (json_decode($product->tags) as $tag)
                                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <span class="sm-text">{{ __('This is used for search. Input those words by which customer can find this product.') }}</span>
                </div>
            </div>
            {{-- <div class="col-lg-2">
                <p>{{ __('Select courier') }} </p>
            </div>
            <div class="col-lg-4">
                <div class="sm-title-group">
                    <div class="input-group overflow-visible">
                        <select name="courieres[]" multiple="multiple" class="courieres form-select" aria-label="Select courieres">
                            @if ($product->courieres != '' && $product->courieres != 'null')
                                @foreach (json_decode($product->courieres) as $courier)
                                    <option value="{{ $courier }}" selected>{{ $courier }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="previous_courieres" value="1" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{ __("Click for the previous product's couriers.") }}
                        </label>
                    </div>
                </div>
            </div> --}}

            <div class="col-lg-2">
                <p>{{ __('Barcode') }} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="barcode" class="form-control{{ $errors->has('barcode') ? ' is-invalid' : '' }}" value="@if ($product->barcode) {{ $product->barcode }}@else{{ old('barcode') }} @endif" placeholder="Barcode">
                    @error('barcode')
                        <label class="error " id="barcode-error" for="barcode">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="col-lg-2">
                <p>{{ __('Unit') }} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <select name="unit" required
                    class="form-select form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}">
                    <option value="">{{ __('Select Unit') }}</option>
                    <option value="Kg" @if ($product->unit == 'Kg' || old('unit') == 'Kg') selected @endif>{{ __('Kg') }}
                    </option>
                    <option value="Piece" @if ($product->unit == 'Piece' || old('unit') == 'Piece') selected @endif>{{ __('Piece') }}
                    </option>
                    <option value="Meter" @if ($product->unit == 'Meter' || old('unit') == 'Meter') selected @endif>{{ __('Meter') }}
                    </option>
                    <option value="Litre" @if ($product->unit == 'Litre' || old('unit') == 'Litre') selected @endif>{{ __('Litre') }}
                    </option>
                    <option value="Pound" @if ($product->unit == 'Pound' || old('unit') == 'Pound') selected @endif>{{ __('Pound') }}
                    </option>
                </select>
                @error('unit')
                    <label class="error " id="unit-error" for="unit">{{ $errors->first('unit') }}</label>
                @enderror
            </div>
            <div class="col-lg-2">
                <p>{{ __('Refundable') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="form-check form-switch btn-one-off">
                        <label>Disable</label>
                        <input type="hidden" value="0" name="is_refundable">
                        <input name="is_refundable" @if ($product->is_refundable || old('is_refundable')) checked @endif
                            class="form-check-input" value="1" type="checkbox">
                        <label>Enable</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{ __('Slug') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="slug"
                        class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                        value="@if ($product->slug) {{ $product->slug }}@else{{ old('slug') }} @endif"
                        placeholder="Slug">
                    @error('slug')
                        <label class="error " id="slug-error" for="slug">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{ __('SKU') }} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="sku" class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}" value="@if ($product->sku) {{ $product->sku }}@else{{ old('sku') }} @endif" placeholder="sku">
                    @error('sku')
                        <label class="error " id="sku-error" for="sku">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{ __('Product Warranty') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="warranty" class="form-control"
                        value="@if ($product->warranty) {{ $product->warranty }}@else{{ old('warranty') }} @endif"
                        placeholder="Product Warranty">
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{ __('Return Policy') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="return_policy" class="form-control" value="@if ($product->return_policy) {{ $product->return_policy }}@else{{ old('return_policy') }} @endif" placeholder="Product Return in Days">
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
                            <p>{{ __('Images') }} @if (Request::is('admin/products/create'))
                                    <span class="text-red">*</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="sm-title-group">
                                <div class="input-images"></div>
                                @error('images')
                                    <label class="error " id="images-error" for="images">
                                        {{ $message }}
                                    </label>
                                @enderror
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
                                <input type="text" name="video_provider" class="form-control" placeholder="Youtube" value="@if ($product->video && $product->video->video_provider != "''") {{ $product->video->video_provider }}@else{{ old('video_provider') }} @endif">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Video Link') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="sm-title-group">
                                <div class="input-group">
                                    <input type="url" name="video_link" class="form-control" placeholder="Video Link" value="@if ($product->video && $product->video->video_link != "''") {{ $product->video->video_link }}@else{{ old('video_link') }} @endif">
                                </div>
                                <span class="sm-text product_image">{{ __('Use proper link without extra parameter. Don’t use short share link.') }}</span>
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
                    <div class="accordion mb-4" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button text-center font-weight-bold d-inline-block" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('Do you want to add variation for this product?') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse {{ $product->productstock ? 'show':'' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5>{{ __('Variation wise stock') }}</h5>
                                        <button type="button" class="btn btn-warning btn-sm base-bg text-light another-variation"><i class="fa fa-plus-circle d-inline-block mt-1" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="variants">
                                        @foreach ($product->productstock as $productstock)
                                        <div class="input-group mb-4">
                                            <select name="colors[]" class="form-control">
                                                <option value="">-{{ __('Select Color') }}-</option>
                                                @foreach ($colors as $key => $color)
                                                    <option {{ $productstock->color_id == $color->id ? 'selected':'' }} value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="sizes[]" class="form-control">
                                                <option value="">-{{ __('Select Size') }}-</option>
                                                @foreach ($sizes as $key => $sz)
                                                    <option {{ $productstock->size_id == $sz->id ? 'selected':'' }} value="{{ $sz->id }}">{{ $sz->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" class="form-control" placeholder="Enter quantity" name="quantities[]" value="{{ $productstock->quantities }}">
                                            <button type="button" class="btn btn-danger input-group-text btn-sm text-light remove-row"><i class="fas fa-trash d-inline-block mt-1"></i></button>
                                        </div>
                                        @endforeach
                                    </div>
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
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="unit_price" type="number" value="{{ $product->unit_price }}" class="form-control" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Purchase price') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="purchase_price" min="0" type="number" value="{{ $product->purchase_price }}" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Discount Type') }}</p>
                        </div>
                        <div class="col-lg-8 mb-2">
                            <div class="overflow-visible">
                                <select name="discount_type" class="form-control">
                                    <option value="">-{{ __('Select') }}-</option>
                                    <option {{ $product->discount_type == 'fixed' ? 'selected':'' }} value="fixed">{{ __('Fixed') }}</option>
                                    <option {{ $product->discount_type == 'percentage' ? 'selected':'' }} value="percentage">{{ __('Percentage') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Discount') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="discount" min="0" type="number" class="form-control" value="{{ $product->discount }}" placeholder="0">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <p>{{ __('Available Quantity') }} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="quantity" min="1" type="number" class="form-control" placeholder="0" value="{{ $product->quantity }}" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Shipping Cost(Inside India)') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="shipping_cost" min="0" type="number" class="form-control" placeholder="0" value="{{ $product->shipping_cost }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Shipping Cost(Outside India)') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group overflow-visible">
                                <input name="outside_shipping_cost" min="0" type="number" class="form-control" placeholder="0" value="{{ $product->outside_shipping_cost }}">
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
                                        @if ($product->attributes != '' && $product->attributes != 'null')
                                            @foreach (json_decode($product->attributes) as $key => $attr)
                                                <option value="{{ $attr }}" selected>{{ $attr }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Product Description') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea name="description" class="editor" id="textEditor">
                                @if ($product->description != "''")
                                {{ $product->description }}@else{{ old('description') }}
                                @endif
                            </textarea>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('PDF Specification') }}</h5>
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
                    @if ($product->pdf_specification)
                    <div class="row">
                        <div class="col-12">
                            <embed src="{{URL::to('uploads/products/pdf').'/'.$product->pdf_specification??''}}" type="application/pdf" width="100%" height="350">
                        </div>
                    </div>
                    @endif
                    <br>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('SEO Meta Tags') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <p>{{ __('Meta Title') }} </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <input name="meta_title" type="text" class="form-control" value="{{ $product->meta_title }}" placeholder="Meta Title">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p>{{ __('Description') }}</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <textarea name="meta_description" class="form-control"> @if ($product->meta_description) {{ $product->meta_description }}@else{{ old('meta_description') }}@endif</textarea>
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
                            @error('meta_image')
                                <label id="meta_image-error" class="error " for="meta_image">
                                    {{ $message }}
                                </label>
                            @enderror
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
                                <input name="is_free_shipping" value="1" class="form-check-input"
                                    @if (($product->details && $product->details->is_free_shipping) || old('is_free_shipping') == 1) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{ __('Flat Rate') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_flat_rate">
                                <input name="is_flat_rate" value="1" class="form-check-input"
                                    @if (($product->details && $product->details->is_flat_rate) || old('is_flat_rate') == 1) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{ __('Product Wise Shipping') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_product_wise_shipping">
                                <input name="is_product_wise_shipping" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_product_wise_shipping) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{ __('Is Product Quantity Multiply') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_quantity_multiply">
                                <input name="is_quantity_multiply" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_quantity_multiply) checked @endif type="checkbox">
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
                    <div class="row mb-3">
                        <div class="col-9">
                            <p>{{ __('Want to manage stock') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_manage_stock">
                                <input name="is_manage_stock" value="1" class="form-check-input" type="checkbox" {{ $product->is_manage_stock ? 'checked':'' }}>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <p>{{ __('Qty') }}</p>
                        </div>
                        <div class="col-lg-9">
                            <input name="warning_quantity" type="number" class="form-control" value="{{ optional($product->details)->warning_quantity }}">
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
                                <input name="is_show_stock_quantity" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_show_stock_quantity) checked @endif
                                    @if (Request::is('admin/products/create')) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{ __('Show Stock with Text Only') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_show_stock_with_text_only">
                                <input name="is_show_stock_with_text_only" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_show_stock_with_text_only) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{ __('Hide Stock') }}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_hide_stock">
                                <input name="is_hide_stock" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_hide_stock) checked @endif type="checkbox">
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
                                <input name="is_cash_on_delivery" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_cash_on_delivery) checked @endif type="checkbox">
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
                                <input name="is_featured" value="1" class="form-check-input" @if ($product->details && $product->details->is_featured) checked @endif type="checkbox">
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
                                <input name="is_best_sell" value="1" class="form-check-input"
                                    @if ($product->details && $product->details->is_best_sell) checked @endif type="checkbox">
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
                                <input name="is_todays_deal" value="1" class="form-check-input" @if ($product->details && $product->details->is_todays_deal) checked @endif type="checkbox">
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
                                <input name="is_flash_deal" value="1" class="form-check-input" @if (optional($product->details)->is_flash_deal) checked @endif type="checkbox">
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
                    <p class="mb-0">{{ __('Inside India') }} <span class="text-red">*</span></p>
                    <div class="input-group month overflow-visible mb-3">
                        <select name="inside_shipping_days" class="form-select form-control" required>
                            <option value="">{{ __('Select Shipping') }}</option>
                            <option value="3-7 days" @if(optional($product->details)->inside_shipping_days == '3-7 days') selected @endif>
                                3-7 days
                            </option>
                            <option value="3-10 days" @if(optional($product->details)->inside_shipping_days == '3-10 days') selected @endif>
                                3-10 days
                            </option>
                            <option value="3-15 days" @if(optional($product->details)->inside_shipping_days == '3-15 days') selected @endif>
                                3-15 days
                            </option>
                            <option value="7-15 days" @if(optional($product->details)->inside_shipping_days == '7-15 days') selected @endif>
                                7-15 days
                            </option>
                            <option value="7-30 days" @if(optional($product->details)->inside_shipping_days == '7-30 days') selected @endif>
                                7-30 days
                            </option>
                        </select>
                    </div>

                    <p class="mb-0">{{ __('Outside India') }} <span class="text-red">*</span></p>
                    <div class="input-group month overflow-visible">
                        <select name="outside_shipping_days" class="form-select form-control" required>
                            <option value="">{{ __('Select Shipping') }}</option>
                            <option value="3-7 days" @if(optional($product->details)->outside_shipping_days == '3-7 days') selected @endif>
                                3-7 days
                            </option>
                            <option value="3-10 days" @if(optional($product->details)->outside_shipping_days == '3-10 days') selected @endif>
                                3-10 days
                            </option>
                            <option value="3-15 days" @if(optional($product->details)->outside_shipping_days == '3-15 days') selected @endif>
                                3-15 days
                            </option>
                            <option value="7-15 days" @if(optional($product->details)->outside_shipping_days == '7-15 days') selected @endif>
                                7-15 days
                            </option>
                            <option value="7-30 days" @if(optional($product->details)->outside_shipping_days == '7-30 days') selected @endif>
                                7-30 days
                            </option>
                        </select>
                    </div>
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
                                <input name="vat" min="0" type="number" class="form-control" placeholder="Enter vat amount" value="{{ optional($product->details)->vat }}" step="any">
                            </div>
                        </div>
                        {{-- <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="">{{ __('Tax') }}</label>
                                <input name="tax" type="number" min="0" class="form-control" placeholder="Enter tax amount" value="{{ optional($product->details)->tax }}" step="any">
                            </div>
                        </div> --}}
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

@push('js')
    @include('productmanagement::products.product-js')
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

            $(".courieres").select2({
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
        });
    </script>
@endpush
