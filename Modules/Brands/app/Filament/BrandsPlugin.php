<?php

namespace Modules\Brands\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class BrandsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Brands';
    }

    public function getId(): string
    {
        return 'brands';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
