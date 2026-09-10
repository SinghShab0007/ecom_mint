<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Seller Registration') }} — {{ config('app.name') }}</title>
    <link rel="icon" href="@if(config('app.favicon')){{ asset(config('app.favicon')) }}@endif">
    @include('backend.includes.layout_css')
    <style>
        .seller-reg-page {
            min-height: 100vh;
            padding: 1.25rem 0 2.5rem;
            background: linear-gradient(160deg, #f0f2f7 0%, #e8ecf4 50%, #f5f6fa 100%);
        }
        .seller-reg-shell {
            max-width: 920px;
            margin: 0 auto;
            padding: 0 12px;
        }
        .seller-reg-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
        .seller-reg-card__head {
            text-align: center;
            padding: 0.5rem 1rem 0.65rem;
            border-bottom: 1px solid #eef0f4;
            background: #fafbfc;
        }
        .seller-reg-card__logo {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 28px;
            max-height: 28px;
            margin: 0 auto 0.35rem;
            overflow: hidden;
        }
        .seller-reg-card__logo img {
            max-height: 26px;
            max-width: 120px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }
        .seller-reg-card__body {
            padding: 1.5rem 1.25rem 2rem;
        }
        @media (min-width: 576px) {
            .seller-reg-card__body { padding: 1.75rem 2rem 2.25rem; }
        }
        .seller-reg-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a1d26;
            margin: 0.25rem 0 0.15rem;
            letter-spacing: -0.02em;
        }
        .seller-reg-bc {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
        }
        .seller-reg-bc a { color: #4C1D6B; }
        .seller-reg-block {
            margin-bottom: 1.75rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eef0f4;
        }
        .seller-reg-block:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .seller-reg-block__title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }
        .seller-reg .form-label {
            font-weight: 600;
            font-size: 0.8125rem;
            color: #475569;
            margin-bottom: 0.35rem;
        }
        .seller-reg .form-control,
        .seller-reg select.form-control {
            border-radius: 8px;
            border-color: #cbd5e1;
            font-size: 0.9375rem;
            padding: 0.5rem 0.75rem;
            min-height: 42px;
        }
        .seller-reg .form-control:focus {
            border-color: #4C1D6B;
            box-shadow: 0 0 0 3px rgba(76, 29, 107, 0.15);
        }
        .seller-reg .form-control[type="file"] {
            padding: 0.4rem 0.65rem;
            min-height: auto;
        }
        .seller-reg .form-text { font-size: 0.75rem; color: #94a3b8; }
        .seller-reg-submit {
            width: 100%;
            max-width: 280px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            margin-top: 0.5rem;
        }
        .seller-reg-footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1.25rem;
            justify-content: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #eef0f4;
            font-size: 0.9rem;
        }
        .seller-reg #gstinWrap.is-hidden { display: none !important; }
    </style>
</head>
<body class="seller-reg">

