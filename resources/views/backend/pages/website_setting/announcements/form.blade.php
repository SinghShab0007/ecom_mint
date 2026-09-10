<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <span class="title">{{__('Announcements Title')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                               value="@if($announcements->title){{$announcements->title}}@else{{ old('title') }}@endif"
                               placeholder="Announcements Title" required>
                        @error('title')
                        <label class="error" id="title-error" for="title">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Thumbnail')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="file" class="form-control {{ $errors->has('thumbnail') ? ' is-invalid' : '' }}" name="thumbnail" accept="image/*"
                               @if(Request::is('website_setting/announcements/create')) required @endif>
                        @error('thumbnail')
                        <label class="error" id="thumbnail-error" for="thumbnail">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Description')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                                <textarea name="description">@if($announcements->description){{$announcements->description}}@else{{old('description')}}@endif</textarea>
                        @error('description')
                        <label class="error" id="description-error" for="description">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Sale price')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="number" min="0" name="sale_price" class="form-control {{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                               value="@if($announcements->sale_price){{$announcements->sale_price}}@else{{ old('sale_price') }}@endif"
                               placeholder="Sale price" required>
                        @error('sale_price')
                        <label class="error" id="sale_price-error" for="sale_price">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Old price')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="number" min="0" name="old_price" class="form-control {{ $errors->has('old_price') ? ' is-invalid' : '' }}"
                               value="@if($announcements->old_price){{$announcements->old_price}}@else{{ old('old_price') }}@endif" placeholder="Old price" required>
                        @error('old_price')
                        <label class="error" id="old_price-error" for="old_price">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Expire At')}}</span>
                </div>
                <div class="col-md-7">
                    <div class="input-group month overflow-visible">
                        <input name="expire_at" type="date" min="{{date("Y-m-d")}}"
                               value="@if($announcements->expire_at){{date("Y-m-d",strtotime($announcements->expire_at))}}@else{{old('expire_at')}}@endif"
                               class="form-control @error('expire_at') is-invalid @enderror">

                        @error('expire_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
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
                $("#announcementsForm").validate({
                    ignore: ".note-editor *"
                });

                $('#editor').summernote({
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
                });
            });
        })(jQuery);

    </script>
@endpush
