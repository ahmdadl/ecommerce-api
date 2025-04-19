<?php

namespace Modules\Core\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Modules\Core\Events\CachedSpaDataUpdated;

class WriteCachedSpaDataListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CachedSpaDataUpdated $event): void
    {
        File::put(public_path("cached-spa-data.js"), $event->jsContent);
    }
}
