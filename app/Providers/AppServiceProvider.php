<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Always use the same URL for both local and production
        // All POST methods will use /growedge/public prefix
        URL::forceRootUrl('https://updates.mrweb.co.in/growedge/public');
        URL::forceScheme('https');
    }
}
