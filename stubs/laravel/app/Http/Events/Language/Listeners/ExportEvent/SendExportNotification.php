<?php

namespace App\Http\Events\Language\Listeners\ExportEvent;

use App\Http\Events\Language\Events\ExportEvent;
use App\Notifications\Language\ExportNotification;

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
