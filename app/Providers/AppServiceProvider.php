<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
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

        // Pre-check to verify if the settings exist
        $preCheck = User::where('domain', $host)->first();

        if (is_null($preCheck)) {
            // Invalidate cache and set $settings to null
            cache()->forget("settings_{$host}");
            $settings = null;
        } else {
            // Fetch settings and cache them if they exist
            $settings = cache()->rememberForever("settings_{$host}", function () use ($host) {
                return User::where('domain', $host)->first();
            });
        }

        // Share settings with all views
        View::share('settings', $settings);

    }
}
