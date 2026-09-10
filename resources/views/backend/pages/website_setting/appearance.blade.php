@extends('backend.layouts.app')
@section('title','Website Appearance - ')
@push('css')

@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
                @include('backend.pages.website_setting.nav')
                <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="appearance" aria-labelledby="appearance-tab">
                        <div class="container content-title">
                            <h4>{{__('Appearance Information')}}</h4>
                        </div>
                        <div class="container">
                            <form id="appearanceForm" method="post"
                                  action="{{route('backend.website_setting.appearance.update',$appearance->id)}}"
                                  enctype="multipart/form-data" class="add-brand-form">
                                @csrf()
                                @method('PUT')
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Frontend website Name')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="website_name" required
                                                               class="form-control @error('website_name') invalid @enderror"
                                                               value="@if($appearance->website_name){{$appearance->website_name}}@else{{old('website_name')}}@endif"
                                                               placeholder="Maan ecommerce">
                                                        @error('website_name')
                                                        <label class="error" id="website_name-error"
                                                               for="website_name">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Website Logo')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <img id="logo" src="{{URL::to('uploads/'.$appearance->logo)}}"
                                                         alt="logo" width="150">
                                                    <div class="input-group">
                                                        <input type="file" name="logo" accept="image/*"
                                                               type="file"
                                                               onchange="document.getElementById('logo').src = window.URL.createObjectURL(this.files[0])"
                                                               class="form-control @error('logo') invalid @enderror"
                                                               value="@if($appearance->logo){{$appearance->logo}}@else{{old('logo')}}@endif">
                                                        @error('logo')
                                                        <label class="error" id="logo-error"
                                                               for="logo">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Website Favicon')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <img id="favicon" src="{{URL::to('uploads/'.$appearance->favicon)}}"
                                                         alt="favicon" width="100">
                                                    <div class="input-group">
                                                        <input type="file" name="favicon" accept="image/*"
                                                               type="file"
                                                               onchange="document.getElementById('favicon').src = window.URL.createObjectURL(this.files[0])"
                                                               class="form-control @error('favicon') invalid @enderror"
                                                               value="@if($appearance->favicon){{$appearance->favicon}}@else{{old('favicon')}}@endif">
                                                        @error('favicon')
                                                        <label class="error" id="favicon-error"
                                                               for="favicon">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Backend Logo')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <img id="backend_logo" src="{{URL::to('uploads/'.$appearance->backend_logo)}}"
                                                         alt="backend_logo" width="150">
                                                    <div class="input-group">
                                                        <input type="file" name="backend_logo" accept="image/*"
                                                               onchange="document.getElementById('backend_logo').src = window.URL.createObjectURL(this.files[0])"
                                                               class="form-control @error('backend_logo') invalid @enderror"
                                                               value="@if($appearance->backend_logo){{$appearance->backend_logo}}@else{{old('backend_logo')}}@endif">
                                                        @error('backend_logo')
                                                        <label class="error" id="backend_logo-error"
                                                               for="backend_logo">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <span class="title">{{__('Website Base Color (Hex color code)')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="website_base_color" required
                                                               class="form-control @error('website_base_color') invalid @enderror"
                                                               value="@if($appearance->website_base_color){{$appearance->website_base_color}}@else{{old('website_base_color')}}@endif"
                                                               placeholder="#E62E04">
                                                        @error('website_base_color')
                                                        <label class="error" id="website_base_color-error"
                                                               for="website_base_color">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Website Base Hover Color (Hex color code)')}}<span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="website_base_hover_color" required
                                                               class="form-control @error('website_base_hover_color') invalid @enderror"
                                                               value="@if($appearance->website_base_hover_color){{$appearance->website_base_hover_color}}@else{{old('website_base_hover_color')}}@endif"
                                                               placeholder="#E62E04">
                                                        @error('website_base_hover_color')
                                                        <label class="error" id="website_base_hover_color-error"
                                                               for="website_base_hover_color">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Cookies Agreement Text')}}</span></div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                    <textarea name="cookies_agreement_desc"
                                                              class="editor form-control">{{$appearance->cookies_agreement_desc}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="show-cookies-btn">{{__('Show Cookies Agreement?')}}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group check-toggle-btn">
                                                        <div class="form-switch">
                                                            <input type="hidden" name="is_show_cookies_agreement"
                                                                   value="0">
                                                            <input class="form-check-input" value="1" name="is_show_cookies_agreement"
                                                                   @if($appearance->is_show_cookies_agreement)checked
                                                                   @endif type="checkbox">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Meta Title')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="meta_title" required
                                                               class="form-control @error('meta_title') invalid @enderror"
                                                               value="@if($appearance->meta_title){{$appearance->meta_title}}@else{{old('meta_title')}}@endif"
                                                               placeholder="Maan ecommerce CMS">
                                                        @error('meta_title')
                                                        <label class="error" id="meta_title-error"
                                                               for="meta_title">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Meta description')}} </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="meta_desc"
                                                               class="form-control @error('meta_desc') invalid @enderror"
                                                               value="@if($appearance->meta_desc){{$appearance->meta_desc}}@else{{old('meta_desc')}}@endif"
                                                               placeholder="Maan ecommerce CMS">
                                                        @error('meta_desc')
                                                        <label class="error" id="meta_desc-error"
                                                               for="meta_desc">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Keywords')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="keywords" required
                                                               class="form-control @error('keywords') invalid @enderror"
                                                               value="@if($appearance->keywords){{$appearance->keywords}}@else{{old('keywords')}}@endif"
                                                               placeholder="Keywords,Keyword,Separate with coma">
                                                        @error('keywords')
                                                        <label class="error" id="keywords-error"
                                                               for="keywords">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Hotline Number')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="hotline_number" required
                                                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                               class="form-control @error('hotline_number') invalid @enderror"
                                                               value="@if($appearance->hotline_number){{$appearance->hotline_number}}@else{{old('hotline_number')}}@endif"
                                                               placeholder="01xxxxxxx">
                                                        @error('hotline_number')
                                                        <label class="error" id="hotline_number-error"
                                                               for="hotline_number">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Email')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="email" name="email" required
                                                               class="form-control @error('email') invalid @enderror"
                                                               value="@if($appearance->email){{$appearance->email}}@else{{old('email')}}@endif"
                                                               placeholder="Email">
                                                        @error('email')
                                                        <label class="error" id="email-error"
                                                               for="email">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Default Currency')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <select name="currency_id"
                                                                class="form-select currency form-control{{ $errors->has('currency_id') ? ' is-invalid' : '' }}"
                                                                required>
                                                            <option value="">{{ __('Select Currency') }}</option>
                                                            @foreach($currencies as $key => $currency)
                                                                <option value="{{$currency->id}}"
                                                                        @if($currency->id==$appearance->currency_id|| $currency->id==old('currency_id')) selected @endif >{{$currency->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('currency_id'))
                                                        <label class="error " id="currency_id-error"
                                                               for="currency_id">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Base Currency')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <select name="base_currency_id"
                                                                class="form-select currency form-control{{ $errors->has('base_currency_id') ? ' is-invalid' : '' }}"
                                                                required>
                                                            <option value="">{{ __('Select Currency') }}</option>
                                                            @foreach($currencies as $key => $currency)
                                                                <option value="{{$currency->id}}"
                                                                        @if($currency->id==$appearance->base_currency_id|| $currency->id==old('base_currency_id')) selected @endif >{{$currency->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('base_currency_id'))
                                                        <label class="error " id="currency_id-error"
                                                               for="currency_id">{{$message}}</label>
                                                        @enderror
                                                        <div class="sm-text small text-danger">{{__('Please update change
                                                            exchange rate of every currency after you update the base
                                                            currency')}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Get in Touch')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <textarea type="text" name="get_in_touch" required
                                                                  class="form-control @error('get_in_touch') invalid @enderror"
                                                                  placeholder="Get in Touch"
                                                        >@if($appearance->get_in_touch && $appearance->get_in_touch!="''"){{$appearance->get_in_touch}}@else{{old('get_in_touch')}}@endif</textarea>
                                                        @error('get_in_touch')
                                                        <label class="error" id="get_in_touch-error"
                                                               for="get_in_touch">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('About Us')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <textarea type="text" name="about_us" required
                                                                  class="form-control @error('about_us') invalid @enderror"
                                                                  placeholder="About us"
                                                        >@if($appearance->about_us && $appearance->about_us!="''"){{$appearance->about_us}}@else{{old('about_us')}}@endif</textarea>
                                                        @error('about_us')
                                                        <label class="error" id="about_us-error"
                                                               for="about_us">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <span class="title">{{__('City')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="city" required
                                                               class="form-control @error('city') invalid @enderror"
                                                               value="@if($appearance->city){{$appearance->city}}@else{{old('city')}}@endif"
                                                               placeholder="City">
                                                        @error('city')
                                                        <label class="error" id="city-error"
                                                               for="city">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Country')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <select name="country"
                                                                class="form-select country form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                                                                required>
                                                            <option value="">{{ __('Select Country') }}</option>
                                                            @foreach($countries as $key => $country)
                                                                <option value="{{$country->name}}"
                                                                        @if($country->name==$appearance->country|| $country->id==old('country')) selected @endif >{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country'))
                                                        <label class="error " id="country-error"
                                                               for="country">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <span class="title">{{__('Post Code')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="post_code" required
                                                               class="form-control @error('post_code') invalid @enderror"
                                                               value="@if($appearance->post_code){{$appearance->post_code}}@else{{old('post_code')}}@endif"
                                                               placeholder="Post Code">
                                                        @error('post_code')
                                                        <label class="error" id="post_code-error"
                                                               for="post_code">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <span class="title">{{__('Facebook Link')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="facebook_link" required
                                                               class="form-control @error('facebook_link') invalid @enderror"
                                                               value="@if($appearance->facebook_link && $appearance->facebook_link!="''"){{$appearance->facebook_link}}@else{{old('facebook_link')}}@endif"
                                                               placeholder="Facebook Link">
                                                        @error('facebook_link')
                                                        <label class="error" id="facebook_link-error"
                                                               for="facebook_link">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Twitter Link')}} <span
                                                            class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="twitter_link" required
                                                               class="form-control @error('twitter_link') invalid @enderror"
                                                               value="@if($appearance->twitter_link && $appearance->twitter_link!="''"){{$appearance->twitter_link}}@else{{old('twitter_link')}}@endif"
                                                               placeholder="Twitter Link">
                                                        @error('twitter_link')
                                                        <label class="error" id="twitter_link-error"
                                                               for="twitter_link">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Pinterest Link')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="pinterest_link" required
                                                               class="form-control @error('pinterest_link') invalid @enderror"
                                                               value="@if($appearance->pinterest_link && $appearance->pinterest_link!="''"){{$appearance->pinterest_link}}@else{{old('pinterest_link')}}@endif"
                                                               placeholder="Pinterest Link">
                                                        @error('pinterest_link')
                                                        <label class="error" id="pinterest_link-error"
                                                               for="pinterest_link">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Instagram Link')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="instagram_link" required
                                                               class="form-control @error('instagram_link') invalid @enderror"
                                                               value="@if($appearance->instagram_link && $appearance->instagram_link!="''"){{$appearance->instagram_link}}@else{{old('instagram_link')}}@endif"
                                                               placeholder="Instagram Link">
                                                        @error('instagram_link')
                                                        <label class="error" id="instagram_link-error"
                                                               for="instagram_link">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Linkdin Link')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="linkdin_link" class="form-control" placeholder="Linkdin Link" value="@if($appearance->linkdin_link && $appearance->linkdin_link!="''"){{$appearance->linkdin_link}}@else{{old('linkdin_link')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="title">{{__('Youtube Link')}} <span class="text-red">*</span></span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="youtube_link" class="form-control" placeholder="Youtube Link" value="@if($appearance->youtube_link && $appearance->youtube_link!="''"){{$appearance->youtube_link}}@else{{old('youtube_link')}}@endif" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 offset-3">
                                            <div class="from-submit-btn">
                                                <button class="submit-btn" type="submit">{{__('Update')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End  -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {

            "use strict";
            $(document).ready(function () {
                $('#appearanceForm').validate();
                $('.country').select2();
                $('.currency').select2();
                /*rich text editor set*/
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
                })
            });

        });
    </script>
@endpush
