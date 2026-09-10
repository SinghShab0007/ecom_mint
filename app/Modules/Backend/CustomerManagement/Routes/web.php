<?php

use App\Modules\Backend\CustomerManagement\Http\Controllers\CustomerController;
use App\Modules\Backend\CustomerManagement\Http\Controllers\EmailSubscriberController;
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
        Route::group(['middleware' => ['check_permission']], function () {
            Route::get('customer/sendMail', [CustomerController::class, 'sendMail']);
            Route::get('customer/changeStatus', [CustomerController::class, 'changeStatus']);
            Route::get('email_subscriber/changeStatus', [EmailSubscriberController::class, 'changeStatus']);
            Route::get('customer_list', [CustomerController::class, 'customerList'])->name('customer.list');
            Route::get('email_subscriber', [EmailSubscriberController::class, 'index'])->name('email_subscriber');
            Route::get('email_subscriber_list', [EmailSubscriberController::class, 'emailSubscriberList'])->name('email_subscriber.list');
            Route::get('suspended_customer_list', [CustomerController::class, 'suspendedCustomerList'])->name('suspended_customer.list');
            Route::get('suspended_customers', [CustomerController::class, 'suspendedCustomers'])->name('customers.suspended');
            Route::resource('customers', 'CustomerController');

        });
    });
});
Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
    Route::group(['middleware' => 'auth:seller'], function () {
        Route::group(['middleware' => ['check_permission']], function () {
            Route::get('customer/sendMail', [CustomerController::class, 'sendMail']);
            Route::get('customer/changeStatus', [CustomerController::class, 'changeStatus']);
            Route::get('email_subscriber/changeStatus', [EmailSubscriberController::class, 'changeStatus']);
            Route::get('customer_list', [CustomerController::class, 'customerList'])->name('customer.list');
            Route::get('email_subscriber', [EmailSubscriberController::class, 'index'])->name('email_subscriber');
            Route::get('email_subscriber_list', [EmailSubscriberController::class, 'emailSubscriberList'])->name('email_subscriber.list');
            Route::get('suspended_customer_list', [CustomerController::class, 'suspendedCustomerList'])->name('suspended_customer.list');
            Route::get('suspended_customers', [CustomerController::class, 'suspendedCustomers'])->name('customers.suspended');
            Route::resource('customers', 'CustomerController');

        });
    });
});
