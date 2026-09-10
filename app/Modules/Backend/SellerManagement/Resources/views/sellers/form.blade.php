@php
    $isEdit = isset($seller) && $seller->exists;
    $sellerCategoryId = old('category', $seller->category_id ?? ($defaultCategoryId ?? null));
    $sellerBusinessType = old('business_type', $seller->business_type ?? 'gstin');
@endphp

<style>
    .admin-seller-form .section-title { font-size: 16px; font-weight: 600; color:#1f2330; border-bottom:1px solid #e3e6ef; padding-bottom:6px; margin: 18px 0 12px; }
    .admin-seller-form .form-label { font-size:13px; color:#3b4252; margin-bottom:4px; }
    .admin-seller-form .form-text { font-size:12px; color:#7d8597; }
    .admin-seller-form .gstin-wrap.is-hidden { display:none; }
    .admin-seller-form .password-toggle { border-left:0; }
</style>

<div class="row admin-seller-form">

    {{-- Account --}}
    <div class="col-12 section-title">{{ __('Account') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $seller->email ?? '') }}" @if(!$isEdit) required @endif>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="mobile">{{ __('Mobile Number') }} <span class="text-danger">*</span></label>
        <input id="mobile" type="tel" name="mobile" inputmode="numeric" pattern="\d{10}" maxlength="10" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', $seller->mobile ?? '') }}" @if(!$isEdit) required @endif>
        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="password">{{ __('Password') }} @if(!$isEdit)<span class="text-danger">*</span>@endif</label>
        <div class="input-group password-field">
            <input id="password" type="password" name="password" minlength="6" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" @if(!$isEdit) required @endif>
            <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1" data-target="password"><i class="fa-solid fa-eye"></i></button>
        </div>
        @if($isEdit)<small class="form-text">{{ __('Leave blank to keep the existing password.') }}</small>@endif
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }} @if(!$isEdit)<span class="text-danger">*</span>@endif</label>
        <div class="input-group password-field">
            <input id="password_confirmation" type="password" name="password_confirmation" minlength="6" class="form-control" autocomplete="new-password" @if(!$isEdit) required @endif>
            <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1" data-target="password_confirmation"><i class="fa-solid fa-eye"></i></button>
        </div>
    </div>

    {{-- Business --}}
    <div class="col-12 section-title">{{ __('Business') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Business Type') }} <span class="text-danger">*</span></label>
        <select id="business_type" name="business_type" class="form-control form-select @error('business_type') is-invalid @enderror" @if(!$isEdit) required @endif>
            @foreach($businessTypes ?? [] as $key => $label)
                <option value="{{ $key }}" {{ ($sellerBusinessType === $key) ? "selected" : "" }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('business_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3 gstin-wrap">
        <label class="form-label" for="gstin">{{ __('GSTIN') }} <span class="text-danger gstin-star">*</span></label>
        <input id="gstin" type="text" name="gstin" maxlength="15" class="form-control text-uppercase @error('gstin') is-invalid @enderror" value="{{ old('gstin', $seller->gstin ?? '') }}" placeholder="{{ __('e.g. 22AAAAA0000A1Z5') }}">
        <small class="form-text">{{ __('15-character GSTIN.') }}</small>
        @error('gstin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="referral_code">{{ __('Referral Code') }}</label>
        <input id="referral_code" type="text" name="referral_code" class="form-control" value="{{ old('referral_code', $seller->referral_code ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="category">{{ __('Category') }} <span class="text-danger">*</span></label>
        <select id="category" name="category" class="form-control form-select @error('category') is-invalid @enderror" @if(!$isEdit) required @endif>
            <option value="">{{ __('Select category') }}</option>
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat->id }}" {{ ((string) $sellerCategoryId === (string) $cat->id) ? "selected" : "" }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- PAN --}}
    <div class="col-12 section-title">{{ __('PAN') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="pan">{{ __('PAN') }} <span class="text-danger">*</span></label>
        <input id="pan" type="text" name="pan" maxlength="10" class="form-control text-uppercase @error('pan') is-invalid @enderror" value="{{ old('pan', $seller->pan ?? '') }}" placeholder="ABCDE1234F" @if(!$isEdit) required @endif>
        @error('pan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="aadhaar">{{ __('Aadhaar Card Number') }}</label>
        <input id="aadhaar" type="text" name="aadhaar" inputmode="numeric" maxlength="12"
               class="form-control @error('aadhaar') is-invalid @enderror"
               value="{{ old('aadhaar', $seller->aadhaar ?? '') }}" placeholder="{{ __('12-digit Aadhaar number') }}">
        <small class="form-text">{{ __('Digits only — 12 characters.') }}</small>
        @error('aadhaar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="pan_image">{{ __('Upload PAN card (image or PDF)') }} @if(!$isEdit)<span class="text-danger">*</span>@endif</label>
        <input id="pan_image" type="file" name="pan_image" class="form-control @error('pan_image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/webp,application/pdf,.pdf" @if(!$isEdit) required @endif>
        <small class="form-text">{{ __('JPG, PNG, WEBP or PDF — max 4 MB.') }}
            @if($isEdit && $seller->pan_image)
                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($seller->pan_image) }}" target="_blank" rel="noopener">{{ __('View current') }}</a>
            @endif
        </small>
        @error('pan_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    {{-- Bank --}}
    <div class="col-12 section-title">{{ __('Bank Details') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="bank_account_number">{{ __('Bank Account Number') }}</label>
        <input id="bank_account_number" type="text" name="bank_account_number" inputmode="numeric" maxlength="18"
               class="form-control @error('bank_account_number') is-invalid @enderror"
               value="{{ old('bank_account_number', $seller->bank_account_number ?? '') }}"
               placeholder="{{ __('9 to 18 digits') }}">
        <small class="form-text">{{ __('Digits only.') }}</small>
        @error('bank_account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="ifsc_code">{{ __('IFSC Code') }}</label>
        <input id="ifsc_code" type="text" name="ifsc_code" maxlength="11"
               class="form-control text-uppercase @error('ifsc_code') is-invalid @enderror"
               value="{{ old('ifsc_code', $seller->ifsc_code ?? '') }}"
               placeholder="{{ __('e.g. SBIN0001234') }}">
        <small class="form-text">{{ __('11 characters.') }}</small>
        @error('ifsc_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Business Info --}}
    <div class="col-12 section-title">{{ __('Business Information') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="business_name">{{ __('Business Name') }} <span class="text-danger">*</span></label>
        <input id="business_name" type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{ old('business_name', $seller->business_name ?? '') }}" @if(!$isEdit) required @endif>
        @error('business_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="company_name">{{ __('Company Name') }} <span class="text-danger">*</span></label>
        <input id="company_name" type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $seller->company_name ?? '') }}" @if(!$isEdit) required @endif>
        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="shop_owner_name">{{ __('Shop Owner Name') }} <span class="text-danger">*</span></label>
        <input id="shop_owner_name" type="text" name="shop_owner_name" class="form-control @error('shop_owner_name') is-invalid @enderror" value="{{ old('shop_owner_name', $seller->shop_owner_name ?? '') }}" @if(!$isEdit) required @endif>
        @error('shop_owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label" for="first_name">{{ __('First Name') }} <span class="text-danger">*</span></label>
        <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $seller->first_name ?? '') }}" @if(!$isEdit) required @endif>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label" for="last_name">{{ __('Last Name') }}</label>
        <input id="last_name" type="text" name="last_name" class="form-control" value="{{ old('last_name', $seller->last_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="shop_manager_name">{{ __('Shop Manager Name') }}</label>
        <input id="shop_manager_name" type="text" name="shop_manager_name" class="form-control" value="{{ old('shop_manager_name', $seller->shop_manager_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="shop_manager_mobile">{{ __('Shop Manager Mobile') }}</label>
        <input id="shop_manager_mobile" type="tel" name="shop_manager_mobile" class="form-control" value="{{ old('shop_manager_mobile', $seller->shop_manager_mobile ?? '') }}">
    </div>

    {{-- Shop Address --}}
    <div class="col-12 section-title">{{ __('Shop Address') }}</div>

    <div class="pincode-group row" data-prefix="shop">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="country">{{ __('Country') }} <span class="text-danger">*</span></label>
            <input id="country" type="text" name="country" class="form-control" value="{{ old('country', $seller->country ?? 'India') }}" @if(!$isEdit) required @endif>
            @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="post_code">{{ __('Pincode') }} <span class="text-danger">*</span></label>
            <input id="post_code" type="text" name="post_code" inputmode="numeric" maxlength="6" pattern="\d{6}" class="form-control pincode-input @error('post_code') is-invalid @enderror" value="{{ old('post_code', $seller->post_code ?? '') }}" @if(!$isEdit) required @endif>
            <small class="form-text pincode-status"></small>
            @error('post_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="shop_no_complex">{{ __('Shop No. / Complex / Street') }} <span class="text-danger">*</span></label>
            <input id="shop_no_complex" type="text" name="shop_no_complex" class="form-control @error('shop_no_complex') is-invalid @enderror" value="{{ old('shop_no_complex', $seller->shop_no_complex ?? '') }}" @if(!$isEdit) required @endif>
            @error('shop_no_complex')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="area">{{ __('Area') }}</label>
            <input id="area" type="text" name="area" class="form-control" value="{{ old('area', $seller->area ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="landmark">{{ __('Landmark') }}</label>
            <input id="landmark" type="text" name="landmark" class="form-control" value="{{ old('landmark', $seller->landmark ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="city">{{ __('City') }} <span class="text-danger">*</span></label>
            <input id="city" type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $seller->city ?? '') }}" @if(!$isEdit) required @endif>
            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="district">{{ __('District') }}</label>
            <input id="district" type="text" name="district" class="form-control district-input" value="{{ old('district', $seller->district ?? '') }}" readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="state">{{ __('State') }} <span class="text-danger">*</span></label>
            <select id="state" name="state" class="form-control form-select state-input @error('state') is-invalid @enderror" @if(!$isEdit) required @endif>
                <option value="">{{ __('Select state') }}</option>
                @foreach($indianStates ?? [] as $st)
                    <option value="{{ $st }}" {{ (old('state', $seller->state ?? '') === $st) ? "selected" : "" }}>{{ $st }}</option>
                @endforeach
            </select>
            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Shipping --}}
    <div class="col-12 section-title">{{ __('Shipping') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="shipping_phone">{{ __('Shipping Phone') }} <span class="text-danger">*</span></label>
        <input id="shipping_phone" type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', $seller->shipping_phone ?? '') }}" @if(!$isEdit) required @endif>
        @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Shop Image --}}
    <div class="col-12 section-title">{{ __('Shop Image / Document (optional)') }}</div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="image">{{ __('Shop Image / Document') }}</label>
        <input id="image" type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/webp,application/pdf,.pdf">
        <small class="form-text">{{ __('JPG, PNG, WEBP or PDF — max 4 MB.') }}
            @if($isEdit && $seller->image)
                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($seller->image) }}" target="_blank" rel="noopener">{{ __('View current') }}</a>
            @endif
        </small>
        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="submit-btn"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? __('Update') : __('Save') }}</button>
    </div>
