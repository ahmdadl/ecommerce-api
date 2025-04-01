<?php

namespace Modules\CompareLists\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\CompareLists\Models\CompareListItem;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = "CompareLists";

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        Route::bind("myCompareItem", function ($value) {
            return CompareListItem::where("id", $value)
                ->where(
                    "compare_list_id",
                    compareListService()?->compareList->id
                )
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
