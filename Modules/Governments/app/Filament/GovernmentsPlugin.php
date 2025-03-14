<?php

namespace Modules\Governments\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class GovernmentsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Governments';
    }

    public function getId(): string
    {
        return 'governments';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
