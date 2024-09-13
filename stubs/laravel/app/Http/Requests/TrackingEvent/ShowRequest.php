<?php

namespace App\Http\Requests\TrackingEvent;

use App\Models\TrackingEvent;
use App\Http\Resources\Models\TrackingEventResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $trackingEvent = TrackingEvent::findOrFail($this->tracking_event_id);

        return $this->user()->can('view', $trackingEvent);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(TrackingEvent::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(TrackingEvent::$loadable_counts)
            ],
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

        $trackingEvent = TrackingEvent::where('id', $this->tracking_event_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new TrackingEventResource($trackingEvent);

    }
    
}
