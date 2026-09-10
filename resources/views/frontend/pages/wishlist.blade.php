@extends('customer.layouts.master')

@section('title','Wishlist')
@section('page_title', __('Wishlist'))

@section('content')

    <div class="pk-card">
        <div class="pk-card-head">
            <div>
                <h3>{{ __('My Wishlist') }}</h3>
                <p>{{ __('Items you saved for later. Move them to your cart whenever you are ready.') }}</p>
            </div>
            <a href="{{ url('shop') }}" class="pk-btn pk-btn-ghost">{{ __('Continue Shopping') }}</a>
        </div>

        @if($wishlists->count() === 0)

            <div class="pk-empty">
                <div class="pk-empty-ic">&#9825;</div>
                <h4>{{ __('Your wishlist is empty') }}</h4>
                <p>{{ __('Tap the heart on any product to save it here.') }}</p>
                <a href="{{ url('shop') }}" class="pk-btn">{{ __('Browse Products') }}</a>
            </div>

        @else

            <div class="pk-table-wrap" id="pkWishTable">
                <table class="pk-table">
                    <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wishlists as $wish)
                        @if($wish->product)
                            <tr id="wish-{{ $wish->id }}">
                                <td>
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        @if($wish->product->images->first())
                                            <img src="{{ asset('uploads/products/galleries') }}/{{ $wish->product->images->first()->image }}"
                                                 alt="{{ $wish->product->name }}">
                                        @endif
                                        <span style="min-width:0;">
                                            <a href="{{ route('product', $wish->product->slug) }}" class="pk-prod-name">{{ $wish->product->name }}</a>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color:var(--pk-ink);">
                                        @if($wish->product->promotions->count() > 0)
                                            {{ currency($wish->product->promotion_price,2) }}
                                        @else
                                            {{ currency(($wish->product->unit_price - $wish->product->discount),2) }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    @if($wish->product->details)
                                        @if($wish->product->details->is_show_stock_quantity == 0)
                                            <span class="pk-chip cancel-btn">{{ __('Out of Stock') }}</span>
                                        @else
                                            <span class="pk-chip delivered-btn">{{ __('In Stock') }}</span>
                                        @endif
                                    @else
                                        <span class="pk-chip">{{ __('No Details') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="wishToCart({{ $wish->id }})" class="pk-link-btn">
                                        {{ __('Add to Cart') }}
                                    </a>
                                </td>
                                <td>
                                    <button type="button" onclick="removeFromWishlist({{ $wish->id }})"
                                            title="{{ __('Remove') }}"
                                            style="background:none;border:0;color:#a12626;font-size:20px;line-height:1;cursor:pointer;padding:4px 8px;">
                                        &times;
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

@stop

@section('script')
    <script>
        "use strict";

        // These live in the storefront layout; the dashboard layout does not load
        // them, so the wishlist page carries its own copy.
        function wishToCart(id) {
            var csrf = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('customer.wishToCart') }}",
                data: {_token: csrf, id: id},
                type: "POST"
            }).done(function (e) {
                $("#cart-count").text(e.count);
                $("#wishlist-count").text(e.wishCount);
                $("#wish-" + id).remove();
                swal("{{ __('Good Choice!') }}", e.name + " {{ __('is added to cart') }}", "success");
                refreshWishEmptyState();
            });
        }

        function removeFromWishlist(id) {
            var csrf = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('customer.removeFromWishlist') }}",
                data: {_token: csrf, id: id},
                type: "POST"
            }).done(function (e) {
                $("#wish-" + id).remove();
                $("#wishlist-count").text(e.count);
                swal("{{ __('Removed') }}", e.name + "{{ __(' is removed from your wishlist!') }}", "warning");
                refreshWishEmptyState();
            });
        }

        // Swap in the empty state once the last row is gone.
        function refreshWishEmptyState() {
            if ($('#pkWishTable tbody tr').length === 0) {
                $('#pkWishTable').replaceWith(
                    '<div class="pk-empty">' +
                    '<div class="pk-empty-ic">&#9825;</div>' +
                    '<h4>{{ __('Your wishlist is empty') }}</h4>' +
                    '<p>{{ __('Tap the heart on any product to save it here.') }}</p>' +
                    '<a href="{{ url('shop') }}" class="pk-btn">{{ __('Browse Products') }}</a>' +
                    '</div>'
                );
            }
        }
    </script>
@stop
