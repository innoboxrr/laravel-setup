<?php

namespace App\Http\Events\Language\Events;

use App\Models\Language;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class RestoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $language;

    public $data;

    public $response;

    public $locale;

    public function __construct(Language $language, array $data, $response, $locale = 'en')
    {

        $this->language = $language;

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
