<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Backend\SellerManagement\Http\Controllers\SellerController;
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
    Route::group(['middleware' => 'auth:admin,seller'], function () {
        Route::get('seller_list', [SellerController::class, 'sellerList'])->name('seller.list');
        Route::get('seller/changeStatus', [SellerController::class, 'changeStatus']);
        Route::get('seller/approve', [SellerController::class, 'approve']);
        Route::group(['middleware' => ['check_permission']], function () {
            Route::get('sellers/{seller}/pan/download', [SellerController::class, 'downloadPan'])->name('sellers.pan.download');
            Route::get('sellers/{seller}/shop-image/download', [SellerController::class, 'downloadShopImage'])->name('sellers.shop_image.download');
            Route::resource('sellers', 'SellerController');
        });
    });
});
