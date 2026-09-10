@extends('customer.layouts.master')

@section('title','My Profile')
@section('page_title', __('My Profile'))

@section('content')

    {{-- Flash + validation feedback --}}
    @if(session('success'))
        <div class="pk-alert pk-alert-ok">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pk-alert pk-alert-err">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="pk-alert pk-alert-err">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Account summary --}}
    <div class="pk-card">
        <div class="pk-card-head">
            <div>
                <h3>{{ __('Profile Photo') }}</h3>
                <p>{{ __('JPG or PNG. This is shown across your account.') }}</p>
            </div>
        </div>
        <div class="pk-card-body">
            <form action="{{ route('profile.image',$user->id) }}" method="post" enctype="multipart/form-data"
                  id="pkAvatarForm">
                @csrf
                <div class="pk-avatar-row">
                    <img src="{{ $user->avatar_url }}"
                         alt="{{ $user->username }}" id="blah" class="pk-avatar-lg"
                         onerror="this.src='{{ asset('frontend/img/users/default.png') }}';this.onerror=null;">
                    <div style="flex:1;min-width:220px;">
                        <div class="pk-field" style="margin-bottom:10px;">
                            <label for="file">{{ __('Choose a new photo') }}</label>
                            <input type="file" id="file" name="image" onchange="readURL(this)"
                                   accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp">
                            <p class="pk-hint" id="pkAvatarHint">
                                {{ __('PNG, JPG or WEBP') }} &middot; {{ __('max') }} {{ $uploadLimitMb }} MB
                            </p>
                        </div>
                        <button type="submit" class="pk-btn">{{ __('Update Photo') }}</button>
                        <p class="pk-hint">
                            {{ __('Last login') }}:
                            {{ $user->last_login_datetime ? $user->last_login_datetime->format('d M Y, h:i A') : __('Not available') }}
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Personal details --}}
    <form action="{{ route('profile.update', auth('customer')->id()) }}" method="post" class="ajaxform">
        @csrf

        <div class="pk-card">
            <div class="pk-card-head">
                <div>
                    <h3>{{ __('Personal Information') }}</h3>
                    <p>{{ __('Keep your contact details up to date for smooth deliveries.') }}</p>
                </div>
            </div>
            <div class="pk-card-body">
                <div class="pk-grid-2">
                    <div class="pk-field">
                        <label for="first_name">{{ __('First name') }}</label>
                        <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                    </div>
                    <div class="pk-field">
                        <label for="last_name">{{ __('Last name') }}</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
                    </div>
                    <div class="pk-field">
                        <label for="username">{{ __('Username') }}</label>
                        <input type="text" id="username" name="username" value="{{ $user->username }}" required>
                    </div>
                    <div class="pk-field">
                        <label for="mobile">{{ __('Contact number') }}</label>
                        <input type="text" id="mobile" name="mobile" value="{{ $user->mobile }}" required>
                    </div>
                    <div class="pk-field">
                        <label for="dob">{{ __('Date of birth') }}</label>
                        <input type="date" id="dob" name="dob" value="{{ $user->dob ? $user->dob->format('Y-m-d') : '' }}">
                    </div>
                    <div class="pk-field">
                        <label for="email_display">{{ __('Email address') }}</label>
                        <input type="email" id="email_display" value="{{ $user->email }}" disabled>
                    </div>
                </div>

                <div class="pk-field">
                    <label for="address">{{ __('Address') }}</label>
                    <input type="text" id="address" name="address" value="{{ $user->address }}" required>
                </div>
            </div>
        </div>

        {{-- Password --}}
        <div class="pk-card">
            <div class="pk-card-head">
                <div>
                    <h3>{{ __('Change Password') }}</h3>
                    <p>{{ __('Leave both fields empty if you do not want to change it.') }}</p>
                </div>
            </div>
            <div class="pk-card-body">
                <div class="pk-grid-2">
                    <div class="pk-field">
                        <label for="old_password">{{ __('Current password') }}</label>
                        <input type="password" id="old_password" name="old_password" autocomplete="current-password">
                    </div>
                    <div class="pk-field">
                        <label for="new_password">{{ __('New password') }}</label>
                        <input type="password" id="new_password" name="password" autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="pk-btn submit-btn">{{ __('Save Changes') }}</button>
            </div>
        </div>
    </form>

@stop

@section('script')
    <script>
        var PK_MAX_MB = {{ $uploadLimitMb }};

        function readURL(input) {
            "use strict";
            if (!input.files || !input.files[0]) { return; }

            var file = input.files[0];
            var hint = document.getElementById('pkAvatarHint');

            // Catch an oversized photo here — once it exceeds PHP's limit the file
            // never reaches the server and the page would just silently reload.
            if (file.size > PK_MAX_MB * 1024 * 1024) {
                input.value = '';
                hint.style.color = '#a12626';
                hint.textContent = "{{ __('That photo is') }} " + (file.size / 1048576).toFixed(1) +
                    " MB — {{ __('please choose one under') }} " + PK_MAX_MB + " MB.";
                return;
            }

            if (!/\.(png|jpe?g|webp)$/i.test(file.name)) {
                input.value = '';
                hint.style.color = '#a12626';
                hint.textContent = "{{ __('Only PNG, JPG and WEBP images are allowed.') }}";
                return;
            }

            hint.style.color = '';
            hint.textContent = "{{ __('Ready to upload') }}: " + file.name;

            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }

        @if(Session::has('success'))
            swal("{{ __('Success!') }}", "{{ Session::get('success') }}", "success");
        @endif

        @if(Session::has('error'))
            swal("{{ __('Error') }}", "{{ Session::get('error') }}", "error");
        @endif
    </script>
@stop
