<?php

namespace Modules\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = "Core";

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        // $this->mapApiRoutes();
        $this->mapWebRoutes();
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

    /**
     * Resolve the model class based on Laravel Modules structure.
     */
    private function resolveModelClass(string $parameter): string
    {
        $modelName = ucfirst($parameter);

        // Assume the namespace follows Modules\{ModuleName}\Models\{ModelName}
        // For simplicity, we assume the module name matches the model name pluralized
        $moduleName = ucfirst(str($parameter)->plural()->value());
        $modelClass = "Modules\\{$moduleName}\\Models\\{$modelName}";

        return $modelClass;
    }
}
