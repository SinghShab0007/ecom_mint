
<div class="manu-bar manu-bar--inline-categories">
    <div class="container">
        <div class="row align-items-center g-0">
            <div class="col-12">
                <nav class="main-manu manu-bar__main" aria-label="<?php echo e(__('Categories')); ?>">
                    <button type="button" class="close-btn" aria-label="<?php echo e(__('Close')); ?>">
                        <span></span>
                        <span></span>
                    </button>
                    <div class="manu-bar__category-scroll">
                    <ul class="manu-bar__category-strip">
                        <li>
                            <a href="<?php echo e(url('shop')); ?>" class="manu-bar__strip-link <?php echo e(isActiveMenu('shop')); ?>"><?php echo e(__('All Products')); ?></a>
                        </li>
                        <?php $__currentLoopData = menus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="manu-bar__cat-item <?php if($menu->subCategories->count()): ?> manu-bar__cat-item--has-mega <?php endif; ?>">
                                <a href="<?php echo e(route('category', $menu->slug ?? 'undefined')); ?>" class="manu-bar__strip-link manu-bar__cat-link <?php echo e(isActiveMenu($menu->slug)); ?>">
                                    <span><?php echo e($menu->name); ?></span>
                                    <?php if($menu->subCategories->count()): ?>
                                        <span class="manu-bar__dd" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
                                    <?php endif; ?>
                                </a>
                                <?php if($menu->subCategories->count()): ?>
                                    <div class="mega-manu">
                                        <div class="container">
                                            <div class="row">
                                                <?php $__currentLoopData = $menu->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-lg-4 col-md-6">
                                                        <ul>
                                                            <?php if($subMenu->subCategories->take(4)->count() > 0): ?>
                                                                <li>
                                                                    <a href="<?php echo e(route('category', $subMenu->slug ?? 'undefined')); ?>">
                                                                        <h6 class="title"><?php echo e($subMenu->name); ?></h6>
                                                                    </a>
                                                                </li>
                                                                <?php $__currentLoopData = $subMenu->subCategories->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subSubMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li>
                                                                        <a href="<?php echo e(route('category', $subSubMenu->slug ?? 'undefined')); ?>"><?php echo e($subSubMenu->name); ?></a>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <li>
                                                                    <a href="<?php echo e(route('category', $subMenu->slug ?? 'undefined')); ?>"><?php echo e($subMenu->name); ?></a>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="manu-bar__cta">
                            <a href="<?php echo e(route('seller.registration')); ?>" class="manu-bar__strip-link <?php echo e(isActiveMenu('/')); ?>"><?php echo e(__('Sale on BillMintMall')); ?></a>
                        </li>
                    </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Menu Bar End -->
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/includes/menu-bar.blade.php ENDPATH**/ ?>