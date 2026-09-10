@extends('customer.layouts.master')

@section('title','Dashboard')
@section('page_title', __('Dashboard'))

@section('content')

    {{-- Welcome --}}
    <div class="pk-card">
        <div class="pk-card-body">
            <h3 style="margin:0 0 4px;font-size:19px;font-weight:700;color:var(--pk-ink);">
                {{ __('Hi') }}, {{ trim(auth('customer')->user()->first_name . ' ' . auth('customer')->user()->last_name) ?: auth('customer')->user()->username }} 👋
            </h3>
            <p style="margin:0;color:var(--pk-muted);font-size:14px;">
                {{ __('Here is a quick overview of your orders. Click any card to filter the list below.') }}
            </p>
        </div>
    </div>

    {{-- Stat tiles (click to filter) --}}
    <div class="pk-stats">
        <a href="javascript:void(0)" onclick="orderList(0,null,this)" class="pk-stat is-active" data-stat="0">
            <span class="pk-stat-ic pk-ic-total"><img src="{{ asset('customer/img/icons/1.svg') }}" alt=""></span>
            <span>
                <span class="pk-stat-val counter">{{ orderCount(0) }}</span>
                <span class="pk-stat-lbl">{{ __('Total Orders') }}</span>
            </span>
        </a>

        <a href="javascript:void(0)" onclick="orderList(5,null,this)" class="pk-stat" data-stat="5">
            <span class="pk-stat-ic pk-ic-ship"><img src="{{ asset('customer/img/icons/track-blue.svg') }}" alt=""></span>
            <span>
                <span class="pk-stat-val counter">{{ orderCount(5) }}</span>
                <span class="pk-stat-lbl">{{ __('Shipped') }}</span>
            </span>
        </a>

        <a href="javascript:void(0)" onclick="orderList(6,null,this)" class="pk-stat" data-stat="6">
            <span class="pk-stat-ic pk-ic-done"><img src="{{ asset('customer/img/icons/track-green.svg') }}" alt=""></span>
            <span>
                <span class="pk-stat-val counter">{{ orderCount(6) }}</span>
                <span class="pk-stat-lbl">{{ __('Delivered') }}</span>
            </span>
        </a>

        <a href="javascript:void(0)" onclick="orderList(7,null,this)" class="pk-stat" data-stat="7">
            <span class="pk-stat-ic pk-ic-cancel"><img src="{{ asset('customer/img/icons/order-cancel.svg') }}" alt=""></span>
            <span>
                <span class="pk-stat-val counter">{{ orderCount(7) }}</span>
                <span class="pk-stat-lbl">{{ __('Cancelled') }}</span>
            </span>
        </a>
    </div>

    {{-- Order list --}}
    <div class="pk-card">
        <div class="pk-card-head">
            <div>
                <h3 id="pkOrderHeading">{{ __('My Orders') }}</h3>
                <p>{{ __('Track, manage and review everything you have ordered.') }}</p>
            </div>
            <a href="{{ url('shop') }}" class="pk-btn pk-btn-ghost">{{ __('Continue Shopping') }}</a>
        </div>

        <div class="maan-content-wpr">
            <div class="pk-empty">
                <div class="pk-empty-ic">&#8987;</div>
                <p>{{ __('Loading your orders...') }}</p>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        "use strict";

        var orderXhr = null;

        var ORDER_TITLES = {
            0: "{{ __('My Orders') }}",
            5: "{{ __('Shipped Orders') }}",
            6: "{{ __('Delivered Orders') }}",
            7: "{{ __('Cancelled Orders') }}"
        };

        function orderList(stat, page, el) {
            var csrf = "{{ csrf_token() }}";

            stat = (stat === undefined || stat === null) ? 0 : stat;
            page = parseInt(page, 10) || 1;

            // highlight the selected tile
            if (el) {
                $('.pk-stat').removeClass('is-active');
                $(el).addClass('is-active');
            }
            $('#pkOrderHeading').text(ORDER_TITLES[stat] || ORDER_TITLES[0]);

            if (orderXhr && orderXhr.readyState !== 4) {
                orderXhr.abort();
            }

            orderXhr = $.ajax({
                url: "{{ route('customer.order.list') }}",
                data: {_token: csrf, stat: stat, page: page},
                type: "post"
            }).done(function (e) {
                $(".maan-content-wpr").html(e);
            }).fail(function (jq, textStatus) {
                if (textStatus !== 'abort') {
                    $(".maan-content-wpr").html(
                        '<div class="pk-empty"><div class="pk-empty-ic">&#9888;</div>' +
                        '<h4>{{ __('Could not load your orders') }}</h4>' +
                        '<p>{{ __('Please refresh the page and try again.') }}</p></div>'
                    );
                }
            });
        }

        $(document).ready(function () {
            orderList(0);
        });

        $(document).on('click', '.pagination-bar a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var page = parseInt((url.split('page=')[1] || '1'), 10) || 1;
            var stat = $(this).data('stat');
            orderList(stat, page);
        });
    </script>
@stop
