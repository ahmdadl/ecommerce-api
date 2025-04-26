<?php

namespace Modules\PrivacyPolicies\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class PrivacyPoliciesPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'PrivacyPolicies';
    }

    public function getId(): string
    {
        return 'privacypolicies';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
