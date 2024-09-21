<?php

namespace App\Support\Listeners\Impersonate;

use Lab404\Impersonate\Events\TakeImpersonation;

class TakeImpersonationListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(TakeImpersonation $event)
    {
        session()->put([
            'password_hash_sanctum' => $event->impersonated->getAuthPassword(),
        ]);
    }
}
