<div class="col-lg-3">
    <p>{{ __('Coupon Code') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="code" type="text" required class="form-control" value="{{ old('code') }}" placeholder="Alphabet & Number">
    </div>
</div>

<div class="col-lg-3">
    <p>{{ __('Minimum Shopping') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="min_buy" type="number" required class="form-control" placeholder="{{ __('Minimum shopping amount to eligible for this coupon') }}">
    </div>
</div>

<div class="col-lg-3">
    <p>{{ __('Maximum Discount') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="max_discount" type="number" required class="form-control" placeholder="{{ __('Maximum amount to be discount') }}">
    </div>
</div>

<div class="col-lg-3">
    <p>{{ __('Number of Coupon') }} <span class="text-red">*</span></p>
</div>
<div class="col-lg-7">
    <div class="input-group">
        <input name="qty" type="number" required class="form-control" placeholder="{{ __('Maximum usage of this coupon') }}">
    </div>
</div>

<div class="col-lg-3">
    <p>{{__('Discount')}}</p>
</div>
<div class="col-lg-5">
    <div class="input-group month overflow-visible">
        <input name="discount" type="number" class="form-control">
        @error('discount')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-lg-2">
    <div class="input-group month overflow-visible">
        <select name="discount_type" class="form-select category form-control" required>
            <option value="">{{ __('Discount Type') }}</option>
            <option value="amount">{{ __('$') }}</option>
            <option value="percent">{{ __('%') }}</option>
        </select>
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
