<?php

use Database\Seeders\BannerSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ColorProductSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\HeaderSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\ModelHasRoleSeeder;
use Database\Seeders\OrderDetailsSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\OrderTimelineSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\PaymentGatewaySeeder;
use Database\Seeders\ProductDetailsSeeder;
use Database\Seeders\ProductImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductSizeSeeder;
use Database\Seeders\PromotionSeeder;
use Database\Seeders\SellerTableSeeder;
use Database\Seeders\ShippingAddressSeeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\UserBillingSeeder;
use Database\Seeders\WishlistSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(array(
             AdminsTableSeeder::class,
             BrandSeeder::class,
             CategorySeeder::class,
             ColorSeeder::class,
             CountrySeeder::class,
             CurrencySeeder::class,
             HeaderSeeder::class,
             WebAppearancesSeeder::class,
             MenuSeeder::class,
             OrderStatusSeeder::class,
             PageSeeder::class,
             PaymentGatewaySeeder::class,
             ProductSeeder::class,
             ProductDetailsSeeder::class,
             ProductImageSeeder::class,
             BannerSeeder::class,
             PromotionSeeder::class,
             SizeSeeder::class,
             UsersTableSeeder::class,
             PermissionsSeeder::class,
             SellerTableSeeder::class,
             ModelHasRoleSeeder::class,
             ColorProductSeeder::class,
             ProductSizeSeeder::class,
             OrderSeeder::class,
             OrderDetailsSeeder::class,
             OrderTimelineSeeder::class,
             ShippingAddressSeeder::class,
             UserBillingSeeder::class,
             WishlistSeeder::class,
             OAuthTableSeeder::class,
         ));
    }
}
