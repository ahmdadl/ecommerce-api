<?php

namespace Modules\Core\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Filters\ModelFilter;

trait HasFiltersScope
{
    /**
     * initialize trait
     */
    public function initializeHasFiltersScope(): void
    {
        //
    }

    /**
     * filter model
     * @param  Builder<$this>  $query
     * @param  ModelFilter  $filter
     * @return Builder<$this>
     */
    public function scopeFilter(Builder $query, ModelFilter $filter): Builder
    {
        return $filter->apply($query);
    }
}
