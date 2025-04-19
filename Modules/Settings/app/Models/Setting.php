<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Observers\CachedSpaDataUpdatedObserver;

#[ObservedBy(CachedSpaDataUpdatedObserver::class)]
class Setting extends Model
{
    protected function casts(): array
    {
        return [
            "data" => "array",
        ];
    }

    /**
     * Singleton-like access (assuming one row for global settings)
     */
    public static function getInstance(): Setting
    {
        return static::firstOrCreate(["id" => 1], ["data" => []]);
    }

    /**
     * Helper to get a specific group or value
     */
    public function getGroup(string $group): array
    {
        return $this->data[$group] ?? [];
    }

    /**
     * Helper to update a specific group
     */
    public function updateGroup(string $group, array $values): void
    {
        $data = $this->data ?? [];
        $data[$group] = $values;
        $this->data = $data;
        $this->save();
    }
}
