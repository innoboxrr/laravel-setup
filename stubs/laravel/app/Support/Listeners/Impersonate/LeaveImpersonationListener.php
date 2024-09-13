<?php

namespace App\Support\Listeners\Impersonate;

use Lab404\Impersonate\Events\LeaveImpersonation;
use Illuminate\Support\Facades\Auth;

class LeaveImpersonationListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(LeaveImpersonation $event)
    {
        session()->remove('password_hash_web');
        session()->put([
            'password_hash_sanctum' => $event->impersonator->getAuthPassword(),
        ]);
        Auth::setUser($event->impersonator);
    }
}
