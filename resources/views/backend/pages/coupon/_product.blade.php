<div class="col-lg-3">
    <p>{{ __('Coupon Code') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="code" type="text" required class="form-control" placeholder="Alphabet & Number">
    </div>
</div>
<div class="col-lg-3">
    <p>{{ __('Product') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <select name="products[]" class="form-select select2 category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required multiple>
            <option value="">{{ __('Select Product') }}</option>
            @foreach($categories as $category)
                @foreach($category->subCategories as $subCategory)
                    @foreach($subCategory->subSubCategories as $subSubCategory)
                        @foreach($subSubCategory->products as $product)
                            <option value="{{ $product->id }}">{{ $category->name.' >>> '.$subCategory->name .' >>> '.$subSubCategory->name.' >>> '.$product->name }}</span></option>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-3">
    <p>{{ __('Number of Coupon') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="qty" type="number" required class="form-control" min="0" placeholder="{{ __('Total coupon can be used') }}">
    </div>
</div>

<div class="col-lg-3">
    <p>{{__('Start')}}</p>
</div>
<div class="col-lg-7">
    <div class="input-group month overflow-visible">
        <input name="start" type="date" min="{{date("Y-m-d")}}" class="form-control">
        @error('start')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-lg-3">
    <p>{{__('End')}}</p>
</div>
<div class="col-lg-7">
    <div class="input-group month overflow-visible">
        <input name="end" type="date" min="{{date("Y-m-d")}}" class="form-control">
        @error('end')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-lg-3">
    <p>{{__('Discount')}}</p>
</div>
<div class="col-lg-5">
    <div class="input-group month overflow-visible">
        <input name="discount" type="number" class="form-control" min="0">
        @error('discount')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-lg-2">
    <div class="input-group month overflow-visible">
        <select name="discount_type" class="form-select category form-control" required>
            <option value="">{{ __('Select Product') }}</option>
            <option value="currency">{{ __('$') }}</option>
            <option value="percent">{{ __('%') }}</option>
        </select>
    </div>
</div>
