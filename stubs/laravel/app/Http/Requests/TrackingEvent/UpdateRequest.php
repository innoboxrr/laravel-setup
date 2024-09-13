<?php

namespace App\Http\Requests\TrackingEvent;

use App\Models\TrackingEvent;
use App\Http\Resources\Models\TrackingEventResource;
use App\Http\Events\TrackingEvent\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $trackingEvent = TrackingEvent::findOrFail($this->tracking_event_id);

        return $this->user()->can('update', $trackingEvent);

    }

    public function rules()
    {
        return [
            //
            'tracking_event_id' => 'required|numeric'
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
        //
    }

    public function handle()
    {

        $trackingEvent = TrackingEvent::findOrFail($this->tracking_event_id);

        $trackingEvent = $trackingEvent->updateModel($this);

        $response = new TrackingEventResource($trackingEvent);

        event(new UpdateEvent($trackingEvent, $this->all(), $response));

        return $response;

    }

}
