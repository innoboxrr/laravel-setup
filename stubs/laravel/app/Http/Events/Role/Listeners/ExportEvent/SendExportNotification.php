<?php

namespace App\Http\Events\Role\Listeners\ExportEvent;

use App\Http\Events\Role\Events\ExportEvent;
use App\Notifications\Role\ExportNotification;

class SendExportNotification
{
    public function __construct()
    {
        //
    }

    public function handle(ExportEvent $event)
    {

        $event->user
            ->notify((new ExportNotification($event->data))->locale($event->locale));

    }
}
