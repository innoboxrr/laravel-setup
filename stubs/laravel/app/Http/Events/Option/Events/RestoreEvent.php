<?php

namespace App\Http\Events\Option\Events;

use App\Models\Option;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class RestoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $option;

    public $data;

    public $response;

    public $locale;

    public function __construct(Option $option, array $data, $response, $locale = 'en')
    {

        $this->option = $option;

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
