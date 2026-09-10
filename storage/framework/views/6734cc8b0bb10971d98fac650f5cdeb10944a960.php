<div class="container order-manu">
    <div class="content-tab-title">
        <h4><?php echo e(__('Overview of environment')); ?></h4>
    </div>

    <!-- Tab Manu Start -->
    <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
        <div class="maan-counter-box <?php if(Request::is('admin/orders','seller/orders')): ?>active <?php endif; ?>" data-bs-toggle="tab"
             data-bs-target="#order-list"
             <?php if(url()->full()!=route('backend.orders.index') && url()->full()!=route('seller.orders.index')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.orders.index')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.orders.index')); ?><?php endif; ?>'" <?php endif; ?>
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/1.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview['total_order']??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Total Order')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box  <?php if(Request::is('admin/pending_orders','seller/pending_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#pending"
             <?php if(url()->full()!=route('backend.pending_orders')&&url()->full()!=route('seller.pending_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.pending_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.pending_orders')); ?><?php endif; ?>'" <?php endif; ?>
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/pending-blue.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <div class="maan-counter">
                        <span class="maan-counter-title counter"><?php echo e($order_overview[1]??0); ?></span>
                    </div>
                    <p class="maan-counter-content"><?php echo e(__('Pending Order')); ?></p>
                </div>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/confirmed_orders','seller/confirmed_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#confirmed"
             <?php if(url()->full()!=route('backend.confirmed_orders') && url()->full()!=route('seller.confirmed_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.confirmed_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.confirmed_orders')); ?><?php endif; ?>'" <?php endif; ?>>
            <div class="maan-icon maan-radius maan-icon-clr-lightgreen">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/Confirmed-green.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[2]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Confirmed')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/processing_orders','seller/processing_orders')): ?>active <?php endif; ?>"
            data-bs-toggle="tab" data-bs-target="#processing"
            <?php if(url()->full()!=route('backend.processing_orders') && url()->full()!=route('seller.processing_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.processing_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.processing_orders')); ?><?php endif; ?>'" <?php endif; ?>>
            <div class="maan-icon maan-radius maan-icon-clr-lightyellow">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/Processing.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[3]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Processing')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/picked_orders','seller/picked_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#picked"
             <?php if(url()->full()!=route('backend.processing_orders') && url()->full()!=route('seller.processing_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.processing_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.processing_orders')); ?><?php endif; ?>'" <?php endif; ?>
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightyellow">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/pick.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[4]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Picked')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/shipped_orders','seller/shipped_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#shipped"
             <?php if(url()->full()!=route('backend.shipped_orders') && url()->full()!=route('seller.shipped_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.shipped_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.shipped_orders')); ?><?php endif; ?>'" <?php endif; ?>>
            <div class="maan-icon maan-radius maan-icon-clr-lightgreen1">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/shipping.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[5]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Shipped')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/delivered_orders','seller/delivered_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#delivered"
             <?php if(url()->full()!=route('backend.delivered_orders') && url()->full()!=route('seller.delivered_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.delivered_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.delivered_orders')); ?><?php endif; ?>'" <?php endif; ?>>
            <div class="maan-icon maan-radius maan-icon-clr-lightblue1">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/Delivered.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[6]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Delivered')); ?></p>
            </div>
        </div>
        <div class="maan-counter-box <?php if(Request::is('admin/cancelled_orders','seller/cancelled_orders')): ?>active <?php endif; ?>"
             data-bs-toggle="tab" data-bs-target="#canclled"
             <?php if(url()->full()!=route('backend.cancelled_orders') && url()->full()!=route('seller.cancelled_orders')): ?> onclick="location.href='<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.cancelled_orders')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.cancelled_orders')); ?><?php endif; ?>'" <?php endif; ?>>
            <div class="maan-icon maan-radius maan-icon-clr-lightred">
                <i> <img src="<?php echo e(URL::to('backend/img/icons/order-cancel.svg')); ?>" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter"><?php echo e($order_overview[7]??0); ?></span>
                </div>
                <p class="maan-counter-content"><?php echo e(__('Order Canceled')); ?></p>
            </div>
        </div>
    </div>
    <!-- Tab Manu End -->
</div>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/app/Modules/Backend/OrderManagement/Resources/views/orders/order_overview.blade.php ENDPATH**/ ?>