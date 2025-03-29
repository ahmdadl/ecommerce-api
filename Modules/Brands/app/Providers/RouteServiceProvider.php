<?php

namespace Modules\Brands\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Brands\Models\Brand;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = "Brands";

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        Route::bind("activeBrand", function ($value) {
            return Brand::where("slug", $value)
                ->where("is_active", true)
                ->firstOrFail();
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        // $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware("web")->group(
            module_path($this->name, "/routes/web.php")
        );
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware("api")
            ->prefix("api")
            ->name("api.")
            ->group(module_path($this->name, "/routes/api.php"));
    }
}
