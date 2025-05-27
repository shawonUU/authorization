<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('perm', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($expression)): ?>";
        });

        Blade::directive('endperm', function () {
            return "<?php endif; ?>";
        });
    }
}
