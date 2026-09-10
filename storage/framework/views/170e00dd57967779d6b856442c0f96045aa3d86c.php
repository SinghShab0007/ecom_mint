<?php
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
?>

<article class="product-card product-card--modern <?php echo e($isOut ? 'is-out' : ''); ?>">
    <div class="product-img product-card__media">
        <a href="<?php echo e(route('product', $product->slug)); ?>" class="d-block">
            <?php if($firstImage): ?>
                <img
                    src="<?php echo e(asset('uploads/products/galleries/'.$firstImage)); ?>"
                    alt="<?php echo e($product->name); ?>"
                    loading="lazy"
                >
            <?php endif; ?>

            <?php if($badge !== ''): ?>
                <span class="product-card__badge"><?php echo e($badge); ?></span>
            <?php endif; ?>

            <?php if($isOut): ?>
                <span class="product-card__sold"><?php echo e(__('Sold out')); ?></span>
            <?php endif; ?>
        </a>
    </div>

    <div class="product-card-details product-card__body">
        <h5 class="title product-card__title">
            <a href="<?php echo e(route('product', $product->slug)); ?>" title="<?php echo e($product->name); ?>">
                <?php echo e($product->name); ?>

            </a>
        </h5>

        <div class="product-card__price">
            <span class="product-card__price-label"><?php echo e(__('Price')); ?>:</span>
            <span class="price"><?php echo e($priceText); ?></span>
            <?php if($oldPriceText): ?>
                <del class="product-card__old"><?php echo e($oldPriceText); ?></del>
                <span class="product-card__off"><?php echo e($offText); ?></span>
            <?php endif; ?>
        </div>

        <div class="product-card__meta">
            <div class="product-card__rating">
                <div class="rateit" data-rateit-value="<?php echo e(productRating($product->reviews)); ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
            </div>

            <div class="product-card__actions">
                <button type="button" class="product-card__icon-btn" onclick="addToWishlist(<?php echo e($product->id); ?>)" aria-label="<?php echo e(__('Wishlist')); ?>">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <button type="button" class="product-card__icon-btn" onclick="addToCart(<?php echo e($product->id); ?>)" aria-label="<?php echo e(__('Add to cart')); ?>">
                    <i class="fas fa-<?php echo e($product->quantity ? 'cart-shopping' : 'circle-xmark text-danger'); ?>"></i>
                </button>
            </div>
        </div>
    </div>
</article>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/components/frontend/product-card.blade.php ENDPATH**/ ?>