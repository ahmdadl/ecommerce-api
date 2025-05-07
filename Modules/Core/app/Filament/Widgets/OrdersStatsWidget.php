<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Modules\Core\Filament\Widgets\BaseStatsWidget;
use Modules\Core\Services\ModelStatisticsService;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\Order;

class OrdersStatsWidget extends BaseStatsWidget
{
    protected function getStats(): array
    {
        $dailyService = (new ModelStatisticsService(new Order()))->filter(
            fn($q) => $q->where("status", "!=", OrderStatus::CANCELLED->value)
        );

        $dailyOrders = $dailyService->getDailyTrend();

        $weeklyService = (new ModelStatisticsService(new Order()))->filter(
            fn($q) => $q->where("status", "!=", OrderStatus::CANCELLED->value)
        );
        $weeklyOrders = $weeklyService->getWeeklyTrend();

        $monthlyService = (new ModelStatisticsService(new Order()))->filter(
            fn($q) => $q->where("status", "!=", OrderStatus::CANCELLED->value)
        );
        $monthlyOrders = $monthlyService->getMonthlyTrend();

        return [
            Stat::make(
                __("core::t.daily_orders"),
                Number::format($dailyOrders["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $dailyOrders,
                        __("core::t.yesterday")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($dailyOrders))
                ->color($this->getTrendColor($dailyOrders)),

            Stat::make(
                __("core::t.weekly_orders"),
                Number::format($weeklyOrders["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $weeklyOrders,
                        __("core::t.last_week")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($weeklyOrders))
                ->color($this->getTrendColor($weeklyOrders))
                ->chart($this->getWeeklyChartData($weeklyService)),

            Stat::make(
                __("core::t.monthly_orders"),
                Number::format($monthlyOrders["current"])
            )
                ->description(
                    $this->getTrendDescription(
                        $monthlyOrders,
                        __("core::t.last_month")
                    )
                )
                ->descriptionIcon($this->getTrendIcon($monthlyOrders))
                ->color($this->getTrendColor($monthlyOrders))
                ->chart($this->getMonthlyChartData($monthlyService)),
        ];
    }
}
