<div class="row">
    <div class="col-lg-3">
        <p>{{__('First Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="first_name" type="text" required class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="@if($customer->first_name){{$customer->first_name}}@else{{ old('first_name') }}@endif" placeholder="First Name">
            @if ($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Last Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="last_name" type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="@if($customer->last_name){{$customer->last_name}}@else{{ old('last_name') }}@endif" placeholder="Last Name">
            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Mobile')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="mobile" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                   class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                   value="@if($customer->mobile){{$customer->mobile}}@else{{ old('mobile') }}@endif"
                   placeholder="Mobile" required>
            @error('mobile')
            <label id="mobile-error" class="invalid-feedback error" for="mobile">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Email')}}<span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="@if($customer->email){{$customer->email}}@else{{ old('email') }}@endif" placeholder="Email" required>
            @error('email')
            <label id="email-error" class="invalid-feedback error" for="email">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Username')}}<span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="username" type="text"
                   class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                   value="@if($customer->username){{$customer->username}}@else{{ old('username') }}@endif"
                   placeholder="Username" required>
            @error('username')
            <label id="username-error" class="invalid-feedback error" for="username">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Password')}}<span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="password" type="password" minlength="8" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="" placeholder="Password" @if(Request::is('admin/customers/create')) required @endif>
            @error('password')
            <label id="password-error" class="invalid-feedback error" for="password">{{$message}}</label>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Confirm Password')}} @if(Request::is('admin/customers/create')) <span class="text-red">*</span> @endif </p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input type="password" minlength="8" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="Confirm Password" @if(Request::is('admin/customers/create')) required @endif>
            @error('password_confirmation')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Address')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea name="address" placeholder="Address" required class="form-control">@if($customer->address){{$customer->address}}@else{{old('address')}}@endif</textarea>
            @error('address')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>

</div>
@push('js')
    <script>
        $(document).ready(function () {
            "use strict";
            $("#customersForm").validate();
        });
    </script>
@endpush
