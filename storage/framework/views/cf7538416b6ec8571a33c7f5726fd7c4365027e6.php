

<?php $__env->startSection('title','404 | Not Found'); ?>

<?php $__env->startSection('content'); ?>
    <section class="maan-error-section">
        <div class="container">
            <div class="maan-error-wrapper">
                <img src="<?php echo e(asset('frontend/img/additional-page/error.png')); ?>" alt="">
                <div class="error-content">
                    <h2><?php echo e(__('error 404')); ?></h2>
                    <p><?php echo e(__('page not found')); ?></p>
                </div>
                <a class="link-anime" href="<?php echo e(url('/')); ?>"><?php echo e(__('Back to Home')); ?></a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/errors/404.blade.php ENDPATH**/ ?>