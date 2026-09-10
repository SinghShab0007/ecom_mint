@extends('frontend.layouts.front')

@section('title', 'CartItem')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Cart') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Card Table Start -->
    <section class="card-table">
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Items') }}</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('Quantity') }}</th>
                        <th scope="col">{{ __('Courier') }}</th>
                        <th colspan="2">{{ __('Total Price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($carts ?? false)
                        @foreach ($carts as $key => $cart)
                            <tr id="cart-row-{{ $key }}">
                                <th scope="row">
                                    <img src="{{ asset('uploads/products/galleries') }}/{{ CartItem::thumbnail($cart->id) }}"
                                        class="b-1" alt="{{ CartItem::name($cart->id) }}">
                                </th>
                                <td colspan="2" class="item-name">
                                    {{ CartItem::name($cart->id) }}
                                    @if ($cart->color)
                                        <span class="badge bg-light text-dark">({{ $cart->color }})</span>
                                    @endif
                                    @if ($cart->size)
                                        - <span class="badge bg-light text-dark">({{ $cart->size }})</span>
                                    @endif
                                </td>
                                <td class="text-right">{{ currency(CartItem::price($cart->id), 2) }}</td>
                                <td class="table-quantity">
                                    <form>
                                        <div class="quantity">
                                            <input type="button" value="-" class="minus" data-key="{{ $key }}" data-id="{{ $cart->id }}" data-product-stock="{{ $cart->product_stock ?? '' }}" onclick="updateCart($(this))">
                                            <input type="number" class="input-number qty" min="1" name="quantity" value="{{ $cart->quantity }}" onchange="updateCart($(this))" data-key="{{ $key }}" data-id="{{ $cart->id }}" data-product-stock="{{ $cart->product_stock ?? '' }}">
                                            <input type="button" value="+" class="plus" data-key="{{ $key }}" data-id="{{ $cart->id }}" data-product-stock="{{ $cart->product_stock ?? '' }}" onclick="updateCart($(this))">
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $cart->courier ?? '' }}</td>
                                <td class="total">
                                    {{ currency(CartItem::price($cart->id, $cart->quantity), 2) }}
                                </td>
                                <td class="table-close-btn">
                                    <button onclick="removeFromCart(`{{ $key }}`,{{ $cart->id }})">
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

            <div class="row justify-content-end py-1">
                <div class="col-sm-6 col-md-4">
                    @if (Cookie::get('total_vat'))
                    <div class="d-flex flex-wrap justify-content-between">
                        <h6>{{ __('Total Vat') }}:</h6>
                        <h6 id="total-vat">{{ currency(Cookie::get('total_vat'), 2) }}</h6>
                    </div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between">
                        <h6>{{ __('Total') }}:</h6>
                        <h6 id="grand-total">{{ currency(Cookie::get('subTotal') + Cookie::get('totalShipping'), 2) }}</h6>
                    </div>
                </div>
            </div>

            <div class="checkout-btn d-flex flex-wrap mt-4 justify-content-between">
                <a class="link-anime float-left bg-dark d-inline-block" href="{{ route('frontend.shop') }}"><i class="fa-solid fa-arrow-left"></i> {{ __('Continue Shopping') }}</a>
                @if ($carts ?? false)
                <a class="link-anime process-btn float-right" href="{{ route('checkout') }}">{{ __('Process to Checkout') }} <i class="fa-solid fa-arrow-right"></i></a>
                @endif
            </div>
        </div>
    </section>
@stop

@push('script')
<script>
    /*
     * updateCart()/removeFromCart() live in the checkout and seller layouts but
     * were never defined in frontend.layouts.front, which this page extends - so
     * the +/- buttons and the remove icon called an undefined function and did
     * nothing. Defined here, bound to this page's own markup.
     */
    function updateCart(elem) {
        var row   = elem.closest('tr');
        var key   = elem.data('key');
        var id    = elem.data('id');
        var stock = parseInt(elem.data('product-stock'), 10);
        var qty   = parseInt(row.find('.qty').val(), 10);
        var action = elem.val();

        // The +/- buttons carry their symbol as the value; the number input does not.
        if (isNaN(parseInt(action, 10))) {
            qty = (action === '+') ? qty + 1 : qty - 1;
        }

        if (!isNaN(stock) && stock > 0 && qty > stock) {
            qty = stock;
            swal("{{ __('Sorry!') }}", "{{ __('Only :n left in stock.') }}".replace(':n', stock), "warning");
        }

        if (isNaN(qty) || qty < 1) {
            row.find('.qty').val(1);
            return;
        }

        row.find('.qty').val(qty);

        $.ajax({
            url: "{{ route('customer.updateCart') }}",
            data: { _token: "{{ csrf_token() }}", key: key, id: id, qty: qty },
            method: "POST"
        }).done(function (e) {
            if (e && e.status === 'success') {
                row.find('.total').text(e.productTotal);
                $('#grand-total').text(e.grand_total);
                if (e.total_vat) { $('#total-vat').text(e.total_vat); }
            } else {
                swal("{{ __('Sorry!') }}", (e && e.message) ? e.message : e, "error");
            }
        }).fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message)
                ? xhr.responseJSON.message : "{{ __('Could not update the cart.') }}";
            swal("{{ __('Sorry!') }}", msg, "error");
        });
    }

    function removeFromCart(key, id) {
        swal({
            title: "{{ __('Really!?') }}",
            text: "{{ __('Are you sure you want to remove this item from the cart?') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function (confirmed) {
            if (!confirmed) { return; }
            $.ajax({
                url: "{{ route('customer.removeFromCart') }}",
                data: { _token: "{{ csrf_token() }}", key: key, id: id },
                method: "POST"
            }).done(function (e) {
                $('#cart-row-' + key).remove();
                $('#cart-count').text(e.count);
                $('#grand-total').text(e.grand_total);
                // Last row gone - show the empty state without a manual refresh.
                if (!e.count) { window.location.reload(); }
            }).fail(function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message : "{{ __('Could not remove the item.') }}";
                swal("{{ __('Sorry!') }}", msg, "error");
            });
        });
    }
</script>
@endpush
