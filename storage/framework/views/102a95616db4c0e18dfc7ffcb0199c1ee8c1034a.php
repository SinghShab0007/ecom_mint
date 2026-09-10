<?php if($offer): ?>
    <section class="offer-count">
        <div class="container" style="padding: 0 24px;">
            <div class="row align-items-center justify-content-center px-2" data-background="<?php echo e(asset('uploads/promotions')); ?>/<?php echo e($offer->image); ?>">
                <div class="col-10 offset-lg-7">
                    <div class="offer-text py-3">
                        <h5><?php echo e($offer->title); ?></h5>
                        <h2><span class="price"><?php echo e($offer->label); ?></span></h2>
                        <div class="offer-wrap">
                            <div class="countdown"></div>
                        </div>
                        <div class="offer-link">
                            <a class="link-anime" href="javascript:addToCart(<?php echo e($offer->product_id); ?>)"><?php echo e(__('Shop Now')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $__env->startPush('script'); ?>
        <script>
            countDown();
            function countDown() {
                $(".countdown").countdown({
                    year: <?php echo e($offer->expire_at->format('Y')); ?>,
                    month: <?php echo e($offer->expire_at->format('m')); ?>,
                    day: <?php echo e($offer->expire_at->format('d')); ?>,
                    hour: <?php echo e($offer->expire_at->format('H')); ?>,
                    minute: <?php echo e($offer->expire_at->format('i')); ?>,
                    second: <?php echo e($offer->expire_at->format('s')); ?>,
                });
            }
        </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/_offer-count.blade.php ENDPATH**/ ?>