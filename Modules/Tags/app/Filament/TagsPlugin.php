<?php

namespace Modules\Tags\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class TagsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Tags';
    }

    public function getId(): string
    {
        return 'tags';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
