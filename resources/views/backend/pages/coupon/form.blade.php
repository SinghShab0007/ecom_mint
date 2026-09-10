<div class="row">
    <div class="col-lg-12">
        @if($errors->any())
            <ul class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-lg-3">
        <p>{{__('Coupon Type')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="type" class="form-select category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required id="type">
                <option value="">{{ __('Select Category') }}</option>
                <option value="product">{{ __('For Product') }}</option>
                <option value="cart">{{ __('For Total Order') }}</option>
            </select>

            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>

<div class="row" id="coupon-form">

</div>

