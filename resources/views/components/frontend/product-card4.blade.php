@php
    $firstImage = $product->images->first()->image ?? null;
    $isOut = ($product->quantity ?? 0) < 1 && ($product->is_manage_stock ?? false);

    $badge = '';
    if (hasPromotion($product->id)) {
        $badge = 'Offer';
    } elseif (($product->discount ?? 0) > 0) {
        $badge = $product->discount_type === 'percentage' ? ('-' . $product->discount . '%') : 'Deal';
    } elseif (!empty($product->details->flash_deal_title)) {
        $badge = $product->details->flash_deal_title;
    }

    $priceText = '';
    $oldPriceText = '';
    $offText = '';
    if (hasPromotion($product->id)) {
        $promo = promotionPrice($product->id);
        $priceText = currency($promo, 2);
        $oldPriceText = currency($product->unit_price, 2);
        $offText = '-' . round((($product->unit_price - $promo) / $product->unit_price) * 100) . '%';
    } else {
        if (($product->discount ?? 0) > 0) {
            $priceText = currency($product->sale_price, 2);
            $oldPriceText = currency($product->unit_price, 2);
            $offText = $product->discount_type === 'percentage'
                ? ('-' . $product->discount . '%')
                : ('-' . round(($product->discount / $product->unit_price) * 100) . '%');
        } else {
            $priceText = currency($product->unit_price, 2);
        }
    }
@endphp

<article class="product-card product-card--modern {{ $isOut ? 'is-out' : '' }}">
    <div class="product-img product-card__media">
        <a href="{{ route('product', $product->slug) }}" class="d-block">
            @if($firstImage)
                <img
                    src="{{ asset('uploads/products/galleries/'.$firstImage) }}"
                    alt="{{ $product->name }}"
                    loading="lazy"
                >
            @endif

            @if($badge !== '')
                <span class="product-card__badge">{{ $badge }}</span>
            @endif

            @if($isOut)
                <span class="product-card__sold">{{ __('Sold out') }}</span>
            @endif
        </a>
    </div>

    <div class="product-card-details product-card__body">
        <h5 class="title product-card__title">
            <a href="{{ route('product', $product->slug) }}" title="{{ $product->name }}">
                {{ $product->name }}
            </a>
        </h5>

        <div class="product-card__price">
            <span class="product-card__price-label">{{ __('Price') }}:</span>
            <span class="price">{{ $priceText }}</span>
            @if($oldPriceText)
                <del class="product-card__old">{{ $oldPriceText }}</del>
                <span class="product-card__off">{{ $offText }}</span>
            @endif
        </div>

        <div class="product-card__meta">
            <div class="product-card__rating">
                <div class="rateit" data-rateit-value="{{ productRating($product->reviews) }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
            </div>

            <div class="product-card__actions">
                <button type="button" class="product-card__icon-btn" onclick="addToWishlist({{ $product->id }})" aria-label="{{ __('Wishlist') }}">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <button type="button" class="product-card__icon-btn" onclick="addToCart({{ $product->id }})" aria-label="{{ __('Add to cart') }}">
                    <i class="fas fa-{{ $product->quantity ? 'cart-shopping' : 'circle-xmark text-danger' }}"></i>
                </button>
            </div>
        </div>
    </div>
</article>
