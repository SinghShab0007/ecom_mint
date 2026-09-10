<table class="table table-responsive-sm">
    <tbody>
    <?php $__currentLoopData = $best_selling_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <div
                    class="maan-appoint-image maan-radius d-flex align-items-center">
                    <?php if($order->product()->exists() && $order->product->images()->exists() && $order->product->images->first()->image): ?>
                        <img class="mr-2"
                             src="<?php echo e(URL::to('uploads/products/galleries/' . $order->product->images->first()->image??'')); ?>"
                             alt="productImage">
                    <?php else: ?>
                        <img class="mr-2"
                             src="<?php echo e(URL::to('uploads/products/galleries/default.jpg')); ?>"
                             alt="productImage">
                    <?php endif; ?>
                    <div class="media-body">
                        <p class="mb-0 maan-chart-title fs"><?php echo e($order->product->name??''); ?></p>
                    </div>
                </div>
            </td>
            <td>
                <p class="maan-date mb-0"><?php echo e($website_appearance->currency->symbol); ?><?php echo e($order->product->sale_price??''); ?> </p>
            </td>
            <td>
                <div class="align-items-center">
                    <div class="maan-appoint-status maan-app-radius">
                        <?php if($order->product()->exists() && $order->product->details()->exists() && $order->product->quantity > $order->product->details->warning_quantity): ?>
                            <span class="maan-title maan-bg-soft-success"><?php echo e(__('In-Stock')); ?></span>
                        <?php else: ?>
                            <span class="maan-title maan-bg-soft-danger"><?php echo e(__('Out of Stock')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
</table>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/_best_selling_product.blade.php ENDPATH**/ ?>