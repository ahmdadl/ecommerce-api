<?php

namespace Modules\PageViews\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class PageViews extends Cluster
{
    public static function getModuleName(): string
    {
        return 'PageViews';
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __('Page Views');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-squares-2x2';
    }
}
