<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3">
                    <p>{{ __('Category') }}  <span class="text-red">*</span></p>
                </div>
                <div class="col-lg-7">
                    <div class="input-group">
                        <select class="form-control select2 form-select{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required id="category_id"
                                name="category_id">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($blog->blog_category_id==$category->id ||old('category_id')==$category->id) selected @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <label class="error" id="category_id-error" for="category_id">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="title">{{__('Title')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                               value="@if($blog->title){{$blog->title}}@else{{ old('title') }}@endif"
                               placeholder=" Title" required>
                        @error('title')
                        <label class="error" id="title-error" for="title">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="description">{{__('Description')}}</span></div>
                <div class="col-md-7">
                    <div class="input-group">
                        <textarea name="description" class="editor form-control">{{$blog->description}}</textarea>
                    </div>
                    @error('description')
                    <label class="error" id="description-error" for="description">{{$message}}</label>
                    @enderror
                </div>
                <div class="col-md-3">
                    <span class="tag">{{__('Tag')}}</span></div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" name="tag" class="form-control" value="{{$blog->tag}}">
                    </div>
                    @error('tag')
                    <label class="error" id="tag-error" for="tag">{{$message}}</label>
                    @enderror
                </div>

                <div class="col-md-3">
                    <span class="image">{{__('Image')}}
                        <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <img id="image" src="{{URL::to('uploads/blogs/'.$blog->image)}}" alt="image" width="100">
                    <div class="input-group">
                        <input type="file" name="image" accept="image/*" type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" class="form-control @error('favicon') invalid @enderror" value="@if($blog->image){{$blog->image}}@else{{old('image')}}@endif">
                        @error('image')
                        <label class="error" id="image-error" for="image">{{$message}}</label>
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

                $('.editor').summernote({
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
