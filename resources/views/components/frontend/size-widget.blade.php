<div class="sidebar-widget">
    <h6>{{ __('Size') }}</h6>
    <div class="product-size-wrap">
        <ul>
            @foreach($sizes as $size)
            <li>
                <label class="product-size">
                    <input type="checkbox" name="size[]" class="size-check" value="{{ $size->id }}">
                    <span class="checkmark">{{ $size->name }}</span>
                </label>
            </li>
            @endforeach
        </ul>
    </div>
</div>
