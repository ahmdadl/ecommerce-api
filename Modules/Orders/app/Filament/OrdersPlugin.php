<?php

namespace Modules\Orders\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class OrdersPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Orders';
    }

    public function getId(): string
    {
        return 'orders';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
