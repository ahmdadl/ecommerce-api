<?php

namespace Modules\Users\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class UsersPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Users';
    }

    public function getId(): string
    {
        return 'users';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
