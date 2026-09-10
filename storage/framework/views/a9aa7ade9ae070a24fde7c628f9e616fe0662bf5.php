
    <ul class="maan-chart-point-list">
        <li class="maan-chart-title fs red">
            <span><?php echo e($best_selling_category['category_name'][0]??''); ?></span>
            <?php if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][0])): ?><p><?php echo e($best_selling_category['category_count'][0]); ?> (<?php echo e(round(($best_selling_category['category_count'][0]*100)/array_sum($best_selling_category['category_count']))); ?>%)</p>
            <?php endif; ?>
        </li>

        <li class="maan-chart-title fs blue">
            <span><?php echo e($best_selling_category['category_name'][1]??''); ?></span>
            <?php if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][1])): ?><p><?php echo e($best_selling_category['category_count'][1]); ?> (<?php echo e(round(($best_selling_category['category_count'][1]*100)/array_sum($best_selling_category['category_count']))); ?>%)</p>
            <?php endif; ?>
        </li>

        <li class="maan-chart-title fs green">
            <span><?php echo e($best_selling_category['category_name'][2]??''); ?></span>
            <?php if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][2])): ?><p><?php echo e($best_selling_category['category_count'][2]); ?> (<?php echo e(round(($best_selling_category['category_count'][2]*100)/array_sum($best_selling_category['category_count']))); ?>%)</p>
            <?php endif; ?>
        </li>

        <li class="maan-chart-title fs">
            <span><?php echo e($best_selling_category['category_name'][3]??''); ?></span>
            <?php if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][3])): ?><p><?php echo e($best_selling_category['category_count'][3]); ?> (<?php echo e(round(($best_selling_category['category_count'][3]*100)/array_sum($best_selling_category['category_count']))); ?>%)</p>
            <?php endif; ?>
        </li>

    </ul>

<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/backend/pages/_monthly_category_status.blade.php ENDPATH**/ ?>