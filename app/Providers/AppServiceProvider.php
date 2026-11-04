<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Source - https://stackoverflow.com/a/64372904
// Posted by Sok Chanty
// Retrieved 2026-08-28, License - CC BY-SA 4.0


use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
    }
}
