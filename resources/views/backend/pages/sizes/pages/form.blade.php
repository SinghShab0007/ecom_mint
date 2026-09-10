<div class="row">

    <div class="col-lg-3">
        <p>{{__('Name')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="name" type="text" required
                   class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                   value="@if($size->name){{$size->name}}@else{{ old('name') }}@endif"
                   placeholder="size">
            @error('name')
            <div class="error invalid-feedback" id="name-error" for="name">{{ $message }}</div>
            @enderror
        </div>
    </div>
        <div class="col-lg-3">
        <p>{{__('Status')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="is_active"
                    class="form-select form-control{{ $errors->has('is_active') ? ' is-invalid' : '' }}">
                <option value="1" @if($size->is_active==1) selected @endif>{{__('Active') }}</option>
                <option value="0" @if($size->is_active==0) selected @endif >{{__('Inactive')}}</option>
            </select>
    </div>
</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                // validate form on keyup and submit
                $("#pageForm").validate({
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
                })
            });
        })(jQuery);

    </script>
@endpush
