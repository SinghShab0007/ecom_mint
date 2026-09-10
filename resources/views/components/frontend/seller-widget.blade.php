<div class="sidebar-widget">
    <h6>{{ __('Seller') }}</h6>
    <div class="widget-valu">
        <ul>
            @foreach($sellers as $seller)
                <li>
                    <input type="checkbox" id="beigeCheck" class="seller-check" value="{{ $seller->id }}">
                    <label for="beigeCheck">{{ $seller->company_name }} ({{ $seller->products->count() }})</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
