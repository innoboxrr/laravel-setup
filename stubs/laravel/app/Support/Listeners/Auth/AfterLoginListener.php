<?php

namespace App\Support\Listeners\Auth;

use Illuminate\Auth\Events\Login;

class AfterLoginListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Login $event)
    {
        try {
            $event->user->trackLoginAttempt();
        } catch (\Exception $e) {
            // do nothing
        }
    }
}
