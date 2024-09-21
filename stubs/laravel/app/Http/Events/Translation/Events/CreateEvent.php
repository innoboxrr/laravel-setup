<?php

namespace App\Http\Events\Translation\Events;

use App\Models\Translation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class CreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $translation;

    public $data;

    public $response;

    public $locale;

    public function __construct(Translation $translation, array $data, $response, $locale = 'en')
    {

        $this->translation = $translation;

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
