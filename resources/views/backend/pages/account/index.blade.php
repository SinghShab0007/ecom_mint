@extends('backend.layouts.app')

@section('title','Account User - ')

@section('content')
    <div class="maan-main-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="multivendors-profile card">
                    <div class="profile-bg">
                        @if(auth('seller')->user())
                            <img src="{{URL::to('uploads/sellers/'.Auth::user()->banner)}}" alt="">
                        @endif

                    </div>
                    <div class="profile-img">
                        @if(auth('admin')->user())
                            <img id="profile_picture" width="100px" height="100px"
                                    src="{{URL::to('uploads/users/'.Auth::user()->avatar)}}" alt="user avatar"/>
                        @else
                            <img id="profile_picture" width="100px" height="100px"
                                    src="{{URL::to('uploads/sellers/'.Auth::user()->image)}}" alt="user avatar"/>
                        @endif
                    </div>
                    <div class="profile-details card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><span>{{ __('Name:') }}</span> {{auth()->user()->name??auth()->user()->company_name}}</li>
                            <li class="list-group-item"><span>{{ __('Email:') }}</span> {{auth()->user()->email}}</li>
                            <li class="list-group-item">{{ __('Registration Date: 12 Dec 2022') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">

                <div class="multivendor-profile-section card">
                    <div class="profile-title">
                        <h4>{{__('Profile')}}</h4>
                    </div>
                    <div class="multivendor-profile-wrapper">
                        <form action="@auth('admin'){{route('backend.account.update',auth()->user()->id)}}@elseauth('seller') {{route('seller.account.update',auth()->user()->id)}}@endauth" class="ajaxform_instant_reload" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if(auth('admin')->user())
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Name') }}</label>
                                    <div class="col-lg-8">
                                        <input readonly name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" value="@if($user->name){{$user->name}}@else{{ old('name') }}@endif" required>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Shop Name') }}</label>
                                    <div class="col-lg-8">
                                        <input readonly name="company_name" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" type="text" value="@if($user->company_name){{$user->company_name}}@else{{ old('company_name') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Mobile') }}</label>
                                    <div class="col-lg-8">
                                        <input name="mobile" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" type="number" value="@if($user->mobile){{$user->mobile}}@else{{ old('mobile') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('First Name') }}</label>
                                    <div class="col-lg-8">
                                        <input name="first_name" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" value="@if($user->first_name){{$user->first_name}}@else{{ old('first_name') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('last Name') }}</label>
                                    <div class="col-lg-8">
                                        <input name="last_name" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" value="@if($user->last_name){{$user->last_name}}@else{{ old('last_name') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Commission') }}</label>
                                    <div class="col-lg-8">
                                        <input readonly  name="seller_commission" class="form-control" value="@if($user->commission){{$user->commission->seller_commission}}@else{{ old('seller_commission') }}@endif">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('TIN/Trade Licence') }}</label>
                                    <div class="col-lg-8">
                                        <input name="tin" class="form-control {{ $errors->has('tin') ? ' is-invalid' : '' }}" type="text" value="@if($user->tin){{$user->tin}}@else{{ old('tin') }}@endif">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('NID/Passport') }}</label>
                                    <div class="col-lg-8">
                                        <input name="nid_no" class="form-control {{ $errors->has('nid_no') ? ' is-invalid' : '' }}" type="text" value="@if($user->nid_no){{$user->nid_no}}@else{{ old('nid_no') }}@endif">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Website') }}</label>
                                    <div class="col-lg-8">
                                        <input name="website" class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}" type="text" value="@if($user->website){{$user->website}}@else{{ old('website') }}@endif">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Facebook') }}</label>
                                    <div class="col-lg-8">
                                        <input name="facebook" class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}" type="text" value="@if($user->facebook){{$user->facebook}}@else{{ old('facebook') }}@endif">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Address') }}</label>
                                    <div class="col-lg-8">
                                        <input name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" value="@if($user->address){{$user->address}}@else{{ old('address') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('City') }}</label>
                                    <div class="col-lg-8">
                                        <input name="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" type="text" value="@if($user->city){{$user->city}}@else{{ old('city') }}@endif" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Post Code') }}</label>
                                    <div class="col-lg-8">
                                        <input name="post_code" class="form-control {{ $errors->has('post_code') ? ' is-invalid' : '' }}" type="number" value="@if($user->post_code){{$user->post_code}}@else{{ old('post_code') }}@endif" >
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Email') }}</label>
                                <div class="col-lg-8">
                                    <input name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="@if($user->email){{$user->email}}@else{{ old('email') }}@endif" required>
                                </div>
                            </div>

                            @if(auth('admin')->user())
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Profile Picture') }}</label>
                                    <div class="col-lg-8">
                                        <input name="avatar" class="form-control {{ $errors->has('avatar') ? ' is-invalid' : '' }}" accept="image/*" type="file" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Banner Picture') }}</label>
                                    <div class="col-lg-8">
                                        <input name="banner" type="file" class="form-control{{ $errors->has('banner') ? ' is-invalid' : '' }}" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label form-control-label">{{ __('Profile Picture') }}</label>
                                    <div class="col-lg-8">
                                        <input name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/*" type="file" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Current Password') }}</label>
                                <div class="col-lg-8">
                                    <input id="current_password" type="password" class="form-control" name="current_password" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label form-control-label">{{__('Password')}}</label>
                                <div class="col-lg-8">
                                    <input id="password" type="password" class="form-control" name="password" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label form-control-label">{{__('Confirm password')}}</label>
                                <div class="col-lg-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                                </div>
                            </div>
                            <div class="form-grou">
                                <button class="btn theme-btn mt-3 submit-btn">{{ __('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            "use strict";

            $(document).on('click', '.nav .nav-link', function () {
                $(this).parent('li').addClass('active');
                $(this).parent('li').siblings('li').removeClass('active');
            })

        });
    </script>
@endpush
