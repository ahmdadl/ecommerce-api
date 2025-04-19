<?php

namespace Modules\Core\Observers;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Events\CachedSpaDataUpdated;

class CachedSpaDataUpdatedObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        event(new CachedSpaDataUpdated());
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        event(new CachedSpaDataUpdated());
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        event(new CachedSpaDataUpdated());
    }

    /**
     * Handle the Model "restored" event.
     */
    public function restored(Model $model): void
    {
        event(new CachedSpaDataUpdated());
    }
}
