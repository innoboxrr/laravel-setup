<?php

namespace App\Http\Events\Option\Listeners\ExportEvent;

use App\Http\Events\Option\Events\ExportEvent;
use App\Notifications\Option\ExportNotification;

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
