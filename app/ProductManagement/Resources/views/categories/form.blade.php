<div class="row">
    <div class="col-lg-3">
        <p>{{__('Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7 mb-2">
        <input id="name" type="text" class="form-control" name="name" value="@if($category->name){{$category->name}}@else{{ old('name') }}@endif" required placeholder="Name" autofocus>
    </div>
    <div class="col-lg-3">
        <p>{{__('Parent Category')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="overflow-visible">
            <select name="category_id" class="parent form-select form-control">
                <option value="">{{ __('Select parent') }}</option>
                <option value="" selected>{{ __('Root') }}</option>
                @foreach($categories as $key => $cat)
                    <option value="{{$cat->id}}" @if($cat->id==$category->category_id) selected @endif >{{$cat->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{ __('Slug') }} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="slug" type="text" class="form-control" name="slug" value="{{ $category->slug }}" required="" placeholder="Slug" autofocus="">
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{('Ordering Number')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="sm-title-group">
            <div class="oder-input">
                <input name="order" min="0" max="1000" type="number" class="form-control" placeholder="Order Level" value="@if($category->order){{$category->order}}@else{{ old('order') }}@endif">
            </div>
            <span class="sm-text">{{__('Higher number has high priority')}}</span>
        </div>
    </div>

    <div class="col-lg-3">
        <p>{{__('Banner(200x200)')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7 mb-2">
        <div class="file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="banner" type="file" class="form-control" name="banner" accept="image/*" autofocus @if(Request::is('admin/categories/create','seller/categories/create'))required @endif>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Image(32x32)')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7 mb-3">
        <div class="file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="icon" type="file" class="form-control" name="icon" accept="image/*" autofocus @if(Request::is('admin/categories/create','seller/categories/create'))required @endif>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta Title')}}</p>
    </div>
    <div class="col-lg-7">
        <input name="meta_title" type="text" required class="form-control" value="@if($category->meta_title){{$category->meta_title}}@else{{ old('meta_title') }}@endif" placeholder="Meta Title">
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta description')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea name="meta_description" class="form-control">@if($category->meta_description){{$category->meta_description}}@else{{ old('meta_description') }}@endif</textarea>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Commission Rate')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group commission-group overflow-visible">
            <input type="number" min="0" step="0.1" max="100" name="commission_rate" class="commission-input" placeholder="Commission Rate" value="@if($category->commission_rate){{$category->commission_rate}}@else{{ old('commission_rate')??0 }}@endif" min="1" required>
            <span class="commission-persent">%</span>
        </div>
    </div>

</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(".parent").select2();

                $('#name').keyup(function(event) {
                    $("input[name='slug']").val(clean($(this).val()));
                    $("input[name='meta_title']").val(clean($(this).val()));
                });
            });
        })(jQuery);
    </script>
@endpush
