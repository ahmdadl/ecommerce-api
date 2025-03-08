<?php

namespace Modules\Brands\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class Brands extends Cluster
{
    public static function getModuleName(): string
    {
        return 'Brands';
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __('Brands');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-squares-2x2';
    }
}
