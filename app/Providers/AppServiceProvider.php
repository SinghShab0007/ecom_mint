<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('backend.includes.navbar', function ($view) {
            $view->with([
                'notifications' => Notification::where('read_at', NULL)->where('notifiable_id', auth(Auth::getDefaultDriver())->id())->where('notifiable_type', 'App\Models\Backend\Admin')->get(),
            ]);
        });

        Schema::defaultStringLength(125);
    }
}
