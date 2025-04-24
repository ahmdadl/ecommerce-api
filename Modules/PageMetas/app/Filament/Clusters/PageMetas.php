<?php

namespace Modules\PageMetas\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class PageMetas extends Cluster
{
    public static function getModuleName(): string
    {
        return 'PageMetas';
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __('Page Metas');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-squares-2x2';
    }
}
