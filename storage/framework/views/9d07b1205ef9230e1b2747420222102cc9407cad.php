

<?php $__env->startSection('title','Customer Login'); ?>

<?php $__env->startSection('content'); ?>
    <h2><?php echo e(__('Welcome to BillMintMall Please Login')); ?></h2>
    <form action="<?php echo e(route('customer.login')); ?>" method="post" autocomplete="off">
        <?php echo csrf_field(); ?>
        <div class="input-group">
            <span><img src="<?php echo e(asset('customer/img/icons/mail.svg')); ?>" alt=""></span>
            <input type="text" name="username" class="form-control" placeholder="User Name/E-mail" autocomplete="off">
            <?php if($errors->has('email')): ?> <p><?php echo e($errors->first('email')); ?></p> <?php endif; ?>
        <?php if($errors->has('username')): ?> <p><?php echo e($errors->first('username')); ?></p> <?php endif; ?>
        </div>
        <div class="input-group">
            <span><img src="<?php echo e(asset('customer/img/icons/Lock.svg')); ?>" alt=""></span>
            <span class="hide-pass">
                            <img src="<?php echo e(asset('customer/img/icons/Hide.svg')); ?>" alt="">
                            <img src="<?php echo e(asset('customer/img/icons/show.svg')); ?>" alt="">
                        </span>
            <input type="password" id="myPass" name="password" class="form-control" placeholder="Password" autocomplete="new-password">
            <?php if($errors->has('password')): ?> <p><?php echo e($errors->first('password')); ?></p> <?php endif; ?>
            <?php if($errors->has('current_password')): ?> <p><?php echo e($errors->first('current_password')); ?></p> <?php endif; ?>
        </div>
        <button type="submit" class="btn login-btn"><?php echo e(__('Login')); ?></button>
    </form>
    <div class="login-footer">
        <a href="<?php echo e(route('customer.register')); ?>"><span><img src="<?php echo e(asset('customer/img/icons/user.svg')); ?>" alt=""></span><?php echo e(__('Create Your Account')); ?></a>
        <a href="<?php echo e(route('customer.password.email')); ?>"><span><img src="<?php echo e(asset('customer/img/icons/lock1.svg')); ?>" alt=""></span><?php echo e(__('Forgot Password?')); ?></a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        let showPass = document.querySelector('.hide-pass');
        showPass.addEventListener('click', function() {
            showPass.classList.toggle("show-pass");
            var x = document.getElementById("myPass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('frontend.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/auth/login.blade.php ENDPATH**/ ?>