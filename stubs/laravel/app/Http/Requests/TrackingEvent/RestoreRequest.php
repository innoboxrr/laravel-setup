<?php

namespace App\Http\Requests\TrackingEvent;

use App\Models\TrackingEvent;
use App\Http\Resources\Models\TrackingEventResource;
use App\Http\Events\TrackingEvent\Events\RestoreEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestoreRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $trackingEvent = TrackingEvent::withTrashed()->findOrFail($this->tracking_event_id);
        
        return $this->user()->can('restore', $trackingEvent);

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

        $trackingEvent = TrackingEvent::withTrashed()->findOrFail($this->tracking_event_id);

        $trackingEvent->restoreModel();

        $response = new TrackingEventResource($trackingEvent);

        event(new RestoreEvent($trackingEvent, $this->all(), $response));

        return $response;

    }
    
}
