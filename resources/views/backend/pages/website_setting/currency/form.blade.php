<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <span class="title">{{__('Name')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                               value="@if($currency->name){{$currency->name}}@else{{ old('name') }}@endif"
                               placeholder="Currency Name" required>
                        @error('name')
                        <label class="error" id="name-error" for="name">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('CC')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('cc') ? ' is-invalid' : '' }}" placeholder="Currency CC" name="cc" value="@if($currency->cc){{$currency->cc}}@else{{ old('cc') }}@endif">
                        @error('cc')
                        <label class="error" id="cc-error" for="cc">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Symbol')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" placeholder="Currency Symbol" class="form-control {{ $errors->has('symbol') ? ' is-invalid' : '' }}" name="symbol" value="@if($currency->symbol){{$currency->symbol}}@else{{ old('symbol') }}@endif">
                        @error('symbol')
                        <label class="error" id="symbol-error" for="symbol">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="title">{{__('Exchange Rate')}} <span class="text-red">*</span></span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" min="0" name="exchange_rate" class="form-control {{ $errors->has('exchange_rate') ? ' is-invalid' : '' }}"
                               value="@if($currency->exchange_rate>=0){{$currency->exchange_rate}}@else{{ old('exchange_rate') }}@endif"
                               placeholder="Exchange Rate" required>
                        @error('exchange_rate')
                        <label class="error" id="exchange_rate-error" for="exchange_rate">{{$message}}</label>
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
