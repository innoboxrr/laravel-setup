<?php

namespace App\Support\Listeners\Auth;

use Illuminate\Auth\Events\Failed;

class FailedLoginListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Failed $event)
    {

        if ($event->user) {
            $event->user->trackLoginAttempt(false);
        }

        // PENDIENTE: En un futuro pensar en un mecanismo para bloquear una cuenta en función de los intentos fallidos
        //              Se puede añadir una columna blocked_at, para indicar la fecha de bloqueo de la cuenta

    }
}
