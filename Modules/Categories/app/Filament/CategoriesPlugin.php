<?php

namespace Modules\Categories\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CategoriesPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Categories';
    }

    public function getId(): string
    {
        return 'categories';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
