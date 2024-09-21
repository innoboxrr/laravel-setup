<?php

namespace App\Http\Requests\TrackingEvent;

use App\Models\TrackingEvent;
use App\Http\Resources\Models\TrackingEventResource;
use App\Http\Events\TrackingEvent\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // Completar user_id si no viene y el usuario está autenticado
        // Recuperar el carrito activo del usuario
        // Completar ip si no viene
        // Completar user_agent si no viene
        $this->merge([
            'user_id' => $this->user() ? $this->user()->id : null,
            'cart_id' => $this->user() ? $this->user()->currentCart?->id : null,
            'ip_address' => $this->ip(),
            'user_agent' => $this->header('User-Agent'),
        ]);
    }

    public function authorize()
    {
        if ($this->user()) {
            // Si el usuario está autenticado, aplica la policy
            return $this->user()->can('create', TrackingEvent::class);
        }

        // Si el usuario no está autenticado, permite la autorización con throttling
        return true;
    }

    public function rules()
    {
        return [
            // Define las reglas de validación aquí si es necesario
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    protected function passedValidation()
    {
        // Solo aplica el throttle si el usuario no está autenticado
        if (!$this->user()) {
            $this->applyThrottle();
        }
    }

    public function handle()
    {
        $trackingEvent = (new TrackingEvent)->createModel($this);

        $response = new TrackingEventResource($trackingEvent);

        event(new CreateEvent($trackingEvent, $this->all(), $response));

        return $response;
    }

    protected function applyThrottle()
    {
        $key = $this->throttleKey();
        $maxAttempts = 2;
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw ValidationException::withMessages([
                'rate_limit' => ['Too many requests. Please try again later.'],
            ]);
        }

        RateLimiter::hit($key, $decayMinutes * 60);
    }

    protected function throttleKey()
    {
        return strtolower($this->input('event_name') . '|' . $this->ip());
    }
}
