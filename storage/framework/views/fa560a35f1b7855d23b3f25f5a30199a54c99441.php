<?php $__currentLoopData = $best_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="maan-note-card-body">
        <div class="dash-customar-author">
            <?php if($customer->image): ?>
            <img src="<?php echo e(URL::to('/frontend/img/users/'.$customer->image)); ?>" alt="">
            <?php else: ?>
                <div class="p-3"><?php echo e(strtoupper(mb_substr($customer->first_name, 0, 1).mb_substr($customer->last_name, 0, 1))); ?></div>
            <?php endif; ?>
            <div>
                <p><?php echo e($customer->email??''); ?></p>
                <h6><?php echo e($customer->full_name()??''); ?></h6>
            </div>
        </div>
        <div class="invoice">
            <a href="<?php echo e(route('backend.orders.show',$customer->orders->first()->id??'#')); ?>">
                <?php echo e($customer->orders->first()->order_no??''); ?>

            </a>
        </div>
        <div class="date">
            <p><?php echo e($customer->orders_count??0); ?> <?php echo e(__('Order')); ?></p>
        </div>
        <div class="date">
            <p>
                <?php if($customer->orders()->exists()): ?>
                    <b><?php echo e($customer->orders->first()->currency()); ?><?php echo e($customer->orders->sum('total_price')??0); ?></b>
                <?php endif; ?>
            </p>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/_best_customers.blade.php ENDPATH**/ ?>