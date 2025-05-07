<?php

namespace Modules\Core\Filament\Resources\DashboardResource\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Core\Filament\Widgets\StatsOverview;
use Modules\Orders\Models\Order;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
