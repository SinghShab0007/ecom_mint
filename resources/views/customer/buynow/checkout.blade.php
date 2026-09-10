@extends('frontend.layouts.front')

@section('title', 'Checkout')

@section('content')

    <!-- Billing Details Start -->
    <section class="billing-details bg-light">
        <form action="{{ route('buynow.store', ['product_id' => $product->id]) }}" method="post" class="ajaxform_instant_reload">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow rounded-3">
                            <div class="card-body">
                                <div class="buy-more-check">
                                    <h4 class="text-center">Order Submit OR</h4>
                                    <h5 class="text-center"><a class="text-primary" href="{{ url('/') }}">Buy More</a> <span class="animation-pulse"></span></h5>
                                </div>
                                <div class="login-form mt-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" name="first_name" value="{{ $billing->first_name ?? auth('customer')->user()->first_name }}" placeholder="Enter your full name">
                                                <span class="label">{{ __('Name') }} <span class="text-danger">*</span></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="number" name="mobile" value="{{ $billing->mobile ?? auth('customer')->user()->mobile }}">
                                                <span class="label">{{ __('Mobile Number') }} <span class="text-danger">*</span></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="text" name="shipping_address" value="{{ $shipping->address_line_one ?? null }}">
                                                <span class="label">{{ __('Shipping Address') }} <span class="text-danger">*</span></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="text" name="billing_address" value="{{ $billing->address_1 ?? null }}">
                                                <span class="label">{{ __('Billing Address') }} <span class="text-danger">*</span></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <span class="label">{{ __('Payment Method') }} <span class="text-danger">*</span></span>
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <input type="radio" name="payment_method" id="cashOnDelivery" class="d-none" checked="checked" value="COD">
                                                    <label for="cashOnDelivery" class="payment-title"><i class="fa-solid fa-hand-holding-dollar"></i> Cash On Delivery</label>
                                                </div>
                                                @if($gatewayEnabled ?? false)
                                                <div class="col-6">
                                                    <input type="radio" name="payment_method" id="payment_method_paydhara" class="d-none" value="Paydhara">
                                                    <label for="payment_method_paydhara" class="payment-title"><i class="fa-solid fa-credit-card"></i> {{ __('Pay Online') }}</label>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mb-3">
                                            <button type="submit" class="btn-anime w-50 submit-btn">{{ __('CONFIRM ORDER') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h4 class="text-center">{{ __('ORDER SUMMARY') }}</h4>
                                <div class="right-form mt-2">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Items') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">
                                                    <img height='70px' width="70px" class="rounded-circle" src="{{ asset('uploads/products/galleries') }}/{{ $product->images->first()->image ?? '' }}" class="b-1" alt="{{ $product->name }}">
                                                    <p>
                                                        {{ $product->name }}
                                                        @if (request('color'))
                                                            <span class="badge bg-light text-dark">({{ request('color') }})</span>
                                                        @endif
                                                        @if (request('size'))
                                                            - <span class="badge bg-light text-dark">({{ request('size') }})</span>
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    {{ request('qty') }}
                                                </td>
                                                <td>
                                                    {{ currency($product->sale_price * request('qty')) }}
                                                </td>
                                                <td class="table-close-btn">
                                                    <a href="{{ route('product', $product->slug) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.995 511.995">
                                                            <path d="M437.126,74.939c-99.826-99.826-262.307-99.826-362.133,0C26.637,123.314,0,187.617,0,256.005s26.637,132.691,74.993,181.047c49.923,49.923,115.495,74.874,181.066,74.874s131.144-24.951,181.066-74.874C536.951,337.226,536.951,174.784,437.126,74.939z M409.08,409.006c-84.375,84.375-221.667,84.375-306.042,0c-40.858-40.858-63.37-95.204-63.37-153.001s22.512-112.143,63.37-153.021c84.375-84.375,221.667-84.355,306.042,0C493.435,187.359,493.435,324.651,409.08,409.006z" />
                                                            <path d="M341.525,310.827l-56.151-56.071l56.151-56.071c7.735-7.735,7.735-20.29,0.02-28.046 c-7.755-7.775-20.31-7.755-28.065-0.02l-56.19,56.111l-56.19-56.111c-7.755-7.735-20.31-7.755-28.065,0.02c-7.735,7.755-7.735,20.31,0.02,28.046l56.151,56.071l-56.151,56.071c-7.755,7.735-7.755,20.29-0.02,28.046c3.868,3.887,8.965,5.811,14.043,5.811s10.155-1.944,14.023-5.792l56.19-56.111l56.19,56.111c3.868,3.868,8.945,5.792,14.023,5.792c5.078,0,10.175-1.944,14.043-5.811C349.28,331.117,349.28,318.562,341.525,310.827z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="order-cart mt-4">
                                        <ul id="order-details">
                                            <li>{{ __('Subtotal') }}<span class="sub-total">{{ currency($product->sale_price * request('qty'), 2) }}</span></li>
                                            <li>{{ __('Shipping Charge') }}
                                                @if( request('area') == 'inside'){{ __('(inside India)') }}
                                                @else {{ __('(outside India)') }} @endif
                                                @php
                                                    $shipping_cost = request('area') == 'inside' ? $product->shipping_cost : $product->outside_shipping_cost;
                                                @endphp
                                                @if(optional($product->details)->is_free_shipping)
                                                    <span class="total-shipping">{{ __('Free') }}</span>
                                                @else
                                                    <span class="total-shipping">{{ currency($shipping_cost) }}</span>
                                                @endif
                                            </li>
                                            @if (Cookie::get('coupon_discount'))
                                            <li>{{ __('Coupon') }}<span>{{ currency(Cookie::get('coupon_discount')) }}</span></li>
                                            @endif
                                            <li>{{ __('Total') }}<span class="grand-total">
                                                    @if(optional($product->details)->is_free_shipping)
                                                        {{ currency(($product->sale_price * request('qty') ) - Cookie::get('coupon_discount')) }}
                                                    @else
                                                        {{ currency(($product->sale_price * request('qty') + $shipping_cost) - Cookie::get('coupon_discount')) }}
                                                    @endif

                                                </span></li>
                                        </ul>
                                    </div>

                                    <h5 class="mb-2">{{ __('Promotional Code') }} ({{ __('Have a coupon?') }})</h5>
                                    @if (Cookie::get('coupon_infos'))
                                        @php
                                            $coupon_infos = json_decode(Cookie::get('coupon_infos'));
                                        @endphp
                                        <div class="right-search input-group mb-0">
                                            <input type="text" name="code" id="code" placeholder="Enter your coupon code" value="{{ $coupon_infos->code }}">
                                            <button type="button" class="btn-anime" id="apply-coupon">{{ __('Apply Coupon') }}</button>
                                        </div>
                                        <div class="row mb-2 coupon-infos">
                                            <div class="col-11">
                                                <h5 class="text-warning">{{ $coupon_infos->code }}</h5>
                                            </div>
                                            <div class="col-1">
                                                <h5><a href="javascript:void(0)" onclick="removeCoupon()"><i class="fa-solid fa-xmark text-danger"></i></a></h5>
                                            </div>
                                        </div>
                                    @else
                                    <div class="right-search input-group mb-0">
                                        <input type="text" name="code" id="code" placeholder="Enter your coupon code">
                                        <button type="button" class="btn-anime" id="apply-coupon">{{ __('Apply Coupon') }}</button>
                                    </div>
                                    <div class="row mb-2 coupon-infos">
                                        {{-- AJAX --}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </section>
    <!-- Billing Details End -->

@stop

@push('script')
    <script>
        $("#apply-coupon").click(function(){
            var code = $("#code").val();
            var csrf = "{{ @csrf_token() }}"
            $.ajax({
                url : "{{ route('customer.coupon') }}",
                data: {_token:csrf,code:code},
                type: 'post'
            }).done(function(res){
                if(res.status !== 'error'){
                    $('.coupon-infos').html(res.coupon_infos)
                    $("#order-details").html(res.after_coupon);
                    swal("Yes!",res.message,"success");
                }else{
                    swal("Oops!",res.msg,"error");
                }
            });
        })

        function removeCoupon() {
            var csrf = "{{ @csrf_token() }}"
            $.ajax({
                url : "{{ route('customer.coupon.remove') }}",
                data: {_token:csrf},
                type: 'post'
            }).done(function(res){
                $("#code").val('');
                $('.coupon-infos').html('');
                $("#order-details").html(res.data);
                swal("Yes!",res.message,"success");
            });
        }

    </script>
@endpush
