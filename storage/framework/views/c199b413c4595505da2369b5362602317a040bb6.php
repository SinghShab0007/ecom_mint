<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e(config('app.name')); ?> - <?php echo e(__('Order Confirmation')); ?></title>
</head>
<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#222;">
    <span style="display:none !important; visibility:hidden; opacity:0; height:0; width:0; overflow:hidden;">
        <?php echo e(__('Order')); ?> #<?php echo e($data['order_no']); ?> - <?php echo e(currency($data['subTotal'],2)); ?>

    </span>

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:24px auto;">
        <tr>
            <td style="padding:0 24px 16px 24px; border-bottom:1px solid #eaeaea;">
                <p style="font-size:18px; margin:0; color:#222;"><strong><?php echo e(config('app.name')); ?></strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <h2 style="margin:0 0 16px 0; font-size:20px; color:#222;"><?php echo e(__('Order Placed')); ?></h2>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    <?php echo e(__('Thank you')); ?> <?php echo e($data['name']); ?>,
                </p>

                <p style="margin:0 0 14px 0; font-size:15px; line-height:1.5;">
                    <?php echo e(__('Your order has been placed successfully. Please confirm the order for fast shipment.')); ?>

                </p>

                <p style="margin:0 0 20px 0; font-size:15px; line-height:1.5;">
                    <?php echo e(__('Order number:')); ?> <strong>#<?php echo e($data['order_no']); ?></strong><br>
                    <?php echo e(__('Subtotal:')); ?> <?php echo e(currency($data['subTotal'],2)); ?><br>
                    <?php if(!empty($data['shippingCost'])): ?>
                        <?php echo e(__('Shipping:')); ?> <?php echo e(currency($data['shippingCost'],2)); ?><br>
                    <?php endif; ?>
                    <?php if(!empty($data['couponDiscount'])): ?>
                        <?php echo e(__('Coupon Discount:')); ?> -<?php echo e(currency($data['couponDiscount'],2)); ?><br>
                    <?php endif; ?>
                    <?php if(isset($data['grandTotal'])): ?>
                        <?php echo e(__('Total:')); ?> <strong style="color:#4C1D6B;"><?php echo e(currency($data['grandTotal'],2)); ?></strong><br>
                    <?php endif; ?>
                    <?php if(!empty($data['paymentBy'])): ?>
                        <?php echo e(__('Payment Method:')); ?> <strong><?php echo e($data['paymentBy']); ?></strong>
                        <?php if(!empty($data['paymentStatus'])): ?>
                            (<?php echo e(ucfirst($data['paymentStatus'])); ?>)
                        <?php endif; ?>
                    <?php endif; ?>
                </p>

                <?php if(!empty($data['billing']) || !empty($data['shipping'])): ?>
                    <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; margin:0 0 16px 0;">
                        <tr>
                            <?php if(!empty($data['billing'])): ?>
                                <td valign="top" style="width:50%; padding:12px; border:1px solid #eaeaea; font-size:13px; line-height:1.6;">
                                    <strong style="display:block; margin-bottom:6px; color:#222;"><?php echo e(__('Billing Address')); ?></strong>
                                    <?php echo e($data['name']); ?><br>
                                    <?php if(!empty($data['mobile'])): ?><?php echo e($data['mobile']); ?><br><?php endif; ?>
                                    <?php echo e($data['billing']['address_1'] ?? ''); ?><br>
                                    <?php if(!empty($data['billing']['address_2'])): ?><?php echo e($data['billing']['address_2']); ?><br><?php endif; ?>
                                    <?php echo e($data['billing']['city'] ?? ''); ?><?php if(!empty($data['billing']['district'])): ?>, <?php echo e($data['billing']['district']); ?><?php endif; ?><br>
                                    <?php echo e($data['billing']['state'] ?? ''); ?> - <?php echo e($data['billing']['pincode'] ?? ''); ?><br>
                                    <?php echo e($data['billing']['country'] ?? 'India'); ?>

                                </td>
                            <?php endif; ?>
                            <?php if(!empty($data['shipping'])): ?>
                                <td valign="top" style="width:50%; padding:12px; border:1px solid #eaeaea; font-size:13px; line-height:1.6;">
                                    <strong style="display:block; margin-bottom:6px; color:#222;"><?php echo e(__('Shipping Address')); ?></strong>
                                    <?php echo e($data['name']); ?><br>
                                    <?php if(!empty($data['mobile'])): ?><?php echo e($data['mobile']); ?><br><?php endif; ?>
                                    <?php echo e($data['shipping']['address_1'] ?? ''); ?><br>
                                    <?php if(!empty($data['shipping']['address_2'])): ?><?php echo e($data['shipping']['address_2']); ?><br><?php endif; ?>
                                    <?php echo e($data['shipping']['city'] ?? ''); ?><?php if(!empty($data['shipping']['district'])): ?>, <?php echo e($data['shipping']['district']); ?><?php endif; ?><br>
                                    <?php echo e($data['shipping']['state'] ?? ''); ?> - <?php echo e($data['shipping']['pincode'] ?? ''); ?><br>
                                    <?php echo e($data['shipping']['country'] ?? 'India'); ?>

                                </td>
                            <?php endif; ?>
                        </tr>
                    </table>
                <?php endif; ?>

                <h3 style="margin:24px 0 12px 0; font-size:16px; color:#222;"><?php echo e(__('Order Items')); ?></h3>

                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; border:1px solid #eaeaea;">
                    <?php if($data['cart']): ?>
                        <?php $__currentLoopData = $data['cart']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="padding:10px; border-bottom:1px solid #f0f0f0; width:130px;">
                                    <img src="<?php echo e($message->embed('uploads/products/galleries/'.CartItem::thumbnail($item->id))); ?>" alt="" width="120" style="display:block; border-radius:4px;">
                                </td>
                                <td style="padding:10px; font-size:14px; line-height:1.6; border-bottom:1px solid #f0f0f0;">
                                    <strong><?php echo e(CartItem::name($item->id)); ?></strong><br>
                                    <span style="color:#666;"><?php echo e(__('Price')); ?>:</span> <?php echo e(currency(CartItem::price($item->id),2)); ?><br>
                                    <span style="color:#666;"><?php echo e(__('Quantity')); ?>:</span> <?php echo e($item->quantity); ?><br>
                                    <span style="color:#666;"><?php echo e(__('Total')); ?>:</span> <strong><?php echo e(currency(CartItem::price($item->id,$item->quantity),2)); ?></strong>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </table>

                <p style="margin:24px 0 0 0; font-size:14px;">
                    <?php echo e(__('Regards')); ?>,<br>
                    <?php echo e(config('app.name')); ?>

                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:12px 24px; border-top:1px solid #eaeaea; text-align:center; font-size:12px; color:#888;">
                &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('All rights reserved')); ?>.
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/mail/order-pending.blade.php ENDPATH**/ ?>