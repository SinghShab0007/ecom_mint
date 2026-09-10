<div class="row">

    <div class="col-lg-3">
        <p>{{__('Brand Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name"
                   value="@if($brand->name){{$brand->name}}@else{{ old('name') }}@endif"
                   placeholder="Name"
                   required
                   autofocus>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{ __('Logo (120x80)') }} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="logo" type="file" class="form-control @error('image') is-invalid @enderror"
                   name="image" accept="image/*"
                   value="@if($brand->image){{$brand->image}}@else{{ old('image') }}@endif"
                   @if(Request::is('brands/create'))required @endif>
            @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Slug')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                   name="slug"
                   value="@if($brand->slug){{$brand->slug}}@else{{ old('slug') }}@endif"
                   required placeholder="Slug"
                   autofocus>

            @error('slug'))
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta Title')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="meta_title" type="text" class="form-control @error('meta_title') is-invalid @enderror"
                   name="meta_title"
                   value="@if($brand->meta_title){{$brand->meta_title}}@else{{ old('meta_title') }}@endif"
                   required placeholder="Meta Title"
                   autofocus>

            @error('meta_title'))
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta description')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                      name="meta_description">@if($brand->meta_description){{$brand->meta_description}}@else{{old('meta_description')}}@endif</textarea>

            @error('meta_description')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Brand Order')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="brand_order" type="number" min="0"
                   class="form-control @error('order') is-invalid @enderror"
                   name="order"
                   value="@if($brand->order){{$brand->order}}@else{{ old('order') }}@endif"
                   required placeholder="Brand Order"
                   autofocus>

            @error('order')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                // validate form on keyup and submit
                $("#brandForm").validate();

            });
        })(jQuery);

    </script>
@endpush
