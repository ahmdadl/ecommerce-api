<?php

namespace Modules\Core\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ModelStatisticsService
{
    protected Builder $query;
    protected string $aggregationMethod = "count";
    protected string $aggregationColumn = "*";
    protected string $dateColumn = "created_at";

    public function __construct(
        Model|Builder $modelOrBuilder,
        string $dateColumn = "created_at"
    ) {
        $this->dateColumn = $dateColumn;
        $this->query =
            $modelOrBuilder instanceof Model
                ? $modelOrBuilder->query()
                : $modelOrBuilder;
    }

    // Set custom aggregation (count, sum, avg, etc.)
    public function aggregateBy(string $method, string $column = "*"): self
    {
        $this->aggregationMethod = $method;
        $this->aggregationColumn = $column;
        return $this;
    }

    // Add custom filters to the query
    public function filter(callable $callback): self
    {
        call_user_func($callback, $this->query);
        return $this;
    }

    // Today vs Yesterday
    public function getDailyTrend(): array
    {
        $today = $this->getAggregateForDate(today());
        $yesterday = $this->getAggregateForDate(today()->subDay());

        return $this->calculateTrend($today, $yesterday);
    }

    // This Week vs Last Week
    public function getWeeklyTrend(): array
    {
        $currentWeek = $this->getAggregateForDateRange(
            today()->startOfWeek(),
            today()->endOfWeek()
        );

        $lastWeek = $this->getAggregateForDateRange(
            today()->subWeek()->startOfWeek(),
            today()->subWeek()->endOfWeek()
        );

        return $this->calculateTrend($currentWeek, $lastWeek);
    }

    // This Month vs Last Month
    public function getMonthlyTrend(): array
    {
        $currentMonth = $this->getAggregateForDateRange(
            today()->startOfMonth(),
            today()->endOfMonth()
        );

        $lastMonth = $this->getAggregateForDateRange(
            today()->subMonth()->startOfMonth(),
            today()->subMonth()->endOfMonth()
        );

        return $this->calculateTrend($currentMonth, $lastMonth);
    }

    // This Year vs Last Year
    public function getYearlyTrend(): array
    {
        $currentYear = $this->getAggregateForDateRange(
            today()->startOfYear(),
            today()->endOfYear()
        );

        $lastYear = $this->getAggregateForDateRange(
            today()->subYear()->startOfYear(),
            today()->subYear()->endOfYear()
        );

        return $this->calculateTrend($currentYear, $lastYear);
    }

    // Historical Data for Charts
    public function getHistoricalData(string $period = "week"): array
    {
        return match ($period) {
            "month" => $this->getMonthlyHistoricalData(),
            "week" => $this->getWeeklyHistoricalData(),
            "year" => $this->getYearlyHistoricalData(),
            default => $this->getWeeklyHistoricalData(),
        };
    }

    protected function getWeeklyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey("weekly_history"),
            now()->addHours(6),
            function () {
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subDays($i);
                    $data[] = $this->getAggregateForDate($date);
                }
                return $data;
            }
        );
    }

    protected function getMonthlyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey("monthly_history"),
            now()->addHours(6),
            function () {
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subMonths($i);
                    $data[] = $this->getAggregateForDateRange(
                        $date->copy()->startOfMonth(),
                        $date->copy()->endOfMonth()
                    );
                }
                return $data;
            }
        );
    }

    protected function getYearlyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey("yearly_history"),
            now()->addHours(6),
            function () {
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subYears($i);
                    $data[] = $this->getAggregateForDateRange(
                        $date->copy()->startOfYear(),
                        $date->copy()->endOfYear()
                    );
                }
                return $data;
            }
        );
    }

    // Helper Methods
    protected function getAggregateForDate(Carbon $date)
    {
        return Cache::remember(
            $this->getCacheKey("date_" . $date->format("Y-m-d")),
            now()->addHours(6),
            fn() => $this->buildQuery()
                ->whereDate($this->dateColumn, $date)
                ->{$this->aggregationMethod}($this->aggregationColumn)
        );
    }

    protected function getAggregateForDateRange(
        Carbon $startDate,
        Carbon $endDate
    ) {
        return Cache::remember(
            $this->getCacheKey(
                "range_" .
                    $startDate->format("Y-m-d") .
                    "_" .
                    $endDate->format("Y-m-d")
            ),
            now()->addHours(6),
            fn() => $this->buildQuery()
                ->whereBetween($this->dateColumn, [$startDate, $endDate])
                ->{$this->aggregationMethod}($this->aggregationColumn)
        );
    }

    protected function buildQuery(): Builder
    {
        return clone $this->query;
    }

    protected function calculateTrend($current, $previous): array
    {
        $difference = $current - $previous;

        $percentageChange =
            $previous > 0
                ? round(($difference / $previous) * 100, 2)
                : ($current > 0
                    ? 100
                    : 0);

        return [
            "current" => $current,
            "previous" => $previous,
            "difference" => $difference,
            "percentage" => $percentageChange,
            "trend" => $percentageChange >= 0 ? "up" : "down",
            "is_positive" => $percentageChange >= 0,
        ];
    }

    protected function getCacheKey(string $type): string
    {
        $modelName = class_basename($this->query->getModel());
        $aggregation = "{$this->aggregationMethod}_{$this->aggregationColumn}";
        return "stats_{$modelName}_{$aggregation}_{$type}_" .
            today()->format("Y-m-d");
    }
}
