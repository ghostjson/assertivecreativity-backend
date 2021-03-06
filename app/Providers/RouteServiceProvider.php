<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('api/auth')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/auth.php'));

            Route::prefix('api/admin')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/admin.php'));

            Route::prefix('api/products/stock')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/stock_products.php'));

            Route::prefix('api/products/custom')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/custom_products.php'));

            Route::prefix('api/orders')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/orders.php'));

            Route::prefix('api/vendor')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/vendor.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
