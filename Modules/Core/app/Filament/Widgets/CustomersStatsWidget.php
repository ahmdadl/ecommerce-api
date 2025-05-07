<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Modules\Core\Filament\Widgets\BaseStatsWidget;
use Modules\Core\Services\ModelStatisticsService;
use Modules\Users\Models\Customer;

class CustomersStatsWidget extends BaseStatsWidget
{
    protected function getStats(): array
    {
        $dailyService = new ModelStatisticsService(new Customer());

        $dailyCustomers = $dailyService->getDailyTrend();

        $weeklyService = new ModelStatisticsService(new Customer());
        $weeklyCustomers = $weeklyService->getWeeklyTrend();

        $monthlyService = new ModelStatisticsService(new Customer());
        $monthlyCustomers = $monthlyService->getMonthlyTrend();

        return [
            Stat::make(
                __("core::t.daily_customers"),
                Number::format($dailyCustomers["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $dailyCustomers,
                        __("core::t.yesterday")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($dailyCustomers))
                ->color($this->getTrendColor($dailyCustomers)),

            Stat::make(
                __("core::t.weekly_customers"),
                Number::format($weeklyCustomers["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $weeklyCustomers,
                        __("core::t.last_week")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($weeklyCustomers))
                ->color($this->getTrendColor($weeklyCustomers))
                ->chart($this->getWeeklyChartData($weeklyService)),

            Stat::make(
                __("core::t.monthly_customers"),
                Number::format($monthlyCustomers["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $monthlyCustomers,
                        __("core::t.last_month")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($monthlyCustomers))
                ->color($this->getTrendColor($monthlyCustomers))
                ->chart($this->getMonthlyChartData($monthlyService)),
        ];
    }
}
