<div class="row">
    <div class="col-lg-3">
        <p>{{__('Category')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="category_id"
                    class="form-select category form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                    required>
                <option value="">{{ __('Select Category') }}</option>
                @foreach($categories as $key => $cat)
                    <option value="{{$cat->id}}" data-id="{{$cat->id}}"
                            @if($cat->id==$banner->category_id || $cat->id==old('category_id')) selected @endif >{{$cat->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Title')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="title" type="text" required
                   class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                   value="@if($banner->title){{$banner->title}}@else{{ old('title') }}@endif"
                   placeholder="Banner Title">
            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Sub-Title')}} </p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="sub_title" type="text"
                   class="form-control {{ $errors->has('sub_title') ? ' is-invalid' : '' }}"
                   value="@if($banner->sub_title){{$banner->sub_title}}@else{{ old('sub_title') }}@endif"
                   placeholder="Banner Sub-Title">
            @if ($errors->has('sub_title'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('sub_title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Offer-Title')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="offer_title" type="text"
                   class="form-control {{ $errors->has('offer_title') ? ' is-invalid' : '' }}"
                   value="@if($banner->offer_title){{$banner->offer_title}}@else{{ old('offer_title') }}@endif"
                   placeholder="Offer-Title" required>
            @error('offer_title')
            <label id="offer_title-error" class="invalid-feedback error" for="offer_title">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Target')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="target"
                    class="form-select form-control{{ $errors->has('target') ? ' is-invalid' : '' }}">
                <option value="">{{__('Select Target') }}</option>
                <option value="_self" selected >_Self</option>
                <option value="_blank" @if('_blank'==$banner->target)) selected @endif >_Blank</option>
                <option value="_top" @if('_top'==$banner->target)) selected @endif >_Top</option>
                <option value="_parent" @if('_parent'==$banner->target)) selected @endif >_Parent</option>
            </select>

            @error('target')
            <label id="target-error" class="invalid-feedback error" for="target">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Type')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="type"
                    class="form-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                    required>
                <option value="">{{__('Select Type') }}</option>
                <option value="banner"  selected >Banner</option>
            </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Description')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea name="description"
                      class="form-control">@if($banner->description){{$banner->description}}@else{{ old('description') }}@endif</textarea>
            @error('description')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Expire At')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group month overflow-visible">
            <input name="expire_at" type="date" min="{{date("Y-m-d")}}"
                   value="@if($banner->expire_at){{date("Y-m-d",strtotime($banner->expire_at))}}@else{{old('expire_at')}}@endif"
                   class="form-control @error('expire_at') is-invalid @enderror">

            @error('expire_at')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Image')}} @if(Request::is('admin/banners/create','seller/banners/create')) <span class="text-red">*</span> @endif </p>
    </div>
    <div class="col-lg-7">
        <div class="sm-title-group">
            <div class="input-group file-upload overflow-visible">
                <label class="file-title">Browse</label>
                <input type="file" name="image"
                       class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}"
                       @if(Request::is('admin/banners/create','seller/banners/create')) required @endif>
                @error('image')
                   <label id="image-error" class="error" for="image">{{$message}}</label>
                @enderror
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                // validate form on keyup and submit
                $("#bannerForm").validate();

                $(document).on("change", '.category', function () {
                    $(".subcategory option").removeAttr("disabled");
                    var id = ($(this).find(":selected").data("id"));
                    $("#bannerForm .subcategory option[data-id]:not([data-id='" + id + "'])").attr("disabled", "true");
                });
                $(".category").select2({
                    // placeholder: "Type"
                });
                $(".brand").select2({
                    // placeholder: "Type"
                });
                $(".product").select2({
                    // placeholder: "Type"
                });

                $('.category').on('select2:select', function (e) {
                    $('.add-product-form').find('.brand').prop('disabled', false);
                    $('.brand').val(null).trigger('change');
                    $('.product').val(null).trigger('change');
                });
                $('.brand').on('select2:select', function (e) {
                    var data = e.params.data;
                    if (data.id) {
                        $('.add-product-form').find('.product').prop('disabled', false);
                        var brand_id = data.id;
                        var cat_id = $('.category').find(':selected').val();
                        if (cat_id && brand_id) {
                            $.ajax({
                                type: "GET",
                                dataType: "json",
                                url: public_path + '/_products',
                                data: {'cat_id': cat_id, 'brand_id': brand_id},
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
                        }
                    } else {
                        $('.add-product-form').find('.product').prop('disabled', true);
                    }
                });
            });
        })(jQuery);

    </script>
@endpush
