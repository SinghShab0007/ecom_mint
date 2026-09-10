<table class="table table-responsive-sm">
    <tbody>
    <?php if($new_orders ?? false): ?>
    <?php $__currentLoopData = $new_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <?php if($order->order ?? false): ?>
                    <div class="media-body">
                        <a href="<?php echo e(auth('seller')->user() ? route('seller.orders.show', $order->order->id) : route('backend.orders.show', $order->order->id)); ?>">
                            <h5 class="mt-0 mb-1 maan-appoint-dg"><?php echo e($order->order->order_no??''); ?></h5>
                        </a>
                        <p class="mb-0 maan-chart-title fs"><?php echo e($order->product->name??''); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <div class="align-items-center">
                    <div class="maan-appoint-status maan-app-radius">
                        <span class="maan-title maan-bg-warning-light text-capitalize">
                            <?php if($order->orderStatus): ?>
                            <?php echo e($order->orderStatus->name ? strtolower($order->orderStatus->name) : ''); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    </tbody>
</table>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/_new_orders.blade.php ENDPATH**/ ?>