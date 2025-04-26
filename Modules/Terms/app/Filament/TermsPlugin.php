<?php

namespace Modules\Terms\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class TermsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Terms';
    }

    public function getId(): string
    {
        return 'terms';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
