<?php

namespace App\Http\Events\TrackingEvent\Listeners\CreateEvent;

use App\Http\Events\TrackingEvent\Events\CreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Client;

class SendEventToTikTok implements ShouldQueue
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

        $accessToken = config('services.tiktok.access_token');
        $pixelId = config('services.tiktok.pixel_id');

        $url = "https://business-api.tiktok.com/open_api/v1.2/pixel/track/?access_token={$accessToken}";

        $this->httpClient->post($url, [
            'json' => [
                'pixel_code' => $pixelId,
                'event' => $trackingEvent->event_name,
                'properties' => [
                    'currency' => 'USD',
                    'value' => $trackingEvent->value,
                    'event_id' => $trackingEvent->id,
                    // Añade más datos según sea necesario
                ],
                'context' => [
                    'ip' => $trackingEvent->ip_address,
                    'user_agent' => $trackingEvent->user_agent,
                ]
            ]
        ]);
        */
    }
}