<div class="container">
    <div class="add-product-form">
        <div class="row">
            <div class="col-lg-2">
                <p>{{__('Category')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <select name="category_id"
                            class="form-control category {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $key => $cat)
                            <option value="{{$cat->id}}"
                                    @if($promo_product->product && $promo_product->product->category_id==$cat->id) selected @endif>{{$cat->name}}</option>
                        @endforeach
                    </select>
                    <a class="btn-clone text-center" type="button" href="@auth('admin'){{route('backend.categories.create')}}@elseauth('seller'){{route('seller.categories.create')}}@endauth">+</a>
                    @if ($errors->has('category_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Brand')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <select name="brand_id"
                    class="form-control brand {{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                        <option value="">{{ __('Select Brand') }}</option>
                        @foreach($brands as $key => $brand)
                            <option value="{{$brand->id}}"
                                    @if($promo_product->product && $promo_product->product->brand_id==$brand->id) selected @endif>{{$brand->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn-clone">+</button>
                    <a class="btn-clone text-center" type="button" href="@auth('admin'){{route('backend.brands.create')}}@elseauth('seller'){{route('seller.brands.create')}}@endauth">+</a>
                    @if ($errors->has('brand_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('brand_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Product')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group  overflow-visible">
                    <select name="product_id" @if(Request::is('admin/promotional_products/create','seller/promotional_products/create')) disabled @endif
                    class="form-control product {{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                        <option value="">{{ __('Select Product') }}</option>
                        @foreach($products as $key => $product)
                            <option value="{{$product->id}}"
                                    @if($product->id==$promo_product->product_id||$product->id==old('product_id'))
                                    selected @endif >{{$product->name}}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <label class="error" id="product_id-error" for="product_id">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Promotion Title')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <input id="title" type="text"
                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                           name="title" placeholder="Promotion Title"
                           value="@if($promo_product->title){{$promo_product->title}}@else{{ old('title') }}@endif"
                           autofocus required>

                    @error('title')
                    <label id="title-error" class="error" for="title">{{$message}}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Promotion Label')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group add-input overflow-visible">
                    <input id="label" type="text"
                           class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }}"
                           name="label" placeholder="Promotion Label"
                           value="@if($promo_product->label){{$promo_product->label}}@else{{ old('label') }}@endif"
                           autofocus required>

                    @error('label')
                    <label id="label-error" class="error" for="label">{{$message}}</label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Promotion Price')}}<span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group overflow-visible">
                    <input name="promotion_price" min="0" type="number"
                           class="form-control {{ $errors->has('promotion_price') ? ' is-invalid' : '' }}"
                           value="@if($promo_product->promotion_price){{$promo_product->promotion_price}}@else{{old('promotion_price')??0}}@endif"
                           placeholder="0" required>
                    @error('promotion_price')
                    <label class="error " id="promotion_price-error" for="promotion_price">
                        {{ $message }}
                    </label>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Expire At')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group month overflow-visible">
                    <input name="expire_at" type="date"
                           value="@if($promo_product->expire_at){{date("Y-m-d",strtotime($promo_product->expire_at))}}@else{{old('expire_at')}}@endif"
                           class="form-control @error('expire_at') is-invalid @enderror">

                </div>
            </div>

            <div class="col-lg-2">
                <p>{{__('Position')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group  overflow-visible">
                    <select name="position"
                            class="form-select form-control {{ $errors->has('position') ? ' is-invalid' : '' }}"
                            required>
                        <option value="">{{ __('Select Position') }}</option>
                        <option value="1" data-size="212x120"
                                @if($promo_product->position=='1' ||'1'==old('position')) selected @endif>{{ __('position 1') }}</option>
                        <option value="2" data-size="300x300"
                                @if($promo_product->position=='2' ||'2'==old('position')) selected @endif>{{ __('position 2') }}</option>
                        <option value="3" data-size="1410x250"
                                @if($promo_product->position=='3' ||'3'==old('position')) selected @endif>{{ __('position 3') }}</option>
                        <option value="4" data-size="1304x553"
                                @if($promo_product->position=='4' ||'4'==old('position')) selected @endif>{{ __('position 4') }}</option>
                    </select>
                    @error('position')
                    <label id="position-error" class="error" for="position">{{$message}}</label>
                    @enderror
                </div>

            </div>

        </div>
    </div>
</div>
<div class="container bg-tr">
    <div class="row">
        <div class="col-lg-12 center-content">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Promotion Images')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="row @error('image') is-invalid @enderror" id="image">
                            <div class="col-lg-2">
                                <p>{{__('Image')}}
                                    <span class="size"
                                          id="image_size">{{old('image_size')?'('.old('image_size').')':''}}</span>
                                </p>

                            </div>
                            <div class="col-lg-4">
                                <div class="sm-title-group">
                                    <div class="input-group file-upload overflow-visible">
                                        <label class="file-title">Browse</label>
                                        <input type="file" name="image" accept="image/*" onchange="document.getElementById('promo_picture').src = window.URL.createObjectURL(this.files[0])"
                                               class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                        @error('image')
                                        <label id="image-error" class="error" for="image">{{$message}}</label>
                                        @enderror
                                    </div>
                                    <span class="sm-text"> {{__('Use')}} {{old('image_size')}} {{__('sizes image')}}</span>
                                </div>
                                <span class="sm-text small"> {{__('212x120 size for position 1, 300x300 size for position 2, 1410x250 size for position 3, 1304x553 size for position 4')}} </span>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4">
                                <img id="promo_picture" width="300px" height="150px"
                                     src="{{URL::to('uploads/promotions/'.$promo_product->image)}}" alt="promotin image"/>
                                <div class="clearfix"></div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script>
        $(document).ready(function () {
            "use strict";

            $(".category").select2({
                // placeholder: "Type"
            });
            $(".brand").select2({
                // placeholder: "Type"
            });
            $(".product").select2({
                // placeholder: "Type"
            });
            // validate form on keyup and submit
            $("#promo_productsForm").validate();

            $('.category').on('select2:select', function (e) {
                $('.product').val(null).trigger('change');
            });
            $('.category').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id) {
                    $('.add-product-form').find('.product').prop('disabled', false);
                    var cat_id = data.id;
                    var brand_id = $('.brand').find(':selected').val();
                    let ids;
                    if(brand_id)
                        ids = {'cat_id': cat_id, 'brand_id': brand_id};
                    else
                        ids = {'cat_id': cat_id};
                    if (cat_id) {
                        getProducts(ids);
                    }
                }
            });
            $('.brand').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id) {
                    $('.add-product-form').find('.product').prop('disabled', false);
                    var brand_id = data.id;
                    var cat_id = $('.category').find(':selected').val();
                    let ids;
                    if(cat_id)
                        ids = {'cat_id': cat_id, 'brand_id': brand_id};
                    else
                        ids = {'brand_id': brand_id};
                    if (brand_id) {
                        getProducts(ids);
                    }
                }
            });

            function getProducts(data){
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/_products'@elseauth('seller')'/seller/_products'@endauth,
                    data: data,
                    success: function (data) {
                        if (data.success) {
                            $('.product option').remove();
                            var option = new Option('Select Product', '', false, false);
                            $('.product').append(option);
                            data.products.forEach(function (product, index) {
                                var option = new Option(product.name, product.id, false, false);
                                $('.product').append(option);
                            });
                            $('.product').val(null).trigger('change');
                        }
                    }
                });
            };

            $(document).on('change', 'select[name="position"]', function () {
                let position = $(this).find(':selected').val();
                let size = $(this).find(':selected').data('size');
                if (size && position) {
                    $('select[name=image_size]').val(size);
                    $(document).find('#image_size').html('( ' + size + ' )');
                    $(document).find('.sm-title-group .sm-text').html('Use ' + size + ' sizes image');
                } else {
                    $(document).find('#image_size').html('');
                    $(document).find('.sm-title-group .sm-text').html('');
                }
            });

        });

    </script>
@endpush
