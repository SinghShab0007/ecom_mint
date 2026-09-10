<!-- Left side column. contains the name and sidebar -->
<nav class="side-bar no-print">
    <div class="side-bar-logo">
        <a href="<?php echo e(route('backend.home')); ?>">
            <img src="<?php echo e(asset('uploads')); ?>/<?php echo e(maanAppearance('backend_logo')); ?>" alt="logo">
        </a>
        <button class="close-btn"></button>
    </div>
    <!-- Side Manu Start -->
    <div class="side-bar-manu">
        <ul>
            <?php if(auth()->user()->can('browse_dashboard') || auth()->user()->hasRole('super-admin')): ?>
                <li>
                    <a class="<?php if(Request::is('/admin') || Route::is('backend.home')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.home')); ?>">
                        <span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1" />
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1" />
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282" rx="1" />
                            </svg>
                        </span>
                        <span class="title"> <?php echo e(__('Dashboard')); ?> </span>
                    </a>
                </li>
            <?php endif; ?>
            <!--start orders -->
            <?php if(Module::has('OrderManagement') && Module::find('OrderManagement')->isEnabled()): ?>
                <?php if(auth()->user()->can('browse_order_management') ||
                        auth()->user()->hasRole('super-admin')): ?>
                    <li class="<?php if(Request::is('admin/*_orders', 'admin/orders', 'admin/orders/*')): ?> active <?php endif; ?> ">
                        <a href="javascript:void(0)">
                            <span class="icon">
                                <svg viewBox="0 0 16 14" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.78125 9.30273H4.25001V10.7715H4.78125V9.30273Z" />
                                    <path d="M6.90625 9.79102H6.375V10.7702H6.90625V9.79102Z" />
                                    <path
                                        d="M10.3594 11.9939V13.9522H9.03125V13.2178C9.03125 12.3667 9.42836 11.6015 10.0582 11.0645C10.2529 11.3406 10.3594 11.6627 10.3594 11.9939Z" />
                                    <path
                                        d="M1.32812 7.34375H7.70312C7.84975 7.34375 7.96875 7.45342 7.96875 7.58854V11.5052C7.96875 11.6403 7.84975 11.7499 7.70312 11.7499H1.32812C1.1815 11.7499 1.0625 11.6403 1.0625 11.5052V7.58854C1.0625 7.45342 1.1815 7.34375 1.32812 7.34375ZM1.59375 11.2604H7.4375V9.30206H5.84375V10.7708H5.3125V8.81248H3.71875V10.7708H3.1875V7.83333H1.59375V11.2604Z" />
                                    <path d="M2.65625 8.32227H2.125V10.7702H2.65625V8.32227Z" />
                                    <path
                                        d="M12.2188 9.79097C11.3385 9.79097 10.625 9.1334 10.625 8.32224C10.625 7.51109 11.3385 6.85352 12.2188 6.85352C13.099 6.85352 13.8125 7.51109 13.8125 8.32224C13.8125 9.1334 13.099 9.79097 12.2188 9.79097Z" />
                                    <path
                                        d="M12.2187 11.5043C12.8551 11.5043 13.3877 11.0889 13.5163 10.5374C13.6714 10.6012 13.8202 10.6759 13.9609 10.7611C13.6935 11.1241 13.5468 11.5525 13.5468 11.9938V13.9522H10.8906V11.9938C10.8906 11.5525 10.744 11.1241 10.4765 10.7608C10.6173 10.6757 10.766 10.6012 10.9211 10.5371C11.0497 11.0889 11.5823 11.5043 12.2187 11.5043ZM11.9531 13.4626H12.4843V12.973H11.9531V13.4626ZM11.9531 12.4834H12.4843V11.9938H11.9531V12.4834Z" />
                                    <path
                                        d="M15.4062 13.2178V13.9522H14.0781V11.9939C14.0781 11.6627 14.1846 11.3406 14.3793 11.0645C15.0091 11.6015 15.4062 12.3667 15.4062 13.2178Z" />
                                    <path
                                        d="M13.0039 10.3756C12.9532 10.7361 12.6219 11.0164 12.2174 11.0164C11.8128 11.0164 11.4816 10.7361 11.4309 10.3756C11.6829 10.3163 11.9457 10.2812 12.2174 10.2812C12.4891 10.2812 12.7518 10.3163 13.0039 10.3756Z" />
                                    <path
                                        d="M13.2812 6.63005C12.9683 6.46262 12.606 6.36519 12.2187 6.36519C11.0471 6.36519 10.0937 7.24374 10.0937 8.3235H8.5V7.58913C8.5 7.18425 8.14247 6.85477 7.70312 6.85477H1.32812C0.88878 6.85477 0.531248 7.18425 0.531248 7.58913V8.3235H-1.90735e-06V1.95898H13.2812V6.63005ZM1.59375 5.87561H2.125V5.38603H1.59375V5.87561ZM0.531248 5.87561H1.0625V5.38603H0.531248V5.87561ZM0.531248 4.89645H4.78125V4.40688H0.531248V4.89645ZM5.84375 2.44856H0.531248V2.93814H5.84375V2.44856ZM6.90625 2.44856H6.375V2.93814H6.90625V2.44856ZM6.90625 3.42772H0.531248V3.9173H6.90625V3.42772ZM6.90625 4.40688H5.3125V4.89645H6.90625V4.40688ZM6.90625 5.38603H2.65625V5.87561H6.90625V5.38603ZM12.75 2.44856H7.4375V5.87561H12.75V2.44856Z" />
                                    <path
                                        d="M13.2812 0V1.46872H-1.90735e-06V0H13.2812ZM12.2187 0.979146H12.75V0.489573H12.2187V0.979146ZM11.1562 0.979146H11.6875V0.489573H11.1562V0.979146ZM10.0937 0.979146H10.625V0.489573H10.0937V0.979146Z" />
                                    <path d="M12.2188 2.9375H7.96875V5.38539H12.2188V2.9375Z" />
                                </svg></span>
                            <span class="title"><?php echo e(__('Order Management')); ?></span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                          stroke-linecap="round" />
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                        </a>
                        <ul>
                            <?php if(auth()->user()->can('browse_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.orders.index')); ?>">
                                        <?php echo e(__('Order List')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_pending_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li><a class="<?php if(Request::is('admin/pending_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.pending_orders')); ?>">
                                        <?php echo e(__('Pending')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_confirmed_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/confirmed_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.confirmed_orders')); ?>">
                                        <?php echo e(__('Confirmed')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_processing_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/processing_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.processing_orders')); ?>">
                                        <?php echo e(__('Processing')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_picked_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/picked_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.picked_orders')); ?>">
                                        <?php echo e(__('Picked')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_shipped_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li><a class="<?php if(Request::is('admin/shipped_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.shipped_orders')); ?>">
                                        <?php echo e(__('Shipped')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_delivered_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li><a class="<?php if(Request::is('admin/delivered_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.delivered_orders')); ?>">
                                        <?php echo e(__('Delivered')); ?> </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_cancelled_orders') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li><a class="<?php if(Request::is('admin/cancelled_orders')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.cancelled_orders')); ?>">
                                        <?php echo e(__('Cancelled')); ?> </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_return_requests') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li><a class="<?php if(Request::is('admin/return_requests')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.return_requests')); ?>">
                                        <?php echo e(__('Returns')); ?>

                                        <?php ($pendingReturns = \App\Modules\Backend\OrderManagement\Entities\OrderDetail::where('order_stat', 9)->count()); ?>
                                        <?php if($pendingReturns): ?>
                                            <span class="badge bg-warning"><?php echo e($pendingReturns); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!--end orders -->

            <?php if(Module::has('ProductManagement') && Module::find('ProductManagement')->isEnabled()): ?>
                <?php if(auth()->user()->can('browse_product_management') ||
                        auth()->user()->hasRole('super-admin')): ?>
                    <li class="<?php if(Request::is(
                            'admin/products',
                            'admin/products/*',
                            'admin/categories',
                            'admin/categories/*',
                            'admin/commissions',
                            'admin/brands',
                            'admin/brands/*',
                            'admin/colors','admin/colors/*','admin/sizes','admin/sizes/*',
                            'admin/products/wholesale')): ?> active <?php endif; ?>">
                        <a href="#">
                            <span class="icon">
                                <svg viewBox="0 0 22 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3101 11.4708L11.4114 24.1705L22.0005 18.6209V6.125L11.3101 11.4708Z" />
                                    <path
                                        d="M17.6499 3.52539L7.1084 8.97609L10.9468 10.9257L21.5181 5.56315L17.6499 3.52539Z" />
                                    <path
                                        d="M14.7189 1.98175L10.958 0L0.405762 5.57106L4.06777 7.43126L14.7189 1.98175Z" />
                                    <path
                                        d="M6.72817 14.531L5.11108 13.4121L3.73112 13.5312V8.01856L0 6.125V18.5911L10.5713 24.1705V11.4875L6.75916 9.55463L6.72817 14.531Z" />
                                </svg>
                            </span>
                            <span class="title"><?php echo e(__('Product Management')); ?></span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                          stroke-linecap="round" />
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            <?php if(auth()->user()->can('browse_products') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/products', 'admin/products/*/edit')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.products.index')); ?>"><?php echo e(__('All Product')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('create_products') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/products/create')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.products.create')); ?>"><?php echo e(__('Add Product')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('flash_deal') ||
                                auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/products/flash-deal')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.products.flash-deal')); ?>"><?php echo e(__('Flash Deal')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_categories') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/categories', 'admin/categories/*/edit')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.categories.index')); ?>"> <?php echo e(__('Category')); ?> </a>
                                </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('create_categories') || auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/categories/create')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.categories.create')); ?>"> <?php echo e(__('Add Category')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('manage_commissions') || auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/commissions')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.commissions.index')); ?>"> <?php echo e(__('Commissions')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_brands') || auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/brands', 'admin/brands/*/edit')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.brands.index')); ?>"> <?php echo e(__('Brand')); ?> </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('create_brands') || auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/brands/create')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.brands.create')); ?>"> <?php echo e(__('Add Brand')); ?> </a>
                                </li>
                            <?php endif; ?>
                                <?php if(auth()->user()->can('browse_colors') || auth()->user()->hasRole('super-admin')): ?>
                                    <li><a class="<?php if(Request::is('admin/colors','admin/colors/*/edit')): ?>active <?php endif; ?>"
                                           href="<?php echo e(route('backend.colors.index')); ?>"> <?php echo e(__('Color')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('create_colors') || auth()->user()->hasRole('super-admin')): ?>
                                    <li><a class="<?php if(Request::is('admin/colors/create')): ?>active <?php endif; ?>"
                                           href="<?php echo e(route('backend.colors.create')); ?>"> <?php echo e(__('Add Color')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('browse_sizes') || auth()->user()->hasRole('super-admin')): ?>
                                    <li><a class="<?php if(Request::is('admin/sizes','admin/sizes/*/edit')): ?>active <?php endif; ?>"
                                           href="<?php echo e(route('backend.sizes.index')); ?>"> <?php echo e(__('Size')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(auth()->user()->can('create_sizes') || auth()->user()->hasRole('super-admin')): ?>
                                    <li><a class="<?php if(Request::is('admin/sizes/create')): ?>active <?php endif; ?>"
                                           href="<?php echo e(route('backend.sizes.create')); ?>"> <?php echo e(__('Add Size')); ?> </a>
                                    </li>
                                <?php endif; ?>
                            <?php if(auth()->user()->can('products_wholesale') || auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/products/wholesale', 'admin/products/wholesale/edit/*')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.products.wholesale')); ?>"> <?php echo e(__('Wholesale')); ?> </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(Module::has('PromotionManagement') && Module::find('PromotionManagement')->isEnabled()): ?>
                <?php if(auth()->user()->can('browse_promotion_management') ||
                        auth()->user()->hasRole('super-admin')): ?>
                    <li class="<?php if(Request::is('admin/promotional_products', 'admin/promotional_products/*', 'admin/coupon*')): ?> active <?php endif; ?>">
                        <a href="#">
                            <span class="icon">
                                <svg viewBox="0 0 22 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3101 11.4708L11.4114 24.1705L22.0005 18.6209V6.125L11.3101 11.4708Z" />
                                    <path d="M17.6499 3.52539L7.1084 8.97609L10.9468 10.9257L21.5181 5.56315L17.6499 3.52539Z" />
                                    <path d="M14.7189 1.98175L10.958 0L0.405762 5.57106L4.06777 7.43126L14.7189 1.98175Z" />
                                    <path d="M6.72817 14.531L5.11108 13.4121L3.73112 13.5312V8.01856L0 6.125V18.5911L10.5713 24.1705V11.4875L6.75916 9.55463L6.72817 14.531Z" />
                                </svg>
                            </span>
                            <span class="title"><?php echo e(__('promotional List')); ?></span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                          stroke-linecap="round" />
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round" />
                                </svg>
                            </span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            <?php if(auth()->user()->can('browse_promotional_products') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/promotional_products')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.promotional_products.index')); ?>"><?php echo e(__('Promotional Product')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('create_promotional_products') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/promotional_products/create')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.promotional_products.create')); ?>">
                                        <?php echo e(__('Add Products')); ?> </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_coupon') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/coupon*')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.coupon.index')); ?>"> <?php echo e(__('Coupons')); ?> </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(Module::has('CustomerManagement') && Module::find('CustomerManagement')->isEnabled()): ?>
                <?php if(auth()->user()->can('browse_customer_management') ||
                        auth()->user()->hasRole('super-admin')): ?>
                    <li class="<?php if(Request::is(
                            'admin/customers',
                            'admin/customers/*',
                            'admin/suspended_customers',
                            'admin/email_subscriber',
                            'seller/email_subscriber')): ?> active <?php endif; ?>">
                        <a href="#"><span class="icon"><svg viewBox="0 0 21 22"
                                                            xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.57812 12.1574C8.57812 13.1661 9.39876 13.9867 10.4074 13.9867C11.416 13.9867 12.2367 13.1661 12.2367 12.1574C12.2367 11.1488 11.416 10.3281 10.4074 10.3281C9.39876 10.3281 8.57812 11.1488 8.57812 12.1574Z" />
                                    <path
                                        d="M10.4085 15.207C8.3911 15.207 6.75 16.8481 6.75 18.8656V21.3453H14.0671V18.8656C14.0671 16.8481 12.426 15.207 10.4085 15.207Z" />
                                    <path
                                        d="M5.52964 13.3762C5.52964 12.3675 4.70901 11.5469 3.70037 11.5469C2.69173 11.5469 1.87109 12.3675 1.87109 13.3762C1.87109 14.3848 2.69173 15.2054 3.70037 15.2054C4.70901 15.2054 5.52964 14.3848 5.52964 13.3762Z" />
                                    <path
                                        d="M18.9432 13.3761C18.9432 12.3675 18.1226 11.5469 17.1139 11.5469C16.1053 11.5469 15.2847 12.3675 15.2847 13.3761C15.2847 14.3848 16.1053 15.2054 17.1139 15.2054C18.1226 15.2054 18.9432 14.3848 18.9432 13.3761Z" />
                                    <path
                                        d="M3.08944 0.53125L2.16178 2.71829L0 3.02317L1.55917 4.50421L1.20062 6.6695L3.08944 5.68229L4.97825 6.6695L4.6197 4.50421L6.13822 3.02317L4.0398 2.71829L3.08944 0.53125Z" />
                                    <path
                                        d="M11.3585 2.71829L10.4082 0.53125L9.4805 2.71829L7.35938 3.02317L8.87789 4.50421L8.51934 6.6695L10.4082 5.68229L12.297 6.6695L11.9384 4.50421L13.4569 3.02317L11.3585 2.71829Z" />
                                    <path
                                        d="M17.7207 0.53125L16.793 2.71829L14.6719 3.02317L16.1904 4.50421L15.8318 6.6695L17.7207 5.68229L19.6095 6.6695L19.2509 4.50421L20.8101 3.02317L18.671 2.71829L17.7207 0.53125Z" />
                                    <path
                                        d="M17.1116 16.4258C16.3011 16.4258 15.5594 16.6978 14.9531 17.1437C15.1572 17.6809 15.2823 18.257 15.2823 18.8648V21.3445H20.8108V20.0843C20.8108 18.0637 19.1322 16.4258 17.1116 16.4258Z" />
                                    <path
                                        d="M0 20.0843V21.3445H5.52846V18.8648C5.52846 18.257 5.65359 17.6809 5.85764 17.1437C5.25137 16.6978 4.50966 16.4258 3.69919 16.4258C1.67858 16.4258 0 18.0637 0 20.0843Z" />
                                </svg></span>
                            <span class="title"><?php echo e(__('Customer Management')); ?></span>
                            <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                          stroke-linecap="round" />
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round" />
                                </svg></span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            <?php if(auth()->user()->can('browse_customers') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/customers', 'seller/customers')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.customers.index')); ?>"><?php echo e(__('All Customer')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if(auth()->user()->can('browse_suspended_customers') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/suspended_customers', 'seller/suspended_customers')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.customers.suspended')); ?>"><?php echo e(__('Suspended Customer')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->can('browse_email_subscriber') ||
                                    auth()->user()->hasRole('super-admin')): ?>
                                <li>
                                    <a class="<?php if(Request::is('admin/email_subscriber', 'seller/email_subscriber')): ?> active <?php endif; ?>"
                                       href="<?php echo e(route('backend.email_subscriber')); ?>"><?php echo e(__('Email Subscriber')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(Module::has('SellerManagement') && Module::find('SellerManagement')->isEnabled()): ?>
                <?php if(auth()->user()->can('browse_seller_management') ||
                        auth()->user()->hasRole('super-admin')): ?>
                    <li class="<?php if(Request::is('admin/sellers', 'admin/seller_commission', 'admin/sellers/*', 'admin/sellers_earning')): ?> active <?php endif; ?>">
                        <a href="#"><span class="icon"><svg viewBox="0 0 24 23"
                                                            xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.6201 9.64488L12.7113 0.263681C12.3019 -0.0878938 11.6978 -0.0878938 11.2885 0.263681L0.37962 9.64488C-0.0777224 10.0379 -0.128669 10.7266 0.264 11.1834C0.656669 11.6404 1.34635 11.6912 1.80209 11.2993L11.9999 2.52951L22.1977 11.2993C22.4035 11.4764 22.6561 11.5628 22.9082 11.5628C23.2151 11.5628 23.5202 11.4341 23.7358 11.1833C24.1284 10.7266 24.0775 10.0378 23.6201 9.64488Z" />
                                    <path d="M8.93802 22.3629V19.6924L8.34375 22.3629H8.93802Z" />
                                    <path d="M15.062 22.3629H15.6563L15.062 19.6924V22.3629Z" />
                                    <path
                                        d="M12.3567 4.0595C12.1525 3.88316 11.8484 3.88316 11.6442 4.0595L3.42343 11.1506C3.3036 11.254 3.23438 11.4048 3.23438 11.5633V21.8182C3.23438 22.1195 3.47858 22.3638 3.78014 22.3638H6.10415L7.44317 16.3756C7.50927 16.0876 7.68334 15.8264 7.96081 15.6683C8.0291 15.6295 9.565 14.7837 11.5811 14.673L11.8531 15.2186H11.8624L11.1254 20.954L11.9327 22.3639H12.068L12.8754 20.954L12.1384 15.2186H12.1452L12.4186 14.673C14.4337 14.7837 15.9717 15.6295 16.04 15.6683C16.3175 15.8264 16.4915 16.0876 16.5576 16.3756L17.8966 22.3638H20.2206C20.5222 22.3638 20.7664 22.1196 20.7664 21.8182V11.5634C20.7664 11.4048 20.6972 11.254 20.5773 11.1507L12.3567 4.0595ZM12.0005 14.427C10.4735 14.427 9.23431 12.6564 9.23431 11.1293C9.23431 9.60226 10.4735 8.36429 12.0005 8.36429C13.5266 8.36429 14.7651 9.60226 14.7651 11.1293C14.7651 12.6564 13.5266 14.427 12.0005 14.427Z" />
                                </svg>
                            </span>
                            <span class="title"><?php echo e(__('Seller Management')); ?></span>
                            <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                          stroke-linecap="round" />
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round" />
                                </svg></span>
                        </a>
                        <!-- Sub Manu Start -->

                        <ul>
                            <li>
                                <a class="<?php if(Request::is('admin/sellers/create')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.sellers.create')); ?>"><?php echo e(__('Create Seller')); ?>

                                </a>
                            </li>
                            <li>
                                <a class="<?php if(Request::is('admin/sellers')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.sellers.index')); ?>"><?php echo e(__('Seller List')); ?>

                                </a>
                            </li>
                            
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_content_management') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is('admin/banners', 'admin/banners/*', 'admin/product_review', 'admin/product_review/*')): ?> active <?php endif; ?>">
                    <a href="#"><span class="icon"><svg viewBox="0 0 23 21"
                                                        xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.013 10.4602H20.3182V3.9342H15.75V5.23941H19.013V10.4602Z" />
                                <path d="M3.26224 5.23941H6.52526V3.9342H1.95703V10.4602H3.26224V5.23941Z" />
                                <path
                                    d="M20.2532 16.1689C20.6971 15.7008 20.9703 15.0692 20.9703 14.3746C20.9703 12.9352 19.7993 11.7642 18.3599 11.7642C16.9205 11.7642 15.7495 12.9352 15.7495 14.3746C15.7495 15.0692 16.0227 15.7008 16.4667 16.1689C15.7006 16.5939 15.0911 17.2682 14.7489 18.0816C14.4066 17.2682 13.7971 16.594 13.031 16.1689C13.475 15.7008 13.7482 15.0692 13.7482 14.3746C13.7482 12.9352 12.5772 11.7642 11.1378 11.7642C9.69839 11.7642 8.52736 12.9352 8.52736 14.3746C8.52736 15.0692 8.80058 15.7008 9.24453 16.1689C8.47842 16.5939 7.86897 17.2682 7.5267 18.0816C7.18443 17.2682 6.57494 16.594 5.80887 16.1689C6.25282 15.7008 6.52604 15.0692 6.52604 14.3746C6.52604 12.9352 5.35501 11.7642 3.91562 11.7642C2.47624 11.7642 1.30521 12.9352 1.30521 14.3746C1.30521 15.0692 1.57843 15.7008 2.02238 16.1689C0.817452 16.8373 0 18.1226 0 19.5954V20.248H22.2756V19.5954C22.2756 18.1226 21.4581 16.8373 20.2532 16.1689Z" />
                                <path
                                    d="M15.0534 8.50117C15.0534 7.02838 14.236 5.74309 13.031 5.0747C13.475 4.60652 13.7482 3.97493 13.7482 3.28034C13.7482 1.84095 12.5772 0.669922 11.1378 0.669922C9.69841 0.669922 8.52738 1.84095 8.52738 3.28034C8.52738 3.97493 8.8006 4.60652 9.24454 5.0747C8.03962 5.74309 7.22217 7.02838 7.22217 8.50117V9.15378H15.0534V8.50117Z" />
                            </svg>
                        </span>
                        <span class="title"><?php echo e(__('Content Management')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="<?php if(Request::is('admin/banners', 'admin/banners/*')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.banners.index')); ?>"><?php echo e(__('Banner')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/product_review')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.product_review.index')); ?>"><?php echo e(__('Product Review')); ?>

                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_faq_manager') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is(
                        'admin/faq_category',
                        'admin/faq_category/*',
                        'admin/faq_subcategory',
                        'admin/faq_subcategory/*',
                        'admin/faq_content',
                        'admin/faq_content/*')): ?> active <?php endif; ?>">
                    <a href="#"><span class="icon"><svg viewBox="0 0 22 23"
                                                        xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path
                                        d="M22.0006 15.1383C22.0006 12.4082 20.4344 9.97179 18.0887 8.78662C18.0159 14.0211 13.7721 18.2649 8.5376 18.3378C9.72276 20.6834 12.1592 22.2496 14.8893 22.2496C16.1692 22.2496 17.414 21.9087 18.5077 21.261L21.9695 22.2186L21.012 18.7567C21.6597 17.663 22.0006 16.4183 22.0006 15.1383Z" />
                                    <path
                                        d="M16.8008 8.65039C16.8008 4.01833 13.0325 0.25 8.40039 0.25C3.76833 0.25 0 4.01833 0 8.65039C0 10.16 0.401825 11.6298 1.16486 12.9202L0.0308838 17.0197L4.13054 15.8859C5.42094 16.649 6.89078 17.0508 8.40039 17.0508C13.0325 17.0508 16.8008 13.2825 16.8008 8.65039ZM7.11133 6.69531H5.82227C5.82227 5.27365 6.97873 4.11719 8.40039 4.11719C9.82205 4.11719 10.9785 5.27365 10.9785 6.69531C10.9785 7.41689 10.673 8.11043 10.1401 8.59785L9.04492 9.60023V10.6055H7.75586V9.03258L9.26984 7.64684C9.54041 7.39926 9.68945 7.06139 9.68945 6.69531C9.68945 5.98448 9.11122 5.40625 8.40039 5.40625C7.68956 5.40625 7.11133 5.98448 7.11133 6.69531ZM7.75586 11.8945H9.04492V13.1836H7.75586V11.8945Z" />
                                </g>
                            </svg>
                        </span>
                        <span class="title"><?php echo e(__('FAQ Manager')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="<?php if(Request::is('admin/faq_category')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.faq_category.index')); ?>"><?php echo e(__('FAQ Category')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/faq_subcategory')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.faq_subcategory.index')); ?>"><?php echo e(__('FAQ SubCategory')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/faq_content', 'admin/faq_content/*')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.faq_content.index')); ?>"><?php echo e(__('FAQ Content')); ?>

                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_reports') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is('admin/stock_report', 'admin/seller_report', 'admin/customer_report')): ?> active <?php endif; ?>">
                    <a href="#"><span class="icon"><svg viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1" />
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1" />
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282"
                                      rx="1" />
                            </svg></span>
                        <span class="title"><?php echo e(__('Report')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="<?php if(Request::is('admin/stock_report')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.stock_report')); ?>"><?php echo e(__('Product (Stock balance)')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/customer_report')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.customer_report')); ?>"><?php echo e(__('Customer Transaction')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/seller_report')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.seller_report')); ?>"><?php echo e(__('Seller info')); ?>

                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_user_permission') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is(
                        'admin/permissions',
                        'admin/permissions/*',
                        'admin/users',
                        'admin/users/*',
                        'admin/roles',
                        'admin/roles/*')): ?> active <?php endif; ?>">
                    <a href="#"><span class="icon"><svg viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path
                                        d="M18.5417 13.763H18.3333V12.513C18.3333 11.3647 17.3984 10.4297 16.25 10.4297C15.1016 10.4297 14.1667 11.3647 14.1667 12.513V13.763H13.9583C13.1541 13.763 12.5 14.4171 12.5 15.2214V18.138C12.5 18.9423 13.1541 19.5964 13.9583 19.5964H18.5417C19.3459 19.5964 20 18.9423 20 18.138V15.2214C20 14.4171 19.3459 13.763 18.5417 13.763ZM15.4167 12.513C15.4167 12.0538 15.7909 11.6797 16.25 11.6797C16.7091 11.6797 17.0833 12.0538 17.0833 12.513V13.763H15.4167V12.513Z" />
                                    <path
                                        d="M11.25 15.2214C11.25 14.0964 11.9392 13.1305 12.9167 12.7214V12.513C12.9167 12.0064 13.0391 11.5314 13.2425 11.1005C12.6125 10.6779 11.8558 10.4297 11.0417 10.4297H3.95828C1.77582 10.4297 0 12.2055 0 14.388V17.3047C0 17.6497 0.279999 17.9297 0.625 17.9297H11.25V15.2214Z" />
                                    <path
                                        d="M11.6664 4.59641C11.6664 6.89758 9.8009 8.76297 7.49973 8.76297C5.19855 8.76297 3.33301 6.89758 3.33301 4.59641C3.33301 2.29523 5.19855 0.429688 7.49973 0.429688C9.8009 0.429688 11.6664 2.29523 11.6664 4.59641Z" />
                                </g>
                            </svg></span>
                        <span class="title"><?php echo e(__('User Permission')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <?php if(auth()->user()->can('browse_users') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/users', 'admin/users/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.users.index')); ?>"><?php echo e(__('Users')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_roles') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/roles', 'admin/roles/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.roles.index')); ?>"><?php echo e(__('Roles')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_permissions') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/permissions', 'admin/permissions/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.permissions.index')); ?>"><?php echo e(__('Permission')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_website_setting') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is(
                        'admin/contact-infos',
                        'admin/website_setting/header',
                        'admin/website_setting/pages',
                        'admin/website_setting/pages/*',
                        'admin/website_setting/appearance',
                        'admin/website_setting/announcements',
                        'admin/website_setting/announcements/*',
                        'admin/website_setting/currency',
                        'admin/website_setting/currency/*',
                        'admin/website_setting/language',
                        'admin/website_setting/notice/*')): ?> active <?php endif; ?>">
                    <a href="#"><span class="icon"><svg viewBox="0 0 20 21"
                                                        xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.653 12.4416L17.7652 11.0041C17.8238 10.5024 17.8238 9.99586 17.7652 9.49414L19.6547 8.05583C20.0088 7.77813 20.1034 7.29118 19.8781 6.90665L17.9141 3.60084C17.6879 3.21389 17.2062 3.0449 16.7786 3.20252L14.5537 4.0742C14.1356 3.77881 13.6877 3.52557 13.217 3.31838L12.8755 1.01671C12.814 0.574834 12.4247 0.246397 11.9667 0.25003H8.03036C7.57625 0.247374 7.19008 0.572138 7.1267 1.01003L6.78442 3.31834C6.31514 3.52752 5.86801 3.78096 5.44947 4.07502L3.21852 3.20166C2.79533 3.0392 2.31402 3.20615 2.09151 3.59248L0.12587 6.90415C-0.10554 7.28931 -0.0102724 7.78161 0.349218 8.05833L2.23696 9.49582C2.17788 9.9975 2.17788 10.5041 2.23696 11.0058L0.347493 12.4433C-0.00718373 12.7206 -0.102251 13.2078 0.123303 13.5925L2.08638 16.8992C2.31229 17.2864 2.79433 17.4555 3.22193 17.2975L5.44686 16.4258C5.86532 16.7213 6.31346 16.9749 6.78438 17.1825L7.12666 19.4825C7.18691 19.9232 7.5738 20.2518 8.03032 20.25H11.9667C12.4217 20.2535 12.8091 19.9286 12.8729 19.49L13.2152 17.1817C13.6845 16.9724 14.1315 16.719 14.5502 16.425L16.7836 17.2992C17.2068 17.4612 17.6879 17.2944 17.9106 16.9083L19.8823 13.5834C20.103 13.1994 20.006 12.7163 19.653 12.4416ZM9.99853 14.4166C7.63549 14.4166 5.71983 12.5512 5.71983 10.25C5.71983 7.94876 7.63545 6.08329 9.99853 6.08329C12.3616 6.08329 14.2772 7.94876 14.2772 10.25C14.2744 12.55 12.3604 14.4139 9.99853 14.4166Z" />
                            </svg></span>
                        <span class="title"><?php echo e(__('Website Setting')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <?php if(auth()->user()->can('browse_header') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/header')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.website_setting.header')); ?>"><?php echo e(__('Header')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_pages') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/pages', 'website_setting/pages/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.website_setting.pages')); ?>"><?php echo e(__('Pages')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_appearance') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/appearance')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.website_setting.appearance')); ?>"><?php echo e(__('Appearance')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_announcements') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/announcements', 'admin/website_setting/announcements/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.announcements.index')); ?>"><?php echo e(__('Announcements')); ?>

                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->user()->can('browse_currency') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/currency', 'admin/website_setting/currency/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.currency.index')); ?>"><?php echo e(__('Currency')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_language') ||
                                auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/language', 'admin/website_setting/language/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.language.index')); ?>"><?php echo e(__('Language')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('browse_notice') || auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/website_setting/notice', 'admin/website_setting/notice/*')): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('backend.notice.index')); ?>"><?php echo e(__('notice')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->can('manage_contact_info') || auth()->user()->hasRole('super-admin')): ?>
                            <li>
                                <a class="<?php if(Request::is('admin/contact-infos')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.contact-infos.index')); ?>">
                                    <?php echo e(__('Contact Infos')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_payment_gateway') ||
                    auth()->user()->hasRole('super-admin')): ?>
                <li>
                    <a class="<?php if(Request::is('admin/payment_gateway*')): ?> active <?php endif; ?>"
                        href="<?php echo e(route('backend.payment_gateway.index')); ?>">
                        <span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1" />
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1" />
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282"
                                    rx="1" />
                            </svg>
                        </span>
                        <span class="title"> <?php echo e(__('Payment Gateway')); ?> </span>
                    </a>
                </li>
                <li>
                    <a class="<?php if(Request::is('admin/payments*')): ?> active <?php endif; ?>"
                        href="<?php echo e(route('backend.payments.index')); ?>">
                        <span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1" />
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1" />
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282" rx="1" />
                            </svg>
                        </span>
                        <span class="title"> <?php echo e(__('Payment')); ?> </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->hasRole('super-admin')): ?>
                <li>
                    <a class="<?php if(Route::is('backend.withdraws.index') || Route::is('backend.withdraws.show')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.withdraws.index')); ?>">
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="title"> <?php echo e(__('Withdraw Manager')); ?> </span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(auth()->user()->can('browse_blog_list') || auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Request::is('admin/blog/category', 'admin/blog/category/*', 'admin/blog', 'admin/blog/*')): ?> active <?php endif; ?>">
                    <a href="">
                        <span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1" />
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1" />
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282"
                                      rx="1" />
                            </svg>
                        </span>
                        <span class="title"> <?php echo e(__('blog List')); ?> </span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <ul>
                        <li>
                            <a class=" <?php if(Request::is('admin/blog/category', 'admin/blog/category/*')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.blog.category.index')); ?>"><?php echo e(__('Blog Category')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="<?php if(Request::is('admin/blog', 'admin/blog/*')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.blog.index')); ?>"><?php echo e(__('blog')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->can('browse_stock_management') || auth()->user()->hasRole('super-admin')): ?>
                <li class="<?php if(Route::is('backend.stocks.index') || Route::is('backend.stocks.show')): ?> active <?php endif; ?>">
                    <a href="#" class="<?php if(Route::is('backend.stocks.index') || Route::is('backend.stocks.show')): ?> active <?php endif; ?>">
                        <span class="icon">
                            <svg viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.6201 9.64488L12.7113 0.263681C12.3019 -0.0878938 11.6978 -0.0878938 11.2885 0.263681L0.37962 9.64488C-0.0777224 10.0379 -0.128669 10.7266 0.264 11.1834C0.656669 11.6404 1.34635 11.6912 1.80209 11.2993L11.9999 2.52951L22.1977 11.2993C22.4035 11.4764 22.6561 11.5628 22.9082 11.5628C23.2151 11.5628 23.5202 11.4341 23.7358 11.1833C24.1284 10.7266 24.0775 10.0378 23.6201 9.64488Z" />
                            <path d="M8.93802 22.3629V19.6924L8.34375 22.3629H8.93802Z" />
                            <path d="M15.062 22.3629H15.6563L15.062 19.6924V22.3629Z" />
                            <path d="M12.3567 4.0595C12.1525 3.88316 11.8484 3.88316 11.6442 4.0595L3.42343 11.1506C3.3036 11.254 3.23438 11.4048 3.23438 11.5633V21.8182C3.23438 22.1195 3.47858 22.3638 3.78014 22.3638H6.10415L7.44317 16.3756C7.50927 16.0876 7.68334 15.8264 7.96081 15.6683C8.0291 15.6295 9.565 14.7837 11.5811 14.673L11.8531 15.2186H11.8624L11.1254 20.954L11.9327 22.3639H12.068L12.8754 20.954L12.1384 15.2186H12.1452L12.4186 14.673C14.4337 14.7837 15.9717 15.6295 16.04 15.6683C16.3175 15.8264 16.4915 16.0876 16.5576 16.3756L17.8966 22.3638H20.2206C20.5222 22.3638 20.7664 22.1196 20.7664 21.8182V11.5634C20.7664 11.4048 20.6972 11.254 20.5773 11.1507L12.3567 4.0595ZM12.0005 14.427C10.4735 14.427 9.23431 12.6564 9.23431 11.1293C9.23431 9.60226 10.4735 8.36429 12.0005 8.36429C13.5266 8.36429 14.7651 9.60226 14.7651 11.1293C14.7651 12.6564 13.5266 14.427 12.0005 14.427Z" />
                            </svg>
                        </span>
                        <span class="title"><?php echo e(__('Stock Management')); ?></span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562"
                                      stroke-linecap="round" />
                                <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                      transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                      stroke-linecap="round" />
                            </svg></span>
                    </a>
                    <ul>
                        <li>
                            <a class="<?php if(Route::is('backend.stocks.index') || Route::is('backend.stocks.show')): ?> active <?php endif; ?>"
                               href="<?php echo e(route('backend.stocks.index')); ?>"><?php echo e(__('Stock List')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->can('browse_notifications') || auth()->user()->hasRole('super-admin')): ?>
                <li>
                    <a class="<?php if(Request::is('admin/notifications')): ?> active <?php endif; ?>" href="<?php echo e(route('backend.notifications.index')); ?>">
                    <span class="icon">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                    </span>
                        <span class="title"><?php echo e(__('Notifications')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- Side Manu End -->
</nav>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/includes/side_bar.blade.php ENDPATH**/ ?>