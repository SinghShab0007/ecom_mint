<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [1, 'super-admin', 'admin', '2021-07-27 08:52:24',  NULL],
            [4, 'admin', 'admin', '2021-08-08 12:45:31',  '2021-09-06 11:38:13' ],
            [5, 'Manager', 'admin', '2021-08-08 13:02:21', '2021-09-06 11:40:16' ],
            [7, 'Seller', 'seller', '2021-09-10 07:52:57', '2021-09-10 07:53:18' ],
        ];

        $permissions = [
            [9, 'browse_roles', 'admin',  '2021-05-24 03:36:57', '2021-05-24 03:36:57'],
            [10, 'create_roles', 'admin',  '2021-05-24 03:36:57', '2021-05-24 03:36:57'],
            [11, 'edit_roles', 'admin',  '2021-05-24 03:36:57', '2021-05-24 03:36:57'],
            [12, 'delete_roles', 'admin',  '2021-05-24 03:36:57', '2021-05-24 03:36:57'],
            [13, 'browse_users', 'admin',  '2021-05-24 07:27:52', '2021-05-24 07:27:52'],
            [14, 'browse_order_management', 'admin',  '2021-05-25 09:29:24', '2021-05-25 09:29:24'],
            [15, 'browse_pending_orders', 'admin',  '2021-05-25 09:29:24', '2021-05-25 09:29:24'],
            [16, 'browse_orders', 'admin',  '2021-05-26 03:04:25', '2021-05-26 03:04:25'],
            [17, 'browse_system_config', 'admin',  '2021-06-03 03:01:46', '2021-06-03 03:17:28'],
            [18, 'browse_customer_management', 'admin',  '2021-06-03 03:25:25', '2021-06-03 03:26:12'],
            [25, 'browse_dashboard', 'admin',  '2021-09-10 07:51:28', '2021-09-10 07:51:28'],
            [26, 'browse_dashboard', 'seller',  '2021-09-10 07:51:28', '2021-09-10 07:51:28'],
            [27, 'browse_orders', 'seller',  '2021-10-01 15:36:06', '2021-10-01 15:36:06'],
            [28, 'browse_order_management', 'seller',  '2021-10-13 09:25:54', '2021-10-13 09:25:54'],
            [29, 'browse_pending_orders', 'seller',  '2021-10-13 09:26:50', '2021-10-13 09:26:50'],
            [30, 'browse_confimed_orders', 'admin',  '2021-10-13 09:28:31', '2021-10-13 09:28:31'],
            [31, 'browse_confimed_orders', 'seller',  '2021-10-13 09:28:31', '2021-10-13 09:28:31'],
            [32, 'browse_processing_orders', 'admin',  '2021-10-13 09:29:04', '2021-10-13 09:29:04'],
            [33, 'browse_processing_orders', 'seller',  '2021-10-13 09:29:25', '2021-10-13 09:29:25'],
            [34, 'browse_picked_order', 'admin',  '2021-10-13 09:30:16', '2021-10-13 09:30:16'],
            [35, 'browse_picked_order', 'seller',  '2021-10-13 09:30:16', '2021-10-13 09:30:16'],
            [36, 'browse_shipped_orders', 'admin',  '2021-10-13 09:30:44', '2021-10-13 09:30:44'],
            [37, 'browse_shipped_orders', 'seller',  '2021-10-13 09:30:44', '2021-10-13 09:30:44'],
            [38, 'browse_delivered_orders', 'admin',  '2021-10-13 09:31:32', '2021-10-13 09:31:32'],
            [39, 'browse_delivered_orders', 'seller',  '2021-10-13 09:31:32', '2021-10-13 09:31:32'],
            [40, 'browse_cancelled_orders', 'admin',  '2021-10-13 09:32:20', '2021-10-13 09:32:20'],
            [41, 'browse_cancelled_orders', 'seller',  '2021-10-13 09:32:20', '2021-10-13 09:32:20'],
            [42, 'browse_product_management', 'admin',  '2021-10-13 09:33:28', '2021-10-13 09:33:28'],
            [43, 'browse_product_management', 'seller',  '2021-10-13 09:33:28', '2021-10-13 09:33:28'],
            [44, 'browse_products', 'admin',  '2021-10-13 09:34:04', '2021-10-13 09:34:04'],
            [45, 'browse_products', 'seller',  '2021-10-13 09:34:04', '2021-10-13 09:34:04'],
            [46, 'create_products', 'admin',  '2021-10-13 09:35:35', '2021-10-13 09:35:35'],
            [47, 'create_products', 'seller',  '2021-10-13 09:35:35', '2021-10-13 09:35:35'],
            [48, 'browse_promotional_products', 'admin',  '2021-10-13 09:36:23', '2021-10-13 09:36:23'],
            [49, 'browse_promotional_products', 'seller',  '2021-10-13 09:36:23', '2021-10-13 09:36:23'],
            [50, 'create_promotional_products', 'admin',  '2021-10-13 09:37:05', '2021-10-13 09:37:05'],
            [51, 'create_promotional_products', 'seller',  '2021-10-13 09:37:05', '2021-10-13 09:37:05'],
            [52, 'browse_categories', 'admin',  '2021-10-13 09:37:53', '2021-10-13 09:37:53'],
            [53, 'browse_categories', 'seller',  '2021-10-13 09:37:53', '2021-10-13 09:37:53'],
            [54, 'create_categories', 'admin',  '2021-10-13 09:38:19', '2021-10-13 09:38:19'],
            [55, 'create_categories', 'seller',  '2021-10-13 09:38:19', '2021-10-13 09:38:19'],
            [56, 'browse_brands', 'admin',  '2021-10-13 09:38:50', '2021-10-13 09:38:50'],
            [57, 'browse_brands', 'seller',  '2021-10-13 09:38:50', '2021-10-13 09:38:50'],
            [58, 'create_brands', 'admin',  '2021-10-13 09:40:26', '2021-10-13 09:40:26'],
            [59, 'create_brands', 'seller',  '2021-10-13 09:40:26', '2021-10-13 09:40:26'],
            [60, 'browse_customers', 'admin',  '2021-10-13 09:42:39', '2021-10-13 09:42:39'],
            [61, 'browse_customers', 'seller',  '2021-10-13 09:42:39', '2021-10-13 09:42:39'],
            [62, 'browse_suspended_customers', 'admin',  '2021-10-13 09:44:00', '2021-10-13 09:44:00'],
            [63, 'edit_customers', 'admin',  '2021-10-13 09:44:17', '2021-10-13 09:44:17'],
            [64, 'delete_customers', 'admin',  '2021-10-13 09:44:37', '2021-10-13 09:44:37'],
            [65, 'browse_sellers', 'admin',  '2021-10-13 09:45:17', '2021-10-13 09:45:17'],
            [66, 'create_sellers', 'admin',  '2021-10-13 09:45:37', '2021-10-13 09:45:37'],
            [67, 'edit_sellers', 'admin',  '2021-10-13 09:46:23', '2021-10-13 09:46:23'],
            [68, 'delete_sellers', 'admin',  '2021-10-13 09:46:43', '2021-10-13 09:46:43'],
            [69, 'browse_content_management', 'admin',  '2021-10-13 10:06:07', '2021-10-13 10:06:07'],
            [70, 'browse_content_management', 'seller',  '2021-10-13 10:06:07', '2021-10-13 10:06:07'],
            [71, 'browse_banners', 'admin',  '2021-10-13 10:07:56', '2021-10-13 10:07:56'],
            [72, 'browse_banners', 'seller',  '2021-10-13 10:07:56', '2021-10-13 10:07:56'],
            [73, 'edit_banners', 'admin',  '2021-10-13 10:08:20', '2021-10-13 10:16:30'],
            [74, 'delete_banners', 'admin',  '2021-10-13 10:08:23', '2021-10-13 10:18:26'],
            [75, 'create_banners', 'admin',  '2021-10-13 10:09:53', '2021-10-13 10:09:53'],
            [76, 'create_banners', 'seller',  '2021-10-13 10:09:53', '2021-10-13 10:09:53'],
            [77, 'edit_banners', 'seller',  '2021-10-13 10:16:30', '2021-10-13 10:16:30'],
            [78, 'delete_banners', 'seller',  '2021-10-13 10:18:26', '2021-10-13 10:18:26'],
            [79, 'browse_product_review', 'admin',  '2021-10-13 10:20:00', '2021-10-13 10:20:00'],
            [80, 'browse_product_review', 'seller',  '2021-10-13 10:20:00', '2021-10-13 10:20:00'],
            [81, 'create_product_review', 'admin',  '2021-10-13 10:21:05', '2021-10-13 10:21:05'],
            [82, 'create_product_review', 'seller',  '2021-10-13 10:21:05', '2021-10-13 10:21:05'],
            [83, 'edit_product_review', 'admin',  '2021-10-13 10:22:00', '2021-10-13 10:22:00'],
            [84, 'edit_product_review', 'seller',  '2021-10-13 10:22:00', '2021-10-13 10:22:00'],
            [85, 'delete_product_review', 'admin',  '2021-10-13 10:22:47', '2021-10-13 10:22:47'],
            [86, 'delete_product_review', 'seller',  '2021-10-13 10:22:47', '2021-10-13 10:22:47'],
            [87, 'edit_products', 'admin',  '2021-10-20 11:15:04', '2021-10-20 11:15:04'],
            [88, 'edit_products', 'seller',  '2021-10-20 11:15:04', '2021-10-20 11:15:04'],
            [89, 'delete_products', 'admin',  '2021-10-20 11:15:28', '2021-10-20 11:15:28'],
            [90, 'delete_products', 'seller',  '2021-10-20 11:15:28', '2021-10-20 11:15:28'],
            [91, 'browse_promotion_management', 'admin',  '2021-10-20 11:15:48', '2021-10-20 11:15:58'],
            [92, 'browse_promotion_management', 'seller',  '2021-10-20 11:15:55', '2021-10-20 11:35:28'],
        ];

        $modelHasRoles = [
            [1, 'App\\User', 1],
            [4, 'App\\User', 2],
            [4, 'App\\User', 3],
        ];

        $roleHasPermissions = [
            [26, 7],
            [27, 7],
            [28, 7],
            [29, 7],
            [31, 7],
            [33, 7],
            [35, 7],
            [37, 7],
            [39, 7],
            [41, 7],
            [43, 7],
            [45, 7],
            [47, 7],
            [53, 7],
            [57, 7],
            [80, 7],
            [88, 7],
            [90, 7],
            [9, 4],
            [10, 4],
            [11, 4],
            [12, 4],
            [13, 4],
            [14, 4],
            [15, 4],
            [16, 4],
            [17, 4],
            [18, 4],
            [25, 4],
            [30, 4],
            [32, 4],
            [34, 4],
            [36, 4],
            [38, 4],
            [40, 4],
            [42, 4],
            [44, 4],
            [46, 4],
            [48, 4],
            [50, 4],
            [52, 4],
            [54, 4],
            [56, 4],
            [58, 4],
            [60, 4],
            [62, 4],
            [63, 4],
            [64, 4],
            [65, 4],
            [66, 4],
            [67, 4],
            [68, 4],
            [69, 4],
            [71, 4],
            [73, 4],
            [74, 4],
            [75, 4],
            [79, 4],
            [81, 4],
            [83, 4],
            [85, 4],
            [87, 4],
            [89, 4],
            [91, 4],
        ];
        foreach($roles as $role){
            DB::table('roles')->insert(
            ['id'=>$role[0],'name'=>$role[1],'guard_name'=>$role[2],'created_at'=>$role[3],'updated_at'=>$role[4]]
            );
        }
        foreach($permissions as $permission){
            DB::table('permissions')->insert(
            ['id'=>$permission[0],'name'=>$permission[1],'guard_name'=>$permission[2],'created_at'=>$permission[3],'updated_at'=>$permission[4]]
            );
        }
        foreach($modelHasRoles as $model_role){
            DB::table('model_has_roles')->insert(
            ['role_id'=>$model_role[0],'model_type'=>$model_role[1],'model_id'=>$model_role[2]]
            );
        }
        foreach($roleHasPermissions as $role_permission){
            DB::table('role_has_permissions')->insert(
            ['permission_id'=>$role_permission[0],'role_id'=>$role_permission[1]]
            );
        }
    }
}
