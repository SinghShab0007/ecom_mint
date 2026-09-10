
<?php
    $productsRemainingTotal = $homeCategoryProductsTotalCap;
?>
<?php $__currentLoopData = $shopCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!$category->products->isEmpty() && $productsRemainingTotal > 0): ?>
        <?php
            $countForThisRow = min($homeCategoryProductLimit, $productsRemainingTotal);
            $rowProducts = $category->products->take($countForThisRow);
            $productsRemainingTotal -= $rowProducts->count();
        ?>
        <!-- Collection Start -->
        <section class="woman-collection">
            <div class="container">
                <div class="main-title">
                    <div class="row align-items-center">
                        <div class="col-sm-8 col-md-9">
                            <h4><?php echo e(ucfirst($category->name)); ?></h4>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="right-link text-md-end">
                                <a href="<?php echo e(route('category',$category->slug)); ?>"><?php echo e(__('Shop More')); ?> <span class="icon"><svg viewBox="0 0 512 512"><path d="M477.5 273L283.1 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.7-22.7c-9.4-9.4-9.4-24.5 0-33.9l154-154.7-154-154.7c-9.3-9.4-9.3-24.5 0-33.9l22.7-22.7c9.4-9.4 24.6-9.4 33.9 0L477.5 239c9.3 9.4 9.3 24.6 0 34zm-192-34L91.1 44.7c-9.4-9.4-24.6-9.4-33.9 0L34.5 67.4c-9.4 9.4-9.4 24.5 0 33.9l154 154.7-154 154.7c-9.3 9.4-9.3 24.5 0 33.9l22.7 22.7c9.4 9.4 24.6 9.4 33.9 0L285.5 273c9.3-9.4 9.3-24.6 0-34z"></path></svg></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row auto-margin-3">
                    <?php $__currentLoopData = $rowProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <?php if (isset($component)) { $__componentOriginal21c3c2c55e30da1a9f261981b4e771a6d80c22bd = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Frontend\ProductCard::class, ['product' => $product]); ?>
<?php $component->withName('frontend.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal21c3c2c55e30da1a9f261981b4e771a6d80c22bd)): ?>
<?php $component = $__componentOriginal21c3c2c55e30da1a9f261981b4e771a6d80c22bd; ?>
<?php unset($__componentOriginal21c3c2c55e30da1a9f261981b4e771a6d80c22bd); ?>
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
        <!-- Collection End -->
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/_products.blade.php ENDPATH**/ ?>