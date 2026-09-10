<?php if($banners->count()): ?>
<!-- Banner Start: ShopZop-style hero (rounded card + slider) -->
<section class="banner banner--hero-shopzop">
    <div class="banner-hero__wrap">
        <div class="swiper banner-slider banner-slider--fullwidth">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <img
                            src="<?php echo e(asset('uploads/banners/'.$banner->image)); ?>"
                            alt="<?php echo e($banner->title ?? __('Banner')); ?>"
                            class="banner-slider__img"
                            <?php if($loop->first): ?> loading="eager" <?php else: ?> loading="lazy" <?php endif; ?>
                            sizes="(max-width: 1400px) 100vw, 1400px"
                        >
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($banners->count() > 1): ?>
                <button type="button" class="swiper-button-prev banner-hero__arrow banner-hero__arrow--prev" aria-label="<?php echo e(__('Previous slide')); ?>"></button>
                <button type="button" class="swiper-button-next banner-hero__arrow banner-hero__arrow--next" aria-label="<?php echo e(__('Next slide')); ?>"></button>
            <?php endif; ?>
            <!-- <div class="swiper-pagination banner-slider__pagination"></div> -->
        </div>
    </div>
</section>
<!-- Banner End -->

<?php $__env->startPush('script'); ?>
    <script>
        (function () {
            function initBannerSlider() {
                if (typeof Swiper === 'undefined') return;
                var el = document.querySelector('.banner-slider--fullwidth');
                if (!el) return;
                var slideCount = el.querySelectorAll('.swiper-slide').length;
                var opts = {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: slideCount > 1,
                    autoplay: slideCount > 1 ? {
                        delay: 4000,
                        disableOnInteraction: false,
                    } : false,
                    pagination: {
                        el: '.banner-slider--fullwidth .banner-slider__pagination',
                        clickable: true,
                    },
                };
                if (slideCount > 1) {
                    opts.navigation = {
                        nextEl: '.banner-hero__arrow--next',
                        prevEl: '.banner-hero__arrow--prev',
                    };
                }
                new Swiper('.banner-slider--fullwidth', opts);
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initBannerSlider);
            } else {
                initBannerSlider();
            }
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/_banner.blade.php ENDPATH**/ ?>