<?php

namespace App\Providers;

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
    public function boot(): void
    {
        // dd(url('/'));

        $baseUrl = url('/');
        $host = parse_url($baseUrl, PHP_URL_HOST);
        // dd($host);

    }
}
