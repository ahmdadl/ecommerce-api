<?php

namespace Modules\CompareLists\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class CompareListsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return "CompareLists";
    }

    public function getId(): string
    {
        return "comparelists";
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
