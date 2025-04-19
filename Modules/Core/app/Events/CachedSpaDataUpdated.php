<?php

namespace Modules\Core\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Core\Actions\GetSpaCachedData;
use Modules\Core\Actions\GetSpaCachedDataAction;

class CachedSpaDataUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ?string $jsContent = null)
    {
        $this->jsContent ??= GetSpaCachedDataAction::new()->handle();
    }
}
