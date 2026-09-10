<canvas id="timeline-chart"></canvas>
<div class="maan-chart-color-point-wrp">
    <div class="color-items blue">
        <p><?php echo e(__('Selected Month')); ?></p>
    </div>
    <div class="color-items red">
        <p><?php echo e(__('Previous Month')); ?></p>
    </div>
</div>

<?php $__env->startPush('js'); ?>
    <script>
        (function ($) {

            "use strict";

            $(document).ready(function () {

            });
        })(jQuery);

        let height = document.querySelector('.dashboard-linecahrt-wrap');
        height.style.height = '200px';
        height.style.overflow = 'hidden';

        let height2 = document.querySelector('#timeline-chart');
        height2.style.height = '160px';
        height2.style.width = '100%';
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/_monthly_sale.blade.php ENDPATH**/ ?>