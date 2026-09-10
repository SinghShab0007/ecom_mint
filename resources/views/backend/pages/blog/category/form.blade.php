<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <span class="title">{{__('Category Name')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                               value="@if($categories->name){{$categories->name}}@else{{ old('name') }}@endif"
                               placeholder="Category Name" required>
                        @error('name')
                        <label class="error" id="title-error" for="name">{{$message}}</label>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('js')
    <script>
        /*(function ($) {
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
        })(jQuery);*/

    </script>
@endpush
