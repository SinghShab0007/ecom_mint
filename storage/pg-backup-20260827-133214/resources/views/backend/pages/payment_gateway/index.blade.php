@extends('backend.layouts.app')
@section('title', __('Payment Gateway') . ' - ')
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
                <div class="content-tab-title">
                    <h4>{{ __('Payment Gateway') }}</h4>
                </div>
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="appearance" aria-labelledby="appearance-tab">
                        <div class="container">
                            <div class="row g-4">
                                @foreach($payment_gateways as $payment_gateway)
                                    @php
                                        $displayName = $payment_gateway->name === 'PaysantsPay' ? 'UPI / Pay' : ucfirst($payment_gateway->name);
                                        $configLabels = [
                                            'merchant_id' => __('Merchant ID'),
                                            'app_id' => __('App ID'),
                                            'sign_key' => __('Sign Key'),
                                            'notify_url' => __('Notify URL'),
                                            'front_callback_url' => __('Front Callback URL'),
                                        ];
                                    @endphp
                                    <div class="col-12 col-lg-6 col-xl-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-header bg-light py-3">
                                                <h5 class="card-title mb-0">{{ $displayName }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <form class="add-brand-form"
                                                      action="{{ route('backend.payment_gateway.update', $payment_gateway->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    @foreach(json_decode($payment_gateway->configuration, true) ?? [] as $index => $config)
                                                        <div class="mb-3">
                                                            <label for="config-{{ $payment_gateway->id }}-{{ $index }}" class="form-label small text-muted">
                                                                {{ $configLabels[$index] ?? ucfirst(str_replace('_', ' ', $index)) }}
                                                            </label>
                                                            <input type="text"
                                                                   id="config-{{ $payment_gateway->id }}-{{ $index }}"
                                                                   name="configuration[{{ $index }}]"
                                                                   class="form-control form-control-sm @error('configuration.'.$index) is-invalid @enderror"
                                                                   value="{{ old('configuration.'.$index, $config ?? '') }}"
                                                                   placeholder="{{ $configLabels[$index] ?? $index }}">
                                                            @error('configuration.'.$index)
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    @endforeach
                                                    <div class="mb-3">
                                                        <label class="form-label small text-muted">{{ __('Status') }}</label>
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" value="0" name="status">
                                                            <input name="status"
                                                                   id="status-{{ $payment_gateway->id }}"
                                                                   @if($payment_gateway->status || old('status')) checked @endif
                                                                   class="form-check-input" value="1"
                                                                   type="checkbox">
                                                            <label class="form-check-label" for="status-{{ $payment_gateway->id }}">{{ __('Active') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-2 border-top">
                                                        <button class="btn btn-primary btn-sm" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
