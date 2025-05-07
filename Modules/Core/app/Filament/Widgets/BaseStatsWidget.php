<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Modules\Core\Services\ModelStatisticsService;

class BaseStatsWidget extends BaseWidget
{
    protected function getTrendDescription(
        array $trend,
        string $comparisonPeriod
    ): string {
        return sprintf(
            "%s%% %s (%d) vs %s",
            abs($trend["percentage"]),
            $trend["trend"],
            abs($trend["difference"]),
            $comparisonPeriod
        );
    }

    protected function getTrendIcon(array $trend): string
    {
        return $trend["is_positive"]
            ? "heroicon-m-arrow-trending-up"
            : "heroicon-m-arrow-trending-down";
    }

    protected function getTrendColor(array $trend): string
    {
        return $trend["is_positive"] ? "success" : "danger";
    }

    protected function getWeeklyChartData(
        ModelStatisticsService $service
    ): array {
        return $service->getHistoricalData("week");
    }

    protected function getMonthlyChartData(
        ModelStatisticsService $service
    ): array {
        return $service->getHistoricalData("month");
    }

    protected function getYearlyChartData(
        ModelStatisticsService $service
    ): array {
        return $service->getHistoricalData("year");
    }
}
