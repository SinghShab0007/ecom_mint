<div class="row">
    <div class="col-lg-3">
        <p>{{__('Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="@if($faq_subcategory->name){{$faq_subcategory->name}}@else{{ old('name') }}@endif"
                   required placeholder="Name"
                   autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Category')}}<span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group overflow-visible">
            <select name="faq_category_id" class="parent form-select form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required>
                <option value="">{{ __('Select parent') }}</option>
                @foreach($faq_categories as $key => $cat)
                    <option value="{{$cat->id}}"
                            @if($cat->id==$faq_subcategory->faq_category_id) selected @endif >{{$cat->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('faq_category_id'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('faq_category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Slug')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                   name="slug"
                   value="@if($faq_subcategory->slug){{$faq_subcategory->slug}}@else{{ old('slug') }}@endif" placeholder="Slug"
                   autofocus>

            @error('slug'))
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{('Ordering Number')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="sm-title-group">
            <div class="input-group oder-input">
                <input name="order" min="0" max="1000" type="number"
                       class="form-control {{ $errors->has('order') ? ' is-invalid' : '' }}"
                       placeholder="Order Level"
                       value="@if($faq_subcategory->order){{$faq_subcategory->order}}@else{{ old('order') }}@endif">
                @if ($errors->has('order'))
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('order') }}</strong>
            </span>
                @endif
            </div>
            <span class="sm-text">{{__('Higher number has high priority')}}</span>
        </div>
    </div>

</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $('#name').keyup(function (event) {
                    $("input[name='slug']").val(clean($(this).val()));
                });
                // validate form on keyup and submit
                $("#faqForm").validate();


            });
        })(jQuery);
    </script>
@endpush
