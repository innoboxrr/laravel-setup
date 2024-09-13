<?php

namespace App\Http\Events\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public $user;

    public $locale;

    public function __construct(array $data, $user, $locale = 'en')
    {

        $this->data = $data;

        $this->user = $user;

        $this->locale = $locale;

    }

    public function broadcastOn()
    {

        return new PrivateChannel('channel-name');

    }
}
