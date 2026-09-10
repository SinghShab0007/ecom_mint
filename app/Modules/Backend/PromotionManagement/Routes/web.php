<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'admin', 'as' => 'backend.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('promo_product_list', 'PromotionalProductController@promoProductList')->name('promo_product.list');
        Route::get('_products', 'PromotionalProductController@filteredProducts');
        Route::get('promo_product/changeStatus', 'PromotionalProductController@changeStatus');
        Route::group(['middleware' => ['check_permission']], function () {
            Route::resource('promotional_products', 'PromotionalProductController')->except('show');
        });
    });
});
Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
    Route::group(['middleware' => 'auth:seller'], function () {
        Route::get('promo_product_list', 'PromotionalProductController@promoProductList')->name('promo_product.list');
        Route::get('_products', 'PromotionalProductController@filteredProducts');
        Route::get('promo_product/changeStatus', 'PromotionalProductController@changeStatus');
        Route::group(['middleware' => ['check_permission']], function () {
            Route::resource('promotional_products', 'PromotionalProductController')->except('show');
        });
    });
});