<div class="seller-reg-page">
    <div class="seller-reg-shell">
        <div class="seller-reg-card">
            <div class="seller-reg-card__head">
                <div class="seller-reg-card__logo">
                    <img src="@if(config('app.logo')){{ asset(config('app.logo')) }}@endif" alt="{{ config('app.name') }}">
                </div>
                <h1 class="seller-reg-title">{{ __('Seller Registration') }}</h1>
                <p class="seller-reg-bc">
                    <a href="{{ url('/') }}">{{ __('Home') }}</a> / {{ __('Registration') }}
                </p>
            </div>
            <div class="seller-reg-card__body seller-reg">

                @if($categories->isEmpty())
                    <div class="alert alert-warning mb-0">{{ __('No product categories are configured. Please contact the administrator.') }}</div>
                @else
                <form action="{{ route('seller.register') }}" method="post" enctype="multipart/form-data" id="sellerRegistrationForm" novalidate>
                    @csrf

                    <div class="seller-reg-block">
                        <h2 class="seller-reg-block__title">{{ __('Seller account') }}</h2>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="email">{{ __('E-mail') }} <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autocomplete="email">
                                @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <div class="input-group password-field">
                                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                    <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1" aria-label="{{ __('Show password') }}" data-target="password">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <div class="input-group password-field">
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
                                    <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1" aria-label="{{ __('Show password') }}" data-target="password_confirmation">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="seller-reg-block">
                        <h2 class="seller-reg-block__title">{{ __('Contact information') }}</h2>
                        <div class="row">
                            {{-- Only one business type is offered, so there is nothing to choose:
                                 show it as a fixed value and post it as a hidden field. --}}
                            @php($defaultBusinessType = array_key_first($businessTypes))
                            <div class="col-12 mb-3">
                                <label class="form-label" for="business_type_display">{{ __('Business Type') }} <span class="text-danger">*</span></label>
                                <input type="hidden" name="business_type" value="{{ $defaultBusinessType }}">
                                <input id="business_type_display" type="text" class="form-control" readonly
                                       value="{{ $businessTypes[$defaultBusinessType] }}" tabindex="-1">
                                @error('business_type')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-12 mb-3" id="gstinWrap">
                                <label class="form-label" for="gstin">{{ __('GSTIN') }} <span class="text-danger">*</span></label>
                                <input id="gstin" name="gstin" type="text" maxlength="15" class="form-control text-uppercase @error('gstin') is-invalid @enderror"
                                       value="{{ old('gstin') }}" placeholder="{{ __('e.g. 22AAAAA0000A1Z5') }}" required autocomplete="off">
                                <p class="form-text mb-0">{{ __('15-character GSTIN issued to your business.') }}</p>
                                @error('gstin')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="referral_code">{{ __('Referral Code') }}</label>
                                <input id="referral_code" name="referral_code" type="text" class="form-control" value="{{ old('referral_code') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pan">{{ __('PAN') }} <span class="text-danger">*</span></label>
                                <input id="pan" name="pan" type="text" maxlength="10" class="form-control text-uppercase @error('pan') is-invalid @enderror" value="{{ old('pan') }}" placeholder="{{ __('e.g. ABCDE1234F') }}" required autocomplete="off">
                                @error('pan')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pan_image">{{ __('Upload PAN card (image or PDF)') }} <span class="text-danger">*</span></label>
                                <input id="pan_image" name="pan_image" type="file" class="form-control @error('pan_image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/webp,application/pdf,.pdf" required>
                                <p class="form-text mb-0">{{ __('JPG, PNG, WEBP or PDF — max 4 MB') }}</p>
                                @error('pan_image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="aadhaar">{{ __('Aadhaar Card Number') }} <span class="text-danger">*</span></label>
                                <input id="aadhaar" name="aadhaar" type="text" inputmode="numeric" maxlength="12"
                                       class="form-control @error('aadhaar') is-invalid @enderror"
                                       value="{{ old('aadhaar') }}" placeholder="{{ __('12-digit Aadhaar number') }}"
                                       required autocomplete="off">
                                <p class="form-text mb-0">{{ __('Digits only — no spaces or dashes.') }}</p>
                                @error('aadhaar')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bank_account_number">{{ __('Bank Account Number') }} <span class="text-danger">*</span></label>
                                <input id="bank_account_number" name="bank_account_number" type="text" inputmode="numeric" maxlength="18"
                                       class="form-control @error('bank_account_number') is-invalid @enderror"
                                       value="{{ old('bank_account_number') }}" placeholder="{{ __('Your bank account number') }}"
                                       required autocomplete="off">
                                <p class="form-text mb-0">{{ __('Digits only — 9 to 18 digits.') }}</p>
                                @error('bank_account_number')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ifsc_code">{{ __('IFSC Code') }} <span class="text-danger">*</span></label>
                                <input id="ifsc_code" name="ifsc_code" type="text" maxlength="11"
                                       class="form-control text-uppercase @error('ifsc_code') is-invalid @enderror"
                                       value="{{ old('ifsc_code') }}" placeholder="{{ __('e.g. SBIN0001234') }}"
                                       required autocomplete="off">
                                <p class="form-text mb-0">{{ __('11 characters — 4 letters, 0, then 6 characters.') }}</p>
                                @error('ifsc_code')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="business_name">{{ __('Business name') }} <span class="text-danger">*</span></label>
                                <input id="business_name" name="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror" value="{{ old('business_name') }}" required>
                                @error('business_name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="shop_owner_name">{{ __('Shop Owner Name') }} <span class="text-danger">*</span></label>
                                <input id="shop_owner_name" name="shop_owner_name" type="text" class="form-control @error('shop_owner_name') is-invalid @enderror" value="{{ old('shop_owner_name') }}" required>
                                @error('shop_owner_name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mobile">{{ __('Shop Owner Mobile Number') }} <span class="text-danger">*</span></label>
                                <input id="mobile" name="mobile" type="tel" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="{{ __('10-digit mobile number') }}" required>
                                @error('mobile')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="shop_manager_name">{{ __('Shop Manager Name (if any)') }}</label>
                                <input id="shop_manager_name" name="shop_manager_name" type="text" class="form-control" value="{{ old('shop_manager_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="shop_manager_mobile">{{ __('Shop Manager Mobile Number') }}</label>
                                <input id="shop_manager_mobile" name="shop_manager_mobile" type="tel" inputmode="numeric" class="form-control" value="{{ old('shop_manager_mobile') }}">
                            </div>
                        </div>
                    </div>

                    <div class="seller-reg-block">
                        <h2 class="seller-reg-block__title">{{ __('Shop Address') }}</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="first_name">{{ __('First name') }} <span class="text-danger">*</span></label>
                                <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                @error('first_name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="last_name">{{ __('Last name') }}</label>
                                <input id="last_name" name="last_name" type="text" class="form-control" value="{{ old('last_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="company_name">{{ __('Shop Name') }} <span class="text-danger">*</span></label>
                                <input id="company_name" name="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                                @error('company_name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="shop_no_complex">{{ __('Shop No. & Complex/Bazar Name') }} <span class="text-danger">*</span></label>
                                <input id="shop_no_complex" name="shop_no_complex" type="text" class="form-control @error('shop_no_complex') is-invalid @enderror" value="{{ old('shop_no_complex') }}" required>
                                @error('shop_no_complex')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="area">{{ __('Area (Street/Colony/Road/Village)') }}</label>
                                <input id="area" name="area" type="text" class="form-control" value="{{ old('area') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="landmark">{{ __('Nearby Landmark') }}</label>
                                <input id="landmark" name="landmark" type="text" class="form-control" value="{{ old('landmark') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="post_code">{{ __('Zip/postal code') }} <span class="text-danger">*</span></label>
                                <input id="post_code" name="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" value="{{ old('post_code') }}" required>
                                @error('post_code')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="city">{{ __('City') }} <span class="text-danger">*</span></label>
                                <input id="city" name="city" type="text" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                                @error('city')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="district">{{ __('District') }}</label>
                                <input id="district" name="district" type="text" class="form-control" value="{{ old('district') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="state">{{ __('State/province') }} <span class="text-danger">*</span></label>
                                <select id="state" name="state" class="form-control @error('state') is-invalid @enderror" required>
                                    <option value="">{{ __('— Select State —') }}</option>
                                    @foreach($indianStates as $st)
                                        <option value="{{ $st }}" {{ (old('state') === $st) ? "selected" : "" }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                                @error('state')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="country">{{ __('Country') }} <span class="text-danger">*</span></label>
                                <select id="country" name="country" class="form-control" required>
                                    <option value="India" {{ (old('country', 'India') === 'India') ? "selected" : "" }}>{{ __('India') }}</option>
                                 
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="shipping_phone">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                <input id="shipping_phone" name="shipping_phone" type="tel" inputmode="numeric" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone') }}" placeholder="+91" required>
                                @error('shipping_phone')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="seller-reg-block">
                        <h2 class="seller-reg-block__title">{{ __('Business category') }}</h2>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="category">{{ __('Business Category') }} <span class="text-danger">*</span></label>
                                <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category', $defaultCategoryId) == $category->id) ? "selected" : "" }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12 mb-0">
                                <label class="form-label" for="shop_image">{{ __('Shop Image / Document') }}</label>
                                <input id="shop_image" name="shop_image" type="file" class="form-control @error('shop_image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/webp,application/pdf,.pdf">
                                <p class="form-text mb-0">{{ __('Optional — JPG, PNG, WEBP or PDF — max 4 MB') }}</p>
                                @error('shop_image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check pl-0">
                            <input class="form-check-input @error('data_consent') is-invalid @enderror" type="checkbox" name="data_consent" id="data_consent" value="1" {{ old('data_consent') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="data_consent" style="font-size:0.9rem;">
                                {{ __('I agree to have my personal data processed as described in the') }}
                                <a href="{{ url('/page/privacy-n-policy') }}" target="_blank" rel="noopener noreferrer">{{ __('privacy policy') }}</a>.
                            </label>
                            @error('data_consent')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary seller-reg-submit login-btn">{{ __('Register') }}</button>
                </form>
                @endif

                <div class="seller-reg-footer-links">
                    <a href="{{ route('seller.password.request') }}">{{ __('Forgot Password?') }}</a>
                    <a href="{{ route('seller.login') }}">{{ __('Sign In') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.includes.layout_js')
<script>
(function () {
    // GSTIN is now mandatory for every seller, so there is no show/hide logic —
    // the field is always visible and required.

    // Aadhaar: digits only, capped at 12.
    var aadhaar = document.getElementById('aadhaar');
    if (aadhaar) {
        aadhaar.addEventListener('input', function () {
            var digits = aadhaar.value.replace(/\D/g, '').slice(0, 12);
            if (aadhaar.value !== digits) { aadhaar.value = digits; }
        });
    }

    // Mobile: digits only, capped at 10.
    var mobile = document.getElementById('mobile');
    if (mobile) {
        mobile.addEventListener('input', function () {
            var digits = mobile.value.replace(/\D/g, '').slice(0, 10);
            if (mobile.value !== digits) { mobile.value = digits; }
        });
    }

    // Bank account number: digits only, capped at 18.
    var bankAcc = document.getElementById('bank_account_number');
    if (bankAcc) {
        bankAcc.addEventListener('input', function () {
            var digits = bankAcc.value.replace(/\D/g, '').slice(0, 18);
            if (bankAcc.value !== digits) { bankAcc.value = digits; }
        });
    }

    // IFSC: uppercase alphanumeric, capped at 11.
    var ifsc = document.getElementById('ifsc_code');
    if (ifsc) {
        ifsc.addEventListener('input', function () {
            var v = ifsc.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 11);
            if (ifsc.value !== v) { ifsc.value = v; }
        });
    }

    // Client-side file-size guard (Laravel rule allows max 4 MB per file).
    var MAX_BYTES = 4 * 1024 * 1024; // 4 MB
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            if (!input.files || !input.files.length) return;
            var file = input.files[0];
            if (file.size > MAX_BYTES) {
                var mb = (file.size / 1024 / 1024).toFixed(1);
                alert('"' + file.name + '" is ' + mb + ' MB. Please choose a file 4 MB or smaller.');
                input.value = '';
            }
        });
    });

    // Show / hide password toggles
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-target'));
            if (!target) return;
            var icon = btn.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                btn.setAttribute('aria-label', '{{ __("Hide password") }}');
            } else {
                target.type = 'password';
                if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
                btn.setAttribute('aria-label', '{{ __("Show password") }}');
            }
        });
    });
})();
</script>
</body>
</html>