</div>

@push('js')
<script>
(function () {
    // GSTIN toggle based on business_type
    var bt = document.getElementById('business_type');
    var gstinWrap = document.querySelector('.gstin-wrap');
    var gstin = document.getElementById('gstin');
    var gstinStar = document.querySelector('.gstin-star');
    function syncGstin() {
        if (!bt || !gstinWrap || !gstin) return;
        if (bt.value === 'gstin') {
            gstinWrap.classList.remove('is-hidden');
            gstin.setAttribute('required', 'required');
            if (gstinStar) gstinStar.style.display = 'inline';
        } else {
            gstinWrap.classList.add('is-hidden');
            gstin.removeAttribute('required');
            gstin.value = '';
            if (gstinStar) gstinStar.style.display = 'none';
        }
    }
    if (bt) {
        bt.addEventListener('change', syncGstin);
        syncGstin();
    }

    // Password show / hide
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-target'));
            if (!target) return;
            var icon = btn.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            } else {
                target.type = 'password';
                if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            }
        });
    });

    // File-size guard (4 MB)
    var MAX = 4 * 1024 * 1024;
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            if (!input.files || !input.files.length) return;
            var f = input.files[0];
            if (f.size > MAX) {
                alert('"' + f.name + '" is ' + (f.size / 1024 / 1024).toFixed(1) + ' MB. Max 4 MB.');
                input.value = '';
            }
        });
    });

    // Pincode → state/district auto-fill
    var lookupUrl = "{{ route('pincode.lookup') }}";
    var pin = document.querySelector('.pincode-input');
    var stateEl = document.querySelector('.state-input');
    var districtEl = document.querySelector('.district-input');
    var status = document.querySelector('.pincode-status');
    var lastLookup = '';

    function setStatus(msg, cls) {
        if (!status) return;
        status.textContent = msg || '';
        status.classList.remove('text-muted','text-danger','text-success');
        if (cls) status.classList.add(cls);
    }
    // The pincode API spells some UTs differently to our dropdown
    // (e.g. "The Dadra And Nagar Haveli And Daman And Diu"), so compare on a
    // normalised form instead of an exact string match.
    function normaliseState(v) {
        return (v || '')
            .toLowerCase()
            .replace(/^the\s+/, '')
            .replace(/[^a-z]/g, '');
    }

    function setStateValue(val) {
        if (!stateEl) return;
        if (stateEl.tagName === 'SELECT') {
            var target = normaliseState(val);
            var found = false;
            for (var i = 0; i < stateEl.options.length; i++) {
                if (normaliseState(stateEl.options[i].value) === target && target !== '') {
                    stateEl.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if (!found) stateEl.value = '';
        } else {
            stateEl.value = val || '';
        }
    }
    function lookup(p) {
        if (p === lastLookup) return;
        lastLookup = p;
        setStatus('Looking up pincode...', 'text-muted');
        fetch(lookupUrl + '?pincode=' + encodeURIComponent(p), { headers: { 'Accept': 'application/json' }})
            .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, body: j }; }); })
            .then(function (res) {
                if (res.ok && res.body && res.body.success) {
                    setStateValue(res.body.state);
                    if (districtEl) districtEl.value = res.body.district || '';
                    setStatus(res.body.state + ' / ' + res.body.district, 'text-success');
                } else {
                    if (districtEl) districtEl.value = '';
                    setStatus((res.body && res.body.message) || 'Pincode not found', 'text-danger');
                }
            })
            .catch(function () { setStatus('Pincode lookup failed', 'text-danger'); });
    }
    if (pin) {
        pin.addEventListener('input', function () {
            var v = (pin.value || '').replace(/\D/g, '').slice(0, 6);
            pin.value = v;
            if (v.length === 6) lookup(v);
            else { lastLookup = ''; setStatus('', 'text-muted'); if (districtEl) districtEl.value = ''; }
        });
        var initial = (pin.value || '').replace(/\D/g, '').slice(0, 6);
        if (initial.length === 6) lookup(initial);
    }

    // Uppercase PAN
    var panInput = document.getElementById('pan');
    if (panInput) {
        panInput.addEventListener('input', function () { panInput.value = panInput.value.toUpperCase(); });
    }

    // Aadhaar: digits only, capped at 12
    var aadhaarInput = document.getElementById('aadhaar');
    if (aadhaarInput) {
        aadhaarInput.addEventListener('input', function () {
            var digits = aadhaarInput.value.replace(/\D/g, '').slice(0, 12);
            if (aadhaarInput.value !== digits) { aadhaarInput.value = digits; }
        });
    }

    // Bank account number: digits only, capped at 18
    var bankAccInput = document.getElementById('bank_account_number');
    if (bankAccInput) {
        bankAccInput.addEventListener('input', function () {
            var digits = bankAccInput.value.replace(/\D/g, '').slice(0, 18);
            if (bankAccInput.value !== digits) { bankAccInput.value = digits; }
        });
    }

    // IFSC: uppercase alphanumeric, capped at 11
    var ifscInput = document.getElementById('ifsc_code');
    if (ifscInput) {
        ifscInput.addEventListener('input', function () {
            var v = ifscInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 11);
            if (ifscInput.value !== v) { ifscInput.value = v; }
        });
    }
})();
</script>
@endpush
