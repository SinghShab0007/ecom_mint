<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\NoticeController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\PaymentGatewayController;
use App\Http\Controllers\Backend\Auth\SellerRegisterController;

/*  route */
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'backend.'], function () {
// Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('verify/reset/code', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('account', 'AccountController@show')->name('account');
        Route::put('account/{id}', 'AccountController@update')->name('account.update');
        Route::get('announcement_list', 'AnnouncementsController@announcementsList')->name('announcements.list');
        Route::get('best_selling_product', 'HomeController@bestSellingProducts')->name('best_selling_products');
        Route::get('best_customers', 'HomeController@bestCustomers')->name('best_customers');
        Route::get('new_orders', 'HomeController@newOrders')->name('new_orders');
        Route::get('monthly_sale', 'HomeController@monthlySale')->name('monthly_sale');
        Route::get('best_selling_category', 'HomeController@bestSellingProductCategory');
        Route::get('banner_list', 'BannerController@bannerList')->name('banner.list');
        Route::get('product_review_list', 'ProductReviewController@productReviewList')->name('product_review.list');
        Route::get('role_list', 'RoleController@roleList')->name('role.list');
        Route::get('user_list', 'UserController@userList')->name('user.list');
        Route::get('permission_list', 'PermissionController@permissionList')->name('permission.list');
        Route::get('faq_category_list', 'FaqCategoryController@faqCategoryList')->name('faq_category.list');
        Route::get('faq_subcategory_list', 'FaqSubCategoryController@faqSubCategoryList')->name('faq_subcategory.list');
        Route::get('faq_content_list', 'FaqController@faqContentList')->name('faq_content.list');
        Route::get('currency_list', 'CurrencyController@currencyList')->name('currency.list');

        Route::resource('coupon', 'CouponController')->except('show');
        Route::post('coupon/product-form',[CouponController::class,'product'])->name('coupon.product');
        Route::post('coupon/list',[CouponController::class,'list'])->name('coupon.list');

        Route::get('website_setting/languages',[LanguageController::class,'index'])->name('language.index');
        Route::post('website_setting/language/store',[LanguageController::class,'store'])->name('language.store');
        Route::post('website_setting/language/edit',[LanguageController::class,'edit'])->name('language.edit');
        Route::patch('website_setting/language/{id}/update',[LanguageController::class,'update'])->name('language.update');
        Route::post('website_setting/language/default',[LanguageController::class,'default'])->name('language.default');
        Route::get('website_setting/language/translation/{id}',[LanguageController::class,'translation'])->name('language.translation');
        Route::post('website_setting/language/translate/{id}',[LanguageController::class,'translate'])->name('language.translate');
        Route::delete('website_setting/language/destroy/{id}',[LanguageController::class,'destroy'])->name('language.destroy');

        Route::get('website_setting/notices',[NoticeController::class,'index'])->name('notice.index');
        Route::post('website_setting/notice/store',[NoticeController::class,'store'])->name('notice.store');
        Route::get('website_setting/notice/edit/{id}',[NoticeController::class,'edit'])->name('notice.edit');
        Route::patch('website_setting/notice/{id}/update',[NoticeController::class,'update'])->name('notice.update');
        Route::delete('website_setting/notice/destroy/{id}',[NoticeController::class,'destroy'])->name('notice.destroy');

        Route::group(['middleware' => ['check_permission']], function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::resource('roles', 'RoleController')->except(['show']);
            Route::get('user/changeStatus', 'UserController@changeStatus');
            Route::resource('users', 'UserController')->except(['show']);
            Route::resource('permissions', 'PermissionController')->except(['show']);
            Route::get('role_permissions', 'RoleController@rolePermissions');
            /* contents routes */
            Route::get('banner/changeStatus', 'BannerController@changeStatus');
            Route::resource('banners', 'BannerController')->except('show');
            Route::get('product_review/changeStatus', 'ProductReviewController@changeStatus');
            Route::resource('product_review', 'ProductReviewController')->except('create', 'store');
            /* faq routes */
            Route::get('faq_category/changeStatus', 'FaqCategoryController@changeStatus');
            Route::resource('faq_category', 'FaqCategoryController')->except('show');
            Route::get('faq_subcategory/changeStatus', 'FaqSubCategoryController@changeStatus');
            Route::resource('faq_subcategory', 'FaqSubCategoryController')->except('show');
            Route::get('faq_contents/changeStatus', 'FaqController@changeStatus');
            Route::resource('faq_content', 'FaqController');
            /* report routes */
            Route::get('stock_report_list', 'ReportController@stockReportList')->name('stock_report.list');
            Route::get('stock_report', 'ReportController@stockReport')->name('stock_report');
            Route::get('seller_report', 'ReportController@sellerReport')->name('seller_report');
            Route::get('seller_report_list', 'ReportController@sellerReportList')->name('seller_report.list');
            Route::get('customer_report', 'ReportController@customerReport')->name('customer_report');
            Route::get('customer_report_list', 'ReportController@customerReportList')->name('customer_report.list');
            /* website setting routes */
            Route::get('banner/changeStatus', 'BannerController@changeStatus');
            Route::get('website_setting/header', 'WebsiteSettingController@header')->name('website_setting.header');
            Route::get('website_setting/changeStatus', 'WebsiteSettingController@changeStatus');
            Route::post('website_setting/upload_logo', 'WebsiteSettingController@uploadLogo');
            Route::get('website_setting/page_list', 'WebsiteSettingController@pageList')->name('website_setting.page.list');
            Route::get('website_setting/pages', 'WebsiteSettingController@pages')->name('website_setting.pages');
            Route::get('website_setting/pages/{id}/edit', 'WebsiteSettingController@pageEdit')->name('website_setting.pages.edit');
            Route::put('website_setting/pages/{id}', 'WebsiteSettingController@pageUpdate')->name('website_setting.pages.update');
            Route::get('website_setting/changeMenuStatus', 'WebsiteSettingController@changeMenuStatus');
            Route::get('website_setting/appearance', 'WebsiteSettingController@appearance')->name('website_setting.appearance');
            Route::resource('website_setting/announcements', AnnouncementsController::class, ['names' => 'announcements']);
            Route::get('announcements/changeStatus', 'AnnouncementsController@changeStatus');
            Route::put('website_setting/appearance/{id}', 'WebsiteSettingController@appearanceUpdate')->name('website_setting.appearance.update');
            Route::resource('payment_gateway', 'PaymentGatewayController')->except(['create','store','show','destroy']);
            Route::get('payments', 'PaymentManagementController@index')->name('payments.index');
            Route::get('payments/list', 'PaymentManagementController@paymentList')->name('payments.list');
            Route::resource('website_setting/currency', CurrencyController::class, ['names' => 'currency']);
            Route::get('currency/changeStatus', 'CurrencyController@changeStatus');
            Route::prefix('blog')->name('blog.')->group(function () {
                Route::prefix('category')->name('category.')->group(function () {
                    Route::get('/',[BlogCategoryController::class,'index'])->name('index');
                    Route::get('/list',[BlogCategoryController::class,'blogCategoryList'])->name('list');
                    Route::get('/create',[BlogCategoryController::class,'create'])->name('create');
                    Route::post('/store',[BlogCategoryController::class,'store'])->name('store');
                    Route::get('/edit/{id}',[BlogCategoryController::class,'edit'])->name('edit');
                    Route::put('/update/{id}',[BlogCategoryController::class,'update'])->name('update');
                    Route::delete('/destroy/{id}',[BlogCategoryController::class,'destroy'])->name('destroy');
                });
                Route::controller(BlogController::class)->group(function () {
                    Route::get('/','index')->name('index');
                    Route::get('/list','blogList')->name('list');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{blog}','edit')->name('edit');
                    Route::put('/update/{blog}','update')->name('update');
                    Route::delete('/destroy/{blog}','destroy')->name('destroy');
                });

            });
            /*color route..*/
            Route::resource('/colors',ColorController::class);
            Route::get('/colors/status',[ColorController::class,'colorStatus'])->name('colors.status');
            /*size route..*/
            Route::resource('/sizes',SizeController::class);
        });
    });
});
Route::get('/colors/status',[\App\Http\Controllers\Backend\ColorController::class,'colorStatus'])->name('colors.status');
Route::get('/sizes/status',[\App\Http\Controllers\Backend\SizeController::class,'sizeStatus'])->name('sizes.status');
/* seller route */
Route::group(['prefix' => 'seller', 'namespace' => 'Backend', 'as' => 'seller.'], function () {
    /* seller authentication */
    Route::get('registration',[SellerRegisterController::class,'registration'])->name('registration');
    Route::post('register',[SellerRegisterController::class,'register'])->name('register');
    Route::get('verify-email',[SellerRegisterController::class,'showVerifyForm'])->name('verification.show');
    Route::post('verify-email',[SellerRegisterController::class,'verifyOtp'])->name('verification.verify');
    Route::post('verify-email/resend',[SellerRegisterController::class,'resendOtp'])->name('verification.resend');
    Route::get('login', 'Auth\SellerLoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\SellerLoginController@login');
    Route::post('logout', 'Auth\SellerLoginController@logout')->name('logout');

// Password Reset Routes...
    Route::get('password/reset', 'Auth\SellerForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\SellerForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('verify/reset/code', 'Auth\SellerResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\SellerResetPasswordController@reset')->name('password.update');

    Route::group(['middleware' => 'auth:seller'], function () {
        Route::get('account', 'AccountController@show')->name('account');
        Route::put('account/{id}', 'AccountController@update')->name('account.update');
        Route::get('announcement_list', 'AnnouncementsController@announcementsList')->name('announcements.list');
        Route::get('best_selling_product', 'HomeController@bestSellingProducts')->name('best_selling_products');
        Route::get('best_customers', 'HomeController@bestCustomers')->name('best_customers');
        Route::get('new_orders', 'HomeController@newOrders')->name('new_orders');
        Route::get('monthly_sale', 'HomeController@monthlySale')->name('monthly_sale');
        Route::get('best_selling_category', 'HomeController@bestSellingProductCategory');
        Route::get('banner_list', 'BannerController@bannerList')->name('banner.list');
        Route::get('product_review_list', 'ProductReviewController@productReviewList')->name('product_review.list');
        Route::get('earning_list', 'WalletController@earningList')->name('earning.list');
        Route::get('withdraw_earning_list', 'WalletController@withdrawEarningList')->name('withdraw_earning.list');

//        Route::group(['middleware' => ['check_permission']], function () {
            //Route::get('/', 'HomeController@index')->name('home');
            /* contents routes */
            Route::get('banner/changeStatus', 'BannerController@changeStatus');
            Route::resource('banners', 'BannerController')->except('show');
            Route::get('product_review/changeStatus', 'ProductReviewController@changeStatus');
            Route::resource('product_review', 'ProductReviewController')->except('create', 'store');
            /* report routes */
            Route::get('stock_report_list', 'ReportController@stockReportList')->name('stock_report.list');
            Route::get('stock_report', 'ReportController@stockReport')->name('stock_report');
            Route::get('seller_report', 'ReportController@sellerReport')->name('seller_report');
            Route::get('seller_report_list', 'ReportController@sellerReportList')->name('seller_report.list');
            Route::get('customer_report', 'ReportController@customerReport')->name('customer_report');
            Route::get('customer_report_list', 'ReportController@customerReportList')->name('customer_report.list');
            Route::get('earning', 'WalletController@earning')->name('earning');
//        });
    });
});

/**
 * @return void
 */

/* clear all cache */
Route::get('/clear-all', function () {
    Artisan::call('optimize:clear');
    echo Artisan::output();
});

/* migration */
Route::get('/migrate',function(){
    Artisan::call('migrate');
    echo Artisan::output();
});

/* migration rollback */
Route::get('/migrate-rollback',function(){
    Artisan::call('migrate:rollback');
    echo Artisan::output();
});

/* create symbolic link */
Route::get('/symlink', function () {
    Artisan::call('storage:link');
    echo Artisan::output();
});
/* clear view cache */
Route::get('/clear-view-cache', function () {
    Artisan::call('view:clear');
    return 'View Cache Cleared';
});

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/updateapp', function() {
    exec('composer dump-autoload');
});

/* PaysantsPay gateway server-to-server notify (no auth, CSRF excluded) */
Route::post('payment/paysantspay/notify', [App\Http\Controllers\Customer\PaymentController::class, 'paysantsPayNotify'])->name('payment.paysantspay.notify');
