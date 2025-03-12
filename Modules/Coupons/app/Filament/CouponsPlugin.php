<?php

namespace Modules\Coupons\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CouponsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Coupons';
    }

    public function getId(): string
    {
        return 'coupons';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
