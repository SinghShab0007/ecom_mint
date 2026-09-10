<div class="row">
    <div class="col-lg-3">
        <p>{{ __('Name') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="@if($user->name){{$user->name}}@else{{ old('name') }}@endif" required
                   autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{ __('E-Mail Address') }}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="@if($user->email){{$user->email}}@else{{ old('email') }}@endif" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Password')}}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="password" type="password"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                   @if(!$user->password) required @endif>

            @error('password')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Confirm Password')}}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                   @if(!$user->password) required @endif>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('User Role')}}  <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" required>
                <option value="">{{ __('Select Role') }}</option>
                @foreach($roles as $key => $role)
                    <option value="{{$role->name}}"
                            @if($user->hasRole($role->name)) selected @endif >{{$role->name}}</option>
                @endforeach
            </select>
            @error('role')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div> <div class="col-lg-3">
        <p>{{__('User Image')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="avatar" type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                   name="avatar" accept="image/*" onchange="readURL(this);"
                   value="@if($user->avatar){{$user->avatar}}@else{{ old('avatar') }}@endif"
                   autofocus>

            @error('avatar')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <img id="image" src="{{asset('uploads/users/'.$user->avatar)}}" class="img-wh-100 mt-2">
    </div>

</div>

@push('js')

    <script>

        (function($){
            "use strict";

            $(document).ready(function () {

                $("#usersForm").validate();

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image')
                            .attr('src', e.target.result)
                            .width(140)
                            .height(120);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

        })(jQuery)

    </script>
@endpush
