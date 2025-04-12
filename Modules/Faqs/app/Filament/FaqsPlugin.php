<?php

namespace Modules\Faqs\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FaqsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Faqs';
    }

    public function getId(): string
    {
        return 'faqs';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
