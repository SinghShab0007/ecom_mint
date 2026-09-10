<div class="row">
    <div class="col-lg-3">
        <p>{{ __('Name') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                   id="name"
                   name="name" value="@if($role->name){{$role->name}}@else{{old('name')}}@endif" autofocus>

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
            <select class="form-control form-select{{ $errors->has('guard_name') ? ' is-invalid' : '' }}" required id="guard_name"
                    name="guard_name">
                <option value="">{{ __('Select Guard') }}</option>
                <option value="admin" @if($role->guard_name=='admin'||old('guard_name')=='admin') selected @endif>{{ __('Admin') }}</option>
                <option value="seller" @if($role->guard_name=='seller'||old('guard_name')=='seller') selected @endif>{{ __('Seller') }}</option>
            </select>
            @error('guard_name')
            <label class="error" id="guard_name-error" for="guard_name">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{ __('Permissions') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select id="permissions" class="form-control select2" name="permissions[]" multiple="multiple">
                @foreach($permissions as $key=> $perm)
                    <option value="{{$perm->name}}"
                            @if($role->name && $role->hasPermissionTo($perm->name)) selected @endif>{{$perm->name}}</option>
                @endforeach
            </select>
            @error('permissions'))
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
</div>

@push('js')
    <script>
        (function($){
            "use strict";
            $(document).ready(function () {

                $("#rolesForm").validate();

                $('#guard_name').on('change', function(e) {
                    let guard = $(this).val();
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: public_path +'/admin/role_permissions',
                        data: {'guard': guard},
                        success: function(data){
                           if(data.success){
                               $('#permissions').empty();
                               $.each(data.permissions,function(index, perm){
                                   var option = new Option(perm, perm, true, false);
                                   $('#permissions').append(option).trigger('change');
                               });
                           }
                        }
                    });
                });

                $('.select2').select2({
                    tags: true
                });
            });
        })(jQuery)

    </script>
@endpush

