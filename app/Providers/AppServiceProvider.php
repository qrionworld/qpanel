<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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
    // Kirim 5 log terbaru ke semua view
    View::composer('*', function ($view) {
        $notifications = ActivityLog::latest()->take(5)->get();
        $view->with('notifications', $notifications);
    });

      Carbon::setLocale('id');
}


}
