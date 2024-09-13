<?php

namespace App\Http\Requests\TrackingEvent;

use App\Models\TrackingEvent;
use App\Http\Resources\Models\TrackingEventResource;
use App\Http\Events\TrackingEvent\Events\DeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $trackingEvent = TrackingEvent::findOrFail($this->tracking_event_id);

        return $this->user()->can('delete', $trackingEvent);

    }

    public function rules()
    {
        return [
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

        $trackingEvent->deleteModel();

        $response = new TrackingEventResource($trackingEvent);

        event(new DeleteEvent($trackingEvent, $this->all(), $response));

        return $response;

    }
    
}
