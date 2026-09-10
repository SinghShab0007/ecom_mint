@extends('customer.layouts.master')

@section('content')
<div class="maan-request-cancellition">
    <div class="container">
        <form action="{{ route('customer.order.cancel', $order->id) }}" method="post">
            @csrf

            <div class="maan-request-cancellition-wrapper">
                <div class="title">
                    <h2>{{ __($status == 7 ? 'Request Cancellation':'Request Return') }}</h2>
                </div>
                <div class="select-cancel-items-wrapper">
                    <div class="cancel-header">
                        <h5>Choose the {{ $status == 7 ? 'cancel':'return' }} item(s) You want to {{ $status == 7 ? 'cancel':'return' }}</h5>
                    </div>
                    <div class="maan-product-cancel-items">
                        <label class="request-cancel-checkbox">
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                        <div class="cancel-product-thumb">
                            <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}" alt="{{ $order->product->name }}">
                            <input type="hidden" name="product_id" value="{{ $order->product->id }}">
                            <p>{{ $order->product->name }}</p>
                            <p>@if($order->color)
                                <span class="badge bg-light text-dark">{{ $order->color }}</span>
                            @endif
                            @if($order->size)
                                <span class="badge bg-light text-dark">{{ $order->size }}</span>
                            @endif
                            </p>
                        </div>
                        <div class="qty">
                            <p>{{ __('Qty') }}: {{ $order->qty }}</p>
                        </div>
                        <div class="maan-select-reason">
                            <input type="hidden" name="order_stat" value="{{ $status }}">
                            <select class="form-control" name="order_stat_desc">
                                <option value="{{ __('Change/Combine Order') }}" selected>{{ __('Change/Combine Order') }}</option>
                                <option value="{{ __('Delivery Time is to long') }}">{{ __('Delivery Time is to long') }}</option>
                                <option value="{{ __('Duplicate Order') }}">{{ __('Duplicate Order') }}</option>
                                <option value="{{ __('Change of delivery address') }}">{{ __('Change of delivery address') }}</option>
                                <option value="{{ __('Shipping Fees') }}">{{ __('Shipping Fees') }}</option>
                                <option value="{{ __('Change of mind') }}">{{ __('Change of mind') }}</option>
                                <option value="{{ __('Forgot to use Voucher/Voucher Issue') }}">{{ __('Forgot to use Voucher/Voucher Issue') }}</option>
                                <option value="{{ __('Decided for alternative Product') }}">{{ __('Decided for alternative Product') }}</option>
                                <option value="{{ __('Found Cheaper Elsewhere') }}">{{ __('Found Cheaper Elsewhere') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="select-cancel-items-wrapper">
                    <div class="cancel-header">
                        <h5>{{ __('Additional information (optional)') }}</h5>
                    </div>
                    <div class="info-wrappr">
                        <textarea class="form-control" name="remarks" placeholder="Additional information (optional)"></textarea>
                    </div>
                </div>
                <div class="select-cancel-items-wrapper">
                    <div class="cancel-header">
                        <h5>{{ __($status == 7 ? 'Cancellation Policy':'Return Policy') }}</h5>
                    </div>
                    <div class="policy-wrappr">
                        <div class="policy-content">
                        {{ $cancellationPolicy->description ?? '' }}
                        </div>
                        <label class="request-cancel-checkbox">
                            {{ __('I have read and accepted the cancellation Policy of POROSKART') }}
                            <input type="checkbox" name="confirm" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="maan-cancellition-btn">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>
@stop
