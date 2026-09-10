<div class="sidebar-widget dd">
    <h6>{{ __('Price') }}</h6>
    <div class="price-range-wraper">
        <div class="price-wrap">
            <div class="price-input-wrapper1">
                <div class="bordered-price">
                    <span class="first">{{ userCurrency('symbol') }}</span>
                    <input class="b price-check" id="price-check-b" type="number" placeholder="min" >
                </div>
                <span class="middle">{{ __(' - ') }}</span>
                <div class="bordered-price">
                    <span class="last">{{ userCurrency('symbol') }} </span>
                    <input class="c price-check" id="price-check-c" type="number" placeholder="max" >
                </div>
                <button class="price-range-btnn"><i class="fa fa-play"></i></button>
            </div>
        </div>
    </div>
</div>
