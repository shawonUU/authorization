<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
// use App\Http\Middleware\RoleMiddleware;
// use App\Http\Middleware\PermissionMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });

        // // Register middleware aliases here:
        // Route::aliasMiddleware('role', RoleMiddleware::class);
        // Route::aliasMiddleware('permission', PermissionMiddleware::class);
    }

    protected function configureRateLimiting(): void
    {
        //
    }
}
