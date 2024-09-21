<?php

namespace App\Http\Events\TrackingEvent\Listeners\CreateEvent;

use App\Http\Events\TrackingEvent\Events\CreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SendEventToFacebook implements ShouldQueue
{
    use InteractsWithQueue;

    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function handle(CreateEvent $event)
    {
        $trackingEvent = $event->trackingEvent;

        // Verificar que en platforms esté Facebook
        if (!in_array('facebook', $trackingEvent->platforms)) {
            Log::info('Event not sent to Facebook: Platform not found');
            return;
        }

        $accessToken = config('app.tracking.facebook_token');
        $pixelId = config('app.tracking.facebook');
        $apiVersion = 'v20.0'; // Asegúrate de utilizar la versión correcta de la API

        $url = "https://graph.facebook.com/{$apiVersion}/{$pixelId}/events?access_token={$accessToken}";

        $data = [
            'event_name' => $trackingEvent->event_name,
            'event_time' => time(),
            'action_source' => 'website',
            'event_source_url' => url()->current(),
            'user_data' => $this->formatUserData($trackingEvent),
            'custom_data' => $this->formatCustomData($trackingEvent),
            'event_id' => $trackingEvent->uuid,
        ];

        try {
            $response = $this->httpClient->post($url, [
                'json' => [
                    'data' => [$data],
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            // Log::info("Facebook API Response: {$statusCode} - {$body}");
            
        } catch (\Exception $e) {
            // Log::error('Error sending event to Facebook: ' . $e->getMessage());
        }
    }

    protected function formatUserData($trackingEvent)
    {
        $geoData = $trackingEvent->geo ?? []; // Extrae los datos de geolocalización, o usa un array vacío si es null

        return [
            'em' => $trackingEvent->user ? [hash('sha256', $trackingEvent->user->email)] : null,  // Correo electrónico hasheado
            'ph' => $trackingEvent->user && $trackingEvent->user->phone_number ? [hash('sha256', $trackingEvent->user->phone_number)] : null,  // Teléfono hasheado
            'client_ip_address' => $trackingEvent->ip_address,  // Dirección IP sin hash
            'client_user_agent' => $trackingEvent->user_agent,  // User Agent sin hash
            'ct' => !empty($geoData['city_name']) ? [hash('sha256', $geoData['city_name'])] : null,  // Ciudad hasheada
            'country' => !empty($geoData['country_name']) ? [hash('sha256', $geoData['country_name'])] : null,  // País hasheado
            'fn' => $trackingEvent->user && $trackingEvent->user->first_name ? [hash('sha256', $trackingEvent->user->first_name)] : null,  // Nombre hasheado
            'ln' => $trackingEvent->user && $trackingEvent->user->last_name ? [hash('sha256', $trackingEvent->user->last_name)] : null,  // Apellido hasheado
            'st' => !empty($geoData['region_name']) ? [hash('sha256', $geoData['region_name'])] : null,  // Estado/Provincia hasheado
            'fbc' => $trackingEvent->fbclid,  // Cookie fbc sin hash
            'db' => $trackingEvent->user && $trackingEvent->user->date_of_birth ? [hash('sha256', $trackingEvent->user->date_of_birth)] : null,  // Fecha de nacimiento hasheada
        ];
    }

    protected function formatCustomData($trackingEvent)
    {
        return [
            'value' => $trackingEvent->event_data['value'],
            'currency' => $trackingEvent->event_data['currency'],
            'content_ids' => $trackingEvent->event_data['products'],
            // Agrega más datos personalizados según sea necesario
        ];
    }
}