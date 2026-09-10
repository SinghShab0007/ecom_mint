<?php $__env->startSection('title','Orders - '); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('backend.includes.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content-body">
    <?php echo $__env->make('ordermanagement::orders.order_overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Tab Content Start -->
        <div class="tab-content order-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="order-list" aria-labelledby="order-list-tab">
                <div class="container">

                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo e(__('Invoice#')); ?></th>
                                <th scope="col"><?php echo e(__('Name')); ?></th>
                                <th scope="col"><?php echo e(__('Shipping')); ?></th>
                                <th scope="col"><?php echo e(__('Discount')); ?></th>
                                <th scope="col"><?php echo e(__('Coupon Discount')); ?></th>
                                <th scope="col"><?php echo e(__('Total')); ?></th>
                                <th scope="col"><?php echo e(__('Payment')); ?></th>
                                <th scope="col"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
        <!-- Tab Content End -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <?php echo $__env->make('backend.includes.datatable_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>

        $(function() {
            "use strict";

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "<?php if(auth()->guard('admin')->check()): ?><?php echo e(route('backend.orders.list')); ?><?php elseif(auth()->guard('seller')->check()): ?><?php echo e(route('seller.orders.list', ['order_no' => request('order')])); ?><?php endif; ?>",
                    columns: [
                        { data: 'order_no' },
                        { data: 'user_last_name' },
                        { data: 'shipping_address_1'},
                        { data: 'discount' },
                        { data: 'coupon_discount' },
                        { data: 'total_price' },
                        { data: 'payment_by' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });
                let method = "<?php echo Route::getCurrentRoute()->getName(); ?>";
                if(method == 'backend.search'){
                    let searchValue = "<?php echo $searchValue; ?>";
                    table.DataTable().search(searchValue).draw();
                }
                else if(method == 'seller.search'){
                    let searchValue = "<?php echo $searchValue; ?>";
                    table.DataTable().search(searchValue).draw();
                }

            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/app/Modules/Backend/OrderManagement/Resources/views/orders/index.blade.php ENDPATH**/ ?>