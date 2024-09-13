<?php

/**
 * This trait must be used in the User model or any Notifiable model.
 * The notificable must return a property called notifications_settings
 */

namespace App\Support\Traits;

use Illuminate\Support\Str;

trait NotificationsVia
{
    /**
     * Determine if the notification should be sent by email.
     */
    protected function shouldBeMailed(string $notification): bool
    {
        // Verificar que la propiedad notifications_settings exista
        // No se si como esto se define en mutator, funcione pero hay que validar
        if (!property_exists($this, 'notifications_settings') || !is_array($this->notifications_settings)) {
            return false;
        }

        // Verificar si la notificación está habilitada para ser enviada por email
        if(isset($this->notifications_settings[$notification])) {
            return $this->notifications_settings[$notification] == 1;
        }
        return false;
    }

    public function getNotificationsSettingsAttribute()
    {
        return json_decode($this->payload['notifications_settings'], true);
    }

    public function getNotificationVia(string $notification, bool $useDatabase = true)
    {   
        $via = [];
        if ($this->shouldBeMailed(Str::snake(class_basename($notification)))) {
            $via[] = 'mail';
        }
        if ($useDatabase) {
            $via[] = 'database';
        }
        return $via;
    }
}