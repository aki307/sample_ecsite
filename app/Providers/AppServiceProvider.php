<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Services\StripeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        \Schema::defaultStringLength(191);
        
        \URL::forceScheme('https');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('StripeService', StripeService::class);
    }
}
