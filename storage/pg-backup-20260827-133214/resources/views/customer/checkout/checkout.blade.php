@extends('frontend.layouts.front')

@section('title','Checkout')

@section('content')

    @push('css')
        <style>
            .billing-details .checkout-form .form-label {
                font-size: 14px;
                color: #2b2f38;
                margin-bottom: 6px;
                display: inline-block;
            }
            .billing-details .checkout-form .form-control {
                height: 44px;
                border: 1px solid #e2e5ec;
                border-radius: 6px;
                padding: 0 14px;
                font-size: 14px;
                color: #2b2f38;
                background: #fff;
                text-transform: none;
            }
            .billing-details .checkout-form .form-control:focus {
                box-shadow: none;
                border-color: #8a8f9b;
                outline: none;
            }
            .billing-details .checkout-form .form-control[readonly] {
                background: #f4f6f9;
                color: #5d6881;
                cursor: not-allowed;
            }
            .billing-details .checkout-form .section-title {
                font-size: 18px;
                font-weight: 600;
                color: #1f2330;
            }
            .billing-details .checkout-form .pincode-status.text-success { color: #2e7d32; }
            .billing-details .checkout-form .pincode-status.text-danger  { color: #c62828; }
            .billing-details .checkout-form .form-check { padding-left: 1.75rem; }
            .billing-details .checkout-form .form-check-input { margin-left: -1.75rem; }
            /* Kill any inherited floating-label animation on this page */
            .billing-details .checkout-form .input-group span.label,
            .billing-details .checkout-form span.label { display: none !important; }
        </style>
    @endpush

    <!-- Billing Details Start -->
    <section class="billing-details bg-light">
        <form action="{{ route('customer.payment') }}" method="post" class="ajaxform_instant_reload">
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
                                <div class="checkout-form mt-4">
                                    <input type="hidden" name="country" value="India">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $billing->first_name ?? auth('customer')->user()->first_name }}" placeholder="Enter your full name" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Mobile Number') }} <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="mobile" inputmode="numeric" pattern="\d{10}" maxlength="10" value="{{ $billing->mobile ?? auth('customer')->user()->mobile }}" required>
                                        </div>
                                    </div>

                                    <h5 class="section-title mt-3 mb-3 border-bottom pb-2">{{ __('Billing Details') }}</h5>
                                    <div class="row pincode-group" data-prefix="billing">
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Country / Region') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="India" readonly>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">{{ __('House number and Street name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="billing_address" value="{{ $billing->address_1 ?? '' }}" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Apartment, suite, unit, etc. (optional)') }}</label>
                                            <input type="text" class="form-control" name="billing_address_2" value="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Postcode / ZIP') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control pincode-input" name="billing_pincode" inputmode="numeric" maxlength="6" pattern="\d{6}" value="{{ $billing->post_code ?? '' }}" required>
                                            <small class="pincode-status text-muted d-block mt-1"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">{{ __('Town / City') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="billing_city" value="{{ $billing->user_city ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">{{ __('District') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control district-input" name="billing_district" value="" readonly required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">{{ __('State') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control state-input" name="billing_state" value="" readonly required>
                                        </div>
                                    </div>

                                    <div class="form-check my-3">
                                        <input class="form-check-input" type="checkbox" id="sameAsBilling" name="same_as_billing" value="1" checked>
                                        <label class="form-check-label" for="sameAsBilling">
                                            {{ __('Billing and Shipping details are the same') }}
                                        </label>
                                    </div>

                                    <div id="shippingDetailsWrap" style="display: none;">
                                        <h5 class="section-title mt-3 mb-3 border-bottom pb-2">{{ __('Shipping Details') }}</h5>
                                        <div class="row pincode-group" data-prefix="shipping">
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">{{ __('Country / Region') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="India" readonly>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">{{ __('House number and Street name') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="shipping_address" value="{{ $shipping->address_line_one ?? '' }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">{{ __('Apartment, suite, unit, etc. (optional)') }}</label>
                                                <input type="text" class="form-control" name="shipping_address_2" value="{{ $shipping->address_line_two ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">{{ __('Postcode / ZIP') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control pincode-input" name="shipping_pincode" inputmode="numeric" maxlength="6" pattern="\d{6}" value="{{ $shipping->shipping_post ?? '' }}">
                                                <small class="pincode-status text-muted d-block mt-1"></small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">{{ __('Town / City') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="shipping_city" value="{{ $shipping->shipping_town ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">{{ __('State') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control state-input" name="shipping_state" value="" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">{{ __('District') }} <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control district-input" name="shipping_district" value="" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mb-3">
                                        <label class="form-label fw-semibold d-block">{{ __('Payment Method') }} <span class="text-danger">*</span></label>
                                        <div class="row mt-2">
                                            {{-- Cash On Delivery is intentionally not offered on this page. --}}
                                            @if($paysantsPayEnabled ?? false)
                                            <div class="col-12">
                                                <input type="radio" name="payment_method" id="payment_method_paysantspay" class="d-none" checked="checked" value="PaysantsPay">
                                                <label for="payment_method_paysantspay" class="payment-title"><i class="fa-solid fa-credit-card"></i> UPI / Pay</label>
                                            </div>
                                            @else
                                            <div class="col-12">
                                                <div class="alert alert-warning mb-0" role="alert">
                                                    {{ __('No online payment method is available right now. Please contact our support team to complete your order.') }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn-anime w-50 submit-btn"
                                                @if(!($paysantsPayEnabled ?? false)) disabled @endif>{{ __('CONFIRM ORDER') }}</button>
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
                                        @if ($carts ?? false)
                                            @foreach ($carts as $key => $cart)
                                                <tr id="cart-row-{{ $key }}">
                                                    <th scope="row">
                                                        <img src="{{ asset('uploads/products/galleries') }}/{{ CartItem::thumbnail($cart->id) }}" class="b-1" alt="{{ CartItem::name($cart->id) }}">
                                                        <p>
                                                            {{ CartItem::name($cart->id) }}
                                                            @if ($cart->color)
                                                                <span class="badge bg-light text-dark">({{ $cart->color }})</span>
                                                            @endif
                                                            @if ($cart->size)
                                                                - <span class="badge bg-light text-dark">({{ $cart->size }})</span>
                                                            @endif
                                                        </p>
                                                    </th>
                                                    <td class="table-quantity">
                                                        <div class="quantity">
                                                            <input type="button" value="-" class="minus" data-key="{{ $key }}" data-id="{{ $cart->id }}" onclick="updateCart($(this))">
                                                            <input type="number" class="input-number w-25 qty" min="1" name="quantity" value="{{ $cart->quantity }}" onchange="updateCart($(this))" oninput="updateCart($(this))" data-key="{{ $key }}" data-id="{{ $cart->id }}" data-product-stock="{{ $cart->product_stock }}">
                                                            <input type="button" value="+" class="plus" data-key="{{ $key }}" data-id="{{ $cart->id }}" data-product-stock="{{ $cart->product_stock }}"  onclick="updateCart($(this))">
                                                        </div>
                                                    </td>
                                                    <td class="total">
                                                        {{ currency(CartItem::price($cart->id, $cart->quantity), 2) }}
                                                    </td>
                                                    <td class="table-close-btn">
                                                        <button type="button" onclick="removeFromCart(`{{ $key }}`,{{ $cart->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.995 511.995">
                                                                <path d="M437.126,74.939c-99.826-99.826-262.307-99.826-362.133,0C26.637,123.314,0,187.617,0,256.005
                                    s26.637,132.691,74.993,181.047c49.923,49.923,115.495,74.874,181.066,74.874s131.144-24.951,181.066-74.874
                                    C536.951,337.226,536.951,174.784,437.126,74.939z M409.08,409.006c-84.375,84.375-221.667,84.375-306.042,0
                                    c-40.858-40.858-63.37-95.204-63.37-153.001s22.512-112.143,63.37-153.021c84.375-84.375,221.667-84.355,306.042,0
                                    C493.435,187.359,493.435,324.651,409.08,409.006z" />
                                                                <path d="M341.525,310.827l-56.151-56.071l56.151-56.071c7.735-7.735,7.735-20.29,0.02-28.046
                                    c-7.755-7.775-20.31-7.755-28.065-0.02l-56.19,56.111l-56.19-56.111c-7.755-7.735-20.31-7.755-28.065,0.02
                                    c-7.735,7.755-7.735,20.31,0.02,28.046l56.151,56.071l-56.151,56.071c-7.755,7.735-7.755,20.29-0.02,28.046
                                    c3.868,3.887,8.965,5.811,14.043,5.811s10.155-1.944,14.023-5.792l56.19-56.111l56.19,56.111
                                    c3.868,3.868,8.945,5.792,14.023,5.792c5.078,0,10.175-1.944,14.043-5.811C349.28,331.117,349.28,318.562,341.525,310.827z" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">
                                                    <p class="text-center">{{ __('No available item in cart') }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>

                                    <div class="order-cart mt-4">
                                        <ul id="order-details">
                                            <li>{{ __('Subtotal') }}<span class="sub-total">{{ currency(Cookie::get('subTotal'), 2) }}</span></li>
                                            <li>{{ __('Shipping Charge') }}
                                                @if(Cookie::get('totalShipping') == 0)
                                                    <span class="total-shipping">{{ __('Free') }}</span>
                                                @else
                                                    <span class="total-shipping">{{ currency(Cookie::get('totalShipping'),2) }}</span>
                                                @endif
                                            </li>
                                            @if (Cookie::get('coupon_discount'))
                                                <li>{{ __('Coupon') }}<span>{{ currency(Cookie::get('coupon_discount'), 2) }}</span></li>
                                            @endif
                                            <li>{{ __('Total') }}<span class="grand-total">{{ currency(Cookie::get('total') - Cookie::get('coupon_discount'), 2) }}</span></li>
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
        (function () {
            var lookupUrl = "{{ route('pincode.lookup') }}";

            function wirePincodeGroup($group) {
                var $pin      = $group.find('.pincode-input');
                var $state    = $group.find('.state-input');
                var $district = $group.find('.district-input');
                var $status   = $group.find('.pincode-status');
                var last      = '';

                function setStatus(msg, cls) {
                    $status.text(msg || '').removeClass('text-muted text-danger text-success');
                    if (cls) $status.addClass(cls);
                }

                function clearAuto() {
                    $state.val('');
                    $district.val('');
                }

                function lookup(pin) {
                    if (pin === last) return;
                    last = pin;
                    setStatus("{{ __('Looking up pincode...') }}", 'text-muted');
                    $.ajax({
                        url: lookupUrl,
                        data: { pincode: pin },
                        type: 'GET',
                        dataType: 'json'
                    }).done(function (res) {
                        if (res && res.success) {
                            $state.val(res.state || '');
                            $district.val(res.district || '');
                            setStatus(res.state + ' / ' + res.district, 'text-success');
                            syncIfMirroring();
                        } else {
                            clearAuto();
                            setStatus((res && res.message) || "{{ __('Pincode not found') }}", 'text-danger');
                        }
                    }).fail(function (xhr) {
                        clearAuto();
                        var msg = "{{ __('Pincode lookup failed') }}";
                        try {
                            var j = xhr.responseJSON;
                            if (j && j.message) msg = j.message;
                        } catch (e) {}
                        setStatus(msg, 'text-danger');
                    });
                }

                $pin.on('input', function () {
                    var v = ($pin.val() || '').replace(/\D/g, '').slice(0, 6);
                    $pin.val(v);
                    if (v.length === 6) {
                        lookup(v);
                    } else {
                        last = '';
                        clearAuto();
                        setStatus('', 'text-muted');
                    }
                });

                $(function () {
                    var initial = ($pin.val() || '').replace(/\D/g, '').slice(0, 6);
                    if (initial.length === 6) {
                        $pin.val(initial);
                        lookup(initial);
                    }
                });
            }

            $('.pincode-group').each(function () { wirePincodeGroup($(this)); });

            // Mirror billing → shipping when the "same as billing" checkbox is checked.
            var $checkbox       = $('#sameAsBilling');
            var $shippingWrap   = $('#shippingDetailsWrap');
            var billingFields   = ['billing_address', 'billing_address_2', 'billing_pincode', 'billing_city', 'billing_district', 'billing_state'];
            var shippingFields  = ['shipping_address', 'shipping_address_2', 'shipping_pincode', 'shipping_city', 'shipping_district', 'shipping_state'];

            function copyBillingToShipping() {
                for (var i = 0; i < billingFields.length; i++) {
                    var val = $('[name="' + billingFields[i] + '"]').val() || '';
                    $('[name="' + shippingFields[i] + '"]').val(val);
                }
            }

            function syncIfMirroring() {
                if ($checkbox.is(':checked')) copyBillingToShipping();
            }

            function applyCheckboxState() {
                if ($checkbox.is(':checked')) {
                    $shippingWrap.hide();
                    copyBillingToShipping();
                    $shippingWrap.find('input').prop('required', false);
                } else {
                    $shippingWrap.show();
                    $shippingWrap.find('input[name="shipping_address"], input[name="shipping_pincode"], input[name="shipping_city"], input[name="shipping_district"], input[name="shipping_state"]').prop('required', true);
                }
            }

            $checkbox.on('change', applyCheckboxState);
            // Keep shipping in sync while user edits billing.
            $(document).on('input change', '.pincode-group[data-prefix="billing"] input', syncIfMirroring);

            applyCheckboxState();
        })();

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

        function removeFromCart(key,id){
            swal({
                title: "{{ __('Really!?') }}",
                text: "{{ __('Are you sure you want remove this form cart?') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((whileDelete)=>{
                if(whileDelete){
                    var csrf = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('customer.removeFromCart') }}",
                        data: {_token:csrf,key:key,id:id},
                        type: "POST"
                    }).done(function(e) {
                        swal("{{ __('Poof! Your item has been removed!') }}", {
                            icon: "success",
                        }).then(value => {
                            $("#cart-count").text(e.count);
                            $(".sub-total").text(e.sub_total);
                            $(".grand-total").text(e.grand_total);
                            $(".total-shipping").text(e.totalShipping);
                            $("#cart-row-"+key).remove();
                        });
                    })
                }
            })
        }

        function updateCart(elem) {
            var key = elem.data('key');
            var id = elem.data('id');
            var product_stock = elem.data('product-stock');
            var action = elem.val();
            var qty = elem.closest('tr').find('.qty').val();

            if(isNaN(action)) {
                if(elem.val() === '+') {
                    qty = parseInt(qty) + 1;
                } else {
                    qty = parseInt(qty) - 1;
                }
            }
            if (product_stock==qty || product_stock<=qty){
                qty = product_stock;
            }
            var csrf = "{{ csrf_token() }}";

            if(qty > 0) {
                $.ajax({
                    url: "{{ route('customer.updateCart') }}",
                    data: {_token:csrf,key:key,id:id,qty:qty},
                    method: "POST",
                }).done(function(e) {
                    if (e.status == 'success') {
                        $(".sub-total").text(e.sub_total);
                        $(".grand-total").text(e.grand_total);
                        elem.closest('tr').find('.qty').val(qty);
                        elem.closest('tr').find('.total').text(e.productTotal);
                    } else {
                        $('.qty').val(parseInt($('.qty').val()) - 1);
                        swal("{{ __('Sorry!') }}", e, "error");
                    }
                })
            }
        }

    </script>
@endpush
