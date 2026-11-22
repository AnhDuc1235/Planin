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
     * (Phân trang dùng view Tailwind mặc định của Laravel, không dùng Bootstrap.)
     */
    public function boot(): void
    {
        //
    }
}
