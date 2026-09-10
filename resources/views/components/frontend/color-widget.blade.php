<div class="sidebar-widget">
    <h6>{{ __('Color') }}</h6>
    <div class="product-color-wraper">
        <ul>
            @foreach($colors as $color)
            <li>
                <label class="porduct-color">
                    <input type="checkbox" class="color-check" name="colors[]" value="{{ $color->id }}">
                    <span class="checkmark" style="background-color: {{ $color->hex }}"></span>
                </label>
            </li>
            @endforeach
        </ul>
    </div>
</div>
