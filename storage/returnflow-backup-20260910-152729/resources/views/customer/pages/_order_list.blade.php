@if($orders->count() === 0)

    <div class="pk-empty">
        <div class="pk-empty-ic">&#128230;</div>
        <h4>{{ __('No orders here yet') }}</h4>
        <p>{{ __('When you place an order it will show up in this list.') }}</p>
        <a href="{{ url('shop') }}" class="pk-btn">{{ __('Start Shopping') }}</a>
    </div>

@else

    <div class="pk-table-wrap">
        <table class="pk-table">
            <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Delivery') }}</th>
                <th>{{ __('Qty') }}</th>
                <th>{{ __('Payment') }}</th>
                <th>{{ __('Courier') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            @if($order->product && $order->product->images->first())
                                <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}"
                                     alt="{{ $order->product->name }}">
                            @endif
                            <span style="min-width:0;">
                                <span class="pk-prod-name">{{ $order->product->name ?? __('Product unavailable') }}</span>
                                <span class="pk-prod-sub">#{{ $order->order->order_no ?? '' }}</span>
                            </span>
                        </div>
                    </td>
                    <td>{{ $order->product->details->inside_shipping_days ?? '7-30 days' }}</td>
                    <td>{{ $order->qty }}</td>
                    <td>{{ $order->order->payment_by ?? '-' }}</td>
                    <td>{{ $order->courier ?: '-' }}</td>
                    <td>
                        <span class="pk-chip {{ orderButtonClass($order->order_stat) }}">{{ orderStatus($order->order_stat) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('order.details',$order->id) }}" class="pk-link-btn">{{ __('Manage') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="padding:14px 20px;">
        <x-customer.page-navigation :paginator="$orders" :stat="$stat"></x-customer.page-navigation>
    </div>

@endif
