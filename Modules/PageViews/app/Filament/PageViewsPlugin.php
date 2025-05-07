<?php

namespace Modules\PageViews\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class PageViewsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'PageViews';
    }

    public function getId(): string
    {
        return 'pageviews';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
