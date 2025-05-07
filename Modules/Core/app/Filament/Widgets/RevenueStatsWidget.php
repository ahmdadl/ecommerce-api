<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Modules\Core\Filament\Widgets\BaseStatsWidget;
use Modules\Core\Services\ModelStatisticsService;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\Order;

class RevenueStatsWidget extends BaseStatsWidget
{
    protected function getStats(): array
    {
        $dailyService = (new ModelStatisticsService(new Order()))
            ->aggregateBy("sum", "totals->total")
            ->filter(
                fn($q) => $q->where(
                    "status",
                    "!=",
                    OrderStatus::CANCELLED->value
                )
            );

        $dailyRevenue = $dailyService->getDailyTrend();

        $weeklyService = (new ModelStatisticsService(new Order()))
            ->aggregateBy("sum", "totals->total")
            ->filter(
                fn($q) => $q->where(
                    "status",
                    "!=",
                    OrderStatus::CANCELLED->value
                )
            );
        $weeklyRevenue = $weeklyService->getWeeklyTrend();

        $monthlyService = (new ModelStatisticsService(new Order()))
            ->aggregateBy("sum", "totals->total")
            ->filter(
                fn($q) => $q->where(
                    "status",
                    "!=",
                    OrderStatus::CANCELLED->value
                )
            );
        $monthlyRevenue = $monthlyService->getMonthlyTrend();

        return [
            Stat::make(
                __("core::t.daily_revenue"),
                Number::currency($dailyRevenue["current"], "EGP")
            )
                ->description(
                    $this->getTrendDescription(
                        $dailyRevenue,
                        __("core::t.yesterday")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($dailyRevenue))
                ->color($this->getTrendColor($dailyRevenue)),

            Stat::make(
                __("core::t.weekly_revenue"),
                Number::currency($weeklyRevenue["current"], "EGP")
            )
                ->description(
                    $this->getTrendDescription(
                        $weeklyRevenue,
                        __("core::t.last_week")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($weeklyRevenue))
                ->color($this->getTrendColor($weeklyRevenue))
                ->chart($this->getWeeklyChartData($weeklyService)),

            Stat::make(
                __("core::t.monthly_revenue"),
                Number::currency($monthlyRevenue["current"], "EGP")
            )
                ->description(
                    $this->getTrendDescription(
                        $monthlyRevenue,
                        __("core::t.last_month")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($monthlyRevenue))
                ->color($this->getTrendColor($monthlyRevenue))
                ->chart($this->getMonthlyChartData($monthlyService)),
        ];
    }
}
