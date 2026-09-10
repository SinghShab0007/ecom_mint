@extends('backend.layouts.app')
@section('title','Seller Details - ')

@push('css')
<style>
    .seller-detail-card { background:#fff; border:1px solid #e3e6ef; border-radius:8px; padding:18px 20px; margin-bottom:18px; }
    .seller-detail-card h5 { font-size:16px; font-weight:600; color:#1f2330; margin:0 0 14px 0; padding-bottom:8px; border-bottom:1px solid #eef0f5; }
    .seller-detail-row { display:flex; flex-wrap:wrap; }
    .seller-detail-row .seller-detail-item { width:50%; padding:8px 12px 8px 0; font-size:14px; color:#3b4252; }
    .seller-detail-row .seller-detail-item .seller-detail-label { display:block; font-size:12px; color:#7d8597; margin-bottom:2px; }
    .seller-detail-row .seller-detail-item .seller-detail-value { word-break:break-word; }
    .seller-detail-row .seller-detail-item .seller-detail-value.empty { color:#b3b8c5; font-style:italic; }
    .seller-detail-badge { display:inline-block; padding:2px 8px; border-radius:12px; font-size:12px; }
    .seller-detail-badge.active { background:#e7f5ee; color:#1f7a47; }
    .seller-detail-badge.inactive { background:#fdecec; color:#a52525; }
    .seller-detail-badge.pending { background:#fff5e0; color:#a87000; }
    .seller-doc-preview { border:1px solid #e3e6ef; border-radius:6px; padding:10px; text-align:center; background:#f9fafc; }
    .seller-doc-preview img { max-width:100%; max-height:320px; border-radius:4px; }
    .seller-doc-preview .pdf-icon { font-size:48px; color:#c63838; margin-bottom:6px; }
    .seller-doc-actions { margin-top:10px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap; }
    .seller-doc-actions .btn { font-size:13px; }
    @media (max-width: 768px) {
        .seller-detail-row .seller-detail-item { width:100%; }
    }
</style>
@endpush

@section('content')
    @php
        $val = function ($v) { return ($v === null || $v === '') ? null : $v; };
    @endphp
    <div class="content-body">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">{{ __('Seller Details') }} — #{{ $seller->id }}</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('backend.sellers.edit', $seller->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-pen me-1"></i>{{ __('Edit') }}
                    </a>
                    <a href="{{ route('backend.sellers.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back') }}
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    {{-- Account & Status --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('Account & Status') }}</h5>
                        <div class="seller-detail-row">
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Email') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->email) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Mobile') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->mobile) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Email Verified') }}</span>
                                <span class="seller-detail-value">
                                    @if($seller->email_verified_at)
                                        <span class="seller-detail-badge active">{{ __('Verified') }}</span>
                                        <small class="text-muted ms-1">{{ \Carbon\Carbon::parse($seller->email_verified_at)->format('d M Y, H:i') }}</small>
                                    @else
                                        <span class="seller-detail-badge pending">{{ __('Pending') }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Account Status') }}</span>
                                <span class="seller-detail-value">
                                    @if($seller->is_active)
                                        <span class="seller-detail-badge active">{{ __('Active') }}</span>
                                    @else
                                        <span class="seller-detail-badge inactive">{{ __('Inactive') }}</span>
                                    @endif
                                    @if($seller->is_approve)
                                        <span class="seller-detail-badge active ms-1">{{ __('Approved') }}</span>
                                    @else
                                        <span class="seller-detail-badge pending ms-1">{{ __('Awaiting Approval') }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Registered On') }}</span>
                                <span class="seller-detail-value">{{ $seller->created_at ? $seller->created_at->format('d M Y, H:i') : '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Data Consent') }}</span>
                                <span class="seller-detail-value">
                                    @if($seller->data_consent)
                                        <span class="seller-detail-badge active">{{ __('Agreed') }}</span>
                                    @else
                                        <span class="seller-detail-badge inactive">{{ __('Not Agreed') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Business Information --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('Business Information') }}</h5>
                        <div class="seller-detail-row">
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Business Type') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->business_type) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('GSTIN') }}</span>
                                <span class="seller-detail-value @if(!$seller->gstin) empty @endif">
                                    {{ $val($seller->gstin) ?? __('Not provided') }}
                                    @if($seller->gstin && $seller->gstin_verified_at)
                                        <span class="seller-detail-badge active ms-1">{{ __('Verified') }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Business Name') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->business_name) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Company Name') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->company_name) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Referral Code') }}</span>
                                <span class="seller-detail-value @if(!$seller->referral_code) empty @endif">{{ $val($seller->referral_code) ?? __('None') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Category') }}</span>
                                <span class="seller-detail-value">
                                    @php
                                        $category = \App\Models\Seller\Category::find($seller->category_id);
                                    @endphp
                                    {{ $category->name ?? '—' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- PAN --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('PAN &amp; Aadhaar Details') }}</h5>
                        <div class="seller-detail-row">
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('PAN Number') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->pan) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Aadhaar Number') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->aadhaar) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Bank Account Number') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->bank_account_number) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('IFSC Code') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->ifsc_code) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('PAN Document') }}</span>
                                <span class="seller-detail-value">
                                    @if($panUrl)
                                        <a href="{{ $panUrl }}" target="_blank" rel="noopener">{{ __('View') }}</a>
                                        |
                                        <a href="{{ route('backend.sellers.pan.download', $seller->id) }}">{{ __('Download') }}</a>
                                    @else
                                        <span class="empty">{{ __('Not uploaded') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Owner & Shop Contacts --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('Owner & Shop Contacts') }}</h5>
                        <div class="seller-detail-row">
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('First Name') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->first_name) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Last Name') }}</span>
                                <span class="seller-detail-value @if(!$seller->last_name) empty @endif">{{ $val($seller->last_name) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Shop Owner Name') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->shop_owner_name) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Shop Manager Name') }}</span>
                                <span class="seller-detail-value @if(!$seller->shop_manager_name) empty @endif">{{ $val($seller->shop_manager_name) ?? __('Not provided') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Shop Manager Mobile') }}</span>
                                <span class="seller-detail-value @if(!$seller->shop_manager_mobile) empty @endif">{{ $val($seller->shop_manager_mobile) ?? __('Not provided') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Shipping Phone') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->shipping_phone) ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Shop Address --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('Shop Address') }}</h5>
                        <div class="seller-detail-row">
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Shop No. / Complex') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->shop_no_complex) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Area') }}</span>
                                <span class="seller-detail-value @if(!$seller->area) empty @endif">{{ $val($seller->area) ?? __('Not provided') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Landmark') }}</span>
                                <span class="seller-detail-value @if(!$seller->landmark) empty @endif">{{ $val($seller->landmark) ?? __('Not provided') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Pincode') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->post_code) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('City') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->city) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('District') }}</span>
                                <span class="seller-detail-value @if(!$seller->district) empty @endif">{{ $val($seller->district) ?? __('Not provided') }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('State') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->state) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item">
                                <span class="seller-detail-label">{{ __('Country') }}</span>
                                <span class="seller-detail-value">{{ $val($seller->country) ?? '—' }}</span>
                            </div>
                            <div class="seller-detail-item" style="width:100%;">
                                <span class="seller-detail-label">{{ __('Full Address (composed)') }}</span>
                                <span class="seller-detail-value @if(!$seller->address) empty @endif">{{ $val($seller->address) ?? __('—') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- PAN Document preview --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('PAN Card') }}</h5>
                        @if($panUrl)
                            <div class="seller-doc-preview">
                                @if(in_array($panExt, ['jpg','jpeg','png','webp','gif']))
                                    <img src="{{ $panUrl }}" alt="PAN card">
                                @elseif($panExt === 'pdf')
                                    <div class="pdf-icon"><i class="fa-solid fa-file-pdf"></i></div>
                                    <div class="text-muted small">{{ __('PDF document') }}</div>
                                @else
                                    <div class="text-muted small">{{ __('File uploaded') }}</div>
                                @endif
                                <div class="seller-doc-actions">
                                    <a href="{{ $panUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i>{{ __('View') }}
                                    </a>
                                    <a href="{{ route('backend.sellers.pan.download', $seller->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-download me-1"></i>{{ __('Download') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-muted small">{{ __('No PAN card uploaded.') }}</div>
                        @endif
                    </div>

                    {{-- Shop Image / Document --}}
                    <div class="seller-detail-card">
                        <h5>{{ __('Shop Image / Document') }}</h5>
                        @if($shopUrl)
                            <div class="seller-doc-preview">
                                @if(in_array($shopExt, ['jpg','jpeg','png','webp','gif']))
                                    <img src="{{ $shopUrl }}" alt="Shop">
                                @elseif($shopExt === 'pdf')
                                    <div class="pdf-icon"><i class="fa-solid fa-file-pdf"></i></div>
                                    <div class="text-muted small">{{ __('PDF document') }}</div>
                                @else
                                    <div class="text-muted small">{{ __('File uploaded') }}</div>
                                @endif
                                <div class="seller-doc-actions">
                                    <a href="{{ $shopUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i>{{ __('View') }}
                                    </a>
                                    <a href="{{ route('backend.sellers.shop_image.download', $seller->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-download me-1"></i>{{ __('Download') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-muted small">{{ __('No shop image uploaded.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
