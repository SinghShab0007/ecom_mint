<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="<?php echo e(config('app.name', 'Mybazar')); ?> <?php echo e(__('Login')); ?>">
    <meta name="description" content="shop login page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo e(config('app.name', 'Mybazar')); ?> <?php echo e(__('Login')); ?></title>

    <!-- All Device Favicon -->
    <link rel="icon" href="<?php if(config('app.favicon')): ?><?php echo e(asset(config('app.favicon'))); ?><?php endif; ?>">

    <?php echo $__env->make('backend.includes.layout_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
<div class="mybazar-login-section">
    <div class="mybazar-login-wrapper">
        <div class="login-wrapper">
            <div class="login-header">
                <img src="<?php if(config('app.logo')): ?><?php echo e(asset(config('app.logo'))); ?><?php endif; ?>" alt="logo">
            </div>
            <div class="login-body">
                <h2><?php echo e(__('Login Panel')); ?></h2>
                <form name="LoginForm" id="LoginForm" action="<?php echo e(url('admin/login')); ?>" method="post" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <div class="input-group">
                        <span><img src="<?php echo e(URL::to('/backend')); ?>/img/icons/mail.svg" alt=""></span>
                        <input id="user-email" type="email" placeholder="Email"
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ? ' is-invalid' : '' <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="email" value="" autocomplete="off" required autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label class="error" id="email-error" for="email"><?php echo e($message); ?></label>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="input-group">
                        <span><img src="<?php echo e(URL::to('/backend')); ?>/img/icons/Lock.svg" alt=""></span>
                        <span class="hide-pass" >
                            <img src="<?php echo e(URL::to('/backend')); ?>/img/icons/Hide.svg" alt="">
                            <img src="<?php echo e(URL::to('/backend')); ?>/img/icons/show.svg" alt="">
                        </span>
                        <input id="password" type="password" placeholder="Password"
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ? ' is-invalid' : '' <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="password" autocomplete="new-password" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label class="error" id="password-error"
                               for="password"><?php echo e($message); ?></label>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn login-btn"><?php echo e(__('Login')); ?></button>
                </form>
                
                <div class="login-footer">
                    <a href="<?php echo e(route('backend.password.request')); ?>">
                        <span><img src="<?php echo e(URL::to('/backend')); ?>/img/icons/lock1.svg" alt=""></span><?php echo e(__('Forgot Password?')); ?></a>
                    <span>
                        <a href="<?php echo e(url('/')); ?>"><span><img src="<?php echo e(URL::to('/backend')); ?>/img/icons/global.svg" alt=""></span><?php echo e(__('Frontend')); ?></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('backend.includes.layout_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    (function ($) {
        "use strict";

        $(document).ready(function () {
            // validate form on keyup and submit
            $("#LoginForm").validate();

            let showPass = document.querySelector('.hide-pass');
            showPass.addEventListener('click', function() {
                showPass.classList.toggle("show-pass");
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            })
        });


    })(jQuery);
</script>
</body>

</html>


<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/auth/login.blade.php ENDPATH**/ ?>