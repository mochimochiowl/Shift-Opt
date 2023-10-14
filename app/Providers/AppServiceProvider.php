<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
    public function boot(UrlGenerator $url): void
    {
        //開発環境ではhttp, 本番環境ではhttps
        if (config('app.env') === 'production' && env('FORCE_HTTPS', true)) {
            $url->forceScheme('https');
        }
    }
}
