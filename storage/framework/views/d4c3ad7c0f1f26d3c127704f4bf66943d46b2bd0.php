<!-- Info Footer Start -->
<div class="info-footer">
    <div class="container">
        <div class="row">

            
            <div class="col-lg-3 col-md-6">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('uploads/footer-logo.png')); ?>" alt="<?php echo e(config('app.name')); ?>"></a>
                    </div>
                    <p><?php echo e(maanAppearance('about_us')); ?></p>

                    <div style="color:var(--color-border); font-size:14px; line-height:1.9;">
                        <p style="margin:0 0 10px 0;">
                            OFFICE NO. S-01, 2nd floor, G-47, Sec-3 Noida,<br>
                            Gautambuddha Nagar, UP - 201301
                        </p>
                        <p style="margin:0 0 6px 0;">
                            <a href="tel:+919211635360" style="color:#A97FD0; text-decoration:none;">+91 9211635360</a>
                        </p>
                        <p style="margin:0;">
                            <a href="mailto:contact@billmintmall.com" style="color:#A97FD0; text-decoration:none;">contact@billmintmall.com</a>
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-3 col-md-6">
                <h6><?php echo e(__('Online Shopping')); ?></h6>
                <ul>
                    <?php $__currentLoopData = menus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('category', $menu->slug ?? 'undefined')); ?>"><?php echo e($menu->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(url('shop')); ?>"><?php echo e(__('All Products')); ?></a></li>
                </ul>
            </div>

            
            <div class="col-lg-2 col-md-4 col-6">
                <h6><?php echo e(__('Accounts & Support')); ?></h6>
                <ul>
                    <li><a href="<?php echo e(url('profile')); ?>"><?php echo e(__('Profile')); ?></a></li>
                    <li><a href="<?php echo e(url('page/contact')); ?>"><?php echo e(__('Help & Support')); ?></a></li>
                    <li><a href="<?php echo e(url('seller/login')); ?>"><?php echo e(__('Seller Login')); ?></a></li>
                    <li><a href="<?php echo e(url('seller/registration')); ?>"><?php echo e(__('Register as Seller')); ?></a></li>
                </ul>
            </div>

            
            <div class="col-lg-2 col-md-4 col-6">
                <h6><?php echo e(__('Quick Links')); ?></h6>
                <ul>
                    <li><a href="<?php echo e(url('page/about-us')); ?>"><?php echo e(__('About Us')); ?></a></li>
                    <li><a href="<?php echo e(url('page/contact')); ?>"><?php echo e(__('Contact Us')); ?></a></li>
                    <li><a href="<?php echo e(url('new-arrivals')); ?>"><?php echo e(__('Latest Products')); ?></a></li>
                    <li><a href="<?php echo e(url('faq')); ?>"><?php echo e(__('FAQ')); ?></a></li>
                </ul>
            </div>

            
            <div class="col-lg-2 col-md-4 col-6">
                <h6><?php echo e(__('Legal & Policies')); ?></h6>
                <ul>
                    <li><a href="<?php echo e(url('page/terms-and-conditions')); ?>"><?php echo e(__('Terms And Conditions')); ?></a></li>
                    <li><a href="<?php echo e(url('page/privacy-n-policy')); ?>"><?php echo e(__('Privacy Policy')); ?></a></li>
                    <li><a href="<?php echo e(url('page/cancellation-policy')); ?>"><?php echo e(__('Cancellations, Returns & Refunds')); ?></a></li>
                    <li><a href="<?php echo e(url('page/shipping-policy')); ?>"><?php echo e(__('Shipping Policy')); ?></a></li>
                    <li><a href="<?php echo e(url('page/dispute-grievance-policy')); ?>"><?php echo e(__('Dispute & Grievance Policy')); ?></a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
<!-- Info Footer End -->
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/includes/info-footer.blade.php ENDPATH**/ ?>