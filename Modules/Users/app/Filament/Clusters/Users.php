<?php

namespace Modules\Users\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class Users extends Cluster
{
    public static function getModuleName(): string
    {
        return "Users";
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __("Users");
    }

    public static function getNavigationIcon(): ?string
    {
        return "heroicon-o-squares-2x2";
    }
}
