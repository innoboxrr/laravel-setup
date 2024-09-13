<?php

namespace App\Http\Events\Role\Events;

use App\Models\Role;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class RestoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $role;

    public $data;

    public $response;

    public $locale;

    public function __construct(Role $role, array $data, $response, $locale = 'en')
    {

        $this->role = $role;

        $this->data = $data;

        $this->response = $response;

        $this->locale = $locale;

        App::setLocale($this->locale);

    }

    public function broadcastOn()
    {

        return new PrivateChannel('channel-name');

    }
}
