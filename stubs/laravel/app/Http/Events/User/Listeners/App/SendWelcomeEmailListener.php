<?php

namespace App\Http\Events\User\Listeners\App;

use Illuminate\Auth\Events\Registered;
use App\Notifications\User\WelcomeEmailNotification;

class SendWelcomeEmailListener
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
        if($event->user) {
            $event->user->notify(new WelcomeEmailNotification());
        }
    }
}
