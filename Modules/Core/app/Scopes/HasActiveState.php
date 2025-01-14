<?php

namespace Modules\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait HasActiveState
{
    /**
     * initialize trait
     *
     * @return void
     */
    public function initializeHasActiveState()
    {
        $this->fillable[] = 'is_active';
        array_merge($this->casts, ['is_active' => 'boolean']);
    }

    /**
     * Scope a query to only include is_active records.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    /**
     * Scope a query to exclude is_active records.
     */
    public function scopeNotActive(Builder $query): void
    {
        $query->where('is_active', 0);
    }
}
