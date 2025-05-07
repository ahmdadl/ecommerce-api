<?php

namespace Modules\Wallets\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class WalletsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Wallets';
    }

    public function getId(): string
    {
        return 'wallets';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
