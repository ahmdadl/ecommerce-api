<?php

namespace Modules\Core\Listeners;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;

class RunAfterCommand
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
    public function handle(CommandFinished $event): void
    {
        if ($event->command === "module:make") {
            // @phpstan-ignore-next-line
            $module = $event->input->getArgument("name");

            Artisan::call("module:filament:install", [
                // @phpstan-ignore-next-line
                "module" => $module[0],
                "-n" => true,
            ]);
        }
    }
}
