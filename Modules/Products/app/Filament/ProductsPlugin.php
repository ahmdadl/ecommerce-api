<?php

namespace Modules\Products\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class ProductsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Products';
    }

    public function getId(): string
    {
        return 'products';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
