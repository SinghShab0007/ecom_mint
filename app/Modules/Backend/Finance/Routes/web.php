<?php

use App\Modules\Backend\Finance\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'seller', 'namespace' => 'Backend', 'as' => 'seller.'], function () {
    Route::group(['middleware' => 'auth:seller'], function () {
        Route::get('finance/statement',[FinanceController::class,'statement'])->name('finance.statement');
        Route::get('finance/orders',[FinanceController::class,'orders'])->name('finance.orders');
    });
});
