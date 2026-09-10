<div class="container content-title">
    <h4>{{__('Product Information')}}</h4>
</div>
<div class="container">
    <div class="add-product-form">
        <div class="row">
            <div class="col-lg-2">
                <p>{{__('Product Name')}}
                    <span class="text-red">*</span>
                </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <input id="name" type="text"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name" placeholder="Product Name"
                           value="@if($product->name){{$product->name}}@else{{ old('name') }}@endif"
                           autofocus required>

                    @error('name')
                    <label class="error" id="name-error" for="name">{{ $message}}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Minimum Qty')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="number" name="minimum_qty"
                           class="form-control{{ $errors->has('minimum_qty') ? ' is-invalid' : '' }}"
                           min="1"
                           placeholder="1"
                           value="@if($product->minimum_qty){{$product->minimum_qty}}@else{{ old('minimum_qty')??10 }}@endif"
                           autofocus required>

                    @error('minimum_qty'))
                    <label class="error " id="minimum_qty-error" for="minimum_qty">{{$message }}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Category')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <select name="category_id"
                            class="category form-select form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                            required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $key => $cat)
                            <option value="{{$cat->id}}"
                                    @if($cat->id==$product->category_id|| $cat->id==old('category_id'))
                                    selected @endif >{{$cat->name}}
                            </option>
                            @if(isset($cat->children))
                                @include('productmanagement::includes.category_option',['child'=>1,'categories'=>$cat->children])
                            @endif

                        @endforeach
                    </select>
                    <a class="btn-clone text-center" type="button" href="{{route('backend.categories.create')}}">+</a>
                    @error('category_id'))
                    <label class="error " id="category_id-error" for="category_id">{{ $message}}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Tags')}} </p>
            </div>
            <div class="col-lg-4">
                <div class="sm-title-group">
                    <div class="input-group overflow-visible">
                        <select class="form-control tags {{ $errors->has('tags') ? ' is-invalid' : '' }}"
                                multiple="multiple" name="tags[]" autofocus>
                            @foreach(explode(',',$product->tags) as $key=> $tg)
                                <option value="{{$tg}}" selected>{{$tg}}</option>
                            @endforeach
                        </select>
                        @error('tags'))
                        <label id="tags-error" class="error " for="tags">{{ $message }}</label>
                        @enderror
                    </div>
                    <span class="sm-text">{{__('This is used for search. Input those words by which customer can find this product.')}}</span>

                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Brand')}} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <select name="brand_id"
                            class="brand form-select form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                        <option value="">{{ __('Select Brand') }}</option>
                        @foreach($brands as $key => $brand)
                            <option value="{{$brand->id}}"
                                    @if($brand->id==$product->brand_id|| $brand->id==old('brand_id')) selected @endif >{{$brand->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn-clone">+</button>
                    <a class="btn-clone text-center" type="button" href="{{route('backend.brands.create')}}">+</a>
                    @error('brand_id'))
                    <label class="error " id="brand_id-error" for="brand_id">{{$message}}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Barcode')}} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="barcode"
                           class="form-control{{ $errors->has('barcode') ? ' is-invalid' : '' }}"
                           value="@if($product->barcode){{$product->barcode}}@else{{ old('barcode') }}@endif"
                           placeholder="Barcode">
                    @error('barcode'))
                    <label class="error " id="barcode-error" for="barcode">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="col-lg-2">
                <p>{{__('Unit')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <select name="unit" required
                            class="form-select form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}">
                        <option value="">{{ __('Select Unit') }}</option>
                        <option value="Kg"
                                @if($product->unit=='Kg'||old('unit')=='Kg') selected @endif>{{ __('Kg') }}</option>
                        <option value="Piece"
                                @if($product->unit=='Piece'||old('unit')=='Piece') selected @endif>{{ __('Piece') }}</option>
                        <option value="Meter"
                                @if($product->unit=='Meter'||old('unit')=='Meter') selected @endif>{{ __('Meter') }}</option>
                        <option value="Litre"
                                @if($product->unit=='Litre'||old('unit')=='Litre') selected @endif>{{ __('Litre') }}</option>
                        <option value="Pound"
                                @if($product->unit=='Pound'||old('unit')=='Pound') selected @endif>{{ __('Pound') }}</option>
                    </select>

                    @error('unit')
                    <label class="error " id="unit-error"
                           for="unit">{{ $errors->first('unit') }}</label>
                    @enderror

                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Refundable')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="form-check form-switch btn-one-off">
                        <label>Disable</label>
                        <input type="hidden" value="0" name="is_refundable">
                        <input name="is_refundable" @if($product->is_refundable || old('is_refundable'))checked
                               @endif class="form-check-input" value="1"
                               type="checkbox">
                        <label>Enable</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Slug')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="slug"
                           class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                           value="@if($product->slug){{$product->slug}}@else{{ old('slug') }}@endif"
                           placeholder="Slug">
                    @error('slug')
                    <label class="error " id="slug-error" for="slug">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('SKU')}} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="sku"
                           class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}"
                           value="@if($product->sku){{$product->sku}}@else{{ old('sku') }}@endif"
                           placeholder="sku">
                    @error('sku'))
                    <label class="error " id="sku-error" for="sku">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            @if(auth()->user()->getRoleNames()->first()=='Seller')
                <input type="hidden" name="seller_id" value="{{auth()->id()}}">
            @else
                <div class="col-lg-2">
                    <p>{{__('Seller')}} <span class="text-red">*</span></p>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <select name="seller_id"
                                class="seller form-select form-control{{ $errors->has('seller_id') ? ' is-invalid' : '' }}" required>
                            <option value="">{{ __('Select Seller') }}</option>
                            @foreach($sellers as $key => $seller)
                                <option value="{{$seller->id}}"
                                        @if($seller->id==$product->seller_id|| $seller->id==old('seller_id')) selected @endif >{{$seller->company_name??''}}</option>
                            @endforeach
                        </select>
                        @error('seller_id'))
                        <label class="error" id="seller_id-error" for="seller_id">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-lg-2">
                <p>{{__('Product Warranty')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="warranty" class="form-control"
                           value="@if($product->warranty){{$product->warranty}}@else{{ old('warranty') }}@endif"
                           placeholder="Product Warranty">
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Return Policy')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="return_policy" class="form-control"
                           value="@if($product->return_policy){{$product->return_policy}}@else{{ old('return_policy') }}@endif"
                           placeholder="Product Return in Days">
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
                    <h4>{{__('Product Images')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <p>{{__('Images')}} @if(Request::is('admin/products/create'))  <span
                                                        class="text-red">*</span> @endif</p>
                        </div>
                        <div class="col-lg-10">
                            <div class="sm-title-group">
                                <div class="input-images"></div>
                                @error('images')
                                <label class="error " id="images-error"
                                       for="images">
                                    {{ $message }}
                                </label>
                                @enderror
                                <span class="sm-text product_image">{{__('Use 330x430 size image for Best Fit.Minimum 1 and maximum 4 image.These images are visible in product details page gallery.')}}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Product Videos')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <p>{{__('Video Provider')}}</p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group file-upload">
                                <input type="text" name="video_provider" class="form-control" placeholder="Youtube"
                                       value="@if($product->video && $product->video->video_provider!="''"){{$product->video->video_provider}}@else{{ old('video_provider') }}@endif">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Video Link')}}</p>
                        </div>
                        <div class="col-lg-10">
                            <div class="sm-title-group">
                                <div class="input-group">
                                    <input type="url" name="video_link" class="form-control" placeholder="Video Link"
                                           value="@if($product->video && $product->video->video_link!="''"){{$product->video->video_link}}@else{{ old('video_link') }}@endif">
                                </div>
                                <span class="sm-text">{{__('Use proper link without extra parameter. Don’t use short share link/embeded iframe code.')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h4>{{__('Product Variation')}}</h4>
                        </div>
                        <div class="col-md-2">
                            <div id="add-btn" class="btn-sm add-more-btn-admin ml-auto m-0">{{__('Add More')}}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-lg-10">
                            <div id="product-price-input-list">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>{{__('Colors')}}</label>
                                        <div class="input-group">
                                            <select id="colors" multiple="multiple" name="colors[]"
                                                    class="colors form-select form-control">
                                                <option value="">{{__('Select Colors')}}</option>

                                                @foreach($colors as $key=> $color)
                                                    <option value="{{$color->id}}" @if($product->colors()->exists() && in_array($color->id, $product->colors()->pluck('colors.id')->toArray())) selected @endif >{{$color->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>{{__('Sizes')}}</label>
                                        <div class="input-group">
                                            <select name="size[]" class="form-select size" multiple="multiple"
                                                    aria-label="Nothing selected">
                                                <option value="">{{__('Select Size')}}</option>

                                                @foreach($sizes as $key=> $sz)
                                                    <option value="{{$sz->id}}" @if($product->sizes()->exists() && in_array($sz->id, $product->sizes()->pluck('sizes.id')->toArray())) selected @endif >{{$sz->name}} </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>{{__('Stock')}}</label>
                                        <input type="number" class="form-control" placeholder="Stock">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <p>{{__('Attributes')}}</p>
                        </div>
                        <div class="col-lg-10">
                            <div class="sm-title-group">
                                <div class="input-group">
                                    <select name="attributes[]" multiple="multiple" class="attributes form-select"
                                            aria-label="Select Attribute">
                                        <option value="">{{__('Select Attribute')}}</option>
                                        @if($product->attributes)
                                            @foreach(json_decode($product->attributes) as $key=> $attr)
                                                <option value="{{$attr}}" selected>{{$attr}}</option>
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
                    <h4>{{__('Product price + stock')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <p>{{__('Unit price')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group overflow-visible">
                                <input name="unit_price" type="number"
                                       value="@if($product->unit_price){{$product->unit_price}}@else{{old('unit_price')}}@endif"
                                       class="form-control{{ $errors->has('unit_price') ? ' is-invalid' : '' }}"
                                       placeholder="0" min="0" required>
                                @error('unit_price')
                                <label class="error " id="unit_price-error" for="unit_price">
                                    {{ $message }}
                                </label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Purchase price')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group overflow-visible">
                                <input name="purchase_price" min="0" type="number"
                                       value="@if($product->purchase_price){{$product->purchase_price}}@else{{old('purchase_price')}}@endif"
                                       class="form-control{{ $errors->has('purchase_price') ? ' is-invalid' : '' }}"
                                       placeholder="0" required>
                                @error('purchase_price')
                                <label class="error " id="purchase_price-error" for="purchase_price">
                                    {{ $message }}
                                </label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Discount')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group overflow-visible">
                                <input name="discount" min="0" type="number"
                                       class="form-control {{ $errors->has('discount') ? ' is-invalid' : '' }}"
                                       value="@if($product->discount){{$product->discount}}@else{{old('discount')??0}}@endif"
                                       placeholder="0">
                                @error('discount')
                                <label class="error " id="discount-error" for="discount">
                                    {{ $message }}
                                </label>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <p>{{__('Quantity')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group overflow-visible">
                                <input name="quantity" min="0" type="number"
                                       class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                       placeholder="0"
                                       value="@if($product->quantity){{$product->quantity}}@else{{old('quantity')}}@endif"
                                       required>
                                @error('quantity')
                                <label id="quantity-error" class="error " for="quantity">
                                    {{ $message}}
                                </label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Shipping Cost')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group overflow-visible">
                                <input name="shipping_cost" min="0" type="number"
                                       class="form-control{{ $errors->has('shipping_cost') ? ' is-invalid' : '' }}"
                                       placeholder="0"
                                       value="@if($product->shipping_cost){{$product->shipping_cost}}@else{{old('shipping_cost')}}@endif"
                                       required>
                                @error('shipping_cost')
                                <label id="shipping_cost-error" class="error " for="shipping_cost">
                                    {{ $message}}
                                </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Product Description')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>{{__('Description')}}</p>
                        </div>
                        <div class="col-lg-12">
                            <textarea name="description" class="editor"
                                      id="textEditor">@if($product->description!="''"){{$product->description}}@else{{old('description')}}@endif</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('PDF Specification')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <p>{{__('PDF Specification')}}</p>
                        </div>
                        <div class="col-lg-10">
                            {{--                            <embed src="{{URL::to('uploads/products/pdf').'/'.$product->pdf_specification??''}}" type="application/pdf"   height="300px" width="100%">--}}
                            <div class="input-group file-upload">
                                <label class="file-title">Browse</label>
                                <input name="pdf_specification" type="file" class="form-control"
                                       accept="application/pdf">
                            </div>
                            @error('pdf_specification')
                            <label id="pdf_specification-error" class="error " for="pdf_specification">
                                {{ $message }}
                            </label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('SEO Meta Tags')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <p>{{__('Meta Title')}} </p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input name="meta_title" type="text"
                                       class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                       value="@if($product->meta_title){{$product->meta_title}}@else{{ old('meta_title') }}@endif"
                                       placeholder="Meta Title">
                                @error('meta_title')
                                <label id="meta_title-error" class="error " for="meta_title">
                                    {{ $message }}
                                </label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Description')}}</p>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <textarea name="meta_description"
                                          class="form-control">@if($product->meta_description){{$product->meta_description}}@else{{old('meta_description')}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p>{{__('Meta Image')}}</p>
                        </div>
                        <div class="col-lg-10">
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
                    <h4>{{__('Shipping Configuration')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{__('Free Shipping')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_free_shipping">
                                <input name="is_free_shipping" value="1" class="form-check-input"
                                       @if(($product->details && $product->details->is_free_shipping)||old('is_free_shipping')==1)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{__('Flat Rate')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_flat_rate">
                                <input name="is_flat_rate" value="1" class="form-check-input"
                                       @if(($product->details && $product->details->is_flat_rate)||old('is_flat_rate')==1)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{__('Product Wise Shipping')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_product_wise_shipping">
                                <input name="is_product_wise_shipping" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_product_wise_shipping)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{__('Is Product Quantity Multiply')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_quantity_multiply">
                                <input name="is_quantity_multiply" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_quantity_multiply)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Low Stock Quantity Warning')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <p>{{__('Qty')}} <span class="text-red">*</span></p>
                        </div>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input name="warning_quantity" type="number"
                                       class="form-control @error('warning_quantity') is-invalid @enderror" min="1"
                                       placeholder="1"
                                       value="@if($product->details && $product->details->warning_quantity){{$product->details->warning_quantity}}@else{{old('warning_quantity')??5}}@endif"
                                       required>
                                @error('warning_quantity')
                                <div id="warning_quantity-error" class="error "
                                     for="warning_quantity">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Stock Visibility State')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{__('Show Stock Quantity')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_show_stock_quantity">
                                <input name="is_show_stock_quantity" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_show_stock_quantity)checked
                                       @endif @if(Request::is('admin/products/create')) checked @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{__('Show Stock with Text Only')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_show_stock_with_text_only">
                                <input name="is_show_stock_with_text_only" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_show_stock_with_text_only)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                        <div class="col-9">
                            <p>{{__('Hide Stock')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_hide_stock">
                                <input name="is_hide_stock" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_hide_stock)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Cash on Delivery')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{__('Status')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_cash_on_delivery">
                                <input name="is_cash_on_delivery" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_cash_on_delivery)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Featured')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{__('Status')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_featured">
                                <input name="is_featured" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_featured)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Best Selling')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{__('Status')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_best_sell">
                                <input name="is_best_sell" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_best_sell)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{('Todays Deal')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <p>{{('Status')}}</p>
                        </div>
                        <div class="col-3">
                            <div class="form-switch">
                                <input type="hidden" value="0" name="is_todays_deal">
                                <input name="is_todays_deal" value="1" class="form-check-input"
                                       @if($product->details && $product->details->is_todays_deal)checked
                                       @endif type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Flash Deal')}}</h4>
                </div>
                <div class="card-body">
                    <p>{{__('Add To Flash')}}</p>
                    <div class="input-group">
                        <input name="flash_deal_title" type="text"
                               class="form-control @error('flash_deal_title') is-invalid @enderror"
                               value="@if($product->details && $product->details->flash_deal_title){{$product->details->flash_deal_title??''}}@else{{ old('flash_deal_title') }}@endif"
                               placeholder="Flash Deal Title">
                        @error('flash_deal_title')
                        <label id="flash_deal_title-error" class="error " for="flash_deal_title">{{$message}}</label>
                        @enderror
                    </div>
                    <p>{{__('Discount')}}</p>
                    <div class="input-group">
                        <input name="flash_deal_discount" type="number" min="0"
                               value="@if($product->details && $product->details->flash_deal_discount){{$product->details->flash_deal_discount??''}}@else{{old('flash_deal_discount')}}@endif"
                               class="form-control @error('flash_deal_discount') is-invalid @enderror" placeholder="0">
                        @error('flash_deal_discount')
                        <label id="flash_deal_discount-error" class="error "
                               for="flash_deal_discount">{{$message}}</label>
                        @enderror
                    </div>
                    <p>{{__('Discount Type')}}</p>
                    <div class="input-group">
                        <select name="flash_deal_discount_type"
                                class="form-select form-control @error('flash_deal_discount_type') is-invalid @enderror">
                            <option value="">{{__('Choose Discount Type')}}</option>
                            <option value="flat"
                                    @if(($product->details && $product->details->flash_deal_discount_type == 'flat')||old('flash_deal_discount_type')== 'flat')selected @endif>
                                Flat
                            </option>
                            <option value="percent"
                                    @if(($product->details && $product->details->flash_deal_discount_type == 'percent')||old('flash_deal_discount_type')== 'percent')selected @endif>
                                Percent
                            </option>
                        </select>
                        @error('flash_deal_discount_type')
                        <label id="flash_deal_discount_type-error" class="error "
                               for="flash_deal_discount_type">{{$message}}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Estimate Shipping Time')}}</h4>
                </div>
                <div class="card-body">
                    <p>{{__('Shipping Days')}} <span class="text-red">*</span></p>
                    <div class="input-group month overflow-visible">

                        <select name="inside_shipping_days"
                                class="form-select form-control @error('inside_shipping_days') is-invalid @enderror"
                                required>
                            <option value="">{{__('Select Shipping')}}</option>
                            <option value="3-7 days"
                                    @if($product->details && $product->details->inside_shipping_days=='3-7 days'||old('inside_shipping_days')=='3-7 days') selected @endif>
                                3-7 days
                            </option>
                            <option value="3-15 days"
                                    @if($product->details && $product->details->inside_shipping_days=='3-15 days'||old('inside_shipping_days')=='3-15 days') selected @endif>
                                3-15 days
                            </option>
                            <option value="7-15 days"
                                    @if($product->details && $product->details->inside_shipping_days=='7-15 days'||old('inside_shipping_days')=='7-15 days') selected @endif>
                                7-15 days
                            </option>
                            <option value="7-30 days"
                                    @if($product->details && $product->details->inside_shipping_days=='7-30 days'||old('inside_shipping_days')=='7-30 days') selected @endif>
                                7-30 days
                            </option>
                        </select>
                        @error('inside_shipping_days')
                        <label id="inside_shipping_days-error" class="error "
                               for="inside_shipping_days">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Vat & TAX')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p>{{__('Vat')}} </p>
                            <div class="input-group ">
                                <input name="vat" min="0" type="number"
                                       class="form-control @error('vat') is-invalid @enderror"
                                       value="@if($product->details && $product->details->vat){{$product->details->vat}}@else{{old('vat')??0 }}@endif"
                                >
                                @error('vat')
                                <label id="vat-error" class="error " for="vat">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p>{{__('Tax')}} </p>
                            <div class="input-group">
                                <input name="tax" type="number" min="0"
                                       class="form-control @error('tax') is-invalid @enderror"
                                       value="@if($product->details && $product->details->tax){{$product->details->tax}}@else{{old('tax')??0}}@endif">
                                @error('tax')
                                <label id="tax-error" class="error " for="tax">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Request::is('admin/products/*/edit'))
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <p>{{__('Publish Status')}}</p>
                            <div class="input-group ">
                                <select name="publish_stat" class="form-control form-select">
                                    <option value="">{{__('Select Status')}}</option>
                                    <option value="0"
                                            @if($product->publish_stat==0) selected @endif>{{__('UnPublish')}}</option>
                                    <option value="1"
                                            @if($product->publish_stat==1) selected @endif>{{__('Draft')}}</option>
                                    <option value="2"
                                            @if($product->publish_stat==2) selected @endif>{{__('Published')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="from-all-btn">
                @if(Request::is('admin/products/create','seller/products/create'))
                    <input class="save" type="submit" name="is_draft" value="Save As Draft">
                    <input class="save-unpublis" type="submit" name="is_unpublish" value="Save & Unpublish">
                    <input class="save-publis" type="submit" name="is_publish" value="Save & Publish">
                @else
                    <input class="save" type="submit" name="" value="Update">
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{asset('backend/js/colors.js')}}"></script>
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
            // validate form on keyup and submit
            $("#productForm").validate({
                ignore: ".note-editor *, .input-images *",
                rules: {
                    flash_deal_title: {
                        required: function () {
                            //returns true if have value
                            if ($("#productForm input[name=flash_deal_discount]").val() || $("#productForm select[name=flash_deal_discount_type]").find('option:selected').val())
                                return true;
                            else
                                return false;
                        }
                    },
                    flash_deal_discount: {
                        required: function () {
                            //returns true if have value
                            if (($("#productForm input[name=flash_deal_title]").val() != '') || ($("#productForm select[name=flash_deal_discount_type]").find('option:selected').val() != '')) {
                                if ($("#productForm input[name=flash_deal_discount]").val() < 0)
                                    return true;
                                else
                                    return false;
                            } else
                                return false;
                        }
                    },
                    flash_deal_discount_type: {
                        required: function () {
                            //returns true if have value
                            if ($("#productForm input[name=flash_deal_title]").val() || $("#productForm input[name=flash_deal_discount]").val())
                                return true;
                            else
                                return false;
                        }
                    }
                }
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



<script>
        $(function() {
            "use strict";
            $( document ).ready(()=>{
                $( "#add-btn" ).on( "click",()=>{
                    $("#product-price-input-list").append(`
                        <div class="input-grid-4 add-input-group-items">
                           <div class="input-group">
                                            <select id="colors" multiple="multiple" name="colors[]"
                                                    class="colors form-select form-control">
                                                <option value="">{{__('Select Colors')}}</option>

                                                @foreach($colors as $key=> $color)
                    <option value="{{$color->id}}" @if($product->colors()->exists() && in_array($color->id, $product->colors()->pluck('colors.id')->toArray())) selected @endif >{{$color->name}}</option>
                                                @endforeach

                    </select>
                </div>
    <input type="text"  class="form-control" placeholder="Sizes">
    <input type="text"  class="form-control" placeholder="Stock">
    <div class="remove-input-list"><i class="fa-solid fa-trash"></i></div>
</div>
`);
                });

                $("body").on("click", ".remove-input-list", function () {
                    $(this).closest(".add-input-group-items").remove();
                });

            })
        });
    </script>
@endpush
