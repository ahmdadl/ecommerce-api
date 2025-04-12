<?php

namespace Modules\ContactUs\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class ContactUsPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'ContactUs';
    }

    public function getId(): string
    {
        return 'contactus';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
