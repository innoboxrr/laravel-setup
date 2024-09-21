<?php

namespace App\Http\Events\Translation\Listeners\ExportEvent;

use App\Http\Events\Translation\Events\ExportEvent;
use App\Notifications\Translation\ExportNotification;

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
