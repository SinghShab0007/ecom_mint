<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductReviewController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::get('categories/{id}', 'CategoryController@show');
    Route::get('categories', 'CategoryController@index');
    Route::get('category/{category_id}/sub_categories', 'SubCategoryController@index');
    Route::get('brands/{id}', 'BrandController@show');
    Route::get('brands', 'BrandController@index');
    Route::get('flash_sale', 'ProductController@flashSale');
    Route::get('new_arrivals', 'ProductController@newArrivals');
    Route::get('popular_products', 'ProductController@popularProducts');
    Route::get('best_selling', 'ProductController@bestSelling');
    Route::get('trends', 'ProductController@trends');
    Route::get('our_featured', 'ProductController@ourFeatured');
    Route::get('best_seller', 'ProductController@bestSeller');
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::post('product_search', 'ProductController@search');
    Route::get('product_review/{product_id}', [ProductReviewController::class, 'index']);
    Route::get('category/{id}/products', 'ProductController@categoryProducts');
    Route::get('brand/{id}/products', 'ProductController@brandProducts');
    Route::get('colors', 'ProductController@colors');
    Route::get('sizes', 'ProductController@sizes');
    Route::get('home', 'WebsiteController@home');

    Route::get('page/{url}','WebsiteController@page');
    Route::get('banners','WebsiteController@banners');
    Route::get('announcements','WebsiteController@announcements');
    Route::get('faq','WebsiteController@faq');
    Route::get('seller_products/{seller_id}','ProductController@sellerProducts');

    /** Customer Auth Routes */
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('send_reset_code', [ForgotPasswordController::class, 'sendResetCodeEmail']);
    Route::post('verify_password_reset_code', [ResetPasswordController::class, 'verifyCode']);
    Route::post('password_reset', [ResetPasswordController::class, 'reset']);
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api', 'as' => 'api.'], function () {
    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('profile', [CustomerController::class, 'profile']);
    Route::post('profile/update', [CustomerController::class, 'update']);
    Route::get('profile/billing', [CustomerController::class, 'getBilling']);
    Route::get('profile/shipping', [CustomerController::class, 'getShipping']);
    Route::post('profile/billing', [CustomerController::class, 'billing']);
    Route::post('profile/shipping', [CustomerController::class, 'shipping']);
    Route::post('profile/image', [CustomerController::class, 'image']);
    Route::post('change_password', [CustomerController::class, 'changePassword']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('add_to_wishlist', [WishlistController::class, 'store']);
    Route::post('remove_from_wishlist', [WishlistController::class, 'removeFromWishlist']);
    Route::post('customer_review', [ProductReviewController::class, 'store']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::post('order_search', [OrderController::class, 'list']);
    Route::get('invoice/{id}', [OrderController::class, 'invoice']);
    Route::post('cancel_order', [OrderController::class, 'cancelOrder']);
    Route::get('cancelled_orders', [OrderController::class, 'cancelledOrderList']);
    Route::get('order_details/{id}', [OrderController::class, 'details']);
    Route::get('order_timelines/{order_details_id}', [OrderController::class, 'timelines']);
    Route::get('order_status/{order_details_id}', [OrderController::class, 'orderStatus']);

    Route::get('currencies', [CurrencyController::class, 'index']);
    Route::get('currency_details/{id}', [CurrencyController::class, 'details']);

    Route::post('order', [PaymentController::class, 'order']);
    Route::post('payment', [PaymentController::class, 'payment']);
    Route::get('stripe', [PaymentController::class, 'stripeInfo']);
    Route::get('paypal', [PaymentController::class, 'paypalInfo']);
    Route::get('product_coupon', [CouponController::class, 'productCoupon']);
    Route::get('cart_coupon', [CouponController::class, 'cartCoupon']);
    Route::post('verify_coupon', [CouponController::class, 'verifyCoupon']);
    Route::post('apply_coupon', [CouponController::class, 'applyCoupon']);
});
