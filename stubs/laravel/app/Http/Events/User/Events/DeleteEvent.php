<?php

namespace App\Http\Events\User\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class DeleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $data;

    public $response;

    public $locale;

    public function __construct(User $user, array $data, $response, $locale = 'en')
    {

        $this->user = $user;

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