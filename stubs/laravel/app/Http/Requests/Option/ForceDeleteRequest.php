<?php

namespace App\Http\Requests\Option;

use App\Http\Events\Option\Events\ForceDeleteEvent;
use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $option = Option::withTrashed()->findOrFail($this->option_id);

        return $this->user()->can('forceDelete', $option);

    }

    public function rules()
    {
        return [
            'option_id' => 'required|numeric',
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

        $option = Option::withTrashed()->findOrFail($this->option_id);

        $option->forceDeleteModel();

        $response = new OptionResource($option);

        event(new ForceDeleteEvent($option, $this->all(), $response));

        return $response;

    }
}
