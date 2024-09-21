<?php

namespace App\Http\Events\TrackingEvent\Listeners\CreateEvent;

use App\Http\Events\TrackingEvent\Events\CreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Client;

class SendEventToGoogle implements ShouldQueue
{
    use InteractsWithQueue;

    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function handle(CreateEvent $event)
    {
        /*
        $trackingEvent = $event->trackingEvent;

        // Implementa la lógica para enviar a Google
        $this->httpClient->post('https://www.google-analytics.com/collect', [
            'form_params' => [
                'v' => 1,
                'tid' => config('services.google.analytics_id'),
                'cid' => $trackingEvent->user_id ?? $trackingEvent->ip_address,
                't' => 'event',
                'ec' => $trackingEvent->event_name,
                'ea' => 'action', // Ajusta según sea necesario
                'el' => 'label', // Ajusta según sea necesario
                'ev' => $trackingEvent->value,
            ],
        ]);
        */
    }
}