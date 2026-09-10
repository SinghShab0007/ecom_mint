<div class="row">
    <div class="col-lg-3">
        <p>{{__('Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="@if($faq_category->name){{$faq_category->name}}@else{{ old('name') }}@endif"
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
        <p>{{__('Slug')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                   name="slug"
                   value="@if($faq_category->slug){{$faq_category->slug}}@else{{ old('slug') }}@endif" placeholder="Slug"
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
                       value="@if($faq_category->order){{$faq_category->order}}@else{{ old('order') }}@endif">
                @if ($errors->has('order'))
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('order') }}</strong>
            </span>
                @endif
            </div>
            <span class="sm-text">{{__('Higher number has high priority')}}</span>
        </div>
    </div>

    <div class="col-lg-3">
        <p>{{__('Icon(200x200)')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="icon" type="file" class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}"
                   name="icon" accept="image/*"
                   autofocus @if(Request::is('admin/faq_category/create'))required @endif>

            @if ($errors->has('icon'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('icon') }}</strong>
                </span>
            @endif
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
