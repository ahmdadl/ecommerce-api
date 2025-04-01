<?php

namespace Modules\Wishlists\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class WishlistsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Wishlists';
    }

    public function getId(): string
    {
        return 'wishlists';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
