<?php

use App\Http\Controllers\Seller\BrandController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\HomeController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SaleController;
use App\Modules\Backend\Finance\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'seller', 'namespace' => 'Backend', 'as' => 'seller.'], function () {
    Route::group(['middleware' => 'auth:seller'], function () {
        Route::get('finance/statement',[FinanceController::class,'statement'])->name('finance.statement');
    });
});

Route::group(['prefix'=>'seller','namespace'=>'Seller','as'=>'seller.'],function(){
    Route::get('/dashboard',[HomeController::class,'index'])->name('home');

    Route::post('sale/store',[SaleController::class,'store'])->name('sale.store');
    Route::post('sale/edit',[SaleController::class,'edit'])->name('sale.edit');
    Route::patch('sale/{id}/update',[SaleController::class,'update'])->name('sale.update');
    Route::delete('sale/destroy/{id}',[SaleController::class,'destroy'])->name('sale.destroy');

    Route::get('products',[ProductController::class,'index'])->name('products');
    Route::get('product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('product/store',[ProductController::class,'store'])->name('product.store');
    Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::patch('product/{id}/update',[ProductController::class,'update'])->name('product.update');
    Route::delete('product/destroy/{id}',[ProductController::class,'destroy'])->name('product.destroy');

    Route::get('products/wholesale', [ProductController::class,'productWholesale'])->name('products.wholesale');
    Route::get('products/wholesale/form', [ProductController::class,'productWholesaleForm'])->name('products.wholesale.form');
    Route::post('products/wholesale/store',[ProductController::class,'wholesaleStore'])->name('products.wholesale.store');
    Route::get('products/wholesale/edit/{wholesale}',[ProductController::class,'wholesaleEdit'])->name('products.wholesale.edit');
    Route::put('products/wholesale/update/{wholesale}',[ProductController::class,'wholesaleUpdate'])->name('products.wholesale.update');
    Route::delete('products/wholesale/destroy/{wholesale}',[ProductController::class,'wholesaleDestroy'])->name('products.wholesale.destroy');
    Route::get('product/changeStatusWholesale',[ProductController::class,'changeStatusWholesale'])->name('product.wholesale.status');

    Route::get('product/categories',[CategoryController::class,'index'])->name('categories');
    Route::get('product/brands',[BrandController::class,'index'])->name('brands');

    Route::resource('withdraws', WithdrawController::class)->only('index', 'create', 'store');
    Route::get('withdraws-datas', 'WithdrawController@withdrawDatas')->name('withdraws.data');

    //Notifications manager
    Route::prefix('notifications')->controller(NotifyController::class)->name('notifications.')->group(function () {
        Route::get('/','mtIndex')->name('index');
        Route::get('/{id}','mtView')->name('mtView');
        Route::get('view/all/','mtReadAll')->name('mtReadAll');
    });
});
