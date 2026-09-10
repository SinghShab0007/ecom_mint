<div class="row">
    <div class="col-lg-3">
        <p>{{ __('Name') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                   id="name"
                   name="name" value="@if($permission->name){{$permission->name}}@else{{old('name')}}@endif" autofocus>

            @error('name'))
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{ __('Guard Name') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select class="form-control select2 form-select{{ $errors->has('guard_name') ? ' is-invalid' : '' }}" required id="guard_name"
            name="guard_name[]" multiple="multiple">
                <option value="">{{ __('Select Guard') }}</option>
                <option value="admin" @if($permission->guard_name=='admin'||old('guard_name')=='admin') selected @endif>{{ __('Admin') }}</option>
                <option value="seller" @if($permission->guard_name=='seller'||old('guard_name')=='seller') selected @endif>{{ __('Seller') }}</option>
            </select>
            @error('guard_name')
            <label class="error" id="guard_name-error" for="guard_name">{{$message}}</label>
            @enderror
        </div>
    </div>
</div>

@push('js')
    <script>
            $(document).ready(function () {
                "use strict";
                $('.select2').select2({
                    tags: true
                });
                $("#permissionsForm").validate();
            });
    </script>
@endpush

